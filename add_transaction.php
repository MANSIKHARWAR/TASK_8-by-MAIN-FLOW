<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/style.css">

<h2>Add Transaction</h2>
<form method="POST">
  <div class="form-row">Buyer
    <select name="buyer_id" required>
      <option value="">-- select buyer --</option>
      <?php $b = $conn->query("SELECT id,name FROM buyers ORDER BY name"); while($row = $b->fetch_assoc()){ echo "<option value='{$row['id']}'>".htmlspecialchars($row['name'])."</option>"; } ?>
    </select>
  </div>

  <div class="form-row">Product
    <select name="product_id" id="product_select" required onchange="fetchPrice()">
      <option value="">-- select product --</option>
      <?php $p = $conn->query("SELECT id,name,price,quantity FROM products ORDER BY name"); while($row = $p->fetch_assoc()){ echo "<option value='{$row['id']}' data-price='{$row['price']}' data-stock='{$row['quantity']}'>".htmlspecialchars($row['name'])." (₹{$row['price']})</option>"; } ?>
    </select>
  </div>

  <div class="form-row">Quantity<br><input type="number" name="quantity" id="qty" value="1" min="1" required></div>
  <div class="form-row">Payment Method
    <select name="payment_method" required>
      <option>UPI</option><option>Credit Card</option><option>Cash</option><option>Net Banking</option>
    </select>
  </div>
  <div class="form-row">Notes<br><textarea name="notes"></textarea></div>
  <button type="submit" name="save">Create Transaction</button>
</form>

<script>
function fetchPrice(){
  const sel = document.getElementById('product_select');
  const opt = sel.options[sel.selectedIndex];
  const price = opt ? opt.dataset.price : 0;
  const stock = opt ? opt.dataset.stock : 0;
  document.getElementById('qty').max = stock;
}
</script>

<?php
if (isset($_POST['save'])) {
  $buyer_id = intval($_POST['buyer_id']);
  $product_id = intval($_POST['product_id']);
  $quantity = intval($_POST['quantity']);
  $payment_method = $_POST['payment_method'];
  $notes = $_POST['notes'];

  // fetch price and stock
  $stmt = $conn->prepare("SELECT price, quantity FROM products WHERE id = ?");
  $stmt->bind_param("i",$product_id); $stmt->execute();
  $prod = $stmt->get_result()->fetch_assoc();
  if (!$prod) { echo "<p style='color:red'>Product not found</p>"; include 'footer.php'; exit; }
  if ($quantity > $prod['quantity']) { echo "<p style='color:red'>Not enough stock (available {$prod['quantity']})</p>"; include 'footer.php'; exit; }

  $total = $prod['price'] * $quantity;

  // transaction: insert transaction and update product stock (atomic)
  $conn->begin_transaction();
  try {
    $stmt = $conn->prepare("INSERT INTO transactions (buyer_id, product_id, quantity, total_amount, payment_method, notes, status) VALUES (?,?,?,?,?,?,?)");
    $stat = 'Pending';
    $stmt->bind_param("iiissss", $buyer_id, $product_id, $quantity, $total, $payment_method, $notes, $stat);
    $stmt->execute();

    $stmt2 = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
    $stmt2->bind_param("ii", $quantity, $product_id);
    $stmt2->execute();

    $conn->commit();
    header("Location: transactions.php");
    exit;
  } catch (Exception $e) {
    $conn->rollback();
    echo "<p style='color:red'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
  }
}
?>

<?php include 'footer.php'; ?>
