<?php
// Ensure $logged_in_user is defined to avoid undefined variable error
if (!isset($logged_in_user)) {
    $logged_in_user = ['role' => 'user']; // default to normal user if not set
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create User</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center font-sans text-gray-800">

  <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 w-full max-w-md">
    <h1 class="text-2xl font-semibold text-center text-gray-900 mb-6">📝 Create User</h1>

    <form id="user-form" action="<?=site_url('users/create/')?>" method="POST" class="space-y-4">

      <!-- Username -->
      <div>
        <label class="block text-gray-700 mb-2 font-medium">Username</label>
        <input type="text" name="username" placeholder="Username" required
               value="<?= isset($username) ? html_escape($username) : '' ?>"
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-gray-700 mb-2 font-medium">Email Address</label>
        <input type="email" name="email" placeholder="Email" required
               value="<?= isset($email) ? html_escape($email) : '' ?>"
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
      </div>

      <!-- Password with toggle -->
      <div>
        <label class="block text-gray-700 mb-2 font-medium">Password</label>
        <div class="relative">
          <input type="password" name="password" id="password" placeholder="Password" required
                 class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
          <i class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-purple-600" id="togglePassword"></i>
        </div>
      </div>

      <!-- Role -->
      <?php if($logged_in_user['role'] === 'admin'): ?>
        <div>
          <label class="block text-gray-700 mb-2 font-medium">Role</label>
          <select name="role" required
                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
            <option value="" disabled selected>Select Role</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
        </div>
      <?php else: ?>
        <input type="hidden" name="role" value="user">
      <?php endif; ?>

      <!-- Submit -->
      <div class="pt-2">
        <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 rounded-md shadow-sm transition duration-200">
          Create User
        </button>
      </div>
    </form>

    <!-- Return Button -->
    <div class="mt-6 text-center">
      <a href="<?=site_url('/users'); ?>" class="text-purple-600 hover:text-purple-500 text-sm font-medium">
        ← Back to User Directory
      </a>
    </div>
  </div>

  <!-- FontAwesome for password icon -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

  <!-- Password Toggle -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const togglePassword = document.getElementById('togglePassword');
      const password = document.getElementById('password');

      if (togglePassword && password) {
        togglePassword.addEventListener('click', function () {
          const type = password.type === 'password' ? 'text' : 'password';
          password.type = type;
          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
        });
      }
    });
  </script>

</body>
</html>
