<?php
include('../db.php');

// Collect input
$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$dob = $_POST['dob'];
$role = $_POST['role'];
$id_card_no = trim($_POST['id_card_no']);
$phone = trim($_POST['phone']);

// Optional: basic validation
if (empty($full_name) || empty($email) || empty($_POST['password']) || empty($dob) || empty($role)) {
  header("Location: create-admin.php?error=All fields are required");
  exit;
}

// Check if email already exists
$check_stmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
  header("Location: create-admin.php?error=Email already exists");
  exit;
}

// Insert new admin
$sql = "INSERT INTO admins (full_name, email, password, dob, role, id_card_no, phone)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $full_name, $email, $password, $dob, $role, $id_card_no, $phone);

if ($stmt->execute()) {
  header("Location: create-admin.php?msg=Admin created successfully");
  exit;
} else {
  header("Location: create-admin.php?error=Database error: " . urlencode($conn->error));
  exit;
}
?>
