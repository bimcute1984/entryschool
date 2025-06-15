<?php
include 'chksession.php';
include '../pages/backend/connectDB.php';

$event_id = $_GET['event_id'];
$schoolID = $_SESSION['schoolID'];

$sql = "DELETE FROM EVEN_JOIN WHERE EVENT_ID = :event_id AND SCHOOLID = :schoolID";
$stmt = oci_parse($ubureg, $sql);
oci_bind_by_name($stmt, ":event_id", $event_id);
oci_bind_by_name($stmt, ":schoolID", $schoolID);

if (oci_execute($stmt)) {
    oci_commit($ubureg); // ✅ commit สำคัญมาก!
    header("Location: GuildanceTable.php?deleted=1");
} else {
    echo "ไม่สามารถลบข้อมูลได้";
}
?>
