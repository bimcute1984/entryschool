<?php
<<<<<<< HEAD
session_start();

// เช็กว่ามี session ของ user หรือไม่
if (!isset($_SESSION['user'])) {
    // ถ้าไม่มี ให้ redirect ไปหน้า login
    header("Location: login.php");
    exit();
}
?>
=======
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>
>>>>>>> 29b51cc (Test commit)
