<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Directory</title>
  <link rel="stylesheet" href="<?=base_url();?>/public/style.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .pagination {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 1.5rem;
    }
    .pagination a {
      display: inline-block;
      padding: 0.5rem 1rem;
      background-color: #7e22ce;
      color: white;
      border-radius: 0.5rem;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      text-decoration: none;
      font-weight: 500;
      transition: background-color 0.2s ease-in-out;
    }
    .pagination a:hover {
      background-color: #6b21a8;
    }
    .pagination strong {
      display: inline-block;
      padding: 0.5rem 1rem;
      background-color: #581c87;
      color: white;
      border-radius: 0.5rem;
      font-weight: 600;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
  </style>
</head>

<body class="bg-gray-900 min-h-screen font-sans text-gray-800">

  <!-- Navbar -->
  <nav class="bg-purple-700 shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <a href="#" class="text-white font-semibold text-xl tracking-wide">📊 User Management</a>
      <a href="<?=site_url('auth/logout');?>" 
         class="bg-white text-purple-700 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-100 transition">
         Logout
      </a>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="max-w-6xl mx-auto mt-10 px-4">
    <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-8">

      <!-- Logged In User Display -->
      <?php if(!empty($logged_in_user)): ?>
        <div class="mb-8 bg-purple-50 text-purple-800 px-6 py-5 rounded-md text-center border border-purple-200">
          <h2 class="text-2xl font-bold mb-1">
            Welcome, <span class="font-semibold"><?= html_escape($logged_in_user['username']); ?></span>!
          </h2>
          <p class="text-lg">Role: <span class="font-semibold"><?= html_escape($logged_in_user['role']); ?></span></p>
        </div>
      <?php else: ?>
        <div class="mb-6 bg-red-100 text-red-700 px-4 py-3 rounded-md text-center">
          Logged in user not found
        </div>
      <?php endif; ?>

      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-purple-700">👥 User Directory</h1>

        <!-- Search Bar -->
        <form method="get" action="<?=site_url('user');?>" class="flex">
          <input 
            type="text" 
            name="q" 
            value="<?=html_escape($_GET['q'] ?? '')?>" 
            placeholder="Search user..." 
            class="w-full border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-gray-800">
          <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 rounded-r-md transition">
            🔍
          </button>
        </form>
      </div>
      
      <!-- Table -->
      <div class="overflow-x-auto rounded-md border border-gray-200">
        <table class="w-full text-center border-collapse">
          <thead>
            <tr class="bg-purple-700 text-white">
              <th class="py-3 px-4">ID</th>
              <th class="py-3 px-4">Username</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">Role</th>
              <th class="py-3 px-4">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <?php foreach(html_escape($users) as $user): ?>
              <tr class="hover:bg-gray-50 transition duration-200">
                <td class="py-3 px-4"><?=($user['id']);?></td>
                <td class="py-3 px-4"><?=($user['username']);?></td>
                <td class="py-3 px-4">
                  <span class="bg-purple-100 text-purple-700 text-sm font-medium px-3 py-1 rounded-full">
                    <?=($user['email']);?>
                  </span>
                </td>
                <td class="py-3 px-4 font-medium"><?=($user['role']);?></td>
                <td class="py-3 px-4 space-x-3">
                  <?php if($logged_in_user['role'] === 'admin' || $logged_in_user['id'] == $user['id']): ?>
                    <a href="<?=site_url('users/update/'.$user['id']);?>"
                       class="px-4 py-2 text-sm font-medium rounded-md bg-purple-500 text-white hover:bg-purple-600 transition duration-200 shadow-sm">
                      ✏️ Update
                    </a>
                  <?php endif; ?>

                  <?php if($logged_in_user['role'] === 'admin'): ?>
                    <a href="<?=site_url('user/delete/'.$user['id']);?>"
                       onclick="return confirm('Are you sure you want to delete this record?');"
                       class="px-4 py-2 text-sm font-medium rounded-md bg-purple-700 text-white hover:bg-purple-800 transition duration-200 shadow-sm">
                      🗑️ Delete
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="mt-6 flex justify-center">
        <div class="pagination">
          <?= $page; ?>
        </div>
      </div>

      <!-- Create New User -->
      <div class="mt-6 text-center">
        <a href="<?=site_url('user/create')?>"
           class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-medium px-6 py-3 rounded-md shadow-sm transition duration-200">
          ➕ Create New User
        </a>
      </div>
    </div>
  </div>

</body>
</html>
