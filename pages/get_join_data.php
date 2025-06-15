<?php
// เปิด header สำหรับ JSON
header('Content-Type: application/json; charset=utf-8');

// ตรวจสอบ session
include 'chksession.php';

// เชื่อมต่อฐานข้อมูล
include "../pages/backend/connectDB.php";

// รับค่า join_id จาก query string
$join_id = $_GET['join_id'] ?? null;

if (!$join_id) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Missing join_id']);
    exit;
}

// สร้างคำสั่ง SQL
$sql = "SELECT JOIN_ID, ACCTIVITYNAME, ACCTIVITYDESC, 
               TO_CHAR(JOIN_DATE, 'YYYY-MM-DD') AS JOIN_DATE, 
               JOIN_TIME, TOTAL_STUDENTS, TOTAL_TEACHER, 
               CONTACT_NAME, CONTACT_NUMBER
        FROM EVEN_JOIN
        WHERE JOIN_ID = :join_id";

// เตรียมคำสั่ง
$stmt = oci_parse($ubureg, $sql);

// ผูกค่าตัวแปร
oci_bind_by_name($stmt, ":join_id", $join_id);

// รันคำสั่ง SQL
if (!oci_execute($stmt)) {
    $e = oci_error($stmt);
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'error' => 'SQL execution failed',
        'details' => $e['message']
    ]);
    exit;
}

// ดึงข้อมูลแถวเดียว
$data = oci_fetch_assoc($stmt);

// ส่งข้อมูลออกแบบ JSON
if ($data) {
    // กรองข้อมูลให้ใช้ UTF-8
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'Data not found for JOIN_ID: ' . $join_id]);
}
?>
