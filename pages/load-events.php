<?php
$pdo = new PDO("mysql:host=localhost;dbname=your_db;charset=utf8", "username", "password");

$stmt = $pdo->query("SELECT * FROM events");
$events = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $events[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['start'],
        'end' => $row['end'],
        'description' => $row['description']
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>