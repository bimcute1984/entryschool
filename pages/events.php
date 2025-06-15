<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";

// ฟังก์ชันแปลงวันที่ภาษาไทย
function thai_date($date) {
  if (!$date) return '-';
  $thai_months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 
                  'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
  $d = date('j', strtotime($date));
  $m = $thai_months[date('n', strtotime($date)) - 1];
  $y = date('Y', strtotime($date)) + 543;
  return "$d $m $y";
}

function thai_time($time) {
  return $time ? date('H:i', strtotime($time)) . ' น.' : '-';
}
?>

<!doctype html>
<html lang="en">
<head>
  <?php include 'component/header.php'; ?>
  <title>ข้อมูลกิจกรรมแนะแนว</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
     data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
  <?php include 'component/menu.php'; ?>
  <div class="body-wrapper">
    <?php include 'component/navbar.php'; ?>
<br>
<br>
<br>
<br>
    <div class="container py-5">
      <h2 class="mb-4">ข้อมูลการแนะแนว ปีการศึกษา 2569</h2>

      <?php
      $sql = "SELECT * FROM EVENTS_GUILDANCE";
      $parse = oci_parse($ubureg, $sql);
      oci_execute($parse);
      ?>

      <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>ลำดับที่</th>
            <th>ชื่อโรงเรียน</th>
            <th>จังหวัด</th>
            <th>วันที่จัด</th>
            <th>เวลา</th>
            <th>จำนวนนักเรียน</th>
            <th>การเข้าร่วมกิจกรรม</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = oci_fetch_assoc($parse)): ?>
            <tr>
              <td><?= htmlentities($row['EVENT_ID']) ?></td>
              <td><?= htmlentities($row['SCHOOLMAINNAME']) ?></td>
              <td><?= htmlentities($row['PROVINCE']) ?></td>
              <td><?= thai_date($row['DATE']) ?></td>
              <td><?= thai_time($row['TIME']) ?></td>
              <td><?= htmlentities($row['TOTAL_SCHOOLMAIN']) ?></td>
              <td>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#joinModal"
                        data-event-id="<?= $row['EVENT_ID'] ?>"
                        data-event-name="<?= htmlentities($row['SCHOOLMAINNAME']) ?>">
                  เข้าร่วมกิจกรรม
                </button>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="joinModal" tabindex="-1" aria-labelledby="joinModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="save_join.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">เข้าร่วมกิจกรรม</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="event_id" id="eventId">
          <div class="mb-3">
            <label class="form-label">กิจกรรม:</label>
            <input type="text" class="form-control" id="eventName" disabled>
          </div>
          <div class="mb-3">
            <label class="form-label">วันที่เข้าร่วม:</label>
            <input type="date" class="form-control" name="join_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">ยืนยันเข้าร่วม</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  const joinModal = document.getElementById('joinModal');
  joinModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const eventId = button.getAttribute('data-event-id');
    const eventName = button.getAttribute('data-event-name');
    document.getElementById('eventId').value = eventId;
    document.getElementById('eventName').value = eventName;
  });
</script>

<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
