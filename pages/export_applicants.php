<?php
session_start();
include '../pages/backend/connectDB.php';

$year = $_GET['year'] ?? null;
$Faculty = $_POST['Faculty'] ?? null;;
$school_id = $_SESSION['schoolID'] ?? null;

if (!$year || !$school_id) {
    die("ข้อมูลไม่ครบถ้วน");
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=TmpApplicants_$year.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr><th colspan='6'>รายชื่อผู้สมัคร ปีการศึกษา $year</th></tr>";
echo "<tr>
        <th>ลำดับ</th>
        <th>ชื่อ-สกุล</th>
        <th>โควตา</th>
        <th>คณะ</th>
        <th>สาขา</th>
        <th>สถานะการสมัคร</th>
      </tr>";

$sql = "SELECT
    PR.PREFIXNAME, 
    TA.APPLICANTNAME, 
    TA.APPLICANTSURNAME, 
    TA.ACADYEAR, 
    TS.SELECTIONSTATUS, 
    AT.APPLICANTTYPENAME, 
    Q.QUOTANAME, 
    F.FACULTYNAME, 
    AT.APPLICANTTYPEID, 
    Q.QUOTAID,  
    F.FACULTYID,
    TA.EMAIL,
    S.BYTEDES
FROM AVSREG.TMPAPPLICANT TA
JOIN AVSREG.PREFIX PR ON TA.PREFIXID = PR.PREFIXID
JOIN AVSREG.TMPAPPLICANTSELECTION TS ON TS.APPLICANTID = TA.APPLICANTID
JOIN AVSREG.APPLICANTTYPE AT ON AT.APPLICANTTYPEID = TA.APPLICANTTYPE
JOIN AVSREG.QUOTA Q ON TS.QUOTAID = Q.QUOTAID
JOIN AVSREG.FACULTY F ON Q.FACULTYID = F.FACULTYID
JOIN AVSREG.sysbytedes S ON (S.TABLENAME='APPLICANT' AND S.COLUMNNAME='APPLICANTSTATUS' AND S.BYTECODE=TS.SELECTIONSTATUS) 
WHERE TA.ACADYEAR = :acadyear
AND TA.SCHOOLID=:schoolid";
;

$stid = oci_parse($ubureg, $sql);
oci_bind_by_name($stid, ':acadyear', $year);
oci_bind_by_name($stid, ':schoolid', $school_id);
oci_execute($stid);

$i = 1;
while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
    $fullname = htmlspecialchars($row['PREFIXNAME'] . $row['APPLICANTNAME'] . ' ' . $row['APPLICANTSURNAME']);
    $type = htmlspecialchars($row['APPLICANTTYPENAME']);
    $faculty = htmlspecialchars($row['FACULTYNAME']);
    $quota = htmlspecialchars($row['QUOTANAME']);
    $byte = htmlspecialchars($row['BYTEDES']);
    
    echo "<tr>
            <td>$i</td>
            <td>$fullname</td>
            <td>$type</td>
            <td>$faculty</td>
            <td>$quota</td>
            <td>$byte</td>
          </tr>";
    $i++;
}

echo "</table>";

oci_free_statement($stid);
oci_close($ubureg);
?>
