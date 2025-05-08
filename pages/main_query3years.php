<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>รายงานผู้สมัครของโรงเรียนฉัน</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h4 class="mb-4">สถิติผู้สมัคร (เฉพาะโรงเรียนของคุณ)</h4>

    <div class="mb-3">
      <label for="yearSelect" class="form-label">เลือกปีการศึกษา:</label>
      <select id="yearSelect" class="form-select w-auto">
        <!-- JS เติมปี -->
      </select>
    </div>

    <table class="table table-bordered text-center">
      <thead class="table-dark">
        <tr>
          <th>คณะ</th>
          <th>จำนวนผู้สมัคร</th>
        </tr>
      </thead>
      <tbody id="resultTable">
        <!-- JS เติมข้อมูล -->
      </tbody>
    </table>
  </div>

  <script>
    const thisYear = new Date().getFullYear() + 543;
    const yearSelect = document.getElementById("yearSelect");
    const tbody = document.getElementById("resultTable");

    for (let i = 0; i < 3; i++) {
      const y = thisYear - i;
      const opt = document.createElement("option");
      opt.value = y;
      opt.text = `ปีการศึกษา ${y}`;
      yearSelect.appendChild(opt);
    }

    loadData(yearSelect.value);
    yearSelect.addEventListener("change", () => loadData(yearSelect.value));

    function loadData(year) {
      fetch(`get_by_faculty.php?year=${year}`)
        .then(res => res.json())
        .then(data => {
          tbody.innerHTML = '';
          data.forEach(row => {
            tbody.innerHTML += `
              <tr>
                <td>${row.FACULTYNAME}</td>
                <td>${row.TOTAL_APPLICANTS}</td>
              </tr>`;
          });
        });
    }
  </script>
</body>
</html>
