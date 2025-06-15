<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";

$schoolID = $_SESSION['schoolID'] ?? null;
if (!$schoolID) {
    echo "<script>alert('กรุณาล็อกอินก่อนใช้งาน'); window.location='login.php';</script>";
    exit;
}

// ดึงข้อมูลกิจกรรมแนะแนวนอกตาราง JOIN_TYPE = 'B' ของโรงเรียนนี้
$sql = "SELECT JOIN_ID, ACCTIVITYNAME, TO_CHAR(JOIN_DATE,'YYYY-MM-DD') AS JOIN_DATE, JOIN_TIME, ACCTIVITYDESC, TOTAL_STUDENTS, TOTAL_TEACHER, CONTACT_NAME, CONTACT_NUMBER, FILE_PATH 
        FROM EVEN_JOIN WHERE SCHOOLID = :schoolID AND JOIN_TYPE = 'B' ORDER BY JOIN_DATE DESC";

$stmt = oci_parse($ubureg, $sql);
oci_bind_by_name($stmt, ':schoolID', $schoolID);
oci_execute($stmt);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8" />
    <title>รายการแนะแนวนอกตาราง</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-4">
    <h3>รายการแนะแนวนอกตารางของโรงเรียนคุณ</h3>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-light">
            <tr>
                <th>ชื่อกิจกรรม</th>
                <th>วันที่</th>
                <th>เวลา</th>
                <th>รายละเอียด</th>
                <th>นักเรียน</th>
                <th>ครู</th>
                <th>ผู้ติดต่อ</th>
                <th>เบอร์โทร</th>
                <th>ไฟล์แนบ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = oci_fetch_assoc($stmt)) : ?>
            <tr>
                <td><?=htmlspecialchars($row['ACCTIVITYNAME'])?></td>
                <td><?=htmlspecialchars($row['JOIN_DATE'])?></td>
                <td><?=htmlspecialchars($row['JOIN_TIME'])?></td>
                <td><?=htmlspecialchars($row['ACCTIVITYDESC'])?></td>
                <td><?=htmlspecialchars($row['TOTAL_STUDENTS'])?></td>
                <td><?=htmlspecialchars($row['TOTAL_TEACHER'])?></td>
                <td><?=htmlspecialchars($row['CONTACT_NAME'])?></td>
                <td><?=htmlspecialchars($row['CONTACT_NUMBER'])?></td>
                <td>
                    <?php if (!empty($row['FILE_PATH'])): ?>
                        <a href="<?=htmlspecialchars($row['FILE_PATH'])?>" target="_blank">📎 ดูไฟล์</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <button class="btn btn-sm btn-primary btn-edit" data-id="<?= $row['JOIN_ID'] ?>">แก้ไข</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal แก้ไขข้อมูล -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editForm" enctype="multipart/form-data" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูลกิจกรรมแนะแนวนอกตาราง</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="join_id" id="edit_join_id" />
          <div class="mb-3">
            <label for="edit_activityname" class="form-label">ชื่อกิจกรรม</label>
            <input type="text" class="form-control" id="edit_activityname" name="activityname" required />
          </div>
          <div class="mb-3">
            <label for="edit_join_date" class="form-label">วันที่</label>
            <input type="date" class="form-control" id="edit_join_date" name="join_date" required />
            <small id="show_thai_date" class="text-muted"></small>
          </div>
          <div class="mb-3">
            <label for="edit_join_time" class="form-label">เวลา</label>
            <input type="time" class="form-control" id="edit_join_time" name="join_time" required />
          </div>
          <div class="mb-3">
            <label for="edit_activitydesc" class="form-label">รายละเอียด</label>
            <textarea class="form-control" id="edit_activitydesc" name="activitydesc" rows="3"></textarea>
          </div>
          <div class="mb-3 row">
            <div class="col">
              <label for="edit_total_students" class="form-label">จำนวนนักเรียน</label>
              <input type="number" class="form-control" id="edit_total_students" name="total_students" required min="0" />
            </div>
            <div class="col">
              <label for="edit_total_teacher" class="form-label">จำนวนครู</label>
              <input type="number" class="form-control" id="edit_total_teacher" name="total_teacher" required min="0" />
            </div>
          </div>
          <div class="mb-3">
            <label for="edit_contact_name" class="form-label">ชื่อผู้ติดต่อ</label>
            <input type="text" class="form-control" id="edit_contact_name" name="contact_name" required />
          </div>
          <div class="mb-3">
            <label for="edit_contact_number" class="form-label">เบอร์โทรศัพท์</label>
            <input type="text" class="form-control" id="edit_contact_number" name="contact_number" required />
          </div>
          <div class="mb-3">
            <label>ไฟล์แนบเดิม</label>
            <div id="edit_old_file">-</div>
          </div>
          <div class="mb-3">
            <label for="edit_upload_file" class="form-label">เปลี่ยนไฟล์แนบ (ถ้ามี)</label>
            <input type="file" class="form-control" id="edit_upload_file" name="upload_file" accept=".pdf,.doc,.docx" />
            <small class="text-muted">รองรับไฟล์ .pdf, .doc, .docx เท่านั้น</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">บันทึก</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
$(document).ready(function () {
  var editModal = new bootstrap.Modal(document.getElementById('editModal'));

  $('.btn-edit').click(function () {
    var join_id = $(this).data('id');
    $.ajax({
      url: 'get_edit_joinoutside.php',
      method: 'GET',
      data: { id: join_id },
      dataType: 'json',
      success: function (data) {
        if(data.error) {
          alert('Error: ' + data.error);
          return;
        }
        $('#edit_join_id').val(data.JOIN_ID);
        $('#edit_activityname').val(data.ACCTIVITYNAME);
        $('#edit_join_date').val(data.JOIN_DATE);
        $('#show_thai_date').text(data.JOIN_DATE_TH);
        $('#edit_join_time').val(data.JOIN_TIME);
        $('#edit_activitydesc').val(data.ACCTIVITYDESC);
        $('#edit_total_students').val(data.TOTAL_STUDENTS);
        $('#edit_total_teacher').val(data.TOTAL_TEACHER);
        $('#edit_contact_name').val(data.CONTACT_NAME);
        $('#edit_contact_number').val(data.CONTACT_NUMBER);

        if (data.FILE_PATH && data.FILE_PATH.trim() !== '') {
          $('#edit_old_file').html(`<a href="${data.FILE_PATH}" target="_blank">📎 ไฟล์เดิม</a>`);
        } else {
          $('#edit_old_file').html('-');
        }

        editModal.show();
      },
      error: function (xhr, status, error) {
        console.error('Error:', status, error);
        console.error('Response:', xhr.responseText);
        alert('เกิดข้อผิดพลาดในการดึงข้อมูล');
      }
    });
  });

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
        if (response.success) {
          Swal.fire('สำเร็จ', 'แก้ไขข้อมูลเรียบร้อยแล้ว', 'success').then(() => {
            editModal.hide();
            location.reload();
          });
        } else {
          Swal.fire('ผิดพลาด', response.error || 'ไม่สามารถแก้ไขข้อมูลได้', 'error');
        }
      },
      error: function (xhr, status, error) {
        console.error('Error:', status, error);
        console.error('Response:', xhr.responseText);
        Swal.fire('ผิดพลาด', 'ไม่สามารถแก้ไขข้อมูลได้', 'error');
      }
    });
  });
});
</script>

</body>
</html>
