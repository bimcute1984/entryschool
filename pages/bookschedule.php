<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>จองห้องประชุม</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      padding: 2rem;
      background-color: #f8f9fa;
    }
    .table thead {
      background-color: #0d6efd;
      color: white;
    }
    .btn-book {
      width: 100%;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 class="mb-4">📌 ตารางจองห้องประชุม ชั้น 3 </h2>

  <table class="table table-bordered text-center">
    <thead>
      <tr>
        <th>วัน/เวลา</th>
        <th>09:00 - 10:00</th>
        <th>10:00 - 11:00</th>
        <th>11:00 - 12:00</th>
        <th>13:00 - 14:00</th>
        <th>14:00 - 15:00</th>
        <th>15:00 - 16:00</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>จันทร์</td>
        <td><button class="btn btn-success btn-book">จอง</button></td>
        <td><button class="btn btn-success btn-book">จอง</button></td>
        <td><button class="btn btn-danger" disabled>ไม่ว่าง</button></td>
        <td><button class="btn btn-success btn-book">จอง</button></td>
        <td><button class="btn btn-success btn-book">จอง</button></td>
      </tr>
      <tr>
        <td>อังคาร</td>
        <td><button class="btn btn-success btn-book">จอง</button></td>
        <td><button class="btn btn-success btn-book">จอง</button></td>
        <td><button class="btn btn-success btn-book">จอง</button></td>
        <td><button class="btn btn-danger" disabled>ไม่ว่าง</button></td>
        <td><button class="btn btn-success btn-book">จอง</button></td>
      </tr>
      <!-- เพิ่มวันอื่นๆ ต่อได้ -->
    </tbody>
  </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // ตัวอย่างการคลิกจอง (สามารถต่อ API หรือ PHP ได้)
  document.querySelectorAll('.btn-book').forEach(btn => {
    btn.addEventListener('click', () => {
      btn.classList.remove('btn-success');
      btn.classList.add('btn-warning');
      btn.textContent = 'รอดำเนินการ';
      btn.disabled = true;

      // ส่งข้อมูลไป backend ได้ที่นี่ (fetch หรือ AJAX)
    });
  });
</script>

</body>
</html>
