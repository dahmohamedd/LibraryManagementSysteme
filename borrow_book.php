<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$book_id = $_GET['id'];

// Check if the book is available
$checkQuery = "SELECT is_available FROM Books WHERE id = :id";
$stmt = $conn->prepare($checkQuery);
$stmt->execute(['id' => $book_id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if ($book['is_available']) {
    // Mark the book as borrowed
    $sql = "INSERT INTO Loans (user_id, book_id, loan_date) 
            VALUES (:user_id, :book_id, CURDATE())";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'book_id' => $book_id
    ]);

    // Update book availability
    $updateQuery = "UPDATE Books SET is_available = 0 WHERE id = :id";
    $stmt = $conn->prepare($updateQuery);
    $stmt->execute(['id' => $book_id]);

    echo "Book borrowed successfully! <a href='fetch_books.php'>Back to Books</a>";
} else {
    echo "Sorry, this book is currently unavailable. <a href='fetch_books.php'>Back to Books</a>";
}
?>