<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";

$schoolID = $_SESSION['schoolID'];

if (!isset($_GET['join_id'])) {
  die("ไม่พบข้อมูล");
}

$join_id = $_GET['join_id'];

$sql = "SELECT * FROM EVEN_JOIN WHERE JOIN_ID = :join_id AND SCHOOLID = :schoolID";
$stmt = oci_parse($ubureg, $sql);
oci_bind_by_name($stmt, ":join_id", $join_id);
oci_bind_by_name($stmt, ":schoolID", $schoolID);
oci_execute($stmt);

$row = oci_fetch_assoc($stmt);
if (!$row) {
  die("ไม่พบข้อมูล");
}

?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <title>พิมพ์ข้อมูลแนะแนวนอกตาราง</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 8px; }
    th { background: #eee; }
  </style>
</head>
<body>
  
<?php
   function formatThaiDate($date) {
    $thaiMonths = [
        '', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน',
        'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
        'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];

    $timestamp = strtotime($date);
    $day = date('j', $timestamp);
    $month = (int)date('n', $timestamp);
    $year = (int)date('Y', $timestamp) + 543;

    return "$day {$thaiMonths[$month]} พ.ศ. $year";
}

?>
  <h2>ข้อมูลแนะแนวนอกตาราง</h2>
  <table>
    <tr><th>ชื่อกิจกรรม</th><td><?=htmlspecialchars($row['ACCTIVITYNAME'])?></td></tr>
    <tr><th>สถานที่จัดกิจกรรม</th><td><?=htmlspecialchars($row['ACCTIVITYDESC'])?></td></tr>
    <tr><th>วันที่</th><td><?=formatThaiDate($row['JOIN_DATE'])?></td></tr>
    <tr><th>เวลา</th><td><?=htmlspecialchars($row['JOIN_TIME'])?> น.</td></tr>
    <tr><th>จำนวนนักเรียน</th><td><?=htmlspecialchars($row['TOTAL_STUDENTS'])?> คน</td></tr>
    <tr><th>จำนวนครู</th><td><?=htmlspecialchars($row['TOTAL_TEACHER'])?> คน</td></tr>
    <tr><th>ชื่อผู้ประสานงาน</th><td><?=htmlspecialchars($row['CONTACT_NAME'])?></td></tr>
    <tr><th>เบอร์โทร</th><td><?=htmlspecialchars($row['CONTACT_NUMBER'])?></td></tr>
    <tr><th>ไฟล์แนบ</th><td>
      <?php if (!empty($row['FILE_PATH'])): ?>
        <a href="<?=htmlspecialchars($row['FILE_PATH'])?>" target="_blank">คลิกดูไฟล์แนบ</a>
      <?php else: ?>
        ไม่มีไฟล์แนบ
      <?php endif; ?>
    </td></tr>
  </table>
  <script>
    window.print();
  </script>
</body>
</html>
