<?php

include "../pages/backend/connectDB.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $year = $_POST['year'] ?? date('Y') + 543; 
  $school_id = $_SESSION['schoolID'] ?? null;
 
 
$sql = "SELECT 
  Faculty.Facultyname,
  COUNT(*) AS total_applicants
FROM avsreg.applicant 
INNER JOIN avsreg.APPLICANTSELECTION 
  ON APPLICANTSELECTION.APPLICANTID = applicant.APPLICANTID
INNER JOIN avsreg.QUOTA 
  ON QUOTA.QUOTAID = APPLICANTSELECTION.QUOTAID
INNER JOIN avsreg.Faculty 
  ON Faculty.facultyid = Quota.facultyid
WHERE APPLICANTSELECTION.ACADYEAR = :acadyear
  AND applicant.SCHOOLID = :schoolID
  AND applicant.APPLICANTSTATUS=50
GROUP BY Faculty.Facultyname
ORDER BY COUNT(*) DESC";
 
 $stid = oci_parse($ubureg, $sql);
 oci_bind_by_name($stid, ":acadyear", $year);
 oci_bind_by_name($stid, ":schoolid", $school_id);
 oci_execute($stid);
 
 $data = [];
 while (($row = oci_fetch_array($stid, OCI_ASSOC))) {
     $data[] = $row;
 }
 
 oci_free_statement($stid);
 header('Content-Type: application/json');
 echo json_encode($data);

}
oci_close($ubureg);
?>
