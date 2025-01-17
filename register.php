<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password

    // Check if email already exists
    $checkQuery = "SELECT * FROM Users WHERE email = :email";
    $stmt = $conn->prepare($checkQuery);
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        echo "Email already exists!";
    } else {
        // Insert user into database
        $sql = "INSERT INTO Users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        echo "Registration successful! <a href='login.php'>Login</a>";
    }
}
?>

<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>