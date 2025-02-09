<?php
require_once(__DIR__ . '/../../config/database.php');

header('Content-Type: application/json');

$sql = "SELECT id_presentation, id_presentation, date_de_presentation FROM calendriers";
$result = $conn->query($sql);

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'presentation' => $row['id_presentation'],
        'etudiant' => $row['id_etudiant'],
        'date' => $row['date_de_presentation']
    ];
}

// Si aucun événement n'existe, renvoie un tableau vide
echo json_encode($events ?: []);
?>
