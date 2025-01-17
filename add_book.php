<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in (optional)
if (!isset($_SESSION['user_id'])) {
    echo "Please <a href='login.php'>log in</a> to access this page.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $author_id = $_POST['author_id'];
    $is_available = true; // New books are available by default

    $sql = "INSERT INTO Books (title, category_id, author_id, is_available) VALUES (:title, :category_id, :author_id, :is_available)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'title' => $title,
        'category_id' => $category_id,
        'author_id' => $author_id,
        'is_available' => $is_available,
    ]);

    echo "Book added successfully! <a href='fetch_books.php'>View Books</a>";
}

// Fetch categories and authors for the dropdowns
$categories = $conn->query("SELECT * FROM Categories")->fetchAll(PDO::FETCH_ASSOC);
$authors = $conn->query("SELECT * FROM Authors")->fetchAll(PDO::FETCH_ASSOC);
?>

<form method="POST">
    <input type="text" name="title" placeholder="Book Title" required>
    <select name="category_id" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <select name="author_id" required>
        <option value="">Select Author</option>
        <?php foreach ($authors as $author): ?>
            <option value="<?php echo $author['id']; ?>"><?php echo $author['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Add Book</button>
</form>