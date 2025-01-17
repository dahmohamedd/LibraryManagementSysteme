<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loan_id = $_POST['loan_id'];
    $return_date = date('Y-m-d');

    // Update loan status
    $sql = "UPDATE Loans SET return_date = :return_date, status = 'returned' WHERE id = :loan_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['return_date' => $return_date, 'loan_id' => $loan_id]);

    // Update book availability
    $updateBook = "UPDATE Books SET is_available = 1 
                   WHERE id = (SELECT book_id FROM Loans WHERE id = :loan_id)";
    $stmt = $conn->prepare($updateBook);
    $stmt->execute(['loan_id' => $loan_id]);

    echo "Book returned successfully! <a href='fetch_books.php'>Back to Books</a>";
}
?>

<form method="POST">
    <select name="loan_id" required>
        <option value="">Select a Loan to Return</option>
        <?php
        $user_id = $_SESSION['user_id'];
        $loans = $conn->query("SELECT Loans.id, Books.title 
                               FROM Loans 
                               JOIN Books ON Loans.book_id = Books.id 
                               WHERE Loans.user_id = $user_id AND Loans.status = 'borrowed'")
                      ->fetchAll(PDO::FETCH_ASSOC);
        foreach ($loans as $loan) {
            echo "<option value='{$loan['id']}'>{$loan['title']}</option>";
        }
        ?>
    </select>
    <button type="submit">Return Book</button>
</form>