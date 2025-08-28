<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head><title>Buyer Detail</title></head>
<body>

<?php
$id = $_GET['id'];
$sql = "SELECT * FROM buyers WHERE id=$id";
$result = $conn->query($sql);
$buyer = $result->fetch_assoc();

echo "<h2>{$buyer['name']}</h2>";
echo "<p>Email: {$buyer['email']}</p>";
echo "<p>Phone: {$buyer['phone']}</p>";
echo "<p>Address: {$buyer['address']}</p>";

// Purchase history
$sql2 = "SELECT t.id, p.name as product, t.total_amount, t.date 
         FROM transactions t 
         JOIN products p ON t.product_id=p.id 
         WHERE t.buyer_id=$id";
$result2 = $conn->query($sql2);

echo "<h3>Purchase History</h3>";
echo "<ul>";
while($row = $result2->fetch_assoc()) {
    echo "<li>{$row['product']} - {$row['total_amount']} on {$row['date']}</li>";
}
echo "</ul>";
?>

</body>
</html>
