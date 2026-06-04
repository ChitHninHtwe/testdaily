<?php
header('Content-Type: application/json');
require_once '../config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'Segment ID required']);
    exit;
}

$id = $conn->real_escape_string($data['id']);
$query = "DELETE FROM user_notes WHERE segment_id = $id";
$conn->query($query);

$query = "DELETE FROM segments WHERE id = $id";

if ($conn->query($query) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Segment deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>