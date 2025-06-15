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
        <div class="card" >
          <div class="card-body">
            
            <div class="container py-5">
  <h2 class="mb-4">หน่วยงานที่เกี่ยวข้อง</h2>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
  <style>
  .card-img-fixed {
    height: 200px;             /* ความสูงเท่ากัน */
    object-fit: cover;         /* ตัดภาพให้พอดี */
    width: 100%;               /* เต็มความกว้างของการ์ด */
  }
</style>
    <!-- Card 1 -->
    <div class="col">
      <div class="card h-100">
        <img src="../pages/images/aboutus/ubu01.jpg" class="card-img-top card-img-fixed" alt="https://www.ubu.ac.th/">
        <div class="card-body">
          <h5 class="card-title">เว็บไซต์มหาวิทยาลัยอุบลราชธานี</h5>
          <p class="card-text">เว็บไซต์สมัครหลักของมหาวิทยาลัยอุบลราชธานี เพื่อติดตามประชาสัมพันธ์อื่นๆ </p>
          <a href="https://www.ubu.ac.th/" class="btn btn-primary">ดูเพิ่มเติม</a>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col">
      <div class="card h-100">
        <img src="../pages/images/aboutus/adm01.jpeg" class="card-img-top card-img-fixed" alt="https://admission.ubu.ac.th/admission/home">
        <div class="card-body">
          <h5 class="card-title">เว็บไซต์รับสมัครบุคคลเข้าศึกษา</h5>
          <p class="card-text">เว็บไซต์รับสมัครสำหรับบุคคลเข้าศึกษาทุกระดับการศึกษา</p>
          <a href="https://admission.ubu.ac.th/admission/home" class="btn btn-primary">ดูเพิ่มเติม</a>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col">
      <div class="card h-100">
<<<<<<< HEAD
        <img src="../pages/images/aboutus/spm01.png" class="card-img-top card-img-fixed" alt="...">
        <div class="card-body">
        <h5 class="card-title">เว็บไซต์หน่วยงานความร่วมมืออื่นๆ </h5>
        <p class="card-text">สำหรับหน่วยงานความร่วมมือ สพม. และโรงเรียนเครือข่ายฯ</p>
=======
        <img src="../pages/images/aboutus/spm01.png" class="card-img-top card-img-fixed" alt="https://entry.ubu.ac.th/entryschool/pages/sign-in-school">
        <div class="card-body">
        <h5 class="card-title">เว็บไซต์หน่วยงานความร่วมมืออื่นๆ </h5>
        <p class="card-text">ระบบสารสนเทศการสมัครเข้าศึกษาสำหรับโรงเรียนและ สพม.</p>
>>>>>>> 29b51cc (Test commit)
          <a href="https://entry.ubu.ac.th/entryschool/pages/sign-in-school" class="btn btn-primary">ดูเพิ่มเติม</a>
        </div>
      </div>
    </div>

    <!-- Card 4 -->
    <div class="col">
      <div class="card h-100">
<<<<<<< HEAD
        <img src="../pages/images/aboutus/act01.png" class="card-img-top card-img-fixed" alt="">
        <div class="card-body">
          <h5 class="card-title">สำนักงานพัฒนานักศึกษา</h5>
          <p class="card-text">เว็บไซต์สวัสดิการนักศึกษา กองทุนกู้ยืม และอื่นๆ</p>
=======
        <img src="../pages/images/aboutus/act01.png" class="card-img-top card-img-fixed" alt="https://www.ubu.ac.th/web/student">
        <div class="card-body">
          <h5 class="card-title">สำนักงานพัฒนานักศึกษา</h5>
          <p class="card-text">เว็บไซต์สวัสดิการนักศึกษา กองทุนกู้ยืม (ทุน/กู้ยืม/ทุนระหว่างเรียน) และอื่นๆ</p>
>>>>>>> 29b51cc (Test commit)
          <a href="https://www.ubu.ac.th/web/student" class="btn btn-primary">ดูเพิ่มเติม</a>
        </div>
      </div>
    </div>
 <!-- Card 5 -->
 <div class="col">
      <div class="card h-100">
<<<<<<< HEAD
        <img src="../pages/images/aboutus/adm01.jpeg" class="card-img-top card-img-fixed" alt="">
        <div class="card-body">
          <h5 class="card-title">เว็บไซต์รับสมัครบุคคลเข้าศึกษา</h5>
          <p class="card-text">เว็บไซต์รับสมัครสำหรับบุคคลเข้าศึกษาทุกระดับการศึกษา</p>
          <a href="https://admission.ubu.ac.th/admission/home" class="btn btn-primary">ดูเพิ่มเติม</a>
