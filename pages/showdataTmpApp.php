<?php
include "../pages/backend/connectDB.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Get form data
$year = $_POST['year'];
$Faculty = $_POST['Faculty'];
$SCHOOLID = $_SESSION['schoolID'];
    


// Prepare the SQL query to select user where username and password match
$sqlselectTemp = "SELECT 
    
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

if($Faculty != ""){
    $sqlselectTemp.=" AND F.FACULTYID=:facultyid";
}



// Create the statement and bind parameters
$statement = oci_parse($ubureg, $sqlselectTemp);

oci_bind_by_name($statement, ':acadyear', $year);
oci_bind_by_name($statement, ':schoolid', $SCHOOLID);
    if($Faculty != ""){
        oci_bind_by_name($statement, ':facultyid', $Faculty);
    }


// Execute the statement
oci_execute($statement);

$data = [];
while ($row = oci_fetch_assoc($statement)) {
    $data[] = $row;
}
oci_free_statement($statement);
echo json_encode($data);
}

// Close the Oracle connection
oci_close($ubureg);


?>
