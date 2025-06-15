<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";

// ตรวจสอบว่า event_id ถูกส่งมาหรือไม่
if (!isset($_GET['event_id'])) {
    echo "ไม่พบรหัสกิจกรรม";
    exit;
}

$event_id = $_GET['event_id'];
$schoolID = $_SESSION['schoolID'];
$join_date = $_POST['join_date'] ?? date("Y-m-d");
$join_time = $_POST['join_time'] ?? date("H:i:s");



// ดึงข้อมูลกิจกรรมตาม event_id
$sql = "SELECT * FROM EVENTS_GUILDANCE WHERE EVENT_ID = :event_id";
$stmt = oci_parse($ubureg, $sql);
oci_bind_by_name($stmt, ":event_id", $event_id);
oci_execute($stmt);
$event = oci_fetch_assoc($stmt);

// ตรวจสอบว่ามีการเข้าร่วมกิจกรรมในตารางแล้วหรือยัง
$sql_check = "SELECT COUNT(*) AS CNT FROM EVEN_JOIN WHERE SCHOOLID = :schoolID AND JOIN_TYPE = 'A'";
$stmt_check = oci_parse($ubureg, $sql_check);
oci_bind_by_name($stmt_check, ":schoolID", $schoolID);
oci_execute($stmt_check);
$row_check = oci_fetch_assoc($stmt_check);
if ($row_check['CNT'] > 0) {
  echo "<script>
    alert('คุณได้เข้าร่วมกิจกรรมในตารางแล้ว กรุณาลบรายการเดิมก่อน');
    window.location.href = 'GuildanceTable.php';
  </script>";
  exit;
}


if (!$event) {
    echo "ไม่พบข้อมูลกิจกรรม";
    exit;
}

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
?>

<!doctype html>
<html lang="th">
<head>
  <?php include 'component/header.php'; ?>
</head>
<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical"
     data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">
  <?php include 'component/menu.php'; ?>
  <div class="body-wrapper">
    <?php include 'component/navbar.php'; ?>
    <br>
    <br>
    <div class="container py-5">
      <h3 class="mb-4">แบบฟอร์มเข้าร่วมกิจกรรมแนะแนว</h3>

      <div class="card p-4 mb-4">
        <p><strong>ชื่อกิจกรรม:</strong> <?= htmlentities($event['SCHOOLMAINNAME']) ?></p>
        <p><strong>จังหวัด:</strong> <?= htmlentities($event['PROVINCE']) ?></p>
        <p><strong>วันที่:</strong> <?= thai_date($event['EVENT_DATE']) ?></p>
        <p><strong>เวลา:</strong> <?= thai_time($event['TIME']) ?></p>
        <p><strong>สถานที่จัดกิจกรรม:</strong> <?= htmlentities($event['DESCRIPTION']) ?></p>
    
      </div>

      <form action="save_join.php" method="post">
        <input type="hidden" name="event_id" value="<?= $_GET['event_id'] ?>">

        <div class="mb-3">
          <label for="contact_prefix" class="form-label">คำนำหน้า</label>
          <select class="form-select" name="contact_prefix" id="contact_prefix" required>
            <option value="">-- เลือก --</option>
            <option value="นาย">นาย</option>
            <option value="นางสาว">นางสาว</option>
            <option value="อื่นๆ">อื่นๆ</option>
          </select>
        </div>

        <div class="mb-3" id="other_prefix_div" style="display:none;">
          <label for="contact_prefix_other" class="form-label">ระบุคำนำหน้าอื่นๆ</label>
          <input type="text" class="form-control" name="contact_prefix_other" id="contact_prefix_other">
        </div>

        <div class="mb-3">
          <label for="contact_name" class="form-label">ชื่อ-นามสกุลผู้ติดต่อ</label>
          <input type="text" class="form-control" name="contact_name" id="contact_name" required>
        </div>

        <div class="mb-3">
          <label for="contact_number" class="form-label">เบอร์โทรศัพท์</label>
          <input type="text" class="form-control" name="contact_number" id="contact_number"
                 pattern="[0-9]{10}" maxlength="10" required>
        </div>
        <div class="mb-3">
          <label for="total_students" class="form-label">จำนวนนักเรียนที่จะนำรับฟังแนะแนว</label>
          <input type="number" class="form-control" name="total_students" id="total_students"
                 pattern="[0-9]{10}" maxlength="4" required>
        </div>
        
        <div class="mb-3">
          <label for="total_teacher" class="form-label">จำนวนครูที่จะนำรับฟังแนะแนว</label>
          <input type="number" class="form-control" name="total_teacher" id="total_teacher"
                 pattern="[0-9]{10}" maxlength="4" required>
        </div>

        <button type="submit" class="btn btn-success">บันทึกการเข้าร่วม</button>
        <a href="GuildanceTable.php" class="btn btn-secondary">ยกเลิก</a>
      </form>
    </div>
  </div>
</div>

<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.min.js"></script>
<script>
  document.getElementById("contact_prefix").addEventListener("change", function () {
    var otherDiv = document.getElementById("other_prefix_div");
    if (this.value === "อื่นๆ") {
      otherDiv.style.display = "block";
      document.getElementById("contact_prefix_other").required = true;
    } else {
      otherDiv.style.display = "none";
      document.getElementById("contact_prefix_other").required = false;
    }
  });
</script>
</body>
</html>
