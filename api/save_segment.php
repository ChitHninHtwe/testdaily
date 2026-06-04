<?php
header('Content-Type: application/json');
require_once '../config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || !isset($data['main_shots'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$id = $conn->real_escape_string($data['id']);
$main_shots = $conn->real_escape_string($data['main_shots']);
$visuals = isset($data['visuals']) ? $conn->real_escape_string($data['visuals']) : '';
$tips = isset($data['tips']) ? $conn->real_escape_string($data['tips']) : '';

$query = "UPDATE segments SET main_shots = '$main_shots', visuals = '$visuals', tips = '$tips' WHERE id = $id";

if ($conn->query($query) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Segment updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
