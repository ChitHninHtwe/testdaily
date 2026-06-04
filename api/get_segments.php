<?php
header('Content-Type: application/json');
require_once '../config.php';

$query = "SELECT * FROM segments ORDER BY id ASC";
$result = $conn->query($query);

$segments = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $segments[] = $row;
    }
}

echo json_encode(['success' => true, 'segments' => $segments]);
$conn->close();
?>