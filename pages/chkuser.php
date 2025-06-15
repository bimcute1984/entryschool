<?php
<<<<<<< HEAD
include "../pages/backend/connectDB.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Get form data
$user = $_POST['username'];
$pass = $_POST['password'];

// Prepare the SQL query to select user where username and password match
$sql = "SELECT ENTRYSCHOOL_USER.*,SCHOOL.SCHOOLNAME FROM UBUDEV.ENTRYSCHOOL_USER 
RIGHT JOIN AVSREG.SCHOOL ON ENTRYSCHOOL_USER.SCHOOLID = SCHOOL.SCHOOLID
WHERE USERNAME=:username AND  PASSWORD = :password";

// Create the statement and bind parameters
$statement = oci_parse($ubureg, $sql);
oci_bind_by_name($statement, ':username', $user);
oci_bind_by_name($statement, ':password', $pass);

// Execute the statement
oci_execute($statement);

// Fetch the result
$row = oci_fetch_assoc($statement);



if ($row) {
    $_SESSION['user'] = $row['USERNAME'];
    $_SESSION['schoolID'] = $row['SCHOOLID'];
    $_SESSION['SCHOOLNAME'] = $row['SCHOOLNAME'];
    $_SESSION['prefix'] = $row['PREFIX'];
    $_SESSION['fullName'] = $row['FULLNAME'];
    $_SESSION['surName'] = $row['SURNAME'];
    $_SESSION['phoneNumber'] = $row['PHONE_NUMBER'];
    // Login successful
    echo json_encode(['status' => 'success', 'message' => 'เข้าสู่ระบบสำเร็จ, ' . $row['USERNAME']]);
} else {
    // Login failed
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบชื่อผู้ใช้งานหรือรหัสผ่าน']);
}// Free resources
oci_free_statement($statement);
}

// Close the Oracle connection
oci_close($ubureg);


=======
session_start();
include "../pages/backend/connectDB.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // ✅ สำหรับ admin (hardcoded)
    if ($user === 'admin' && $pass === '8888') {
        $_SESSION['user'] = 'admin';
        $_SESSION['role'] = 'admin';
        $_SESSION['prefix'] = 'คุณ';
        $_SESSION['fullName'] = 'ผู้ดูแลระบบ';
        $_SESSION['surName'] = '';
        $_SESSION['SCHOOLNAME'] = 'มหาวิทยาลัยอุบลราชธานี';

        echo json_encode([
            'status' => 'success',
            'message' => 'เข้าสู่ระบบในฐานะเจ้าหน้าที่งานรับเข้าศึกษา',
            'redirect' => 'adminMenu2.php'
        ]);
        exit;
    }

    // ✅ สำหรับผู้ใช้โรงเรียน (ดึงจากฐานข้อมูล)
    $sql = "SELECT ENTRYSCHOOL_USER.*, SCHOOL.SCHOOLNAME 
            FROM UBUDEV.ENTRYSCHOOL_USER 
            RIGHT JOIN AVSREG.SCHOOL 
            ON ENTRYSCHOOL_USER.SCHOOLID = SCHOOL.SCHOOLID
            WHERE USERNAME = :username AND PASSWORD = :password";

    $statement = oci_parse($ubureg, $sql);
    oci_bind_by_name($statement, ':username', $user);
    oci_bind_by_name($statement, ':password', $pass);
    oci_execute($statement);

    $row = oci_fetch_assoc($statement);

    if ($row) {
        // ✅ กำหนด session
        $_SESSION['user'] = $row['USERNAME'];
        $_SESSION['schoolID'] = $row['SCHOOLID'];
        $_SESSION['SCHOOLNAME'] = $row['SCHOOLNAME'];
        $_SESSION['prefix'] = $row['PREFIX'];
        $_SESSION['fullName'] = $row['FULLNAME'];
        $_SESSION['surName'] = $row['SURNAME'];
        $_SESSION['phoneNumber'] = $row['PHONE_NUMBER'];
        $_SESSION['role'] = 'school';

        oci_free_statement($statement);
        oci_close($ubureg);

        echo json_encode([
            'status' => 'success',
            'message' => 'เข้าสู่ระบบสำเร็จ, ' . $row['USERNAME'],
            'redirect' => 'dashboard.php'
        ]);
        exit;
    } else {
        // ❌ ล็อกอินไม่สำเร็จ
        oci_free_statement($statement);
        oci_close($ubureg);

        echo json_encode([
            'status' => 'error',
            'message' => 'ไม่พบชื่อผู้ใช้งานหรือรหัสผ่าน'
        ]);
        exit;
    }
}
>>>>>>> 29b51cc (Test commit)
?>
