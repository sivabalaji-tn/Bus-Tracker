<?php
include('../db.php');
header('Content-Type: application/json');

if (isset($_POST['id'], $_POST['announcement'])) {
  $id = $_POST['id'];
  $announcement = $_POST['announcement'];

  $stmt = $conn->prepare("UPDATE buses SET announcement = ? WHERE id = ?");
  $stmt->bind_param("si", $announcement, $id);

  if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Announcement updated"]);
  } else {
    echo json_encode(["success" => false, "message" => "Failed to update announcement"]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
