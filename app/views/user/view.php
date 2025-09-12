<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #87CEEB, #1E90FF);
            font-family: Arial, sans-serif;
            min-height: 100vh;
        }
        .navbar {
            background-color: #0047AB;
        }
        .card {
            margin: 40px auto;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
            background: #f8f9fa;
        }
        .table thead {
            background-color: #0047AB;
            color: #fff;
        }
        .table tbody tr:hover {
            background-color: #dbeafe;
        }
        .btn-primary {
            background-color: #1E90FF;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0047AB;
        }
        h2 {
            color: #0047AB;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">💠USER LIST</a>
        </div>
    </nav>

    <!-- User List Card -->
    <div class="container">
        <div class="card">
            <h2 class="text-center mb-4">USER LIST</h2>
            <a href="<?=site_url('user/create');?>" class="btn btn-primary mb-3">+ Add New User</a>
            <table class="table table-bordered table-striped table-hover text-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach(html_escape($users) as $user): ?>
                        <tr>
                            <td><?=$user['id'];?></td>
                            <td><?=$user['username'];?></td>
                            <td><?=$user['email'];?></td>
                            <td>
                                <a href="<?=site_url('user/update/'. $user['id']);?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?=site_url('user/delete/'. $user['id']);?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
