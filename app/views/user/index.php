<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
    <style>
        /* Custom pagination style */
        .pagination a, .pagination span {
            margin: 0 4px;
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-decoration: none;
            color: #1d4ed8;
            transition: background 0.2s;
        }
        .pagination a:hover {
            background: #bfdbfe;
        }
        .pagination strong {
            background: #1d4ed8;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
        }
    </style>
</head>
<body class="bg-blue-300">
    <div class="container mx-auto mt-10">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold text-center text-blue-800 mb-4">USER LIST</h1>

            <!-- Search form -->
            <form method="get" action="<?= site_url('user/index'); ?>" class="flex justify-center mb-4">
                <input type="text" name="q" value="<?= isset($q) ? htmlspecialchars($q) : '' ?>"
                       placeholder="Search user..."
                       class="border rounded-l px-4 py-2 w-1/3" />
                <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-r">🔍</button>
            </form>

            <!-- Add New User button -->
            <div class="flex justify-center mb-4">
                <a href="<?= site_url('user/create'); ?>"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                   + Add New User
                </a>
            </div>

            <!-- User table -->
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-200">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Username</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($all)): ?>
                        <?php foreach ($all as $user): ?>
                            <tr>
                                <td class="border px-4 py-2"><?= $user['id']; ?></td>
                                <td class="border px-4 py-2"><?= htmlspecialchars($user['username']); ?></td>
                                <td class="border px-4 py-2"><?= htmlspecialchars($user['email']); ?></td>
                                <td class="border px-4 py-2">
                                    <a href="<?= site_url('user/edit/'.$user['id']); ?>" class="text-blue-600 hover:underline">Edit</a> |
                                    <a href="<?= site_url('user/delete/'.$user['id']); ?>" onclick="return confirm('Are you sure?');" class="text-red-600 hover:underline">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
<div class="mt-6 flex justify-center">
    <div class="pagination flex space-x-2">
        <?= $page; ?>
    </div>
</div>
    <a href="<?= site_url('auth/logout'); ?>" 
     class="btn-logout" onclick="return confirm('Are you sure you want to log out?');">
     Logout</a>
    </a>

<style>
    .pagination a, .pagination strong {
        margin: 0 4px;
        padding: 6px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        text-decoration: none;
        color: #1d4ed8;
        transition: background 0.2s;
    }
    .pagination a:hover {
        background: #bfdbfe;
    }
    .pagination strong {
        background: #1d4ed8;
        color: white;
    }
</style>

</body>
</html>
