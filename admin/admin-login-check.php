<?php
session_start();
include('../db.php');

function log_login_attempt($email, $status) {
  global $conn;
  $ip = $_SERVER['REMOTE_ADDR'];
  $stmt = $conn->prepare("INSERT INTO login_logs (email, ip_address, status) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $email, $ip, $status);
  $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if too many failed attempts from same IP
  $ip = $_SERVER['REMOTE_ADDR'];
  $check_stmt = $conn->prepare("
    SELECT COUNT(*) as fail_count FROM login_logs
    WHERE ip_address = ? AND status = 'fail' AND timestamp > NOW() - INTERVAL 5 MINUTE
  ");
  $check_stmt->bind_param("s", $ip);
  $check_stmt->execute();
  $fail_data = $check_stmt->get_result()->fetch_assoc();

  if ($fail_data['fail_count'] >= 5) {
    header("Location: admin-login.php?error=Too many attempts. Try again in 5 mins");
    exit;
  }

  // Look up admin
  $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($admin = $result->fetch_assoc()) {
    if (password_verify($password, $admin['password'])) {
      $_SESSION['admin_logged_in'] = true;
      $_SESSION['admin_id'] = $admin['id'];
      $_SESSION['admin_name'] = $admin['full_name'];
      $_SESSION['admin_role'] = $admin['role'];

      log_login_attempt($email, 'success');
      header("Location: admin-login.php?success=Welcome " . urlencode($admin['full_name']));
      exit;
    } else {
      log_login_attempt($email, 'fail');
      header("Location: admin-login.php?error=Incorrect password");
      exit;
    }
  } else {
    log_login_attempt($email, 'fail');
    header("Location: admin-login.php?error=Email not found");
    exit;
  }
}
?>
