<?php
header('Content-Type: application/json');
require_once "../pages/backend/connectDB.php";

$faculties = [];
$data = [];

$sql = "
    SELECT FACULTY_NAME, COUNT(*) AS TOTAL
    FROM ADMISSION_DATA
    WHERE STATUS = 50
      AND YEAR BETWEEN TO_CHAR(TO_NUMBER(TO_CHAR(SYSDATE, 'YYYY')) - 543 - 2)
                    AND TO_CHAR(TO_NUMBER(TO_CHAR(SYSDATE, 'YYYY')) - 543)
    GROUP BY FACULTY_NAME
    ORDER BY TOTAL DESC
    FETCH FIRST 5 ROWS ONLY
";

$parse = oci_parse($conn, $sql);
oci_execute($parse);

while ($row = oci_fetch_assoc($parse)) {
    $faculties[] = $row['FACULTY_NAME'];
    $data[] = (int)$row['TOTAL'];
}

echo json_encode([
    'faculties' => $faculties,
    'datasets' => [[
        'label' => 'รวม 3 ปี',
        'data' => $data
    ]]
]);
