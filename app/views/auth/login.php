<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="<?=base_url();?>public/auth.css">
</head>
<body>
  <div class="auth-box">
    <h2>Login Page</h2>

    <form method="post" action="<?= site_url('auth/login'); ?>">
      <input type="text" name="username" placeholder="Enter Username" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <button type="submit" class="btn-login">Login</button>
    </form>

    

    <p class="login-text">
      Don't have an account?
      <a href="<?= site_url('auth/register'); ?>" class="register-link">Register</a>
    </p>
  </div>
</body>
</html>