=======
        <img src="../pages/images/aboutus/dome.jpg" class="card-img-top card-img-fixed" alt="https://www.ubu.ac.th/web/pnr">
        <div class="card-body">
          <h5 class="card-title">สำนักบริหารทรัพย์สินและสิทธิประโยชน์</h5>
          <p class="card-text">หอพัก หอใน ห้องพักภายในมหาวิทยาลัยและสวัสดิการ ร้านค้า</p>
          <a href="https://www.ubu.ac.th/web/pnr" class="btn btn-primary">ดูเพิ่มเติม</a>
>>>>>>> 29b51cc (Test commit)
        </div>
      </div>
    </div>
     <!-- Card 6 -->
     <div class="col">
      <div class="card h-100">
<<<<<<< HEAD
        <img src="../pages/images/aboutus/adm01.jpeg" class="card-img-top card-img-fixed" alt="https://admission.ubu.ac.th/admission/home">
        <div class="card-body">
          <h5 class="card-title">เว็บไซต์รับสมัครบุคคลเข้าศึกษา</h5>
          <p class="card-text">เว็บไซต์รับสมัครสำหรับบุคคลเข้าศึกษาทุกระดับการศึกษา</p>
          <a href="https://admission.ubu.ac.th/admission/home" class="btn btn-primary">ดูเพิ่มเติม</a>
=======
        <img src="../pages/images/aboutus/academic.jpg" class="card-img-top card-img-fixed" alt="https://www.ubu.ac.th/web/academic">
        <div class="card-body">
          <h5 class="card-title">กองบริการการศึกษา</h5>
          <p class="card-text">เว็บไซต์กองบริการการศึกษา ดูและเรื่องงานวิชาการ แหล่งรวบรวมความรู้ทางวิชาการ</p>
          <a href="https://www.ubu.ac.th/web/academic" class="btn btn-primary">ดูเพิ่มเติม</a>
>>>>>>> 29b51cc (Test commit)
        </div>
      </div>
    </div>
     <!-- Card 7 -->
     <div class="col">
      <div class="card h-100">
<<<<<<< HEAD
        <img src="../pages/images/aboutus/adm01.jpeg" class="card-img-top card-img-fixed" alt="https://admission.ubu.ac.th/admission/home">
        <div class="card-body">
          <h5 class="card-title">เว็บไซต์รับสมัครบุคคลเข้าศึกษา</h5>
          <p class="card-text">เว็บไซต์รับสมัครสำหรับบุคคลเข้าศึกษาทุกระดับการศึกษา</p>
          <a href="https://admission.ubu.ac.th/admission/home" class="btn btn-primary">ดูเพิ่มเติม</a>
=======
        <img src="../pages/images/aboutus/curiculum.jpg" class="card-img-top card-img-fixed" alt="https://www.ubu.ac.th/web/educational">
        <div class="card-body">
          <h5 class="card-title">งานมาตรฐานและพัฒนาหลักสูตร</h5>
          <p class="card-text">หลักสูตรที่เปิดรับ ปริญญาตรี ปริญญาโท และปริญญาเอก</p>
          <a href="https://www.ubu.ac.th/web/educational" class="btn btn-primary">ดูเพิ่มเติม</a>
        </div>
      </div>
    </div>

     <!-- Card 8 -->
     <div class="col">
      <div class="card h-100">
        <img src="../pages/images/aboutus/ocn.jpg" class="card-img-top card-img-fixed" alt="https://ocn.ubu.ac.th/">
        <div class="card-body">
          <h5 class="card-title">สำนักคอมพิวเตอร์และเครือข่าย</h5>
          <p class="card-text">หลักสูตรที่เปิดรับ ปริญญาตรี ปริญญาโท และปริญญาเอก</p>
          <a href="https://ocn.ubu.ac.th/" class="btn btn-primary">ดูเพิ่มเติม</a>
        </div>
      </div>
    </div>

     <!-- Card 9 -->
     <div class="col">
      <div class="card h-100">
        <img src="../pages/images/aboutus/oar.jpg" class="card-img-top card-img-fixed" alt="https://www.oar.ubu.ac.th/web/">
        <div class="card-body">
          <h5 class="card-title">สำนักวิทยบริการ</h5>
          <p class="card-text">บริหารห้องสมุด สื่อ โสต co-working space</p>
          <a href="https://www.oar.ubu.ac.th/web/" class="btn btn-primary">ดูเพิ่มเติม</a>
>>>>>>> 29b51cc (Test commit)
        </div>
      </div>
    </div>

  </div>
</div>

<<<<<<< HEAD
          </div>
        </div>
        <div class="card">
          <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">ข้อมูลผู้สมัคร</h5>
           


          </div>
        </div>
      </div>
    </div>
  </div>
=======
      
>>>>>>> 29b51cc (Test commit)
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    
</body>

</html>