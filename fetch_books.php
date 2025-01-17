<?php
include 'db_connection.php';

$sql = "SELECT Books.id, Books.title, Categories.name AS category, Authors.name AS author, Books.is_available 
        FROM Books
        LEFT JOIN Categories ON Books.category_id = Categories.id
        LEFT JOIN Authors ON Books.author_id = Authors.id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Books List</h1>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Author</th>
            <th>Available</th>
        </tr>
        <?php foreach ($books as $book): ?>
        <tr>
             <td><?php echo $book['title']; ?></td>
             <td><?php echo $book['category']; ?></td>
             <td><?php echo $book['author']; ?></td>
             <td><?php echo $book['is_available'] ? 'Yes' : 'No'; ?></td>
             <td>
                  <a href="edit_book.php?id=<?php echo $book['id']; ?>">Edit</a> | 
                  <a href="delete_book.php?id=<?php echo $book['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
             </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>