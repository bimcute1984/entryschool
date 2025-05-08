<?php
include "../pages/backend/connectDB.php";

$sql = "SELECT event_id, title, start_date, end_date FROM events_guildance";
$stid = oci_parse($conn, $sql);
oci_execute($stid);

$events = [];
while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
    $events[] = [
        'id'    => $row['EVENT_ID'],
        'title' => $row['TITLE'],
        'start' => date('Y-m-d', strtotime($row['START_DATE'])),
        'end'   => date('Y-m-d', strtotime($row['END_DATE']))
    ];
}

oci_free_statement($stid);
oci_close($conn);

header('Content-Type: application/json');
echo json_encode($events);
?>
