<?php
include "../pages/backend/connectDB.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SCHOOLID = $_SESSION['schoolID'];
    $input = json_decode(file_get_contents('php://input'), true);
    $years = $input['years']; // เช่น [2566, 2567, 2568]

    // เตรียมโครงสร้างข้อมูล
    $facultyList = [];
    $dataByYear = [];

    foreach ($years as $year) {
        $sql = "
            SELECT Faculty.FACULTYNAME, COUNT(*) AS TOTAL
            FROM avsreg.applicant
            INNER JOIN avsreg.APPLICANTSELECTION ON applicant.APPLICANTID = APPLICANTSELECTION.APPLICANTID
            INNER JOIN avsreg.QUOTA ON QUOTA.QUOTAID = APPLICANTSELECTION.QUOTAID
            INNER JOIN avsreg.FACULTY ON FACULTY.FACULTYID = QUOTA.FACULTYID
            WHERE applicant.schoolid = :schoolid
            AND applicant.APPLICANTSTATUS = 50
            AND APPLICANTSELECTION.ACADYEAR = :acadyear
            GROUP BY Faculty.FACULTYNAME
        ";
        $stmt = oci_parse($ubureg, $sql);
        oci_bind_by_name($stmt, ':schoolid', $SCHOOLID);
        oci_bind_by_name($stmt, ':acadyear', $year);
        oci_execute($stmt);

        $tempData = [];
        while ($row = oci_fetch_assoc($stmt)) {
            $faculty = $row['FACULTYNAME'];
            $tempData[$faculty] = (int)$row['TOTAL'];
            if (!in_array($faculty, $facultyList)) {
                $facultyList[] = $faculty;
            }
        }

        $dataByYear[$year] = $tempData;
        oci_free_statement($stmt);
    }

    oci_close($ubureg);

    // เตรียมข้อมูลสำหรับ Chart.js
    $colors = ['#a2cffe', '#3399ff', '#005cbf'];
    $datasets = [];
    $i = 0;

    foreach ($years as $year) {
        $counts = [];
        foreach ($facultyList as $faculty) {
            $counts[] = $dataByYear[$year][$faculty] ?? 0;
        }

        $datasets[] = [
            'label' => "ปี $year",
            'data' => $counts,
            'backgroundColor' => $colors[$i % count($colors)]
        ];
        $i++;
    }

    echo json_encode([
        'faculties' => $facultyList,
        'datasets' => $datasets
    ]);
}
?>
