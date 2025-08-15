<?php
session_start();
include('../db.php');

header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'Bus Driver') {
  echo json_encode(['success' => false, 'message' => 'Unauthorized']);
  exit;
}

$driver_id = $_SESSION['admin_id'];
$lat = isset($_POST['lat']) ? floatval($_POST['lat']) : null;
$lng = isset($_POST['lng']) ? floatval($_POST['lng']) : null;

// Make sure lat/lng are provided
if ($lat === null || $lng === null) {
  echo json_encode(['success' => false, 'message' => 'Coordinates missing']);
  exit;
}

// Check if this driver's bus is currently active
$check = $conn->prepare("SELECT id FROM buses WHERE driver_id = ? AND status = 'active'");
$check->bind_param("i", $driver_id);
$check->execute();
$result = $check->get_result();

if ($result && $result->num_rows > 0) {
  // Update location
  $update = $conn->prepare("UPDATE buses SET latitude = ?, longitude = ? WHERE driver_id = ?");
  $update->bind_param("ddi", $lat, $lng, $driver_id);
  
  if ($update->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => 'DB update failed']);
  }
} else {
  // Bus is inactive, do not update location
  echo json_encode(['success' => false, 'message' => 'Bus is not active, location not updated']);
}
