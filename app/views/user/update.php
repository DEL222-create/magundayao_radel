<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User/Update</title>
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
            margin: 60px auto;
            max-width: 500px;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
            background: #f8f9fa;
        }
        .btn-primary {
            background-color: #1E90FF;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0047AB;
        }
        label {
            font-weight: bold;
            color: #0047AB;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">💠 Blue User System</a>
        </div>
    </nav>

    <!-- Update Form -->
    <div class="card">
        <h2 class="text-center text-dark mb-4">✏️ Update User</h2>
        <form action="<?=site_url('user/update/'. $user['id']);?>" method="post">
            <div class="mb-3">
                <label for="username">👤 Username</label>
                <input type="text" id="username" name="username" value="<?=html_escape($user['username']);?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email">📧 Email</label>
                <input type="email" id="email" name="email" value="<?=html_escape($user['email']);?>" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">💾 Update User</button>
                <a href="/" class="btn btn-secondary">↩ Back</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
