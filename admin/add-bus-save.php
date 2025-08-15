<?php
include('../db.php');

$bus_number = trim($_POST['bus_number']);
$bus_name = trim($_POST['bus_name']);
$route_id = $_POST['route_id'];
$driver_id = $_POST['driver_id'];
$conductor_id = $_POST['conductor_id'];
$capacity = $_POST['capacity'];
$year_of_mfg = $_POST['year_of_mfg'];

// Validate required fields
if (empty($bus_number) || empty($route_id) || empty($driver_id) || empty($conductor_id)) {
  header("Location: add-bus.php?error=Please fill all required fields.");
  exit;
}

// Check for duplicate bus number
$check = $conn->prepare("SELECT id FROM buses WHERE bus_number = ?");
$check->bind_param("s", $bus_number);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
  header("Location: add-bus.php?error=Bus number already exists.");
  exit;
}

// Insert the bus
$sql = "INSERT INTO buses (bus_number, bus_name, route_id, driver_id, conductor_id, capacity, year_of_mfg)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiiiii", $bus_number, $bus_name, $route_id, $driver_id, $conductor_id, $capacity, $year_of_mfg);

if ($stmt->execute()) {
  header("Location: add-bus.php?msg=Bus added successfully!");
} else {
  header("Location: add-bus.php?error=Failed to add bus.");
}
?>
