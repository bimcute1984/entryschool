<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // แสดง error เพื่อ debug

include 'chksession.php';
include "../pages/backend/connectDB.php";

header('Content-Type: application/json');

if (!$ubureg) {
    echo json_encode(['error' => 'ไม่สามารถเชื่อมต่อฐานข้อมูลได้']);
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['error' => 'Missing ID']);
    exit;
}

$sql = "SELECT JOIN_ID, ACCTIVITYNAME, JOIN_DATE, JOIN_TIME, ACCTIVITYDESC, 
               TOTAL_STUDENTS, TOTAL_TEACHER, CONTACT_NAME, CONTACT_NUMBER, FILE_PATH
        FROM EVEN_JOIN 
        WHERE JOIN_ID = :id";
$stmt = oci_parse($ubureg, $sql);
if (!$stmt) {
    echo json_encode(['error' => 'ไม่สามารถเตรียมคำสั่ง SQL ได้']);
    exit;
}

oci_bind_by_name($stmt, ':id', $id);

if (oci_execute($stmt)) {
    $row = oci_fetch_assoc($stmt);
    if ($row) {
        foreach ($row as $key => $value) {
            if (is_resource($value)) {
                $row[$key] = stream_get_contents($value);
            }
        }

        // ✅ แปลง JOIN_DATE เป็น Y-m-d และ JOIN_DATE_TH (พ.ศ.)
        if (!empty($row['JOIN_DATE'])) {
            $timestamp = strtotime($row['JOIN_DATE']);
            if ($timestamp !== false) {
                $thai_months = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                    "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
                $day = date('j', $timestamp);
                $month = (int)date('n', $timestamp);
                $year_th = (int)date('Y', $timestamp) + 543;

                $row['JOIN_DATE_TH'] = "$day " . $thai_months[$month] . " $year_th";
                $row['JOIN_DATE'] = date('Y-m-d', $timestamp);
            } else {
                $row['JOIN_DATE_TH'] = "";
                $row['JOIN_DATE'] = "";
            }
        } else {
            $row['JOIN_DATE_TH'] = "";
            $row['JOIN_DATE'] = "";
        }

        echo json_encode($row, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['error' => 'ไม่พบข้อมูล']);
    }
} else {
    $e = oci_error($stmt);
    echo json_encode(['error' => 'SQL Error: ' . $e['message']]);
}

oci_free_statement($stmt);
oci_close($ubureg);
?>
