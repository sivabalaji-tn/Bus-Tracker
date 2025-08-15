<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] !== 'Bus Driver') {
  header("Location: ../driver-login.php");
  exit;
}

$driver_id = $_SESSION['admin_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
  header('Content-Type: application/json');
  $status = $_POST['status'];

  if (!in_array($status, ['active', 'inactive'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit;
  }

  $stmt = $conn->prepare("UPDATE buses SET status = ? WHERE driver_id = ?");
  $stmt->bind_param("si", $status, $driver_id);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
  }
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lat'], $_POST['lng'])) {
  header('Content-Type: application/json');
  $lat = $_POST['lat'];
  $lng = $_POST['lng'];

  $stmt = $conn->prepare("UPDATE buses SET lat = ?, lng = ? WHERE driver_id = ?");
  $stmt->bind_param("ddi", $lat, $lng, $driver_id);

  if ($stmt->execute()) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
  }
  exit;
}

// Get assigned bus
$stmt = $conn->prepare("SELECT id, bus_number, bus_name, status FROM buses WHERE driver_id = ?");
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$bus = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Driver Dashboard - Bus Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success px-3">
  <span class="navbar-brand"><i class="bi bi-truck-front-fill me-2"></i>Driver Dashboard</span>
  <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
</nav>

<div class="container py-5">
  <h3 class="mb-4">👋 Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?></h3>

  <?php if ($bus): ?>
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h5><i class="bi bi-bus-front-fill me-2"></i>Bus: <?= htmlspecialchars($bus['bus_number']) ?> (<?= htmlspecialchars($bus['bus_name']) ?>)</h5>
        <p>Status: 
          <span id="bus-status" class="badge bg-<?= $bus['status'] === 'active' ? 'success' : 'secondary' ?>">
            <?= ucfirst($bus['status']) ?>
          </span>
        </p>
        <p id="liveClock" class="text-muted mb-3"></p>
        <div class="mt-3">
          <button class="btn btn-success me-2" onclick="startTrip()">
            <i class="bi bi-play-fill"></i> Start Trip
          </button>
          <button class="btn btn-danger" onclick="stopTrip()">
            <i class="bi bi-stop-fill"></i> Stop Trip
          </button>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-warning mt-4">You are not assigned to any bus yet.</div>
  <?php endif; ?>
</div>

<div id="camera-container" class="mt-3" style="display: none;">
  <video id="driver-video" width="320" height="240" autoplay muted></video>
</div>


<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center border-0">
      <div class="modal-body p-5">
        <div class="spinner-border text-success mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
        <h5 id="loadingText">Loading...</h5>
      </div>
    </div>
  </div>
</div>

<script>
function showLoading(messages, callback) {
  const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
  const text = document.getElementById('loadingText');
  let i = 0;

  text.textContent = messages[i];
  modal.show();

  const interval = setInterval(() => {
    i++;
    if (i < messages.length) {
      text.textContent = messages[i];
    } else {
      clearInterval(interval);
      setTimeout(() => {
        modal.hide();
        callback();
      }, 600);
    }
  }, 1000);
}

function updateStatus(status) {
  fetch('driver-dashboard.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'status=' + status
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      const badge = document.getElementById('bus-status');
      badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
      badge.className = 'badge bg-' + (status === 'active' ? 'success' : 'secondary');
    } else {
      alert('❌ ' + data.message);
    }
  });
}
function sendLocation(lat, lon) {
  fetch('update-location.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `lat=${lat}&lon=${lon}`
  });
}

function startTracking() {
  if (navigator.geolocation) {
    setInterval(() => {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const lat = position.coords.latitude;
          const lon = position.coords.longitude;
          sendLocation(lat, lon);
        },
        (err) => console.warn('GPS error:', err),
        { enableHighAccuracy: true }
      );
    }, 10000);
  } else {
    alert("Geolocation not supported by this browser.");
  }
}
startTracking();

function startTrip() {
  document.getElementById('startSound').play();
  showLoading(['Warming up engine...', 'Fetching database...', 'Starting trip...'], () => {
    updateStatus('active');
  });
}

function stopTrip() {
  document.getElementById('stopSound').play();
  showLoading(['Shutting down systems...', 'Saving trip data...', 'Stopping bus...'], () => {
    updateStatus('inactive');
  });
}

/// driver face camera
function startTrip() {
  document.getElementById('startSound').play();
  showLoading(['Warming up engine...', 'Fetching database...', 'Starting trip...'], () => {
    updateStatus('active');
  });
}

function openCamera() {
  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true, audio: false })
      .then(stream => {
        document.getElementById('camera-container').style.display = 'block';
        const video = document.getElementById('driver-video');
        video.srcObject = stream;
        streamRef = stream;

        // Every 5 sec capture frame and send to server
        captureInterval = setInterval(captureFrame, 5000);
      })
      .catch(err => alert('Camera access denied: ' + err));
  } else alert('getUserMedia not supported.');
}

function captureFrame() {
  if (!streamRef) return;
  const canvas = document.createElement('canvas');
  canvas.width = 320; canvas.height = 240;
  const ctx = canvas.getContext('2d');
  ctx.drawImage(document.getElementById('driver-video'), 0, 0, 320, 240);
  const imageData = canvas.toDataURL('image/jpeg');

  const formData = new FormData();
formData.append('bus_id', busId);
formData.append('frame', imageData);

fetch('bus-surveillance.php', {
  method: 'POST',
  body: formData
});


}

function stopTrip() {
  document.getElementById('stopSound').play();
  showLoading(['Shutting down systems...', 'Saving trip data...', 'Stopping bus...'], () => {
    updateStatus('inactive');
    if (streamRef) {
      streamRef.getTracks().forEach(t => t.stop());
      clearInterval(captureInterval);
    }
  });
}


setInterval(() => {
  const now = new Date();
  document.getElementById('liveClock').textContent = '🕒 ' + now.toLocaleTimeString();
}, 1000);

// GPS update every 10 seconds
setInterval(() => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(pos => {
      fetch('driver-dashboard.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `lat=${pos.coords.latitude}&lng=${pos.coords.longitude}`
      });
    });
  }
}, 10000);
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<audio id="startSound" src="https://assets.mixkit.co/sfx/preview/mixkit-fast-small-sweep-transition-166.wav"></audio>
<audio id="stopSound" src="https://assets.mixkit.co/sfx/preview/mixkit-retro-game-notification-212.wav"></audio>
</body>
</html>
