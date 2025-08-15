<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin-login.php");
  exit;
}

include('../db.php');
function getCount($conn, $sql) {
  $result = $conn->query($sql);
  if (!$result) return 0;
  $row = $result->fetch_row();
  return $row ? $row[0] : 0;
}

// Fetch dashboard stats
$total_buses = getCount($conn, "SELECT COUNT(*) FROM buses");
$total_routes = getCount($conn, "SELECT COUNT(*) FROM routes");
$active_buses = getCount($conn, "SELECT COUNT(*) FROM buses WHERE status = 'active'");
$total_admins = getCount($conn, "SELECT COUNT(*) FROM admins");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Bus Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="admin-styles/admin.css" rel="stylesheet">
</head>
<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
      <span class="navbar-brand"><i class="bi bi-bus-front-fill me-1"></i> Bus Tracker Admin</span>
      <div class="d-flex">
        <span class="text-white me-3">👋 Welcome, <?= $_SESSION['admin_name'] ?> (<?= $_SESSION['admin_role'] ?>)</span>
        <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-warning text-dark">
          <div class="card-body">
            <h6><i class="bi bi-bus-front-fill me-2"></i>Total Buses</h6>
            <h3><?= $total_buses ?></h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-success text-white">
          <div class="card-body">
            <h6><i class="bi bi-signpost-2-fill me-2"></i>Total Routes</h6>
            <h3><?= $total_routes ?></h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-info text-white">
          <div class="card-body">
            <h6><i class="bi bi-check2-circle me-2"></i>Active Buses</h6>
            <h3><?= $active_buses ?></h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm border-0 bg-secondary text-white">
          <div class="card-body">
            <h6><i class="bi bi-people-fill me-2"></i>Total Admins</h6>
            <h3><?= $total_admins ?></h3>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <h5 class="mb-3">Quick Actions</h5>
      <div class="d-flex flex-wrap gap-3">
        <a href="add-bus.php" class="btn btn-outline-success">
          <i class="bi bi-plus-circle-fill me-1"></i> Add Bus
        </a>
        <a href="add-route.php" class="btn btn-outline-success">
          <i class="bi bi-geo-alt-fill me-1"></i> Add Route
        </a>
        <a href="manage-buses.php" class="btn btn-outline-warning">
          <i class="bi bi-wrench-adjustable-circle-fill me-1"></i> Manage Buses
        </a>
        <a href="create-admin.php" class="btn btn-outline-primary">
          <i class="bi bi-person-plus-fill me-1"></i> Create Admin
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>