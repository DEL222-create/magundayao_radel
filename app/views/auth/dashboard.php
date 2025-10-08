<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - User Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stats-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-2px);
        }
        .btn-dashboard {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            color: white;
        }
        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <?php $session = lava_instance()->session; ?>
    
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-blue-800">
                        <i class="fas fa-users mr-2"></i>User Management System
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">
                        <i class="fas fa-user mr-1"></i>
                        Welcome, <strong><?= $session->userdata('username') ?></strong>
                    </span>
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">
                        <i class="fas fa-crown mr-1"></i><?= ucfirst($session->userdata('role')) ?>
                    </span>
                    <a href="<?= site_url('auth/logout') ?>" 
                       class="btn-logout" 
                       onclick="return confirm('Are you sure you want to log out?');">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="dashboard-card rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-bold mb-2">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </h2>
            <p class="text-lg opacity-90">
                Manage your users and system settings from this central location.
            </p>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="stats-card p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users text-3xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">User Management</h3>
                        <p class="text-gray-600">View and manage all users</p>
                        <a href="<?= site_url('user/index') ?>" class="btn-dashboard mt-3">
                            <i class="fas fa-list"></i> View Users
                        </a>
                    </div>
                </div>
            </div>

            <div class="stats-card p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-plus text-3xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Add New User</h3>
                        <p class="text-gray-600">Create a new user account</p>
                        <a href="<?= site_url('user/create') ?>" class="btn-dashboard mt-3">
                            <i class="fas fa-plus"></i> Add User
                        </a>
                    </div>
                </div>
            </div>

            <div class="stats-card p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-cog text-3xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">System Settings</h3>
                        <p class="text-gray-600">Configure system preferences</p>
                        <button class="btn-dashboard mt-3" onclick="alert('Settings feature coming soon!')">
                            <i class="fas fa-wrench"></i> Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity or Quick Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="stats-card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-chart-bar mr-2"></i>Quick Stats
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Users:</span>
                        <span class="font-semibold text-blue-600">Loading...</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Active Sessions:</span>
                        <span class="font-semibold text-green-600">1</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Your Role:</span>
                        <span class="font-semibold text-purple-600"><?= ucfirst($session->userdata('role')) ?></span>
                    </div>
                </div>
            </div>

            <div class="stats-card p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-clock mr-2"></i>Recent Activity
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-sign-in-alt text-green-500 mr-2"></i>
                        You logged in successfully
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-user text-blue-500 mr-2"></i>
                        Welcome to the dashboard
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>