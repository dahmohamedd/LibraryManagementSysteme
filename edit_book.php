<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$book_id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $author_id = $_POST['author_id'];

    $sql = "UPDATE Books 
            SET title = :title, category_id = :category_id, author_id = :author_id 
            WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'title' => $title,
        'category_id' => $category_id,
        'author_id' => $author_id,
        'id' => $book_id
    ]);

    echo "Book updated successfully! <a href='fetch_books.php'>View Books</a>";
} else {
    $book = $conn->query("SELECT * FROM Books WHERE id = $book_id")->fetch(PDO::FETCH_ASSOC);
}

?>

<form method="POST">
    <input type="text" name="title" value="<?php echo $book['title']; ?>" required>
    <select name="category_id" required>
        <?php
        $categories = $conn->query("SELECT * FROM Categories")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($categories as $category) {
            $selected = $book['category_id'] == $category['id'] ? 'selected' : '';
            echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
        }
        ?>
    </select>
    <select name="author_id" required>
        <?php
        $authors = $conn->query("SELECT * FROM Authors")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($authors as $author) {
            $selected = $book['author_id'] == $author['id'] ? 'selected' : '';
            echo "<option value='{$author['id']}' $selected>{$author['name']}</option>";
        }
        ?>
    </select>
    <button type="submit">Update Book</button>
</form>