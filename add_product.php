<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    mysqli_query($conn, "INSERT INTO products(name, price, stock) VALUES('$name', '$price', '$stock')");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <h2>Add New Product</h2>
    <p class="form-subtitle">Create a new inventory item with product name, price, and stock quantity.</p>

    <form method="POST">
        <label>Product Name</label>
        <input type="text" name="name" placeholder="Example: Mechanical Keyboard" required>

        <label>Price</label>
        <input type="number" name="price" placeholder="Example: 250000" required>

        <label>Stock</label>
        <input type="number" name="stock" placeholder="Example: 12" required>

        <div class="form-actions">
            <button type="submit" name="submit" class="btn">Save Product</button>
            <a href="index.php" class="back-btn">Back to Dashboard</a>
        </div>
    </form>

    <div class="footer-note">
        Fill all fields correctly before saving.
    </div>
</div>

</body>
</html>