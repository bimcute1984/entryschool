<?php
include 'chksession.php';
include '../pages/backend/connectDB.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schoolmainname = $_POST['schoolmainname'];
    $province = $_POST['province'];
    $event_date = $_POST['event_date'];
    $time = $_POST['time'];
    $description = $_POST['description'];
    $contactname = $_POST['contactname'];
    $contactnumber = $_POST['contactnumber'];
    $total_schoolmain = (int)$_POST['total_schoolmain'];

    $sql = "UPDATE EVENTS_GUILDANCE SET 
        SCHOOLMAINNAME = :schoolmainname,
        PROVINCE = :province,
        EVENT_DATE = TO_DATE(:event_date, 'YYYY-MM-DD'),
        TIME = :time,
        DESCRIPTION = :description,
        CONTACTNAME = :contactname,
        CONTACTNUMBER = :contactnumber,
        TOTAL_SCHOOLMAIN = :total_schoolmain
        WHERE EVENT_ID = :id";

    $stid = oci_parse($ubureg, $sql);

    oci_bind_by_name($stid, ':schoolmainname', $schoolmainname);
    oci_bind_by_name($stid, ':province', $province);
    oci_bind_by_name($stid, ':event_date', $event_date);
    oci_bind_by_name($stid, ':time', $time);
    oci_bind_by_name($stid, ':description', $description);
    oci_bind_by_name($stid, ':contactname', $contactname);
    oci_bind_by_name($stid, ':contactnumber', $contactnumber);
    oci_bind_by_name($stid, ':total_schoolmain', $total_schoolmain);
    oci_bind_by_name($stid, ':id', $id);

    if (oci_execute($stid, OCI_COMMIT_ON_SUCCESS)) {
        header('Location: AdminAdddata.php');
        exit;
    } else {
        $e = oci_error($stid);
        echo "เกิดข้อผิดพลาด: " . $e['message'];
    }
}

// ดึงข้อมูลเดิม
$sql_select = "SELECT * FROM EVENTS_GUILDANCE WHERE EVENT_ID = :id";
$stid_select = oci_parse($ubureg, $sql_select);
oci_bind_by_name($stid_select, ':id', $id);
oci_execute($stid_select);
$data = oci_fetch_assoc($stid_select);
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขกิจกรรมแนะแนว</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f0f2f5;">

<!-- Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editEventLabel">📝 แก้ไขกิจกรรมแนะแนว</h5>
        <a href="AdminAdddata.php" class="btn-close" aria-label="Close"></a>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label">🏫 ชื่อสถานศึกษา</label>
              <input type="text" name="schoolmainname" class="form-control" value="<?= htmlentities($data['SCHOOLMAINNAME']) ?>" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">📍 จังหวัด</label>
              <input type="text" name="province" class="form-control" value="<?= htmlentities($data['PROVINCE']) ?>" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">📅 วันที่จัดกิจกรรม</label>
              <input type="date" name="event_date" class="form-control" value="<?= date('Y-m-d', strtotime($data['EVENT_DATE'])) ?>" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">⏰ เวลา</label>
              <input type="text" name="time" class="form-control" value="<?= htmlentities($data['TIME']) ?>" required>
            </div>

            <div class="col-md-12">
              <label class="form-label">🗺️ สถานที่จัดกิจกรรม</label>
              <textarea name="description" class="form-control" rows="2"><?= htmlentities($data['DESCRIPTION']) ?></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label">👩‍💼 ชื่อผู้ประสานงาน</label>
              <input type="text" name="contactname" class="form-control" value="<?= htmlentities($data['CONTACTNAME']) ?>" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">📱 เบอร์โทร</label>
              <input type="text" name="contactnumber" class="form-control" value="<?= htmlentities($data['CONTACTNUMBER']) ?>" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">🏫 จำนวนนักเรียนโรงเรียนหลัก</label>
              <input type="number" name="total_schoolmain" class="form-control" value="<?= htmlentities($data['TOTAL_SCHOOLMAIN']) ?>" required>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <a href="AdminAdddata.php" class="btn btn-secondary">ย้อนกลับ</a>
          <button type="submit" class="btn btn-success">💾 บันทึกการแก้ไข</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  var editModal = new bootstrap.Modal(document.getElementById('editEventModal'));
  editModal.show();
</script>

</body>
</html>
