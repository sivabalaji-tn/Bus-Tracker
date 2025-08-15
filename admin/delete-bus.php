<?php
include('../db.php');
header('Content-Type: application/json');

if (isset($_POST['id'])) {
  $id = $_POST['id'];

  $stmt = $conn->prepare("DELETE FROM buses WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Bus deleted successfully"]);
  } else {
    echo json_encode(["success" => false, "message" => "Failed to delete bus"]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
