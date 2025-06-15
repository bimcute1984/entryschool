<?php
include 'db_connect.php'; // เชื่อมต่อ Oracle หรือ MySQL

$id = $_POST['id'];
$response = ['success' => false];

$sql = "SELECT * FROM activities WHERE id = :id";
$parse = oci_parse($conn, $sql);
oci_bind_by_name($parse, ":id", $id);
oci_execute($parse);
$row = oci_fetch_assoc($parse);

if ($row) {
    $response['success'] = true;
    $response['data'] = [
        'id' => $row['ID'],
        'name' => $row['NAME'],
        'file_name' => $row['FILE_NAME'] ?? ''
    ];
}

echo json_encode($response);
?>
