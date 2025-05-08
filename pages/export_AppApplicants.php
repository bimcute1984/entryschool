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
header("Content-Disposition: attachment; filename=applicants_$year.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr><th colspan='6'>รายชื่อผู้ยืนยันสิทธิ์เข้าศึกษา ปีการศึกษา $year</th></tr>";
echo "<tr>
        <th>ลำดับ</th>
        <th>เลขสมัคร</th>
        <th>ชื่อ-สกุล</th>
        <th>โควตา</th>
        <th>คณะ</th>
        
        <th>สาขา</th>
      </tr>";

$sql = "SELECT applicant.APPLICANTCODE,prefix.prefixname,applicant.APPLICANTNAME,applicant.APPLICANTSURNAME,applicant.HOMEPHONENO,
APPLICANTTYPE.APPLICANTTYPENAME ,Faculty.Facultyname,quota.quotaname
FROM avsreg.applicant 
INNER JOIN avsreg.prefix ON prefix.PREFIXID = applicant.PREFIXID
INNER JOIN avsreg.APPLICANTSELECTION ON APPLICANTSELECTION.APPLICANTID = applicant.APPLICANTID
INNER JOIN avsreg.QUOTA ON QUOTA.QUOTAID = APPLICANTSELECTION.QUOTAID
INNER JOIN avsreg.APPLICANTTYPE ON applicant.APPLICANTTYPE = APPLICANTTYPE.APPLICANTTYPEID
INNER JOIN avsreg.Faculty ON Faculty.facultyid = Quota.facultyid
WHERE applicant.APPLICANTSTATUS=50
AND APPLICANTSELECTION.ACADYEAR=:acadyear
AND applicant.schoolid=:schoolid
";
;

$stid = oci_parse($ubureg, $sql);
oci_bind_by_name($stid, ':acadyear', $year);
oci_bind_by_name($stid, ':schoolid', $school_id);
oci_execute($stid);

$i = 1;
while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
    $APPLICANTCODE = htmlspecialchars($row['APPLICANTCODE']);
    $fullname = htmlspecialchars($row['PREFIXNAME'] . $row['APPLICANTNAME'] . ' ' . $row['APPLICANTSURNAME']);
    $type = htmlspecialchars($row['APPLICANTTYPENAME']);
    $faculty = htmlspecialchars($row['FACULTYNAME']);
    $quota = htmlspecialchars($row['QUOTANAME']);
    
    
    echo "<tr>
            <td>$i</td>
            <td>$APPLICANTCODE</td>
            <td>$fullname</td>
            <td>$type</td>
            <td>$faculty</td>
            <td>$quota</td>
          </tr>";
    $i++;
}

echo "</table>";

oci_free_statement($stid);
oci_close($ubureg);
?>
