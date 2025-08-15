<?php
include('../db.php');
header('Content-Type: application/json');

if (isset($_POST['id'], $_POST['status'])) {
  $id = $_POST['id'];
  $status = $_POST['status'];

  $stmt = $conn->prepare("UPDATE buses SET status = ? WHERE id = ?");
  $stmt->bind_param("si", $status, $id);

  if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Status updated"]);
  } else {
    echo json_encode(["success" => false, "message" => "Failed to update status"]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
