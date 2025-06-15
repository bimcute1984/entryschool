<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";

$schoolID = $_SESSION['schoolID'] ?? null;

if (!$schoolID) {
    echo "<script>alert('ไม่พบข้อมูลผู้ใช้งาน'); window.history.back();</script>";
    exit;
}

// รับค่าจากฟอร์ม
$activityname = $_POST['activityname'] ?? '';
$join_date = $_POST['join_date'] ?? '';
$join_time = $_POST['join_time'] ?? '';
$activitydesc = $_POST['activitydesc'] ?? '';
$total_students = $_POST['total_students'] ?? 0;
$total_teacher = $_POST['total_teacher'] ?? 0;
$contact_name = $_POST['contact_name'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$join_type = 'B'; // แนะแนวนอกตาราง

// ตรวจสอบข้อมูลสำคัญว่าไม่ว่าง
if (
    empty($activityname) || empty($join_date) || empty($join_time) ||
    empty($total_students) || empty($total_teacher) ||
    empty($contact_name) || empty($contact_number)
) {
    echo "<script>alert('กรุณากรอกข้อมูลให้ครบทุกช่อง'); history.back();</script>";
    exit;
}

// === จัดการไฟล์แนบ ===
$upload_file = '';
if (!empty($_FILES['upload_file']['name'])) {

    $upload_error = $_FILES['upload_file']['error'];
    if ($upload_error !== 0) {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์ (error code: {$upload_error})'); history.back();</script>";
        exit;
    }

    if (!is_uploaded_file($_FILES["upload_file"]["tmp_name"])) {
        echo "<script>alert('ไฟล์ไม่ได้ถูกอัพโหลดผ่าน HTTP POST'); history.back();</script>";
        exit;
    }

    $file_name = basename($_FILES["upload_file"]["name"]);
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed = ['pdf', 'doc', 'docx'];

    if (!in_array($file_type, $allowed)) {
        echo "<script>alert('รองรับเฉพาะไฟล์ .pdf, .doc, .docx เท่านั้น'); history.back();</script>";
        exit;
    }

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0755, true)) {
            echo "<script>alert('สร้างโฟลเดอร์ uploads ไม่สำเร็จ'); history.back();</script>";
            exit;
        }
    }

    // สร้างชื่อไฟล์ใหม่ป้องกันซ้ำและปลอดภัย
    $new_file_name = time() . "_" . uniqid() . "." . $file_type;
    $target_file = $target_dir . $new_file_name;

    if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
        $upload_file = $target_file;
    } else {
        echo "<script>alert('ไม่สามารถอัปโหลดไฟล์ได้ กรุณาตรวจสอบสิทธิ์ของโฟลเดอร์ uploads'); history.back();</script>";
        exit;
    }
}

// === เตรียม SQL สำหรับ INSERT ===
$sql = "INSERT INTO EVEN_JOIN (
    JOIN_ID, SCHOOLID, ACCTIVITYNAME, JOIN_DATE, JOIN_TIME,
    ACCTIVITYDESC, TOTAL_STUDENTS, TOTAL_TEACHER, CONTACT_NAME, CONTACT_NUMBER,
    FILE_PATH, JOIN_TYPE
) VALUES (
    even_join_seq.NEXTVAL, :schoolID, :activityname, TO_DATE(:join_date, 'YYYY-MM-DD'),
    :join_time, :activitydesc, :total_students, :total_teacher,
    :contact_name, :contact_number, :file_path, :join_type
)";

$stmt = oci_parse($ubureg, $sql);
oci_bind_by_name($stmt, ":schoolID", $schoolID);
oci_bind_by_name($stmt, ":activityname", $activityname);
oci_bind_by_name($stmt, ":join_date", $join_date);
oci_bind_by_name($stmt, ":join_time", $join_time);
oci_bind_by_name($stmt, ":activitydesc", $activitydesc);
oci_bind_by_name($stmt, ":total_students", $total_students);
oci_bind_by_name($stmt, ":total_teacher", $total_teacher);
oci_bind_by_name($stmt, ":contact_name", $contact_name);
oci_bind_by_name($stmt, ":contact_number", $contact_number);
oci_bind_by_name($stmt, ":file_path", $upload_file);
oci_bind_by_name($stmt, ":join_type", $join_type);

// === บันทึกข้อมูล ===
if (oci_execute($stmt)) {
    echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); window.location='OutsideSchedule.php';</script>";
} else {
    $e = oci_error($stmt);
    echo "<script>alert('เกิดข้อผิดพลาด: " . htmlentities($e['message']) . "'); history.back();</script>";
}

oci_free_statement($stmt);
oci_close($ubureg);
?>
