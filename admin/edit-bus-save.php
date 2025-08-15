<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin-login.php");
  exit;
}

include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bus_id = intval($_POST['bus_id']);
  $bus_number = trim($_POST['bus_number']);
  $bus_name = trim($_POST['bus_name']);
  $route_id = intval($_POST['route_id']);
  $driver_id = !empty($_POST['driver_id']) ? intval($_POST['driver_id']) : null;
  $conductor_id = !empty($_POST['conductor_id']) ? intval($_POST['conductor_id']) : null;
  $capacity = intval($_POST['capacity']);
  $year_of_mfg = intval($_POST['year_of_mfg']);

  $stmt = $conn->prepare("
    UPDATE buses
    SET bus_number = ?, bus_name = ?, route_id = ?, driver_id = ?, conductor_id = ?, capacity = ?, year_of_mfg = ?
    WHERE id = ?
  ");
  $stmt->bind_param(
    "ssiiiiii",
    $bus_number,
    $bus_name,
    $route_id,
    $driver_id,
    $conductor_id,
    $capacity,
    $year_of_mfg,
    $bus_id
  );

  if ($stmt->execute()) {
    $_SESSION['success_msg'] = "Bus updated successfully!";
  } else {
    $_SESSION['error_msg'] = "Something went wrong. Please try again.";
  }

  header("Location: manage-buses.php");
  exit;
} else {
  header("Location: manage-buses.php");
  exit;
}
?>
