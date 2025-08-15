<?php
session_start();
include('../db.php');

$email = trim($_POST['email']);
$password = $_POST['password'];

// Check if the email exists and role is 'Bus Driver'
$stmt = $conn->prepare("SELECT id, full_name, password, role FROM admins WHERE email = ? AND role = 'Bus Driver'");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $admin = $result->fetch_assoc();

  // Verify password
  if (password_verify($password, $admin['password'])) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_name'] = $admin['full_name'];
    $_SESSION['admin_role'] = $admin['role'];

    header("Location: driver-dashboard.php");
    exit;
  } else {
    header("Location: driver-login.php?error=Invalid password");
    exit;
  }
} else {
  header("Location: driver-login.php?error=Driver not found or invalid role");
  exit;
}
?>
