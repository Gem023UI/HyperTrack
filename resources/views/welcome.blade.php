<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel eCommerce</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
        <h1 class="mb-4">Welcome to Laravel eCommerce 🛍️</h1>
        <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-primary ms-2">Sign Up</a>
    </div>
</body>
</html>
