<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin-login.php");
  exit;
}

include('../db.php');

if (!isset($_GET['id'])) {
  header("Location: manage-buses.php");
  exit;
}

$bus_id = intval($_GET['id']);
$result = $conn->prepare("SELECT * FROM buses WHERE id = ?");
$result->bind_param("i", $bus_id);
$result->execute();
$bus = $result->get_result()->fetch_assoc();

// Fetch dropdown data
$routes = $conn->query("SELECT id, start_location, end_location FROM routes");
$drivers = $conn->query("SELECT id, full_name FROM admins WHERE role = 'Bus Driver'");
$conductor = $conn->query("SELECT id, full_name FROM admins WHERE role = 'Bus Conductor'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Bus - Bus Tracker</title>
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
      <a href="admin-dashboard.php" class="btn btn-outline-light btn-sm me-2">
        <i class="bi bi-house-fill"></i> Dashboard
      </a>
      <a href="logout.php" class="btn btn-outline-light btn-sm">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg p-4">
        <h4 class="mb-4 text-success"><i class="bi bi-pencil-fill"></i> Edit Bus</h4>
        <form method="POST" action="edit-bus-save.php">
          <input type="hidden" name="bus_id" value="<?= $bus['id'] ?>">

          <div class="mb-3">
            <label class="form-label">Bus Number</label>
            <input type="text" name="bus_number" class="form-control" required value="<?= htmlspecialchars($bus['bus_number']) ?>">
          </div>

          <div class="mb-3">
            <label class="form-label">Bus Name</label>
            <input type="text" name="bus_name" class="form-control" value="<?= htmlspecialchars($bus['bus_name']) ?>">
          </div>

          <div class="mb-3">
            <label class="form-label">Route</label>
            <select name="route_id" class="form-select" required>
              <option disabled>Select Route</option>
              <?php while ($r = $routes->fetch_assoc()): ?>
                <option value="<?= $r['id'] ?>" <?= $bus['route_id'] == $r['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($r['start_location'] . ' → ' . $r['end_location']) ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Driver</label>
            <select name="driver_id" class="form-select">
              <option value="">-- Optional --</option>
              <?php while ($d = $drivers->fetch_assoc()): ?>
                <option value="<?= $d['id'] ?>" <?= $bus['driver_id'] == $d['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($d['full_name']) ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Conductor</label>
            <select name="conductor_id" class="form-select">
              <option value="">-- Optional --</option>
              <?php while ($c = $conductor->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>" <?= $bus['conductor_id'] == $c['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($c['full_name']) ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" required value="<?= $bus['capacity'] ?>">
          </div>

          <div class="mb-3">
            <label class="form-label">Year of Manufacture</label>
            <input type="number" name="year_of_mfg" class="form-control" required value="<?= $bus['year_of_mfg'] ?>">
          </div>

          <div class="text-end">
            <a href="manage-buses.php" class="btn btn-secondary">
              <i class="bi bi-arrow-left-circle"></i> Cancel
            </a>
            <button class="btn btn-success">
              <i class="bi bi-save-fill"></i> Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
