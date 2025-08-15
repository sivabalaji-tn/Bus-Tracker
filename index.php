<!--This project is completely made by Siva Balaji SM and No one have Right to change the source!-->
<!--No one is allowed to make a an ownership of this project!-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bus Tracker Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="admin-styles/admin.css" rel="stylesheet">

  <style>
    .custom-toast {
      position: fixed;
      right: 20px;
      min-width: 280px;
      backdrop-filter: blur(10px);
      border-radius: 12px;
      color: #fff;
      padding: 12px 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      z-index: 1055;
      opacity: 0;
      transform: translateX(100%);
      transition: all 0.6s ease;
      font-size: 14px;
    }
    .custom-toast.show {
      opacity: 1;
      transform: translateX(0);
    }
    #guestToast {
      top: 20px;
      background: rgba(25, 135, 84, 0.9);
    }
    #driverToast {
      top: 90px;
      background: rgba(13, 110, 253, 0.9);
    }
    .custom-toast strong {
      color: #ffe066;
    }
    .custom-toast button {
      background: transparent;
      border: none;
      color: #fff;
      font-size: 18px;
      line-height: 1;
      padding: 0;
      cursor: pointer;
    }
  </style>
</head>
<body class="admin-login-bg">
<div id="guestToast" class="custom-toast">
  <div class="d-flex justify-content-between align-items-start">
    <div>
      <i class="bi bi-info-circle-fill me-1"></i>
      <strong>Guest Admin:</strong>
      <div>Login: visitorfors4@gmail.com<br>Pass: 1234</div>
    </div>
    <button onclick="hideToast('guestToast')">&times;</button>
  </div>
</div>

<div id="driverToast" class="custom-toast">
  <div class="d-flex justify-content-between align-items-start">
    <div>
      <i class="bi bi-truck-front-fill me-1"></i>
      <strong>Guest Driver:</strong>
      <div>Login: drivers4@gmail.com<br>Pass: 1234</div>
    </div>
    <button onclick="hideToast('driverToast')">&times;</button>
  </div>
</div>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
    <marquee>This Website is Under Maintanence by Siva Balaji S</marquee>
    <div class="text-center mb-4">
      <i class="bi bi-bus-front-fill text-success display-4"></i>
      <h3 class="text-success mt-2">Bus Tracker</h3>
      <p class="text-muted">Select your login type</p>
    </div>
    <div class="d-grid gap-3">
      <a href="track.php" class="btn btn-outline-success">
        <i class="bi bi-geo-alt-fill me-1"></i> Track Buses
      </a>
      <a href="admin/admin-login.php" class="btn btn-outline-success">
        <i class="bi bi-person-badge-fill me-1"></i> Admin Login
      </a>
      <a href="admin/driver-login.php" class="btn btn-outline-success">
        <i class="bi bi-truck-front-fill me-1"></i> Driver Login
      </a>
    </div>
  </div>
</div>

<footer class="bg-success text-white py-1">
  <div class="container text-center">
    <p class="mb-1">© 2025 Siva Balaji – IT Student | Pre-Final Year</p>
    <p class="small text-muted">All rights reserved.</p>
  </div>
</footer>

<script>
  function showToast(id, delay) {
    let toast = document.getElementById(id);
    setTimeout(() => {
      toast.classList.add('show');
      setTimeout(() => {
        hideToast(id);
      }, 10000);
    }, delay);
  }
  function hideToast(id) {
    let toast = document.getElementById(id);
    toast.classList.remove('show');
  }
  document.addEventListener('DOMContentLoaded', () => {
    showToast('guestToast', 200);
    showToast('driverToast', 800);
  });
</script>

</body>
</html>
