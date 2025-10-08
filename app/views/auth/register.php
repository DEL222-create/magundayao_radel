<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - User Management System</title>
  <link rel="stylesheet" href="<?= base_url(); ?>public/auth.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <div class="auth-container">
    <h1><i class="fas fa-user-plus"></i> Register Account</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('auth/register'); ?>" class="auth-form">
      <div class="input-group">
        <i class="fas fa-user input-icon"></i>
        <input type="text" name="username" placeholder="Username" required>
      </div>
      
      <div class="input-group">
        <i class="fas fa-envelope input-icon"></i>
        <input type="email" name="email" placeholder="Enter Email" required>
      </div>
      
      <div class="input-group">
        <i class="fas fa-lock input-icon"></i>
        <input type="password" name="password" placeholder="Password" required>
      </div>
      
      <div class="input-group">
        <i class="fas fa-lock input-icon"></i>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      </div>

      <div class="input-group">
        <i class="fas fa-user-tag input-icon"></i>
        <select name="role" required>
          <option value="user" selected>👤 User</option>
          <option value="admin">👑 Admin</option>
        </select>
      </div>

      <button type="submit" class="btn-login">
        <i class="fas fa-user-plus"></i> Register
      </button>
    </form>

    <p class="register-text">
      Already have an account? 
      <a href="<?= site_url('auth/login'); ?>" class="register-link">
        <i class="fas fa-sign-in-alt"></i> Login here
      </a>
    </p>
  </div>
</body>
</html>