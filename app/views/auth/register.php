<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="<?= base_url(); ?>public/auth.css">
</head>
<body class="auth-body">

  <div class="auth-container">
    <h1> Register Account </h1>



    <form method="post" action="<?= site_url('auth/register'); ?>" class="auth-form">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Enter Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>

      <!-- Optional: Role dropdown -->
      <select name="role" required>
        <option value="user" selected>👤 User</option>
        <option value="admin">👑 Admin</option>
      </select>

      <button type="submit" class="btn-login">Register</button>
    </form>

    <p class="register-text">
      Already have an account? 
      <a href="<?= site_url('auth/login'); ?>" class="register-link">Login here</a>
    </p>
  </div>

</body>
</html>