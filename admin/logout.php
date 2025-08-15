<?php
session_start();

// Save role before destroying session
$role = $_SESSION['admin_role'] ?? '';

// Clear session
session_unset();
session_destroy();

// Redirect based on role
if ($role === 'Bus Driver') {
  header("Location: driver-login.php?msg=Logged out successfully");
} else {
  header("Location: admin-login.php?msg=Logged out successfully");
}
exit;
?>
