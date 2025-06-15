<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>อัลบัมหน้าเว็บย่อย</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
  <h2 class="mb-4">หน้าเว็บย่อยแบบอัลบัม</h2>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    
    <!-- Card 1 -->
    <div class="col">
      <div class="card h-100">
        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">หน้า 1</h5>
          <p class="card-text">คำอธิบายสั้น ๆ ของหน้า 1</p>
          <a href="page1.html" class="btn btn-primary">ดูเพิ่มเติม</a>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col">
      <div class="card h-100">
        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">หน้า 2</h5>
          <p class="card-text">คำอธิบายสั้น ๆ ของหน้า 2</p>
          <a href="page2.html" class="btn btn-primary">ดูเพิ่มเติม</a>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col">
      <div class="card h-100">
        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">หน้า 3</h5>
          <p class="card-text">คำอธิบายสั้น ๆ ของหน้า 3</p>
          <a href="page3.html" class="btn btn-primary">ดูเพิ่มเติม</a>
        </div>
      </div>
    </div>

  </div>
</div>
=======
<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";

$schoolID = $_SESSION['schoolID'];

$upload_dir = __DIR__ . "/uploads/";
$upload_display_path = "/entryschool/pages/uploads/";

if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากฟอร์ม
    $activityname = $_POST['activityname'] ?? '';
    $activitydesc = $_POST['activitydesc'] ?? '';
    $total_students = $_POST['total_students'] ?? 0;
    $total_teacher = $_POST['total_teacher'] ?? 0;
    $join_date = $_POST['join_date'] ?? '';
    $join_time = $_POST['join_time'] ?? '';
    $contact_name = $_POST['contact_name'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $file_name = '';
    $file_path = '';

    // อัปโหลดไฟล์
    if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] == 0) {
        $ext = pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['pdf', 'doc', 'docx'])) {
            $file_name = uniqid("JOIN") . "_" . $schoolID . "_" . date("YmdHis") . "." . $ext;
            $file_server_path = $upload_dir . $file_name;
            $file_path = $upload_display_path . $file_name;

            if (!move_uploaded_file($_FILES['upload_file']['tmp_name'], $file_server_path)) {
                echo "<p style='color:red;'>❌ ไม่สามารถอัปโหลดไฟล์ได้ ตรวจสอบ permission ของโฟลเดอร์ uploads</p>";
                exit;
            }
        } else {
            echo "<p style='color:red;'>❌ รองรับเฉพาะไฟล์ .pdf, .doc, .docx เท่านั้น</p>";
            exit;
        }
    }

    // ดึงค่า NEXTVAL
    $sql_seq = "SELECT EVEN_JOIN_SEQ.NEXTVAL AS NEXT_ID FROM DUAL";
    $stmt_seq = oci_parse($ubureg, $sql_seq);
    oci_execute($stmt_seq);
    $row_seq = oci_fetch_assoc($stmt_seq);
    $join_id = $row_seq['NEXT_ID'];

    // ตั้งค่า event_id เป็น NULL หรือ 0 (เพราะเป็นกิจกรรมนอกตาราง)
    $event_id = null;

    $sql_insert = "INSERT INTO EVEN_JOIN 
      (JOIN_ID, SCHOOLID, TOTAL_STUDENTS, TOTAL_TEACHER, CONTACT_NAME, CONTACT_NUMBER, JOIN_TYPE, JOIN_DATE, JOIN_TIME, ACCTIVITYNAME, ACCTIVITYDESC, FILE_NAME, FILE_PATH) 
      VALUES 
      (:join_id, :schoolID, :total_students, :total_teacher, :contact_name, :contact_number, 'B', TO_DATE(:join_date, 'YYYY-MM-DD'), :join_time, :activityname, :activitydesc, :file_name, :file_path)";


    $stmt_insert = oci_parse($ubureg, $sql_insert);
    oci_bind_by_name($stmt_insert, ':join_id', $join_id);
    oci_bind_by_name($stmt_insert, ':schoolID', $schoolID);
    oci_bind_by_name($stmt_insert, ':total_students', $total_students);
    oci_bind_by_name($stmt_insert, ':total_teacher', $total_teacher);
    oci_bind_by_name($stmt_insert, ':contact_name', $contact_name);
    oci_bind_by_name($stmt_insert, ':contact_number', $contact_number);
    oci_bind_by_name($stmt_insert, ':join_date', $join_date);
    oci_bind_by_name($stmt_insert, ':join_time', $join_time);
    oci_bind_by_name($stmt_insert, ':activityname', $activityname);
    oci_bind_by_name($stmt_insert, ':activitydesc', $activitydesc);
    oci_bind_by_name($stmt_insert, ':file_name', $file_name);
    oci_bind_by_name($stmt_insert, ':file_path', $file_path);

    if (oci_execute($stmt_insert, OCI_COMMIT_ON_SUCCESS)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
          Swal.fire('สำเร็จ', 'บันทึกข้อมูลเรียบร้อยแล้ว', 'success').then(() => {
            window.location.href = window.location.href;
          });
        </script>";
    } else {
        $e = oci_error($stmt_insert);
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
          Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาด: " . addslashes($e['message']) . "', 'error');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <?php include 'component/header.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="page-wrapper" id="main-wrapper">
    <?php include 'component/menu.php'; ?>
    <div class="body-wrapper">
      <?php include 'component/navbar.php'; ?>
      <div class="container-fluid">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">📌 ขอแนะแนวนอกตาราง</h5>
            <form method="POST" enctype="multipart/form-data" class="row g-3">

              <div class="col-md-6">
                <label class="form-label">📅 ชื่อกิจกรรม</label>
                <input type="text" name="activityname" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">📅 วันที่จัดกิจกรรม</label>
                <input type="date" name="join_date" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">เวลาจัดกิจกรรม</label>
                <input type="time" name="join_time" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">📝 รายละเอียดกิจกรรม</label>
                <input type="text" name="activitydesc" class="form-control">
              </div>

              <div class="col-md-4">
                <label class="form-label">👨‍🎓 จำนวนนักเรียน</label>
                <input type="number" name="total_students" class="form-control" required>
              </div>

              <div class="col-md-4">
                <label class="form-label">👩‍🏫 จำนวนครู</label>
                <input type="number" name="total_teacher" class="form-control" required>
              </div>

              <div class="col-md-4">
                <label class="form-label">📁 แนบไฟล์ (.pdf, .doc, .docx)</label>
                <input type="file" name="upload_file" accept=".pdf,.doc,.docx" class="form-control">
              </div>

              <div class="col-md-6">
                <label class="form-label">👤 ชื่อผู้ประสานงาน</label>
                <input type="text" name="contact_name" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">📱 เบอร์โทร</label>
                <input type="text" name="contact_number" class="form-control" required>
              </div>

              <div class="col-12 text-end">
                <button type="submit" class="btn btn-success">💾 บันทึกข้อมูล</button>
              </div>
            </form>
          </div>
        </div>

        <!-- ตารางแสดงรายการ -->
        <div class="card mt-4">
          <div class="card-body">
            <h5 class="card-title">📋 รายการที่บันทึกไว้</h5>
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="table-light">
                  <tr>
                    <th>ชื่อกิจกรรม</th>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>รายละเอียด</th>
                    <th>จำนวนนักเรียน</th>
                    <th>จำนวนครู</th>
                    <th>ผู้ประสานงาน</th>
                    <th>เบอร์โทร</th>
                    <th>ไฟล์</th>
                    <th>จัดการ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM EVEN_JOIN WHERE SCHOOLID = :schoolID AND JOIN_TYPE = 'B' ORDER BY JOIN_ID DESC";
                  $stmt = oci_parse($ubureg, $sql);
                  oci_bind_by_name($stmt, ":schoolID", $schoolID);
                  oci_execute($stmt);
                  while ($row = oci_fetch_assoc($stmt)) {
                    $file_link = $row['FILE_PATH'] ? "<a href='{$row['FILE_PATH']}' target='_blank'>📄 ดาวน์โหลด</a>" : '-';
                    echo "<tr>
                      <td>" . htmlspecialchars($row['ACCTIVITYNAME']) . "</td>
                      <td>" . htmlspecialchars(date('d/m/Y', strtotime($row['JOIN_DATE']))) . "</td>
                      <td>" . htmlspecialchars($row['JOIN_TIME']) . "</td>
                      <td>" . htmlspecialchars($row['ACCTIVITYDESC']) . "</td>
                      <td>" . htmlspecialchars($row['TOTAL_STUDENTS']) . "</td>
                      <td>" . htmlspecialchars($row['TOTAL_TEACHER']) . "</td>
                      <td>" . htmlspecialchars($row['CONTACT_NAME']) . "</td>
                      <td>" . htmlspecialchars($row['CONTACT_NUMBER']) . "</td>
                      <td>$file_link</td>
                      <td>
                        <button class='btn btn-warning btn-sm btn-edit' data-id='{$row['JOIN_ID']}'>แก้ไข</button>
                        <button class='btn btn-danger btn-sm btn-delete' data-id='{$row['JOIN_ID']}'>ลบ</button>
                        <a href='print_join_outside.php?id={$row['JOIN_ID']}' target='_blank' class='btn btn-info btn-sm'>พิมพ์</a>
                      </td>
                    </tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Modal แก้ไขข้อมูล -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <form id="editForm" method="POST" enctype="multipart/form-data" class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูลกิจกรรมนอกตาราง</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="edit_join_id" id="edit_join_id">
                <div class="mb-3">
                  <label>ชื่อกิจกรรม</label>
                  <input type="text" name="edit_activityname" id="edit_activityname" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>วันที่จัดกิจกรรม</label>
                  <input type="date" name="edit_join_date" id="edit_join_date" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>เวลาจัดกิจกรรม</label>
                  <input type="time" name="edit_join_time" id="edit_join_time" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>รายละเอียดกิจกรรม</label>
                  <input type="text" name="edit_activitydesc" id="edit_activitydesc" class="form-control">
                </div>
                <div class="mb-3">
                  <label>จำนวนนักเรียน</label>
                  <input type="number" name="edit_total_students" id="edit_total_students" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>จำนวนครู</label>
                  <input type="number" name="edit_total_teacher" id="edit_total_teacher" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>ชื่อผู้ประสานงาน</label>
                  <input type="text" name="edit_contact_name" id="edit_contact_name" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>เบอร์โทร</label>
                  <input type="text" name="edit_contact_number" id="edit_contact_number" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>แนบไฟล์ใหม่ (.pdf, .doc, .docx) หากต้องการเปลี่ยน</label>
                  <input type="file" name="edit_upload_file" accept=".pdf,.doc,.docx" class="form-control">
                </div>
                <div id="existing_file_link" class="mb-3"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
              </div>
            </form>
          </div>
        </div>

      </div> <!-- container-fluid -->
    </div> <!-- body-wrapper -->
  </div> <!-- page-wrapper -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function () {
      var editModal = new bootstrap.Modal(document.getElementById('editModal'));

      // กดปุ่มแก้ไข
      $('.btn-edit').click(function () {
        var join_id = $(this).data('id');
        $.ajax({
          url: 'get_join_outside.php',
          method: 'GET',
          data: { id: join_id },
          dataType: 'json',
          success: function (data) {
            $('#edit_join_id').val(data.JOIN_ID);
            $('#edit_activityname').val(data.ACCTIVITYNAME);
            $('#edit_join_date').val(data.JOIN_DATE);
            $('#edit_join_time').val(data.JOIN_TIME);
            $('#edit_activitydesc').val(data.ACCTIVITYDESC);
            $('#edit_total_students').val(data.TOTAL_STUDENTS);
            $('#edit_total_teacher').val(data.TOTAL_TEACHER);
            $('#edit_contact_name').val(data.CONTACT_NAME);
            $('#edit_contact_number').val(data.CONTACT_NUMBER);

            if (data.FILE_PATH) {
              $('#existing_file_link').html(`<a href="${data.FILE_PATH}" target="_blank">ไฟล์แนบเดิม: ดาวน์โหลด</a>`);
            } else {
              $('#existing_file_link').html('ไม่มีไฟล์แนบเดิม');
            }
            editModal.show();
          },
          error: function () {
            alert('เกิดข้อผิดพลาดในการดึงข้อมูล');
          }
        });
      });

      // ส่งฟอร์มแก้ไข
      $('#editForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
          url: 'update_join_outside.php',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            Swal.fire('สำเร็จ', 'แก้ไขข้อมูลเรียบร้อยแล้ว', 'success').then(() => {
              location.reload();
            });
          },
          error: function () {
            Swal.fire('ผิดพลาด', 'ไม่สามารถแก้ไขข้อมูลได้', 'error');
          }
        });
      });

      // ลบข้อมูล
      $('.btn-delete').click(function () {
        var join_id = $(this).data('id');
        Swal.fire({
          title: 'ยืนยันการลบ?',
          text: "ข้อมูลที่ลบจะไม่สามารถกู้คืนได้!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'ลบเลย',
          cancelButtonText: 'ยกเลิก'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: 'delete_join_outside.php',
              method: 'POST',
              data: { id: join_id },
              success: function () {
                Swal.fire('ลบเรียบร้อย', 'ข้อมูลถูกลบแล้ว', 'success').then(() => {
                  location.reload();
                });
              },
              error: function () {
                Swal.fire('ผิดพลาด', 'ไม่สามารถลบข้อมูลได้', 'error');
              }
            });
          }
        });
      });
    });
  </script>
>>>>>>> 29b51cc (Test commit)

</body>
</html>
