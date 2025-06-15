<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: ../pages/AdminAdddata.php");
    exit;
}
include 'chksession.php';
include "../pages/backend/connectDB.php"; // เชื่อมต่อ Oracle DB

// ฟังก์ชันแปลงวันที่เป็นภาษาไทย
function thai_date($date) {
  if (!$date) return '-';
  $thai_months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.',
                  'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
  $d = date('j', strtotime($date));
  $m = $thai_months[date('n', strtotime($date)) - 1];
  $y = date('Y', strtotime($date)) + 543;
  return "$d $m $y";
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schoolmainname = $_POST['schoolmainname'];
    $province = $_POST['province'];
    $event_date_raw = $_POST['date']; // YYYY-MM-DD
    $time = $_POST['time'];
    $description = $_POST['description'];
    $contactname = $_POST['contactname'];
    $contactnumber = $_POST['contactnumber'];
    $total_schoolmain = (int)$_POST['total_schoolmain'];

    // หา EVENT_ID ใหม่
    $sql_id = "SELECT NVL(MAX(EVENT_ID), 0) + 1 AS NEW_ID FROM EVENTS_GUILDANCE";
    $stid_id = oci_parse($ubureg, $sql_id);
    oci_execute($stid_id);
    $row_id = oci_fetch_assoc($stid_id);
    $new_id = $row_id['NEW_ID'];

    // แปลงวันที่ให้เหมาะกับ TO_DATE
    $event_date_for_oracle = date('Y-m-d', strtotime($event_date_raw));

    // เตรียมคำสั่ง INSERT
    $sql_insert = "INSERT INTO EVENTS_GUILDANCE (
        EVENT_ID, SCHOOLMAINNAME, PROVINCE, EVENT_DATE, TIME, DESCRIPTION,
        CONTACTNAME, CONTACTNUMBER, TOTAL_SCHOOLMAIN
    ) VALUES (
        :event_id, :schoolmainname, :province, TO_DATE(:event_date, 'YYYY-MM-DD'),
        :time, :description, :contactname, :contactnumber, :total_schoolmain
    )";

    $stid_insert = oci_parse($ubureg, $sql_insert);
    oci_bind_by_name($stid_insert, ':event_id', $new_id);
    oci_bind_by_name($stid_insert, ':schoolmainname', $schoolmainname);
    oci_bind_by_name($stid_insert, ':province', $province);
    oci_bind_by_name($stid_insert, ':event_date', $event_date_for_oracle);
    oci_bind_by_name($stid_insert, ':time', $time);
    oci_bind_by_name($stid_insert, ':description', $description);
    oci_bind_by_name($stid_insert, ':contactname', $contactname);
    oci_bind_by_name($stid_insert, ':contactnumber', $contactnumber);
    oci_bind_by_name($stid_insert, ':total_schoolmain', $total_schoolmain);

    $result = oci_execute($stid_insert, OCI_COMMIT_ON_SUCCESS);

    if ($result) {
        $msg = "เพิ่มข้อมูลสำเร็จ!";
    } else {
        $e = oci_error($stid_insert);
        $msg = "เกิดข้อผิดพลาด: " . htmlentities($e['message']);
    }
}
?>

<!doctype html>
<html lang="th">
<head>
  <?php include 'component/header.php'; ?>
</head>

<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
     data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
  <?php include 'component/menu.php'; ?>
  <div class="body-wrapper">
    <?php include 'component/navbar.php'; ?>
    <br>
    <br>
    
    <div class="container py-5">
      
      <h2 class="mb-4">ข้อมูลกิจกรรมแนะแนวทั้งหมด</h2>

      <?php
        $sql = "SELECT * FROM EVENTS_GUILDANCE ORDER BY EVENT_DATE ASC, TIME ASC";
        $stid = oci_parse($ubureg, $sql);
        oci_execute($stid);
        $i = 1;
        ?>

      <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>ลำดับที่</th>
            <th>ชื่อโรงเรียน</th>
            <th>จังหวัด</th>
            <th>วันที่จัด</th>
            <th>เวลา</th>
            <th>สถานที่</th>
            <th>จำนวนนักเรียนหลัก</th>
            <th>ชื่อผู้ประสานงานหลัก</th>
            <th>เบอร์โทรศัพท์</th>
            
          </tr>
        </thead>
        <tbody>
          <?php while ($row = oci_fetch_assoc($stid)): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlentities($row['SCHOOLMAINNAME']) ?></td>
              <td><?= htmlentities($row['PROVINCE']) ?></td>
              <td><?= thai_date($row['EVENT_DATE']) ?></td>
              <td><?= htmlentities($row['TIME']) ?></td>
              <td><?= htmlentities($row['DESCRIPTION']) ?></td>
              <td><?= htmlentities($row['TOTAL_SCHOOLMAIN']) ?></td>
              <td><?= htmlentities($row['CONTACTNAME']) ?></td>
              <td><?= htmlentities($row['CONTACTNUMBER']) ?></td>
              
            </tr>
            
          <?php endwhile; ?>
        </tbody>
      </table>
       <div class="card shadow-sm mb-4">
        <div class="card-body">
          <h4 class="card-title mb-3">ข้อมูลการแนะแนวประจำปีการศึกษา 2569</h4>
          <a href="AdminAdddata.php" class="btn btn-primary me-2">เพิ่มตารางการแนะแนว</a>
          <!-- <a href="ManageSchool.php" class="btn btn-secondary me-2">จัดการโรงเรียน</a>
          <a href="SummaryReport.php" class="btn btn-success">สรุปรายงาน</a> -->
        </div>
      </div>

    </div>
  </div>
</div>

<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.min.js"></script>
</body>
</html>
