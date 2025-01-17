<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// List all overdue loans
$sql = "SELECT Loans.id, Users.name AS user_name, Books.title, Loans.loan_date 
        FROM Loans
        JOIN Users ON Loans.user_id = Users.id
        JOIN Books ON Loans.book_id = Books.id
        WHERE Loans.status = 'borrowed' AND DATEDIFF(CURDATE(), Loans.loan_date) > 14";

$loans = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overdue Loans</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Overdue Loans</h1>
    <table border="1">
        <tr>
            <th>User</th>
            <th>Book</th>
            <th>Loan Date</th>
            <th>Days Overdue</th>
        </tr>
        <?php foreach ($loans as $loan): ?>
        <tr>
            <td><?php echo $loan['user_name']; ?></td>
            <td><?php echo $loan['title']; ?></td>
            <td><?php echo $loan['loan_date']; ?></td>
            <td><?php echo (date('Y-m-d') - $loan['loan_date']) - 14; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>