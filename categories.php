<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sql = "INSERT INTO categories (name) VALUES (:name)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['name' => $name]);
    echo "Category added!";
}

$categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>
</head>
<body>
    <h2>Categories</h2>
    <form method="POST" action="categories.php">
        <label for="name">Add Category:</label>
        <input type="text" name="name" required>
        <button type="submit">Add</button>
    </form>

    <h3>Current Categories:</h3>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><?php echo htmlspecialchars($category['name']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
