<?php
session_start();
include "../pages/backend/connectDB.php";
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// รับค่าจาก POST
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// กำหนด username และ password ที่ถูกต้อง
$correct_username = 'admin';
$correct_password = '8888';

if ($username === $correct_username && $password === $correct_password) {
    // Login สำเร็จ
    echo json_encode([
        'status' => 'success',
        'message' => 'ยินดีต้อนรับเข้าสู่ระบบ',
    ]);
} else {
    // Login ล้มเหลว
    echo json_encode([
        'status' => 'error',
        'message' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
    ]);
}
}
