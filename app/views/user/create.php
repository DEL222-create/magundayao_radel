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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen flex items-center justify-center font-sans relative bg-gradient-to-br from-red-900 via-red-700 to-red-500">

  <!-- Overlay Pattern -->
  <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>

  <!-- Main Form Card -->
  <div class="relative z-10 w-full max-w-lg p-10 bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl text-white animate-fadeIn">
    
    <!-- Header -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-extrabold mb-2 drop-shadow-lg">👤 Create User</h1>
      <p class="text-red-100 text-sm md:text-base">Fill out the form below to add a new user to the system.</p>
    </div>

    <form id="user-form" action="<?=site_url('user/create/')?>" method="POST" class="space-y-6">

      <!-- Username -->
      <div>
        <label class="block text-red-200 mb-2 font-medium">Username</label>
        <input type="text" name="username" placeholder="Enter username" required
               value="<?= isset($username) ? html_escape($username) : '' ?>"
               class="w-full px-5 py-3 bg-white/20 text-white border border-white/30 rounded-xl placeholder-gray-300 focus:ring-2 focus:ring-white focus:border-white outline-none transition duration-300 hover:bg-white/25">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-red-200 mb-2 font-medium">Email Address</label>
        <input type="email" name="email" placeholder="Enter email address" required
               value="<?= isset($email) ? html_escape($email) : '' ?>"
               class="w-full px-5 py-3 bg-white/20 text-white border border-white/30 rounded-xl placeholder-gray-300 focus:ring-2 focus:ring-white focus:border-white outline-none transition duration-300 hover:bg-white/25">
      </div>

      <!-- Password -->
      <div>
        <label class="block text-red-200 mb-2 font-medium">Password</label>
        <div class="relative">
          <input type="password" name="password" id="password" placeholder="Enter password" required
                 class="w-full px-5 py-3 bg-white/20 text-white border border-white/30 rounded-xl placeholder-gray-300 focus:ring-2 focus:ring-white focus:border-white outline-none transition duration-300 hover:bg-white/25">
          <i class="fa-solid fa-eye absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer text-red-200 hover:text-white transition duration-200" id="togglePassword"></i>
        </div>
      </div>

      <!-- Role -->
      <?php if($logged_in_user['role'] === 'admin'): ?>
        <div>
          <label class="block text-red-200 mb-2 font-medium">Role</label>
          <select name="role" required
                  class="w-full px-5 py-3 bg-white/20 text-white border border-white/30 rounded-xl focus:ring-2 focus:ring-white focus:border-white outline-none transition duration-300 hover:bg-white/25">
            <option value="" disabled selected>Select Role</option>
            <option value="user" class="text-gray-800">User</option>
            <option value="admin" class="text-gray-800">Admin</option>
          </select>
        </div>
      <?php else: ?>
        <input type="hidden" name="role" value="user">
      <?php endif; ?>

      <!-- Submit Button -->
      <div>
        <button type="submit"
                class="w-full bg-white text-red-700 font-semibold py-3 rounded-xl shadow-lg hover:bg-red-100 hover:text-red-900 transition duration-300 transform hover:-translate-y-1">
          ➕ Create User
        </button>
      </div>
    </form>

    <!-- Back Link -->
    <div class="mt-8 text-center">
      <a href="<?=site_url('/user'); ?>" class="text-red-200 hover:text-white text-sm font-medium transition duration-300">
        ← Back to User Directory
      </a>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

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

  <style>
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px);}
      100% { opacity: 1; transform: translateY(0);}
    }
    .animate-fadeIn {
      animation: fadeIn 0.8s ease forwards;
    }
  </style>
</body>
</html>
