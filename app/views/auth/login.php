<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome for eye icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center font-sans">

  <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 w-full max-w-md">
    <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">🔑 Login</h2>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
      <div class="bg-purple-50 border border-purple-400 text-purple-700 text-sm p-3 rounded mb-4 text-center">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('auth/login') ?>" class="space-y-4">
      <!-- Username -->
      <div>
        <label class="block text-gray-700 mb-2 font-medium">Username</label>
        <input type="text" name="username" placeholder="Enter your username" required
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
      </div>

      <!-- Password -->
      <div class="relative">
        <label class="block text-gray-700 mb-2 font-medium">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
        <i class="fa-solid fa-eye toggle-password absolute right-3 top-11 text-gray-500 cursor-pointer"></i>
      </div>

      <!-- Button -->
      <div class="pt-2">
        <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 rounded-md shadow-sm transition duration-200">
          Login
        </button>
      </div>
    </form>

    <!-- Register Link -->
    <div class="mt-6 text-center">
      <p class="text-sm text-gray-700">
        Don’t have an account?
        <a href="<?= site_url('auth/register'); ?>" class="text-purple-600 hover:text-purple-500 font-medium">
          Register here
        </a>
      </p>
    </div>
  </div>

  <script>
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);

      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>

</body>
</html>
