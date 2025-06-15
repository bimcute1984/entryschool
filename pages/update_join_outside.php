<?php
error_reporting(0);
ini_set('display_errors', 0);

include 'chksession.php';
include "../pages/backend/connectDB.php";

header('Content-Type: application/json');

$schoolID = $_SESSION['schoolID'] ?? null;

if (!$schoolID) {
    echo json_encode(['success' => false, 'error' => 'ไม่พบข้อมูลผู้ใช้งาน']);
    exit;
}

$join_id = $_POST['join_id'] ?? null;
$activityname = $_POST['activityname'] ?? '';
$join_date = $_POST['join_date'] ?? '';
$join_time = $_POST['join_time'] ?? '';
$activitydesc = $_POST['activitydesc'] ?? '';
$total_students = $_POST['total_students'] ?? 0;
$total_teacher = $_POST['total_teacher'] ?? 0;
$contact_name = $_POST['contact_name'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$join_type = 'B';

if (
    !$join_id ||
    empty($activityname) || empty($join_date) || empty($join_time) ||
    empty($total_students) || empty($total_teacher) ||
    empty($contact_name) || empty($contact_number)
) {
    echo json_encode(['success' => false, 'error' => 'กรุณากรอกข้อมูลให้ครบทุกช่อง']);
    exit;
}

// ดึงไฟล์เดิมจาก DB เพื่อเอาไว้ถ้าไม่อัปโหลดไฟล์ใหม่
$sql_get_file = "SELECT FILE_PATH FROM EVEN_JOIN WHERE JOIN_ID = :join_id AND SCHOOLID = :schoolID";
$stmt_file = oci_parse($ubureg, $sql_get_file);
oci_bind_by_name($stmt_file, ':join_id', $join_id);
oci_bind_by_name($stmt_file, ':schoolID', $schoolID);
oci_execute($stmt_file);
$row_file = oci_fetch_assoc($stmt_file);
$old_file_path = $row_file['FILE_PATH'] ?? '';

$upload_file = $old_file_path; // ค่าเริ่มต้น

// ถ้ามีไฟล์ใหม่ อัปโหลดแทนที่
if (!empty($_FILES['upload_file']['name'])) {

    if ($_FILES['upload_file']['error'] !== 0) {
        echo json_encode(['success' => false, 'error' => 'เกิดข้อผิดพลาดในการอัปโหลดไฟล์ (error code: '.$_FILES['upload_file']['error'].')']);
        exit;
    }

    $file_name = basename($_FILES["upload_file"]["name"]);
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed = ['pdf', 'doc', 'docx'];

    if (!in_array($file_type, $allowed)) {
        echo json_encode(['success' => false, 'error' => 'รองรับเฉพาะไฟล์ .pdf, .doc, .docx เท่านั้น']);
        exit;
    }

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $new_file_name = time() . "_" . uniqid() . "." . $file_type;
    $target_file = $target_dir . $new_file_name;

    if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
        $upload_file = $target_file;

        // ลบไฟล์เก่า (ถ้ามี)
        if ($old_file_path && file_exists($old_file_path)) {
            unlink($old_file_path);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ไม่สามารถอัปโหลดไฟล์ได้']);
        exit;
    }
}

// อัปเดตข้อมูล
$sql = "UPDATE EVEN_JOIN SET
            ACCTIVITYNAME = :activityname,
            JOIN_DATE = TO_DATE(:join_date, 'YYYY-MM-DD'),
            JOIN_TIME = :join_time,
            ACCTIVITYDESC = :activitydesc,
            TOTAL_STUDENTS = :total_students,
            TOTAL_TEACHER = :total_teacher,
            CONTACT_NAME = :contact_name,
            CONTACT_NUMBER = :contact_number,
            FILE_PATH = :file_path
        WHERE JOIN_ID = :join_id AND SCHOOLID = :schoolID AND JOIN_TYPE = :join_type";

$stmt = oci_parse($ubureg, $sql);

oci_bind_by_name($stmt, ':activityname', $activityname);
oci_bind_by_name($stmt, ':join_date', $join_date);
oci_bind_by_name($stmt, ':join_time', $join_time);
oci_bind_by_name($stmt, ':activitydesc', $activitydesc);
oci_bind_by_name($stmt, ':total_students', $total_students);
oci_bind_by_name($stmt, ':total_teacher', $total_teacher);
oci_bind_by_name($stmt, ':contact_name', $contact_name);
oci_bind_by_name($stmt, ':contact_number', $contact_number);
oci_bind_by_name($stmt, ':file_path', $upload_file);
oci_bind_by_name($stmt, ':join_id', $join_id);
oci_bind_by_name($stmt, ':schoolID', $schoolID);
oci_bind_by_name($stmt, ':join_type', $join_type);

if (oci_execute($stmt)) {
    oci_commit($ubureg);
    echo json_encode(['success' => true]);
} else {
    $e = oci_error($stmt);
    echo json_encode(['success' => false, 'error' => $e['message']]);
}

oci_free_statement($stmt);
oci_close($ubureg);
