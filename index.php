<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Welcome to the Library Management System</h1>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Hello, <?php echo $_SESSION['user_name']; ?>!</p>
        <a href="fetch_books.php">View Books</a> | 
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="register.php">Register</a> | 
        <a href="login.php">Login</a>
    <?php endif; ?>
</body>
</html>