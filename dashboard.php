<?php
session_start();
include_once('db.php');

// Fetch total products
$totalProducts = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();

// Fetch low stock alerts (e.g., stock less than 15)
$lowStockAlerts = $conn->query("SELECT COUNT(*) FROM products WHERE stock < 15")->fetchColumn();

// Fetch expiry alerts (nearly expired in the next 7 days)
$nearlyExpire = $conn->query("SELECT COUNT(*) FROM products WHERE expiry_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->fetchColumn();

// Fetch all products, grouped by category
$query = "SELECT * FROM products ORDER BY added_date DESC";
$products = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Add new product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $expiry_date = $_POST['expiry_date'];

    if ($stock > 0 && !empty($name) && !empty($category)) {
        $stmt = $conn->prepare("INSERT INTO products (name, category, stock, expiry_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $category, $stock, $expiry_date]);
        $_SESSION['message'] = "Product added successfully.";
    } else {
        $_SESSION['error'] = "Invalid input.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Remove product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['del'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['message'] = "Product removed successfully.";

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Update product stock
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $stock_change = $_POST['stock_change'];

    // Fetch current stock
    $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    $new_stock = $product['stock'] + $stock_change;

    // Prevent negative stock
    if ($new_stock >= 0) {
        $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $stmt->execute([$new_stock, $id]);
        $_SESSION['message'] = "Product stock updated successfully.";
    } else {
        $_SESSION['error'] = "Stock cannot be negative.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>McDonald's Inventory Management Dashboard</title>
    <style>
        
        body {
            font-family: times, sans-serif;
            background-image:url("images/dash.jpg");
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .header {
            background-color: #8B8000;
            color: #8B0000;
            padding: 20px;
            text-align: center;
            background: linear-gradient(#8B8000, yellow, #8B8000); 
        }
        .container {
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
          
        }
        .metrics {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .metric {
            background: #FFC300;
            padding: 20px;
            border-radius: 8px;
            flex: 1;
            margin: 0 10px;
            text-align: center;
            background: linear-gradient( #FFFFED, #ffc300); 
            
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #FFC300;
            color: #8B0000;
        }
        .button {
            background-color: #FFC300;
            color: red;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .error {
            color: red;
        }
    
        nav {
            display: flex;
            justify-content: center;
            overflow: auto;

            
        }
        nav a {
            color: #8B0000;
            padding: 20px 20px;
            text-decoration: none;
            text-align: center;
            font-size: 17px;
            border: 1px;
        }
        nav a:hover {
            background-color: #8B0000;
            color: white;
        
}

@media screen and (max-width: 500px) {
  .navbar a {
    float: none;
    display: block;
  }
}
        
    </style>
</head>

<body>

<div class="header">

    <h1>McDonald's Inventory Management Dashboard</h1>
    
    <nav>
    <a class="active" href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
<a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a>
</div>

<div class="sidebar-footer">

<div class="container">
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='success'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']);
    }

    if (isset($_SESSION['error'])) {
        echo "<div class='error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
    ?>

    <div class="metrics">
        <div class="metric">
            <h2>Total Products</h2>
            <p><?php echo $totalProducts; ?></p>
        </div>
        <div class="metric">
            <h2>Low Stock Alerts</h2>
            <p><?php echo $lowStockAlerts; ?></p>
        </div>
        <div class="metric">
            <h2>Expiry Alerts</h2>
            <p><?php echo $nearlyExpire; ?></p>
        </div>
    </div>

    <h2>Add New Product</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Product Name" required>
        <select name="category" required>
            <option value="">Select Category</option>
            <option value="Frozen">Frozen</option>
            <option value="Chiller">Chiller</option>
            <option value="Stock Room">Stock Room</option>
        </select>
        <input type="number" name="stock" placeholder="Stock Level" min="1" required>
        <input type="date" name="expiry_date" required>
        <button type="submit" name="add" class="button">Add Product</button>
    </form>

    <h2>Product List</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Stock Level</th>
                <th>Expiry Date</th>
                <th>Added Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['category']); ?></td>
                    <td><?php echo htmlspecialchars($product['stock']); ?></td>
                    <td><?php echo htmlspecialchars($product['expiry_date']); ?></td>
                    <td><?php echo htmlspecialchars($product['added_date']); ?></td>
                    <td>
                        <!-- Edit Stock Form -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <input type="number" name="stock_change" placeholder="Change Stock" required>
                            <button type="submit" name="edit" class="button">Edit</button>
                        </form>

                        <!-- Remove Product Form -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="del" class="button">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
