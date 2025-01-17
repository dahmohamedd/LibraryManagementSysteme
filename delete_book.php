<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$book_id = $_GET['id'];

$sql = "DELETE FROM Books WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $book_id]);

echo "Book deleted successfully! <a href='fetch_books.php'>Back to Books</a>";
?>