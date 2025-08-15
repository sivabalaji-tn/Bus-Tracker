<?php include('../db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Admin - Bus Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="admin-styles/admin.css" rel="stylesheet">
</head>
<a href="admin-dashboard.php" class="btn btn-success position-fixed top-0 end-0 m-4 rounded-circle shadow-lg"
   style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;" 
   title="Go to Dashboard">
  <i class="bi bi-house-door-fill text-white fs-5"></i>
</a>

<body class="admin-login-bg">


  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-md-9">
        <div class="card shadow-lg p-4 rounded-4 bg-white">
          <div class="text-center mb-4">
            <i class="bi bi-person-plus-fill text-success display-5"></i>
            <h4 class="text-success mt-2">Create New Admin</h4>
            <p class="text-muted">Assign role and credentials</p>
          </div>

          <!-- Alerts -->
          <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
              <i class="bi bi-check-circle-fill me-2"></i>
              <?= htmlspecialchars($_GET['msg']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>
              <?= htmlspecialchars($_GET['error']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form method="POST" action="create-admin-save.php">
            <div class="row g-3">
              <div class="col-md-12">
                <label class="form-label">Full Name</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-person-fill"></i></span>
                  <input type="text" name="full_name" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-envelope-fill"></i></span>
                  <input type="email" name="email" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-lock-fill"></i></span>
                  <input type="password" name="password" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-calendar-event-fill"></i></span>
                  <input type="date" name="dob" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Role</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-briefcase-fill"></i></span>
                  <select name="role" class="form-select" required>
                    <option selected disabled>Select Role</option>
                    <option>Shed Manager</option>
                    <option>Control Unit</option>
                    <option>Vehicle Maintenance</option>
                    <option>Bus Driver</option>
                    <option>Bus Conductor</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">ID Card Number</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-credit-card-fill"></i></span>
                  <input type="text" name="id_card_no" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <div class="input-group">
                  <span class="input-group-text bg-success text-white"><i class="bi bi-telephone-fill"></i></span>
                  <input type="text" name="phone" class="form-control" required>
                </div>
              </div>

              <div class="col-md-12 mt-3">
                <button class="btn btn-warning w-100">
                  <i class="bi bi-check-circle-fill"></i> Create Admin
                </button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS for alerts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
