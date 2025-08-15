<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin-login.php");
  exit;
}

include('../db.php');

$buses = $conn->query("SELECT b.id, b.bus_number, b.bus_name, b.status, b.announcement, r.start_location, r.end_location FROM buses b LEFT JOIN routes r ON b.route_id = r.id");

if (!$buses) {
  die("❌ SQL Error: " . $conn->error);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Buses - Bus Tracker</title>
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
  <h4 class="mb-4 text-success"><i class="bi bi-wrench-adjustable-circle-fill"></i> Manage Buses</h4>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle bg-white">
      <thead class="table-success">
        <tr>
          <th>#</th>
          <th>Bus Number</th>
          <th>Bus Name</th>
          <th>Route</th>
          <th>Status</th>
          <th>Announcement</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = $buses->fetch_assoc()): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= htmlspecialchars($row['bus_number']) ?></td>
          <td><?= htmlspecialchars($row['bus_name']) ?></td>
          <td><?= htmlspecialchars($row['start_location'] . ' → ' . $row['end_location']) ?></td>
          <td>
            <select class="form-select form-select-sm status-select" data-id="<?= $row['id'] ?>">
              <option value="active" <?= $row['status'] === 'active' ? 'selected' : '' ?>>Active</option>
              <option value="inactive" <?= $row['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
              <option value="maintenance" <?= $row['status'] === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
            </select>
          </td>
          <td>
            <input type="text" class="form-control form-control-sm announcement-input" 
              data-id="<?= $row['id'] ?>" value="<?= htmlspecialchars($row['announcement']) ?>">
          </td>
          <td>
            <a href="edit-bus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
              <i class="bi bi-pencil-fill"></i>
            </a>
            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="<?= $row['id'] ?>">
              <i class="bi bi-trash-fill"></i>
            </button>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
// Update status
const statusSelects = document.querySelectorAll('.status-select');
statusSelects.forEach(select => {
  select.addEventListener('change', () => {
    const id = select.dataset.id;
    const status = select.value;
    fetch('update-bus-status.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${id}&status=${status}`
    })
    .then(res => res.json())
    .then(data => {
      if (!data.success) alert('❌ ' + data.message);
    });
  });
});

// Update announcement
const announcements = document.querySelectorAll('.announcement-input');
announcements.forEach(input => {
  input.addEventListener('blur', () => {
    const id = input.dataset.id;
    const value = input.value;
    fetch('update-announcement.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${id}&announcement=${encodeURIComponent(value)}`
    })
    .then(res => res.json())
    .then(data => {
      if (!data.success) alert('❌ ' + data.message);
    });
  });
});

// Delete bus
const deleteBtns = document.querySelectorAll('.delete-btn');
deleteBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    if (confirm('Are you sure you want to delete this bus?')) {
      const id = btn.dataset.id;
      fetch('delete-bus.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          location.reload();
        } else {
          alert('❌ ' + data.message);
        }
      });
    }
  });
});
</script>

</body>
</html>
