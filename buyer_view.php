<?php include 'header.php';
$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM buyers WHERE id=?");
$stmt->bind_param("i",$id); $stmt->execute();
$buyer = $stmt->get_result()->fetch_assoc();
if (!$buyer) { echo "<p>Buyer not found</p>"; include 'footer.php'; exit; }
?>

<h2>Buyer: <?=htmlspecialchars($buyer['name'])?></h2>
<p><strong>Email:</strong> <?=htmlspecialchars($buyer['email'])?></p>
<p><strong>Phone:</strong> <?=htmlspecialchars($buyer['phone'])?></p>
<p><strong>Address:</strong> <?=nl2br(htmlspecialchars($buyer['address']))?></p>

<h3>Purchase History</h3>
<?php
$stmt = $conn->prepare("SELECT t.*, p.name as product_name FROM transactions t JOIN products p ON t.product_id = p.id WHERE t.buyer_id = ? ORDER BY t.transaction_date DESC");
$stmt->bind_param("i",$id); $stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows == 0) echo "<p>No purchases yet.</p>";
else {
  echo "<table><thead><tr><th>Product</th><th>Qty</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th></tr></thead><tbody>";
  while($r = $res->fetch_assoc()) {
    echo "<tr>
      <td>".htmlspecialchars($r['product_name'])."</td>
      <td>".$r['quantity']."</td>
      <td>".$r['total_amount']."</td>
      <td>".$r['payment_method']."</td>
      <td>".$r['status']."</td>
      <td>".$r['transaction_date']."</td>
    </tr>";
  }
  echo "</tbody></table>";
}
?>

<?php include 'footer.php'; ?>
