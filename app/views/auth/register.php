<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome for eye icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center font-sans">

  <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 w-full max-w-md">
    <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">📝 Register</h2>

    <form method="POST" action="<?= site_url('auth/register'); ?>" class="space-y-4">
      <!-- Username -->
      <div>
        <label class="block text-gray-700 mb-2 font-medium">Username</label>
        <input type="text" name="username" placeholder="Enter your username" required
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-gray-700 mb-2 font-medium">Email</label>
        <input type="email" name="email" placeholder="Enter your email" required
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
      </div>

      <!-- Password -->
      <div class="relative">
        <label class="block text-gray-700 mb-2 font-medium">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
        <i class="fa-solid fa-eye absolute right-3 top-11 text-gray-500 cursor-pointer" id="togglePassword"></i>
      </div>

      <!-- Confirm Password -->
      <div class="relative">
        <label class="block text-gray-700 mb-2 font-medium">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Re-enter your password" required
               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:outline-none transition duration-200">
        <i class="fa-solid fa-eye absolute right-3 top-11 text-gray-500 cursor-pointer" id="toggleConfirmPassword"></i>
      </div>

      <!-- Button -->
      <div class="pt-2">
        <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 rounded-md shadow-sm transition duration-200">
          Register
        </button>
      </div>
    </form>

    <!-- Login Link -->
    <div class="mt-6 text-center">
      <p class="text-sm text-gray-700">
        Already have an account?
        <a href="<?= site_url('auth/login'); ?>" class="text-purple-600 hover:text-purple-500 font-medium">
          Login here
        </a>
      </p>
    </div>
  </div>

  <script>
    function toggleVisibility(toggleId, inputId) {
      const toggle = document.getElementById(toggleId);
      const input = document.getElementById(inputId);

      toggle.addEventListener('click', function () {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    }

    toggleVisibility('togglePassword', 'password');
    toggleVisibility('toggleConfirmPassword', 'confirmPassword');
  </script>

</body>
</html>
