<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bus Tracker - Maintenance</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #f5f5f5;
      font-family: 'Segoe UI', sans-serif;
      overflow: hidden;
    }

    .center-box {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

  </style>
</head>
<body>

<div class="center-box">
  <i class="bi bi-wrench-adjustable-circle display-1 text-success mb-3"></i>
  <h2 class="text-success mb-2">Bus Tracker</h2>
  <p class="text-muted">Live bus tracking interface is temporarily unavailable.</p>
   </div>


<!-- Maintenance Modal (auto show) -->
<div class="modal fade" id="maintenanceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title"><i class="bi bi-tools me-2"></i> Maintenance Notice</h5>
      </div>
      <div class="modal-body">
        <p>🚧 We are currently upgrading our live tracking system to serve you better.</p>
        <p class="mb-0">Please check back soon. Thank you for your patience!</p><br>
        <p> Site Under Maintained by Siva Balaji S due to Errors from driver side panel we stopped serving this page</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-bs-dismiss="modal">
          <i class="bi bi-check-circle"></i> OK
        </button>
      </div>
    </div>
  </div>
</div>

<!-- RGB Marquee    q!I95mEDhkd7@lnp   -->
<div class="rgb-marquee">
  🚧 This website is under maintenance. Please check back shortly. 🚧
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Auto show popup after page loads
  const modal = new bootstrap.Modal(document.getElementById('maintenanceModal'));
  window.addEventListener('DOMContentLoaded', () => {
    modal.show();
  });
</script>

</body>
</html>
