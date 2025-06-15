<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";

$schoolID = $_SESSION['schoolID'];
$sql = "SELECT JOIN_ID, ACCTIVITYNAME, ACCTIVITYDESC, TOTAL_STUDENTS, TOTAL_TEACHER, 
               TO_CHAR(JOIN_DATE, 'YYYY-MM-DD') AS JOIN_DATE, 
               JOIN_TIME, CONTACT_NAME, CONTACT_NUMBER, FILE_NAME, FILE_PATH 
        FROM EVEN_JOIN 
        WHERE JOIN_ID = :join_id";

$stmt = oci_parse($ubureg, $sql);
oci_bind_by_name($stmt, ":join_id", $join_id);
oci_execute($stmt);
$row = oci_fetch_assoc($stmt);




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $activityname = $_POST['activityname'] ?? '';
    $activitydesc = $_POST['activitydesc'] ?? '';
    $total_students = $_POST['total_students'] ?? 0;
    $total_teacher = $_POST['total_teacher'] ?? 0;
    $join_date = $_POST['join_date'] ?? '';
    $join_time = $_POST['join_time'] ?? '';
    $contact_name = $_POST['contact_name'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $file_name = '';
    $file_path = '';

    $sql = "UPDATE EVEN_JOIN SET JOIN_ID = :join_id, SCHOOLID =:schoolID , ACCTIVITYNAME = :activityname, JOIN_DATE = TO_CHAR(:join_date, 'YYYY-MM-DD'), ACCTIVITYDESC = :activitydesc, 
             TOTAL_TEACHER = :total_teacher,TOTAL_STUDENTS = :total_students, CONTACT_NAME = :contact_name , CONTACT_NUMBER = :contact_number, JOIN_TYPE = 'B', FILE_PATH = :file_path WHERE JOIN_ID = :id";


   $stmt = oci_parse($ubureg, $sql);
   oci_bind_by_name($stmt, ":id", $join_id);
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
    oci_execute($stmt);

    echo "<script>alert('แก้ไขสำเร็จ'); window.location='OutsideSchedule.php';</script>";
}


?>


