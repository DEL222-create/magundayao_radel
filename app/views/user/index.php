<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - User List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .pagination a, .pagination span {
            margin: 0 4px;
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            text-decoration: none;
            color: #3b82f6;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .pagination a:hover {
            background: #dbeafe;
            border-color: #3b82f6;
            transform: translateY(-1px);
        }
        .pagination strong {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border-color: #3b82f6;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            color: white;
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            color: white;
        }
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            color: white;
        }
        .btn-logout {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-logout:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
            color: white;
        }
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .search-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= site_url('auth/dashboard') ?>" class="text-xl font-bold text-blue-800">
                        <i class="fas fa-users mr-2"></i>User Management System
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= site_url('auth/dashboard') ?>" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                    </a>
                    <a href="<?= site_url('auth/logout') ?>" 
                       class="btn-logout" 
                       onclick="return confirm('Are you sure you want to log out?');">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="table-container">
            <!-- Header Section -->
            <div class="search-container">
                <h1 class="text-2xl font-bold mb-4">
                    <i class="fas fa-list mr-2"></i>User Management
                </h1>
                
                <!-- Search and Add User -->
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <form method="get" action="<?= site_url('user/index'); ?>" class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" 
                                   name="q" 
                                   value="<?= isset($q) ? htmlspecialchars($q) : '' ?>"
                                   placeholder="Search users by name or email..."
                                   class="w-full px-4 py-3 pl-10 pr-4 rounded-lg border-0 bg-white/90 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white/50" />
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    
                    <a href="<?= site_url('user/create'); ?>" class="btn-primary">
                        <i class="fas fa-user-plus"></i> Add New User
                    </a>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-1"></i>ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-user mr-1"></i>Username
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-envelope mr-1"></i>Email
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-1"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (!empty($all)): ?>
                            <?php foreach ($all as $user): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #<?= $user['id']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($user['username']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= htmlspecialchars($user['email']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="<?= site_url('user/edit/'.$user['id']); ?>" 
                                               class="btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= site_url('user/delete/'.$user['id']); ?>" 
                                               onclick="return confirm('Are you sure you want to delete this user?');" 
                                               class="btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                        <p class="text-gray-500 mb-4">Get started by adding your first user.</p>
                                        <a href="<?= site_url('user/create'); ?>" class="btn-primary">
                                            <i class="fas fa-user-plus"></i> Add First User
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (!empty($all)): ?>
                <div class="bg-gray-50 px-6 py-4 border-t">
                    <div class="flex justify-center">
                        <div class="pagination flex space-x-2">
                            <?= $page; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>