<?php
include 'config.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    mysqli_query($conn, "UPDATE products SET name='$name', price='$price', stock='$stock' WHERE id=$id");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <h2>Edit Product</h2>
    <p class="form-subtitle">Update the selected product information below.</p>

    <form method="POST">
        <label>Product Name</label>
        <input type="text" name="name" value="<?php echo $data['name']; ?>" required>

        <label>Price</label>
        <input type="number" name="price" value="<?php echo $data['price']; ?>" required>

        <label>Stock</label>
        <input type="number" name="stock" value="<?php echo $data['stock']; ?>" required>

        <div class="form-actions">
            <button type="submit" name="update" class="btn">Update Product</button>
            <a href="index.php" class="back-btn">Back to Dashboard</a>
        </div>
    </form>

    <div class="footer-note">
        Make sure the data is correct before updating.
    </div>
</div>

</body>
</html>