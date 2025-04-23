<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";
?>
<!doctype html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
  <?php
  include 'component/header.php';
  ?>
  
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
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







<div class="container my-5">
    <div id="calendar"></div>
  </div>

  <!-- Modal แสดงรายละเอียดกิจกรรม -->
  <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">รายละเอียดกิจกรรม</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p id="eventTitle"></p>
          <p id="eventDescription"></p>
        </div>
      </div>
    </div>
  </div>

  <!-- JS ของ Bootstrap และ FullCalendar (วางก่อนปิด </body>) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

  <!-- สคริปต์ตั้งค่าปฏิทิน -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'load-events.php', // โหลดกิจกรรมจาก PHP

        eventClick: function(info) {
          document.getElementById('eventTitle').innerText = info.event.title;
          document.getElementById('eventDescription').innerText = info.event.extendedProps.description || "ไม่มีรายละเอียด";
          var modal = new bootstrap.Modal(document.getElementById('eventModal'));
          modal.show();
        }
      });

      calendar.render();
    });
  </script>



  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
</body>

</html>