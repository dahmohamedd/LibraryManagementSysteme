<?php
$host = 'localhost';
$dbname = 'LibraryManagement';
$username = 'root'; // Default username
$password = ''; // Default password (leave empty)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>