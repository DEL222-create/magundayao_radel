<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Directory</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .animated-bg {
      background: linear-gradient(-45deg, #7f1d1d, #b91c1c, #dc2626, #ef4444);
      background-size: 300% 300%;
      animation: gradientShift 10s ease infinite;
    }

    @keyframes fadeSlideIn {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    tbody tr { animation: fadeSlideIn 0.5s ease forwards; }

    .pagination { display: flex; gap: 0.5rem; flex-wrap: wrap; justify-content: center; margin-top: 1.5rem; }
    .pagination a { display: inline-block; padding: 0.5rem 1rem; background-color: #dc2626; color: white; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: transform 0.2s, background-color 0.2s; }
    .pagination a:hover { background-color: #b91c1c; transform: scale(1.1); }
    .pagination strong { display: inline-block; padding: 0.5rem 1rem; background-color: #7f1d1d; color: white; border-radius: 0.5rem; font-weight: 600; }
  </style>
</head>

<body class="min-h-screen animated-bg font-sans text-gray-800">

  <!-- Navbar -->
  <nav class="bg-red-800/80 backdrop-blur shadow-lg transition-all duration-500 hover:shadow-xl">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <a href="#" class="text-white font-bold text-xl tracking-wide flex items-center gap-2 hover:scale-105 transition-transform">
        <i class="fa-solid fa-users"></i> User Management
      </a>
      <a href="<?= site_url('auth/logout'); ?>"
         class="bg-white text-red-700 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-100 hover:scale-105 active:scale-95 transition-all duration-200">
         Logout
      </a>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="max-w-6xl mx-auto mt-10 px-4">
    <div class="bg-white/95 shadow-2xl border border-gray-200 rounded-xl p-8 backdrop-blur-sm transition-all duration-500 hover:shadow-red-300">

      <!-- Logged In User Display -->
      <?php if(!empty($logged_in_user)): ?>
        <div class="mb-8 bg-red-50 text-red-800 px-6 py-5 rounded-md text-center border border-red-200 animate-pulse">
          <h2 class="text-2xl font-bold mb-1">
            Welcome, <span class="font-semibold"><?= html_escape($logged_in_user['username']); ?></span>!
          </h2>
          <p class="text-lg">Role: <span class="font-semibold"><?= html_escape($logged_in_user['role']); ?></span></p>
        </div>
      <?php endif; ?>

      <!-- Header & Search -->
      <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
        <h1 class="text-2xl font-semibold text-red-700 flex items-center gap-2">
          <i class="fa-solid fa-address-book"></i> User Directory
        </h1>

        <form method="get" action="<?= site_url('user'); ?>" class="flex w-full sm:w-auto">
          <input 
            type="text" 
            name="q" 
            value="<?= html_escape($_GET['q'] ?? '') ?>" 
            placeholder="Search user..." 
            class="w-full border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-800 transition">
          <button type="submit" class="bg-red-600 hover:bg-red-700 active:scale-95 text-white px-4 rounded-r-md transition-all duration-200">
            🔍
          </button>
        </form>
      </div>

      <!-- User Table -->
      <div class="overflow-x-auto rounded-md border border-gray-200 shadow-inner">
        <table class="w-full text-center border-collapse">
          <thead>
            <tr class="bg-red-700 text-white">
              <th class="py-3 px-4">ID</th>
              <th class="py-3 px-4">Username</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">Role</th>
              <th class="py-3 px-4">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php foreach(html_escape($users) as $user): ?>
              <tr class="hover:bg-red-50 hover:scale-[1.02] transition-all duration-300">
                <td class="py-3 px-4"><?= $user['id']; ?></td>
                <td class="py-3 px-4 font-medium text-gray-900"><?= $user['username']; ?></td>
                <td class="py-3 px-4">
                  <span class="bg-red-100 text-red-700 text-sm font-medium px-3 py-1 rounded-full">
                    <?= $user['email']; ?>
                  </span>
                </td>
                <td class="py-3 px-4 font-medium text-gray-800"><?= $user['role']; ?></td>
                <td class="py-3 px-4 space-x-3">
                  <?php if($logged_in_user['role'] === 'admin' || $logged_in_user['id'] == $user['id']): ?>
                    <a href="<?= site_url('user/update/'.$user['id']); ?>"
                       class="px-4 py-2 text-sm font-medium rounded-md bg-red-500 text-white hover:bg-red-600 active:scale-95 transition-all duration-200 shadow-sm">
                      Update
                    </a>
                  <?php endif; ?>
                  <?php if($logged_in_user['role'] === 'admin'): ?>
                    <a href="<?= site_url('user/delete/'.$user['id']); ?>"
                       onclick="return confirm('Are you sure you want to delete this record?');"
                       class="px-4 py-2 text-sm font-medium rounded-md bg-red-700 text-white hover:bg-red-800 active:scale-95 transition-all duration-200 shadow-sm">
                      Delete
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <?php if(!empty($page)): ?>
      <div class="mt-6 flex justify-center">
        <div class="pagination">
          <?php foreach($page as $link): ?>
            <?php if($link['active']): ?>
              <strong><?= $link['label']; ?></strong>
            <?php else: ?>
              <a href="<?= $link['url']; ?>"><?= $link['label']; ?></a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- Create New User -->
      <div class="mt-8 text-center">
        <a href="<?= site_url('user/create') ?>"
           class="inline-block bg-red-600 hover:bg-red-700 active:scale-95 text-white font-medium px-6 py-3 rounded-md shadow-md transition-all duration-200">
           Create New User
        </a>
      </div>

    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
