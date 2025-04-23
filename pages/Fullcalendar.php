<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ปฏิทินกิจกรรม</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">

  <style>
    body {
      padding: 2rem;
      background-color: #f8f9fa;
    }
    #calendar {
      background-color: white;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <div class="container">
    <h2 class="mb-4">📅 ปฏิทินกิจกรรม</h2>
    <div id="calendar"></div>
  </div>

  <!-- Modal เพิ่มกิจกรรม -->
  <div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog">
      <form id="eventForm" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">เพิ่มกิจกรรม</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="eventDate">
          <div class="mb-3">
            <label for="eventTitle" class="form-label">ชื่อกิจกรรม</label>
            <input type="text" class="form-control" id="eventTitle" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">บันทึก</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'th',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true,
        select: function(info) {
          document.getElementById('eventDate').value = info.startStr;
          new bootstrap.Modal(document.getElementById('eventModal')).show();
        },
        events: []
      });

      calendar.render();

      // บันทึกกิจกรรม
      document.getElementById('eventForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const title = document.getElementById('eventTitle').value;
        const date = document.getElementById('eventDate').value;

        if (title && date) {
          calendar.addEvent({
            title: title,
            start: date,
            allDay: true
          });
        }

        // ล้างข้อมูล & ปิด modal
        document.getElementById('eventTitle').value = '';
        bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
      });
    });
  </script>

</body>
</html>