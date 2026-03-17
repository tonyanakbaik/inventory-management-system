<?php
include 'config.php';

$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $result = mysqli_query($conn, "SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY id DESC");
} else {
    $result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
}

$totalProductsQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$totalProducts = mysqli_fetch_assoc($totalProductsQuery)['total'];

$totalStockQuery = mysqli_query($conn, "SELECT SUM(stock) as total_stock FROM products");
$totalStock = mysqli_fetch_assoc($totalStockQuery)['total_stock'];
if (!$totalStock) {
    $totalStock = 0;
}

$totalValueQuery = mysqli_query($conn, "SELECT SUM(price * stock) as total_value FROM products");
$totalValue = mysqli_fetch_assoc($totalValueQuery)['total_value'];
if (!$totalValue) {
    $totalValue = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="topbar">
        <div class="brand">
            <h1>Inventory Management</h1>
            <p>Elegant dashboard for managing products, stock, and inventory value.</p>
        </div>
        <a href="add_product.php" class="btn">+ Add Product</a>
    </div>

    <div class="overview">
        <div class="stat-card products">
            <div class="stat-label">Total Products</div>
            <div class="stat-number"><?php echo $totalProducts; ?></div>
        </div>

        <div class="stat-card stock">
            <div class="stat-label">Total Stock</div>
            <div class="stat-number"><?php echo $totalStock; ?></div>
        </div>

        <div class="stat-card value">
            <div class="stat-label">Inventory Value</div>
            <div class="stat-number">Rp <?php echo number_format($totalValue, 0, ',', '.'); ?></div>
        </div>
    </div>

    <form method="GET" class="toolbar">
        <div class="search-box">
            <span>🔍</span>
            <input type="text" name="search" placeholder="Search product name..." value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <button type="submit" class="btn">Search</button>
    </form>

    <div class="table-card">
        <?php if (mysqli_num_rows($result) > 0) { ?>
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>

                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td class="product-name"><?php echo $row['name']; ?></td>
                    <td>
                        <span class="price-badge">
                            Rp <?php echo number_format($row['price'], 0, ',', '.'); ?>
                        </span>
                    </td>
                    <td>
                        <span class="stock-badge <?php echo ($row['stock'] <= 5) ? 'stock-low' : 'stock-high'; ?>">
                            <?php echo $row['stock']; ?> pcs
                        </span>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                            <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <?php } else { ?>
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3>No products found</h3>
                <p>Try adding a new product or search with a different keyword.</p>
            </div>
        <?php } ?>
    </div>

    <div class="footer-note">
        Built with PHP, MySQL, HTML, and CSS.
    </div>
</div>

</body>
</html>