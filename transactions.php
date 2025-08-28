<?php
include 'db.php';

// Add transaction
if(isset($_POST['add'])){
    $buyer_id = $_POST['buyer_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Optionally calculate total_amount automatically
    $product_query = mysqli_query($conn, "SELECT price FROM products WHERE id='$product_id'");
    $product = mysqli_fetch_assoc($product_query);
    $total_amount = $product['price'] * $quantity;

    mysqli_query($conn, "INSERT INTO transactions (buyer_id, product_id, quantity, total_amount) VALUES ('$buyer_id', '$product_id', '$quantity', '$total_amount')");
}

// Delete transaction
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM transactions WHERE transaction_id=$id");
}

// Fetch buyers and products for dropdowns
$buyers = mysqli_query($conn, "SELECT * FROM buyers");
$products = mysqli_query($conn, "SELECT * FROM products");

// Fetch transaction data
$result = mysqli_query($conn, "
    SELECT 
        t.transaction_id, 
        b.name AS buyer, 
        p.name AS product, 
        p.price, 
        t.quantity, 
        t.total_amount, 
        t.transaction_date,
        t.payment_method,
        t.status
    FROM transactions t
    JOIN buyers b ON t.buyer_id = b.id
    JOIN products p ON t.product_id = p.id
    ORDER BY t.transaction_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transactions</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Transactions</h2>

    <!-- Add Transaction Form -->
    <form method="POST">
        <select name="buyer_id" required>
            <option value="">Select Buyer</option>
            <?php while($b = mysqli_fetch_assoc($buyers)){ ?>
                <option value="<?= $b['id'] ?>"><?= $b['name'] ?></option>
            <?php } ?>
        </select>

        <select name="product_id" required>
            <option value="">Select Product</option>
            <?php while($p = mysqli_fetch_assoc($products)){ ?>
                <option value="<?= $p['id'] ?>"><?= $p['name'] ?> (₹<?= $p['price'] ?>)</option>
            <?php } ?>
        </select>

        <input type="number" name="quantity" placeholder="Quantity" required>
        <button type="submit" name="add">Add Transaction</button>
    </form>

    <!-- Transaction Table -->
    <table>
        <tr>
            <th>ID</th><th>Buyer</th><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Date</th><th>Payment</th><th>Status</th><th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['transaction_id'] ?></td>
            <td><?= $row['buyer'] ?></td>
            <td><?= $row['product'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['total_amount'] ?></td>
            <td><?= $row['transaction_date'] ?></td>
            <td><?= $row['payment_method'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a href="transactions.php?delete=<?= $row['transaction_id'] ?>" class="btn">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="index.php" class="btn">⬅ Back</a>
</div>
</body>
</html>
