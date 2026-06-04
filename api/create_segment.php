<?php
header('Content-Type: application/json');
require_once '../config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['segment_name']) || empty($data['start_time']) || empty($data['end_time'])) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

// Escape strings to prevent SQL injections
$segment_name = $conn->real_escape_string($data['segment_name']);
$start_time   = $conn->real_escape_string($data['start_time']);
$end_time     = $conn->real_escape_string($data['end_time']);
$duration     = $conn->real_escape_string($data['duration']);
$main_shots   = $conn->real_escape_string($data['main_shots']);
$visuals      = $conn->real_escape_string($data['visuals']);
$tips         = $conn->real_escape_string($data['tips']);

$query = "INSERT INTO segments (segment_name, start_time, end_time, duration, main_shots, visuals, tips) 
          VALUES ('$segment_name', '$start_time', '$end_time', '$duration', '$main_shots', '$visuals', '$tips')";

if ($conn->query($query) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'New segment added to database!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$conn->close();
?>