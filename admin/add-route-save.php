<?php
include('../db.php');

$route_name = trim($_POST['route_name']);
$start_location = trim($_POST['start_location']);
$end_location = trim($_POST['end_location']);
$stops = explode("\n", trim($_POST['stops']));

// Validation
if (empty($route_name) || empty($start_location) || empty($end_location) || empty($stops)) {
  header("Location: add-route.php?error=All fields are required");
  exit;
}

// Prepare insert for route
$sql = "INSERT INTO routes (route_name, start_location, end_location) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
  die("❌ Prepare failed: " . $conn->error);  // Debug output
}

$stmt->bind_param("sss", $route_name, $start_location, $end_location);

if ($stmt->execute()) {
  $route_id = $stmt->insert_id;

  // Prepare stop insertion
  $stop_sql = "INSERT INTO route_stops (route_id, stop_name, stop_order) VALUES (?, ?, ?)";
  $stop_stmt = $conn->prepare($stop_sql);

  if (!$stop_stmt) {
    die("❌ Stop statement prepare failed: " . $conn->error);  // Debug output
  }

  $order = 1;
  foreach ($stops as $stop) {
    $clean_stop = trim($stop);
    if (!empty($clean_stop)) {
      $stop_stmt->bind_param("isi", $route_id, $clean_stop, $order);
      $stop_stmt->execute();
      $order++;
    }
  }

  header("Location: add-route.php?msg=Route and stops added successfully");
  exit;

} else {
  header("Location: add-route.php?error=Failed to insert route: " . urlencode($stmt->error));
  exit;
}
?>
