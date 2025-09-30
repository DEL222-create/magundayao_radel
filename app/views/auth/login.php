<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #87CEEB, #1E90FF);
      font-family: Arial, sans-serif;
      min-height: 100vh;
    }
    .navbar { background-color: #0047AB; }
    .card {
      margin: 60px auto;
      max-width: 400px;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.3);
      background: #f8f9fa;
    }
    .btn-primary { background-color: #1E90FF; border: none; }
    .btn-primary:hover { background-color: #0047AB; }
  </style>
</head>
<body>
  <nav class="navbar navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">🔑 LOGIN</a>
    </div>
  </nav>

  <div class="card">
    <h2 class="text-center text-dark mb-4">USER LOGIN</h2>
    <form action="<?=site_url('auth/login');?>" method="post">
      <div class="mb-3">
        <label for="username" class="form-label">👤 Username</label>
        <input type="text" id="username" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">🔒 Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">✅ Login</button>
    </form>
    <p class="mt-3 text-center">No account yet? <a href="<?=site_url('auth/register');?>">Register</a></p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
