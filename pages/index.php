<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";
?>
<!doctype html>
<html lang="en">

<head>
  <?php
  include 'component/header.php';
  ?>
</head>

<body>
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
      <div class="container-fluid">

      
        
        <div class="card">
          <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">ข้อมูลผู้สมัคร</h5>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">ลำดับ</th>
                  <th scope="col">เลขสมัคร</th>
                  <th scope="col">ชื่อ-สกุล</th>
                  <th scope="col">เบอร์โทร</th>
                  <th scope="col">โควตา</th>
                  <th scope="col">คณะ</th>
                  <th scope="col">สาขา</th>
                  <th scope="col">สถานะการชำระเงิน</th>
                  <th scope="col">สถานะการสมัคร</th>
                  <th scope="col">หมายเหตุ</th>
                </tr>
              </thead>
              <tbody id="data-table">
             
              </tbody>
            </table>


          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
</body>

</html>