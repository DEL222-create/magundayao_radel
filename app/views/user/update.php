<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - User Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px 12px 0 0;
        }
        .btn-primary {
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
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            color: white;
        }
        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
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
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(107, 114, 128, 0.3);
            color: white;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= site_url('user/index') ?>" class="text-xl font-bold text-blue-800">
                        <i class="fas fa-users mr-2"></i>User Management System
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= site_url('user/index') ?>" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-list mr-1"></i>Back to Users
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="form-container">
            <!-- Header Section -->
            <div class="form-header">
                <h1 class="text-2xl font-bold mb-2">
                    <i class="fas fa-user-edit mr-2"></i>Edit User
                </h1>
                <p class="text-lg opacity-90">
                    Update user information and settings.
                </p>
            </div>

            <!-- Form Section -->
            <div class="p-6">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                        <i class="fas fa-exclamation-circle mr-2"></i><?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                        <i class="fas fa-check-circle mr-2"></i><?= $_SESSION['success']; unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('user/edit/'. $user['id']); ?>" method="post" class="space-y-6">
                    <div>
                        <label for="username" class="form-label">
                            <i class="fas fa-user mr-2"></i>Username
                        </label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               value="<?= htmlspecialchars($user['username']); ?>" 
                               class="form-input" 
                               required>
                    </div>

                    <div>
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="<?= htmlspecialchars($user['email']); ?>" 
                               class="form-input" 
                               required>
                    </div>

                    <div>
                        <label for="password" class="form-label">
                            <i class="fas fa-lock mr-2"></i>New Password (Optional)
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-input" 
                               placeholder="Leave blank to keep current password">
                        <p class="text-sm text-gray-500 mt-1">Leave blank if you don't want to change the password</p>
                    </div>

                    <div class="flex justify-between items-center pt-4">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i> Update User
                        </button>
                        <a href="<?= site_url('user/index'); ?>" class="btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Users
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>