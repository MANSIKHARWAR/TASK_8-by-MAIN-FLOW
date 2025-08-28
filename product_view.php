<?php include 'header.php';
$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
if (!$product) { echo "<p>Product not found</p>"; include 'footer.php'; exit; }
?>

<h2><?=htmlspecialchars($product['name'])?></h2>
<p><img src="<?= $product['image'] ? 'uploads/'.htmlspecialchars($product['image']) : 'https://via.placeholder.com/150' ?>" width="150"></p>
<p><strong>Category:</strong> <?=htmlspecialchars($product['category'])?></p>
<p><strong>Price:</strong> <?= $product['price'] ?></p>
<p><strong>Stock:</strong> <?= $product['quantity'] ?></p>
<p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($product['description'])) ?></p>

<?php include 'footer.php'; ?>
