<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";

// รับ event_id และ schoolID
$event_id = $_GET['event_id'] ?? null;
$schoolID = $_SESSION['schoolID'];

if (!$event_id || !$schoolID) {
  die("ไม่พบข้อมูลกิจกรรมหรือโรงเรียน");
}

// ตรวจสอบว่ามีการเข้าร่วมไปแล้วหรือยัง
$sql_check = "SELECT COUNT(*) AS TOTAL FROM EVEN_JOIN WHERE SCHOOLID = :schoolID AND JOIN_TYPE = 'A'";
$stmt_check = oci_parse($ubureg, $sql_check);
oci_bind_by_name($stmt_check, ":schoolID", $schoolID);
oci_execute($stmt_check);
$row = oci_fetch_assoc($stmt_check);

if ($row['TOTAL'] > 0) {
  echo "<script>alert('โรงเรียนของคุณได้เข้าร่วมกิจกรรมไปแล้ว'); window.location='GuildanceTable.php';</script>";
  exit;
}

// สร้าง JOIN_ID (สุ่ม หรือใช้ timestamp)
$join_id = uniqid('JOIN');

// เตรียมคำสั่ง INSERT
$sql_insert = "INSERT INTO EVEN_JOIN (
  JOIN_ID, EVENT_ID, SCHOOLID, JOIN_TYPE
) VALUES (
  :join_id, :event_id, :schoolID, 'A'
)";
$stmt_insert = oci_parse($ubureg, $sql_insert);
oci_bind_by_name($stmt_insert, ":join_id", $join_id);
oci_bind_by_name($stmt_insert, ":event_id", $event_id);
oci_bind_by_name($stmt_insert, ":schoolID", $schoolID);

// ทำการ INSERT
if (oci_execute($stmt_insert)) {
  echo "<script>alert('เข้าร่วมกิจกรรมสำเร็จ'); window.location='GuildanceTable.php';</script>";
} else {
  $e = oci_error($stmt_insert);
  echo "เกิดข้อผิดพลาด: " . $e['message'];
}
?>
