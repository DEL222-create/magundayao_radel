<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update User</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-900 via-gray-900 to-black min-h-screen flex items-center justify-center font-sans">

  <div class="bg-white/10 backdrop-blur-md p-8 rounded-2xl shadow-lg border border-red-500/30 w-full max-w-md">
    <h2 class="text-3xl font-bold text-center text-red-400 mb-6">📝 Update User</h2>

    <form action="<?= site_url('user/update/' . $user['id']) ?>" method="POST" class="space-y-4">

      <!-- Username -->
      <div>
        <label class="block text-gray-200 mb-2 font-medium">Username</label>
        <input type="text" name="username" value="<?= html_escape($user['username']) ?>" required
               class="w-full px-4 py-3 border border-red-400/40 bg-gray-900/60 text-white rounded-md focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition duration-200 placeholder-gray-400">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-gray-200 mb-2 font-medium">Email Address</label>
        <input type="email" name="email" value="<?= html_escape($user['email']) ?>" required
               class="w-full px-4 py-3 border border-red-400/40 bg-gray-900/60 text-white rounded-md focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition duration-200 placeholder-gray-400">
      </div>

      <?php if(!empty($logged_in_user) && $logged_in_user['role'] === 'admin'): ?>
        <!-- Role Dropdown -->
        <div>
          <label class="block text-gray-200 mb-2 font-medium">Role</label>
          <select name="role" required
                  class="w-full px-4 py-3 border border-red-400/40 bg-gray-900/60 text-white rounded-md focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition duration-200">
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
          </select>
        </div>

        <!-- Password Field -->
        <div>
          <label class="block text-gray-200 mb-2 font-medium">Password</label>
          <input type="password" name="password" placeholder="Leave blank to keep current password"
                 class="w-full px-4 py-3 border border-red-400/40 bg-gray-900/60 text-white rounded-md focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition duration-200 placeholder-gray-400">
        </div>
      <?php endif; ?>

      <!-- Submit Button -->
      <div class="pt-2">
        <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-md shadow-md transition duration-200">
          🔄 Update User
        </button>
      </div>
    </form>

    <!-- Back Link -->
    <div class="mt-6 text-center">
      <a href="<?= site_url('/user'); ?>" class="text-red-400 hover:text-red-300 text-sm font-medium transition duration-200">
        ← Back to User Directory
      </a>
    </div>
  </div>

</body>
</html>
