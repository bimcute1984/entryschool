<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";

$schoolID = $_SESSION['schoolID'];

if (isset($_GET['join_id'])) {
  $join_id = $_GET['join_id'];

  // ลบไฟล์แนบถ้ามี
  $sql_select = "SELECT FILE_PATH FROM EVEN_JOIN WHERE JOIN_ID = :join_id AND SCHOOLID = :schoolID";
  $stmt_select = oci_parse($ubureg, $sql_select);
  oci_bind_by_name($stmt_select, ":join_id", $join_id);
  oci_bind_by_name($stmt_select, ":schoolID", $schoolID);
  oci_execute($stmt_select);
  $row = oci_fetch_assoc($stmt_select);

  if (!empty($row['FILE_PATH']) && file_exists(__DIR__ . '/' . $row['FILE_PATH'])) {
    unlink(__DIR__ . '/' . $row['FILE_PATH']);
  }

  $sql_delete = "DELETE FROM EVEN_JOIN WHERE JOIN_ID = :join_id AND SCHOOLID = :schoolID";
  $stmt_delete = oci_parse($ubureg, $sql_delete);
  oci_bind_by_name($stmt_delete, ":join_id", $join_id);
  oci_bind_by_name($stmt_delete, ":schoolID", $schoolID);

  if (oci_execute($stmt_delete, OCI_COMMIT_ON_SUCCESS)) {
    echo "<script>alert('ลบข้อมูลสำเร็จ'); window.location.href='OutsideSchedule.php';</script>";
  } else {
    $e = oci_error($stmt_delete);
    echo "<script>alert('ผิดพลาด: " . addslashes($e['message']) . "'); window.location.href='OutsideSchedule.php';</script>";
  }
} else {
  header("Location: OutsideSchedule.php");
}
?>
