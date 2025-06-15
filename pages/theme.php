<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";
<<<<<<< HEAD
?>
=======

function formatThaiDate($strDate) {
    if (!$strDate) return '';
    $months = [
        "", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
        "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
    ];
    $timestamp = strtotime($strDate);
    $day = date("j", $timestamp);
    $month = $months[(int)date("n", $timestamp)];
    $year = date("Y", $timestamp) + 543;
    return "$day $month $year";
}




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
          // ตรวจสอบ MIME TYPE
          $allowedMimeTypes = [
              'application/pdf',
              'application/msword',
              'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
          ];
          $finfo = finfo_open(FILEINFO_MIME_TYPE);
          $mime = finfo_file($finfo, $_FILES['upload_file']['tmp_name']);
          finfo_close($finfo);


        if (!in_array($mime, $allowedMimeTypes)) {
        echo "<p style='color:red;'>❌ ไฟล์ไม่ใช่ชนิดที่รองรับ (PDF หรือ Word เท่านั้น)</p>";
        exit;
     }

        // หาก MIME TYPE ผ่าน ให้ดำเนินการต่อ
        $target_dir = "uploads/";
        $file_name = basename($_FILES["upload_file"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
           $file_path = $upload_display_path . $file_name;
            echo "<p style='color:green;'>✅ อัปโหลดไฟล์เรียบร้อย</p>";
        } else {
            echo "<p style='color:red;'>❌ อัปโหลดไฟล์ไม่สำเร็จ</p>";
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


>>>>>>> 29b51cc (Test commit)
<!doctype html>
<html lang="en">

<head>
  <?php
  include 'component/header.php';
  ?>
<<<<<<< HEAD
=======
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
>>>>>>> 29b51cc (Test commit)
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <?php
  include 'component/menu.php';
    ?>
<<<<<<< HEAD
    <!--  Main wrapper -->
    <div class="body-wrapper">
    <?php
  include 'component/navbar.php';
    ?>
      <div class="container-fluid">

      
        <div class="card" >
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">ยินดีต้อนรับเข้าสู่หน้าข้อมูลสารสนเทศสำหรับสถานศึกษา</h5>
            

          </div>
        </div>
        <div class="card">
          <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">ข้อมูลผู้สมัคร</h5>
           


          </div>
        </div>
=======
   <!-- Main wrapper -->
<div class="body-wrapper">
  <?php include 'component/navbar.php'; ?>
  <div class="container-fluid">

    <!-- กล่อง: ขอแนะแนวนอกตาราง -->
    <div class="card shadow p-4 mb-4">
      <h5 class="card-title mb-3">📌 ขอแนะแนวนอกตาราง</h5>
      <form method="POST" action="save_join_outside.php" enctype="multipart/form-data" class="row g-3">

        <div class="col-md-6">
          <label class="form-label">📅 ชื่อกิจกรรม</label>
          <input type="text" name="activityname" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">📅 วันที่จัดกิจกรรม</label>
          <input type="date" name="join_date" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">⏰ เวลาจัดกิจกรรม</label>
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
          <button type="submit" class="btn btn-success" onclick="this.disabled=true; this.form.submit();">💾 บันทึกข้อมูล</button>
        </div>
      </form>
    </div>

    <!-- กล่อง: รายการที่บันทึกไว้ -->
    <div class="card shadow p-4">
      <h5 class="card-title mb-3">📋 รายการที่บันทึกไว้</h5>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-light text-center">
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
              $sql = "SELECT 
                        JOIN_ID,
                        SCHOOLID,
                        TO_CHAR(JOIN_DATE, 'YYYY-MM-DD') AS JOIN_DATE,
                        JOIN_TIME,
                        ACCTIVITYNAME,
                        ACCTIVITYDESC,
                        TOTAL_STUDENTS,
                        TOTAL_TEACHER,
                        CONTACT_NAME,
                        CONTACT_NUMBER,
                        FILE_PATH
                      FROM EVEN_JOIN 
                      WHERE SCHOOLID = :schoolID 
                        AND JOIN_TYPE = 'B' 
                      ORDER BY JOIN_ID DESC";

              $stmt = oci_parse($ubureg, $sql);
              oci_bind_by_name($stmt, ":schoolID", $schoolID);
              oci_execute($stmt);

              while ($row = oci_fetch_assoc($stmt)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['ACCTIVITYNAME']) . "</td>
                        <td>" . formatThaiDate($row['JOIN_DATE']) . "</td>
                        <td>" . htmlspecialchars($row['JOIN_TIME']) . "</td>
                        <td>" . htmlspecialchars($row['ACCTIVITYDESC']) . "</td>
                        <td>" . htmlspecialchars($row['TOTAL_STUDENTS']) . "</td>
                        <td>" . htmlspecialchars($row['TOTAL_TEACHER']) . "</td>
                        <td>" . htmlspecialchars($row['CONTACT_NAME']) . "</td>
                        <td>" . htmlspecialchars($row['CONTACT_NUMBER']) . "</td>
                        <td>";
                        if (!empty($row['FILE_PATH'])) {
                          echo "<a href='" . htmlspecialchars($row['FILE_PATH']) . "' target='_blank'>📎 ดูไฟล์</a>";
                        } else {
                          echo "-";
                        }
                echo "</td>
                      <td>
                        <a href='print_join_outside.php?join_id=" . urlencode($row['JOIN_ID']) . "' class='btn btn-primary btn-sm' target='_blank'>🖨️</a>
                        <a href='delete_join_outside.php?join_id=" . urlencode($row['JOIN_ID']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"ต้องการลบข้อมูลใช่หรือไม่?\")'>🗑️</a>
                        <button class='btn btn-warning btn-sm btn-edit' data-id='" . $row['JOIN_ID'] . "'>✏️</button>
                      </td>
                      </tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    
  </div>
</div>

        

        
        <!-- Modal แก้ไข -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <form id="editForm" method="POST" enctype="multipart/form-data" action="update_join_outside.php">
              
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">แก้ไขข้อมูล</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="join_id" id="edit_join_id">
                  <div class="mb-3">
                    <label for="edit_activityname" class="form-label">ชื่อกิจกรรม</label>
                    <input type="text" class="form-control" id="edit_activityname" name="activityname" required>
                  </div>
                  <div class="mb-3">
                    <label for="edit_join_date" class="form-label">วันที่จัดกิจกรรม</label>
                    <input type="date" class="form-control" id="edit_join_date" name="join_date" required>
                  </div>
                  <div class="mb-3">
                    <label for="edit_join_time" class="form-label">เวลาจัดกิจกรรม</label>
                    <input type="time" class="form-control" id="edit_join_time" name="join_time" required>
                  </div>
                  <div class="mb-3">
                    <label for="edit_activitydesc" class="form-label">รายละเอียดกิจกรรม</label>
                    <input type="text" class="form-control" id="edit_activitydesc" name="activitydesc">
                  </div>
                  <div class="mb-3">
                    <label for="edit_total_students" class="form-label">จำนวนนักเรียน</label>
                    <input type="number" class="form-control" id="edit_total_students" name="total_students" required>
                  </div>
                  <div class="mb-3">
                    <label for="edit_total_teacher" class="form-label">จำนวนครู</label>
                    <input type="number" class="form-control" id="edit_total_teacher" name="total_teacher" required>
                  </div>
                  <div class="mb-3">
                    <label for="edit_contact_name" class="form-label">ชื่อผู้ประสานงาน</label>
                    <input type="text" class="form-control" id="edit_contact_name" name="contact_name" required>
                  </div>
                  <div class="mb-3">
                    <label for="edit_contact_number" class="form-label">เบอร์โทร</label>
                    <input type="text" class="form-control" id="edit_contact_number" name="contact_number" required>
                  </div>
                    <div class="mb-3">
                      <label class="form-label">ไฟล์เดิม</label>
                      <div id="edit_old_file">-</div>
                    </div>

                  <div class="mb-3">
                    <label for="edit_upload_file" class="form-label">แนบไฟล์ใหม่ (ถ้าต้องการแทนไฟล์เดิม)</label>
                    <input type="file" class="form-control" id="edit_upload_file" name="upload_file" accept=".pdf,.doc,.docx">
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                  <button type="submit" class="btn btn-primary">💾 บันทึกการแก้ไข</button>
                </div>

              </div>
            </form>
          </div>
        </div>
       
                      <script>
                      document.querySelectorAll('.btn-edit').forEach(button => {
                        button.addEventListener('click', function () {
                          const joinId = this.getAttribute('data-id');

                          fetch(`get_join_data.php?join_id=${joinId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.FILE_PATH && data.FILE_PATH !== '') {
                                  document.getElementById('edit_old_file').innerHTML = `<a href="${data.FILE_PATH}" target="_blank">📎 ดูไฟล์เดิม</a>`;
                                } else {
                                  document.getElementById('edit_old_file').innerHTML = '-';
                                }
                              document.getElementById('edit_join_id').value = data.JOIN_ID;
                              document.getElementById('edit_activityname').value = data.ACCTIVITYNAME;
                              document.getElementById('edit_join_date').value = data.JOIN_DATE;
                              document.getElementById('edit_join_time').value = data.JOIN_TIME;
                              document.getElementById('edit_activitydesc').value = data.ACCTIVITYDESC;
                              document.getElementById('edit_total_students').value = data.TOTAL_STUDENTS;
                              document.getElementById('edit_total_teacher').value = data.TOTAL_TEACHER;
                              document.getElementById('edit_contact_name').value = data.CONTACT_NAME;
                              document.getElementById('edit_contact_number').value = data.CONTACT_NUMBER;

                              const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                              editModal.show();
                            });
                        });
                      });
                      </script>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
     
    </div>
  </div>

     <!-- Script สำหรับเปิด Modal แก้ไข -->
        <script>
          function openEditModal(data) {
            // เติมค่าลงในฟอร์มแก้ไข
            document.getElementById("edit_join_id").value = data.JOIN_ID;
            document.getElementById("edit_activityname").value = data.ACCTIVITYNAME;
            document.getElementById("edit_join_date").value = data.JOIN_DATE;
            document.getElementById("edit_join_time").value = data.JOIN_TIME;
            document.getElementById("edit_activitydesc").value = data.ACCTIVITYDESC;
            document.getElementById("edit_total_students").value = data.TOTAL_STUDENTS;
            document.getElementById("edit_total_teacher").value = data.TOTAL_TEACHER;
            document.getElementById("edit_contact_name").value = data.CONTACT_NAME;
            document.getElementById("edit_contact_number").value = data.CONTACT_NUMBER;

            
            if (data.FILE_PATH && data.FILE_PATH !== '') {
                document.getElementById('edit_old_file').innerHTML = `<a href="${data.FILE_PATH}" target="_blank">📎 ไฟล์เดิม</a>`;
              } else {
                document.getElementById('edit_old_file').innerHTML = "-";
              }


            // เปิด Modal
            var myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
          }

          function formatThaiDate($date) {
                  $months = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
                  $d = date_create_from_format('d-M-y', $date);
                  if ($d) {
                      $day = $d->format('j');
                      $month = $months[(int)$d->format('n')];
                      $year = (int)$d->format('Y') + 543;
                      return "$day $month $year";
                  }
                  return "-";
              }
          </script>


      </div> <!-- container-fluid -->
    </div> <!-- body-wrapper -->
  </div> <!-- main-wrapper -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function () {
      var editModal = new bootstrap.Modal(document.getElementById('editModal'));

      // กดปุ่มแก้ไข
      $('.btn-edit').click(function () {
        var join_id = $(this).data('id');
        $.ajax({
          url: 'edit_join_outside.php',
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
              editModal.hide();
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
          </div>
        </div>
        
>>>>>>> 29b51cc (Test commit)
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    
</body>

</html>