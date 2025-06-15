<?php
include '../pages/backend/connectDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $joinID = $_POST['join_id'];
    $status = $_POST['status'];

    $sql = "UPDATE EVEN_JOIN SET STATUS = :status WHERE JOIN_ID = :join_id";
    $stid = oci_parse($ubureg, $sql);
    oci_bind_by_name($stid, ':status', $status);
    oci_bind_by_name($stid, ':join_id', $joinID);
    oci_execute($stid);
    oci_free_statement($stid);
    oci_close($ubureg);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
