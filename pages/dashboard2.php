
<?php include 'connectDB.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แดชบอร์ด - Oracle</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h1 class="mb-4">แดชบอร์ดข้อมูลจาก Oracle</h1>

  <?php
  // ตัวอย่าง query
  $sql = "SELECT ID, ITEM_NAME, STATUS FROM ITEMS"; // ชื่อตารางใน Oracle
  $stid = oci_parse($ubureg, $sql);
  oci_execute($stid);
  ?>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>รหัส</th>
        <th>ชื่อรายการ</th>
        <th>สถานะ</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = oci_fetch_assoc($stid)): ?>
        <tr>
          <td><?= $row['ID'] ?></td>
          <td><?= $row['ITEM_NAME'] ?></td>
          <td>
            <?php if ($row['STATUS'] == 'AVAILABLE'): ?>
              <span class="badge bg-success">ว่าง</span>
            <?php else: ?>
              <span class="badge bg-danger">ยืมอยู่</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>