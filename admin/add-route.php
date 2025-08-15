<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin-login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Route - Bus Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="admin-styles/admin.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-success">
    <div class="container-fluid">
      <a href="admin-dashboard.php" class="navbar-brand">
        <i class="bi bi-bus-front-fill"></i> Admin Dashboard
      </a>
      <span class="text-white">👋 Welcome, <?= $_SESSION['admin_name'] ?></span>
    </div>
  </nav>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm p-4 rounded-4 bg-white">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-success"><i class="bi bi-geo-alt-fill"></i> Add New Route</h4>
            <a href="admin-dashboard.php" class="btn btn-sm btn-outline-secondary">
              <i class="bi bi-house-fill"></i> Home
            </a>
          </div>

          <!-- Alerts -->
          <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($_GET['msg']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($_GET['error']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form method="POST" action="add-route-save.php">
            <div class="mb-3">
              <label class="form-label">Route Name</label>
              <div class="input-group">
                <span class="input-group-text bg-success text-white"><i class="bi bi-signpost-2-fill"></i></span>
                <input type="text" name="route_name" class="form-control" required>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Start Location</label>
              <div class="input-group">
                <span class="input-group-text bg-success text-white"><i class="bi bi-flag-fill"></i></span>
                <input type="text" name="start_location" class="form-control" required>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">End Location</label>
              <div class="input-group">
                <span class="input-group-text bg-success text-white"><i class="bi bi-flag-fill"></i></span>
                <input type="text" name="end_location" class="form-control" required>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Stops (One per line)</label>
              <div class="input-group">
                <span class="input-group-text bg-success text-white"><i class="bi bi-list-ol"></i></span>
                <textarea name="stops" class="form-control" rows="4" placeholder="Example:&#10;Periyakulam&#10;Theni Old Bus Stand&#10;Cumbum" required></textarea>
              </div>
            </div>

            <button class="btn btn-warning w-100">
              <i class="bi bi-check-circle-fill"></i> Add Route
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
