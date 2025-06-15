<?php
include 'chksession.php';
include '../pages/backend/connectDB.php';

$event_id = $_GET['event_id'];
$schoolID = $_SESSION['schoolID'];

$sql = "SELECT * FROM EVEN_JOIN WHERE EVENT_ID = :event_id AND SCHOOLID = :schoolID";
$stmt = oci_parse($ubureg, $sql);
oci_bind_by_name($stmt, ":event_id", $event_id);
oci_bind_by_name($stmt, ":schoolID", $schoolID);
oci_execute($stmt);
$row = oci_fetch_assoc($stmt);

if (!$row) {
  echo "<script>alert('ไม่พบข้อมูลที่จะแก้ไข'); window.location.href='GuildanceTable.php';</script>";
  exit;
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขข้อมูลการเข้าร่วมกิจกรรม</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">

<!-- Modal -->

<div class="modal fade" id="editJoinModal" tabindex="-1" aria-labelledby="editJoinModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editJoinModalLabel">✏️ แก้ไขข้อมูลการเข้าร่วมกิจกรรม</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
      </div>
      <form method="POST" action="update_join.php">
        <div class="modal-body">
          <input type="hidden" name="event_id" value="<?= $event_id ?>">
          
          <div class="mb-3">
            <label class="form-label">👨‍🎓 จำนวนนักเรียน</label>
            <input type="number" name="total_students" class="form-control" value="<?= $row['TOTAL_STUDENTS'] ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">👩‍🏫 จำนวนครู</label>
            <input type="number" name="total_teacher" class="form-control" value="<?= $row['TOTAL_TEACHER'] ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">👩‍💼 ชื่อผู้ประสานงาน</label>
            <input type="text" name="contact_name" class="form-control" value="<?= $row['CONTACT_NAME'] ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">📱 เบอร์โทรศัพท์</label>
            <input type="text" name="contact_number" class="form-control" value="<?= $row['CONTACT_NUMBER'] ?>" required>
          </div>

        </div>
        <div class="modal-footer">
          <a href="GuildanceTable.php" class="btn btn-secondary">ย้อนกลับ</a>
          <button type="submit" class="btn btn-success">💾 อัปเดตข้อมูล</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var modalEl = document.getElementById('editJoinModal');
    if (modalEl) {
      var modal = new bootstrap.Modal(modalEl);
      modal.show();
    }
  });
</script>
</body>
</html>
