<?php
include 'db.php';

// Add product
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    mysqli_query($conn, "INSERT INTO products(name,price) VALUES('$name','$price')");
}

// Delete product
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
}
$result = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Products</h2>

    <form method="POST">
        <input type="text" name="name" placeholder="Enter Product Name" required>
        <input type="number" step="0.01" name="price" placeholder="Enter Price" required>
        <button type="submit" name="add">Add Product</button>
    </form>

    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Price</th><th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['price'] ?></td>
            <td>
                <a href="products.php?delete=<?= $row['id'] ?>" class="btn">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="index.php" class="btn">⬅ Back</a>
</div>
</body>
</html>
