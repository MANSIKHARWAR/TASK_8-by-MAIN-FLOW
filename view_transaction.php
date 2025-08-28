<?php include 'header.php';
$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT t.*, b.name AS buyer_name, p.name AS product_name, p.price as product_price FROM transactions t JOIN buyers b ON t.buyer_id=b.id JOIN products p ON t.product_id=p.id WHERE t.id = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$tx = $stmt->get_result()->fetch_assoc();
if (!$tx) { echo "<p>Transaction not found</p>"; include 'footer.php'; exit; }
?>

<h2>Transaction #<?= $tx['id'] ?></h2>
<p><strong>Buyer:</strong> <?= htmlspecialchars($tx['buyer_name']) ?></p>
<p><strong>Product:</strong> <?= htmlspecialchars($tx['product_name']) ?></p>
<p><strong>Unit price:</strong> <?= $tx['product_price'] ?></p>
<p><strong>Quantity:</strong> <?= $tx['quantity'] ?></p>
<p><strong>Total:</strong> <?= $tx['total_amount'] ?></p>
<p><strong>Payment:</strong> <?= $tx['payment_method'] ?></p>
<p><strong>Status:</strong> <?= $tx['status'] ?></p>
<p><strong>Date:</strong> <?= $tx['transaction_date'] ?></p>
<p><strong>Notes:</strong> <?= nl2br(htmlspecialchars($tx['notes'])) ?></p>

<p>
  <a class="btn" href="transactions.php">Back</a>
  <a class="btn" href="transaction_update_status.php?id=<?= $tx['id'] ?>&status=Completed">Mark Completed</a>
  <a class="btn btn-danger" href="transaction_update_status.php?id=<?= $tx['id'] ?>&status=Canceled">Cancel</a>
</p>

<?php include 'footer.php'; ?>
