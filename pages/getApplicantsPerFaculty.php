<?php
include "../pages/backend/connectDB.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SCHOOLID = $_SESSION['schoolID'];
    $years = json_decode(file_get_contents('php://input'), true)['years'];

    // เตรียม SQL
    $placeholders = implode(",", array_map(fn($i) => ":year$i", array_keys($years)));
    $sql = "
        SELECT Faculty.FACULTYNAME, APPLICANTSELECTION.ACADYEAR, COUNT(*) AS TOTAL
        FROM avsreg.applicant
        INNER JOIN avsreg.APPLICANTSELECTION ON applicant.APPLICANTID = APPLICANTSELECTION.APPLICANTID
        INNER JOIN avsreg.QUOTA ON QUOTA.QUOTAID = APPLICANTSELECTION.QUOTAID
        INNER JOIN avsreg.FACULTY ON FACULTY.FACULTYID = QUOTA.FACULTYID
        WHERE applicant.schoolid = :schoolid
        AND applicant.APPLICANTSTATUS = 50
        AND APPLICANTSELECTION.ACADYEAR IN ($placeholders)
        GROUP BY Faculty.FACULTYNAME, APPLICANTSELECTION.ACADYEAR
        ORDER BY Faculty.FACULTYNAME, APPLICANTSELECTION.ACADYEAR
    ";

    $stmt = oci_parse($ubureg, $sql);
    oci_bind_by_name($stmt, ':schoolid', $SCHOOLID);

    foreach ($years as $i => $year) {
        oci_bind_by_name($stmt, ":year$i", $years[$i]);
    }

    oci_execute($stmt);

    $result = [];
    $faculties = [];

    while ($row = oci_fetch_assoc($stmt)) {
        $faculty = $row['FACULTYNAME'];
        $year = $row['ACADYEAR'];
        $count = (int)$row['TOTAL'];

        if (!in_array($faculty, $faculties)) {
            $faculties[] = $faculty;
        }

        $result[$faculty][$year] = $count;
    }

    oci_free_statement($stmt);
    oci_close($ubureg);

    echo json_encode([
        'faculties' => $faculties,
        'data' => $result
    ]);
}
?>
