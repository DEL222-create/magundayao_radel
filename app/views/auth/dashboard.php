<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: linear-gradient(to right, #87CEEB, #1E90FF); font-family: Arial, sans-serif; min-height: 100vh; }
    .navbar { background-color: #0047AB; }
    .container { margin-top: 50px; }
    .card { padding: 30px; border-radius: 15px; box-shadow: 0 6px 12px rgba(0,0,0,0.3); background: #f8f9fa; }
  </style>
</head>
<body>
  <nav class="navbar navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">📊 DASHBOARD</a>
      <a href="<?=site_url('auth/logout');?>" class="btn btn-danger">Logout</a>
    </div>
  </nav>

  <div class="container">
    <div class="card">
      <h2 class="text-center text-dark">Welcome, <?= $_SESSION['username'] ?? 'Guest' ?>!</h2>
      <p class="text-center">You are logged in as <strong><?= $_SESSION['role'] ?? 'user' ?></strong>.</p>

      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="text-center mt-4">
          <a href="<?=site_url('user');?>" class="btn btn-primary">👥 Manage Users</a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
