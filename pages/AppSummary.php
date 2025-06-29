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
            <h5 class="card-title fw-semibold mb-4">ยินดีต้อนรับเข้าสู่หน้าข้อมูลสารสนเทศสำหรับสถานศึกษา</h5>
            <div class="row">
              <div class="col-3">
                  <div class="mb-3">
                  <label class="form-label">ปีการศึกษา</label>
                  <?php
                    $currentYear = date('Y') + 543; // แปลง ค.ศ. เป็น พ.ศ.
                    $startYear = $currentYear - 5;
                  ?>
                  <select class="form-select" name="year" id="year">
                    <?php for ($year = $currentYear; $year >= $startYear; $year--): ?>
                  <option value="<?= $year ?>" <?= ($year == $currentYear) ? 'selected' : '' ?>>
                    <?= $year ?>
                  </option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>
              <div class="col-4">
                <div class="mb-3">
                  <label class="form-label">คณะ</label>
                  <select class="form-select" name="Faculty" id="Faculty">
                    <option value="" selected>เลือกคณะที่ต้องการ</option>
                      <?php
                      $sqlSelectFac="SELECT * FROM avsreg.FACULTY
                      WHERE FACULTYTYPE ='F' AND FACULTYID NOT IN (0,22,24,91,92)
                      ORDER BY FACULTYID ASC";

                      $stid = oci_parse($ubureg,$sqlSelectFac);
                      oci_execute($stid);
                      
                        while ($row = oci_fetch_assoc($stid)) {
                        echo '<option value="' . $row['FACULTYID'] . '">' . $row['FACULTYNAME'] . '</option>';
                        }

                        
                        oci_free_statement($stid);
                        oci_close($ubureg);
                      ?>
                    </select>
                </div>
              </div>

              <div class="col-4">
                <div class="mb-3">
                <br>
                  <button onclick="searchData();" type="button" class="btn btn-warning mt-2">ค้นหา</button>       
                  <a id="exportLink" href="#" target="_blank" class="btn btn-success mt-2 ms-2">Export Excel</a>
                </div>



              </div>

            </div>

          </div>
        </div>
        <div class="card">
          <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">ข้อมูลผู้ยืนยันสิทธิ์เข้าศึกษา</h5>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">ลำดับ</th>
                  <th scope="col">เลขสมัคร</th>
                  <th scope="col">ชื่อ-สกุล</th>
                  <!-- <th scope="col">เบอร์โทร</th> -->
                  <th scope="col">โควตา</th>
                  <th scope="col">คณะ</th>
                  <th scope="col">สาขา</th>
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
  <script>
    function searchData(){
     var year =$('#year').val();
     var Faculty  =$('#Faculty').val();
     document.getElementById('exportLink').href = `export_AppApplicants.php?year=${year}`;
     $.ajax({
      url: 'showdataApplicant50.php',
      method: 'POST',
      data:{
        year: year,
        Faculty: Faculty
      },
      dataType: 'json',
      success: function(response) {
      console.log(response);
      let rows = '';
      let i = 1;
      response.forEach(row =>{
        rows += `<tr>
                    <td style="width: 1rem;">${i++}</td> <!-- เพิ่มลำดับที่ -->
                    <td style="width: 4rem;">${row.APPLICANTCODE}</td>
                    <td style="width: 28rem;">${row.PREFIXNAME}${row.APPLICANTNAME}  ${row.APPLICANTSURNAME}</td>
                    
                    <td style="width: 30rem;">${row.APPLICANTTYPENAME}</td>
                    <td style="width: 20rem;">${row.FACULTYNAME}</td>
                    <td style="width: 20rem;">${row.QUOTANAME}</td>
                    </tr>` ;
      });
      $('#data-table').html(rows);
      console.log(rows);
      
      },
      error: function (){
        Swal.fire({
          icon: 'error',
              title: 'Error',
              text: 'Something went wrong with the server.',
              confirmButtonText: 'ตกลง'
        });

      }
      
     });
    }
  </script>
</body>

</html>