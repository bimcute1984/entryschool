<?php
include 'chksession.php';
include '../pages/backend/connectDB.php';

// รับค่าจากฟอร์ม
$event_id = $_POST['event_id'] ?? '';
$schoolID = $_SESSION['schoolID'] ?? '';

$total_students = $_POST['total_students'] ?? '';
$total_teacher = $_POST['total_teacher'] ?? '';
$contact_name = $_POST['contact_name'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';

// ตรวจสอบความถูกต้องเบื้องต้น
if (empty($event_id) || empty($schoolID)) {
    echo "<script>alert('ข้อมูลไม่ครบถ้วน'); window.location.href='GuildanceTable.php';</script>";
    exit;
}

// สร้างคำสั่ง SQL สำหรับอัปเดต
$sql = "UPDATE EVEN_JOIN
        SET TOTAL_STUDENTS = :total_students,
            TOTAL_TEACHER = :total_teacher,
            CONTACT_NAME = :contact_name,
            CONTACT_NUMBER = :contact_number
        WHERE EVENT_ID = :event_id AND SCHOOLID = :schoolID";

$stmt = oci_parse($ubureg, $sql);

// ผูกค่าพารามิเตอร์
oci_bind_by_name($stmt, ':total_students', $total_students);
oci_bind_by_name($stmt, ':total_teacher', $total_teacher);
oci_bind_by_name($stmt, ':contact_name', $contact_name);
oci_bind_by_name($stmt, ':contact_number', $contact_number);
oci_bind_by_name($stmt, ':event_id', $event_id);
oci_bind_by_name($stmt, ':schoolID', $schoolID);

// ดำเนินการและตรวจสอบผล
if (oci_execute($stmt)) {
    echo "<script>alert('อัปเดตข้อมูลเรียบร้อยแล้ว'); window.location.href='GuildanceTable.php';</script>";
} else {
    $e = oci_error($stmt);
    echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดต: " . htmlentities($e['message']) . "'); window.history.back();</script>";
}
?>
