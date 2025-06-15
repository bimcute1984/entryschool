<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";
<<<<<<< HEAD
?>
<!doctype html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
  <?php
  include 'component/header.php';
  ?>
  
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <?php
  include 'component/menu.php';
    ?>
    <!--  Main wrapper -->
    <div class="body-wrapper">
    <?php
  include 'component/navbar.php';
    ?>







<div class="container my-5">
    <div id="calendar"></div>
  </div>

  <!-- Modal แสดงรายละเอียดกิจกรรม -->
  <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">รายละเอียดกิจกรรม</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p id="eventTitle"></p>
          <p id="eventDescription"></p>
        </div>
      </div>
    </div>
  </div>

  <!-- JS ของ Bootstrap และ FullCalendar (วางก่อนปิด </body>) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

  <!-- สคริปต์ตั้งค่าปฏิทิน -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'load-events.php', // โหลดกิจกรรมจาก PHP

        eventClick: function(info) {
          document.getElementById('eventTitle').innerText = info.event.title;
          document.getElementById('eventDescription').innerText = info.event.extendedProps.description || "ไม่มีรายละเอียด";
          var modal = new bootstrap.Modal(document.getElementById('eventModal'));
          modal.show();
        }
      });

      calendar.render();
    });
  </script>



  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
</body>

</html>
=======

// ฟังก์ชันแปลงวันที่ภาษาไทย
function thai_date($even_date) {
  if (!$even_date) return '-';
  $thai_months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.',
                  'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
  $d = date('j', strtotime($even_date));
  $m = $thai_months[date('n', strtotime($even_date)) - 1];
  $y = date('Y', strtotime($even_date)) + 543;
  return "$d $m $y";
}

function thai_time($time) {
  return $time ? date('H:i', strtotime($time)) . ' น.' : '-';
}

$schoolID = $_SESSION['schoolID'];

// ดึงรายการกิจกรรมที่โรงเรียนนี้เข้าร่วม
$joined_events = [];
$sql_joined = "SELECT EVENT_ID FROM EVEN_JOIN WHERE SCHOOLID = :schoolID AND JOIN_TYPE = 'A'";
$stmt_joined = oci_parse($ubureg, $sql_joined);
oci_bind_by_name($stmt_joined, ":schoolID", $schoolID);
oci_execute($stmt_joined);
while ($r = oci_fetch_assoc($stmt_joined)) {
  $joined_events[] = $r['EVENT_ID'];
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
    <br><br>
    <div class="container py-5">
      <h2 class="mb-4">ข้อมูลกิจกรรมแนะแนว ปีการศึกษา 2569</h2>

      <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>ลำดับ</th>
            <th>ชื่อโรงเรียน</th>
            <th>จังหวัด</th>
            <th>วันที่จัด</th>
            <th>เวลา</th>
            <th>สถานที่จัดกิจกรรม</th>
            <th>จำนวน นร.</th>
            <th>การเข้าร่วมกิจกรรม</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM EVENTS_GUILDANCE ORDER BY EVENT_DATE ASC";
        $stmt = oci_parse($ubureg, $sql);
        oci_execute($stmt);
        $count = 1;
        while ($row = oci_fetch_assoc($stmt)) {
          $event_id = $row['EVENT_ID'];
          ?>
          <tr>
            <td><?= $count++ ?></td>
            <td><?= htmlentities($row['SCHOOLMAINNAME']) ?></td>
            <td><?= htmlentities($row['PROVINCE']) ?></td>
            <td><?= thai_date($row['EVENT_DATE']) ?></td>
            <td><?= thai_time($row['TIME']) ?></td>
            <td><?= htmlentities($row['DESCRIPTION']) ?></td>
            <td><?= htmlentities($row['TOTAL_SCHOOLMAIN']) ?></td>
            
            <td>
              <?php
                $has_joined = count($joined_events) > 0;
                $is_this_event_joined = in_array($event_id, $joined_events);

                if ($is_this_event_joined): ?>
                  <a href="edit_join.php?event_id=<?= $event_id ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                  <a href="delete_join.php?event_id=<?= $event_id ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('คุณแน่ใจว่าต้องการลบข้อมูลนี้หรือไม่?')">ลบ</a>
                  <a href="print_join.php?event_id=<?= $event_id ?>" class="btn btn-success btn-sm" target="_blank">พิมพ์</a>
                <?php elseif ($has_joined): ?>
                  <button class="btn btn-secondary btn-sm" disabled>เข้าร่วม</button>
                <?php else: ?>
                  <a href="join_form.php?event_id=<?= $event_id ?>" class="btn btn-primary btn-sm">เข้าร่วม</a>

                <?php endif; ?>

            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.min.js"></script>
</body>
</html>
>>>>>>> 29b51cc (Test commit)
