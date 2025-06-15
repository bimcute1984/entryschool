<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ระบบข้อมูลสารสนเทศสำหรับสถานศึกษา</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon_ubu.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logos/favicon_ubu.png" width="180" alt="">
                </a>
                <p class="text-center">ระบบข้อมูลสารสนเทศสำหรับสถานศึกษา</p>
                <form id="loginForm">
                  <div class="mb-4">
                    <label for="username" class="form-label">Username : </label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                  <div class="mb-4">
                    <label for="Password" class="form-label">Password :</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                  <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
                    
                  </div>
                  
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
     <!-- SweetAlert2 -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(event) {
                event.preventDefault(); // ป้องกันการ reload หน้าเมื่อส่งฟอร์ม

                // เก็บค่าจากฟอร์ม
                var username = $('#username').val();
                var password = $('#password').val();

                $.ajax({
                    url: 'chkuser.php', // ไฟล์ PHP สำหรับตรวจสอบการล็อกอิน
                    method: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    dataType: 'json', // คาดหวังให้ผลลัพธ์เป็น JSON
                    success: function(response) {
                        if (response.status === 'success') {
                            // แสดง SweetAlert2 สำหรับการล็อกอินสำเร็จ
                            Swal.fire({
                                icon: 'success',
                                title: 'Login สำเร็จ',
                                text: response.message,
                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                // นำผู้ใช้ไปยังหน้าอื่นหลังจากล็อกอินสำเร็จ
<<<<<<< HEAD
                                window.location.href = 'dashboard.php';
=======
                                window.location.href = response.redirect;
>>>>>>> 29b51cc (Test commit)
                            });
                        } else {
                            // แสดง SweetAlert2 สำหรับการล็อกอินไม่สำเร็จ
                            Swal.fire({
                                icon: 'warning',
                                title: 'Login Failed',
                                text: response.message,
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong with the server.',
                            confirmButtonText: 'ตกลง'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>