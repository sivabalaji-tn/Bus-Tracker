<?php
include('../db.php');

// Fetch Routes
$routes = $conn->query("SELECT id, start_location, end_location FROM routes");

// Fetch Drivers
$drivers = $conn->query("SELECT id, full_name FROM admins WHERE role = 'Bus Driver'");

// Fetch Conductors
$conductors = $conn->query("SELECT id, full_name FROM admins WHERE role = 'Bus Conductor'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Bus - Bus Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="admin-styles/admin.css" rel="stylesheet">
</head>
<body class="admin-login-bg">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        <div class="card shadow-lg p-4 rounded-4 bg-white">

          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h4 class="text-success"><i class="bi bi-bus-front-fill me-2"></i>Add New Bus</h4>
              <p class="text-muted">Enter complete bus details</p>
            </div>
            <a href="admin-dashboard.php" class="btn btn-sm btn-outline-success">
              <i class="bi bi-house-door-fill"></i> Dashboard
            </a>
          </div>

          <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($_GET['msg']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($_GET['error']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form method="POST" action="add-bus-save.php">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Bus Number</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-123"></i></span>
                  <input type="text" name="bus_number" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Bus Name (Optional)</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-tag-fill"></i></span>
                  <input type="text" name="bus_name" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Assign Route</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-signpost-2-fill"></i></span>
                  <select name="route_id" class="form-select" required>
                    <option selected disabled>Select Route</option>
                    <?php while ($route = $routes->fetch_assoc()): ?>
                      <option value="<?= $route['id'] ?>">
                        <?= $route['start_location'] ?> → <?= $route['end_location'] ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Driver</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-person-badge-fill"></i></span>
                  <select name="driver_id" class="form-select" required>
                    <option selected disabled>Select Driver</option>
                    <?php while ($driver = $drivers->fetch_assoc()): ?>
                      <option value="<?= $driver['id'] ?>"><?= $driver['full_name'] ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Conductor</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-person-vcard-fill"></i></span>
                  <select name="conductor_id" class="form-select" required>
                    <option selected disabled>Select Conductor</option>
                    <?php while ($conductor = $conductors->fetch_assoc()): ?>
                      <option value="<?= $conductor['id'] ?>"><?= $conductor['full_name'] ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Capacity</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-people-fill"></i></span>
                  <input type="number" name="capacity" class="form-control" min="10" max="100" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Year of Manufacturing</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-calendar-fill"></i></span>
                  <input type="number" name="year_of_mfg" class="form-control" min="1990" max="<?= date('Y') ?>" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Bus Type</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-fan"></i></span>
                  <select name="bus_type" class="form-select">
                    <option>Non-AC</option>
                    <option>AC</option>
                    <option>EV</option>
                  </select>
                </div>
              </div>

              <div class="col-md-12">
                <label class="form-label">Notes (Optional)</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="Add any specific note about the bus"></textarea>
              </div>

              <div class="col-md-12 mt-3">
                <button class="btn btn-warning w-100">
                  <i class="bi bi-plus-circle-fill"></i> Add Bus
                </button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
