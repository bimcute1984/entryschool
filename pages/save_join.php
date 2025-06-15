<?php
include 'chksession.php';
include "../pages/backend/connectDB.php";

$schoolID = $_SESSION['schoolID'];

// รับค่าจากฟอร์ม
$event_id = $_POST['event_id'] ?? '';
$total_students = $_POST['total_students'] ?? '';
$contact_name = $_POST['contact_name'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$total_teacher = $_POST['total_teacher'] ?? '';
$join_type = 'A'; // A = ในตาราง

// รับคำนำหน้า
$prefix = $_POST['contact_prefix'] ?? '';
$prefix_other = $_POST['contact_prefix_other'] ?? '';
$final_prefix = ($prefix === 'อื่นๆ' && !empty($prefix_other)) ? $prefix_other : $prefix;

// รวมคำนำหน้ากับชื่อจริง
$contact_name_full = $final_prefix . $contact_name;

// ตรวจสอบความถูกต้อง
if (empty($event_id) || empty($total_students) || empty($contact_name_full) || empty($contact_number)) {
    die("ข้อมูลไม่ครบถ้วน");
}

// ตรวจสอบซ้ำว่าเคยเข้าร่วมกิจกรรมในตารางแล้วหรือยัง
$sql_check = "SELECT COUNT(*) AS CNT FROM EVEN_JOIN WHERE SCHOOLID = :schoolID AND JOIN_TYPE = 'A'";
$stmt_check = oci_parse($ubureg, $sql_check);
oci_bind_by_name($stmt_check, ":schoolID", $schoolID);
oci_execute($stmt_check);
$row_check = oci_fetch_assoc($stmt_check);
if ($row_check['CNT'] > 0) {
    echo "<script>
        alert('คุณได้เข้าร่วมกิจกรรมในตารางแล้ว กรุณาลบรายการเดิมก่อน');
        window.location.href = 'GuildanceTable.php';
    </script>";
    exit;
}

// ดึงข้อมูล EVENT_DATE และ TIME จากกิจกรรม
$sql_event = "SELECT EVENT_DATE, TIME FROM EVENTS_GUILDANCE WHERE EVENT_ID = :event_id";
$stmt_event = oci_parse($ubureg, $sql_event);
oci_bind_by_name($stmt_event, ":event_id", $event_id);
oci_execute($stmt_event);
$event_data = oci_fetch_assoc($stmt_event);

if (!$event_data) {
    die("ไม่พบข้อมูลกิจกรรมที่เลือก");
}

$join_date = $event_data['EVENT_DATE']; // รูปแบบ YYYY-MM-DD
$join_time = $event_data['TIME'];       // เช่น 10:00:00

// สร้าง JOIN_ID แบบสุ่ม
$join_id = uniqid("JID");

// SQL บันทึกข้อมูล
$sql = "INSERT INTO EVEN_JOIN (
    JOIN_ID,
    SCHOOLID,
    EVENT_ID,
    JOIN_DATE,
    JOIN_TIME,
    TOTAL_STUDENTS,
    TOTAL_TEACHER,
    CONTACT_NAME,
    CONTACT_NUMBER,
    JOIN_TYPE
) VALUES (
    :join_id,
    :schoolID,
    :event_id,
    TO_DATE(:join_date, 'YYYY-MM-DD'),
    :join_time,
    :total_students,
    :total_teacher,
    :contact_name,
    :contact_number,
    :join_type
)";

$stmt = oci_parse($ubureg, $sql);

// ผูกตัวแปร
oci_bind_by_name($stmt, ":join_id", $join_id);
oci_bind_by_name($stmt, ":schoolID", $schoolID);
oci_bind_by_name($stmt, ":event_id", $event_id);
oci_bind_by_name($stmt, ":join_date", $join_date);
oci_bind_by_name($stmt, ":join_time", $join_time);
oci_bind_by_name($stmt, ":total_students", $total_students);
oci_bind_by_name($stmt, ":total_teacher", $total_teacher);
oci_bind_by_name($stmt, ":contact_name", $contact_name_full);
oci_bind_by_name($stmt, ":contact_number", $contact_number);
oci_bind_by_name($stmt, ":join_type", $join_type);

// รันและตรวจผล
if (oci_execute($stmt)) {
    echo "<script>
        alert('บันทึกข้อมูลเรียบร้อยแล้ว');
        window.location = 'GuildanceTable.php';
    </script>";
} else {
    $e = oci_error($stmt);
    echo "เกิดข้อผิดพลาด: " . $e['message'];
}
?>
