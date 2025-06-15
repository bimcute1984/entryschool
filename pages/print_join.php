<?php
include 'chksession.php';
include '../pages/backend/connectDB.php';

$event_id = $_GET['event_id'];
$schoolID = $_SESSION['schoolID'];

$sql = "SELECT * FROM EVEN_JOIN ej
        JOIN EVENTS_GUILDANCE ev ON ej.EVENT_ID = ev.EVENT_ID
        WHERE ej.EVENT_ID = :event_id AND ej.SCHOOLID = :schoolID";
$stmt = oci_parse($ubureg, $sql);
oci_bind_by_name($stmt, ":event_id", $event_id);
oci_bind_by_name($stmt, ":schoolID", $schoolID);
oci_execute($stmt);
$row = oci_fetch_assoc($stmt);

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

<h2>ข้อมูลเข้าร่วมกิจกรรม</h2>
<p>โรงเรียน: <?= $row['SCHOOLMAINNAME'] ?></p>
<p>จังหวัด: <?= $row['PROVINCE'] ?></p>
<p>วันที่จัด: <?= formatThaiDate($row['EVENT_DATE']) ?></p>
<p>สถานที่จัดงาน: <?= $row['DESCRIPTION'] ?></p>
<p>นักเรียน: <?= $row['TOTAL_STUDENTS'] ?> คน</p>
<p>ครู: <?= $row['TOTAL_TEACHER'] ?> คน</p>

<p>ครูผู้ประสานงาน: <?= $row['CONTACT_PREFIX'] . $row['CONTACT_NAME'] ?> (<?= $row['CONTACT_NUMBER'] ?>)</p>

<script>window.print();</script>
