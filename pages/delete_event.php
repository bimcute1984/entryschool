<?php
include 'chksession.php';
include '../pages/backend/connectDB.php';

$id = $_GET['id'];

$sql = "DELETE FROM EVENTS_GUILDANCE WHERE EVENT_ID = :id";
$stid = oci_parse($ubureg, $sql);
oci_bind_by_name($stid, ':id', $id);

if (oci_execute($stid, OCI_COMMIT_ON_SUCCESS)) {
    header("Location: AdminAdddata.php");
    exit;
} else {
    $e = oci_error($stid);
    echo "เกิดข้อผิดพลาด: " . $e['message'];
}
