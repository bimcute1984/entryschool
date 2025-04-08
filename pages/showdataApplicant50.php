<?php
include "../pages/backend/connectDB.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

$year = $_POST['year'];
$Faculty = $_POST['Faculty'];
$SCHOOLID = $_SESSION['schoolID'];

$sqlselectApplicant50="SELECT applicant.APPLICANTCODE,prefix.prefixname,applicant.APPLICANTNAME,applicant.APPLICANTSURNAME,applicant.HOMEPHONENO,
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

if($Faculty != ""){
    $sqlselectApplicant50.=" AND Faculty.FACULTYID=:facultyid";
}

$statement = oci_parse($ubureg, $sqlselectApplicant50);

oci_bind_by_name($statement, ':acadyear', $year);
oci_bind_by_name($statement, ':schoolid', $SCHOOLID);

    if($Faculty != ""){
        oci_bind_by_name($statement, ':facultyid', $Faculty);
    }

oci_execute($statement);

$data = [];
while ($row = oci_fetch_assoc($statement)) {
    $data[] = $row;
}
oci_free_statement($statement);
echo json_encode($data);
}
oci_close($ubureg);
?>