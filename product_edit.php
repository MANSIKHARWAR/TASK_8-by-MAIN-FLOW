<?php include 'header.php';
$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
if (!$product) { echo "<p>Product not found</p>"; include 'footer.php'; exit; }
?>

<h2>Edit Product</h2>
<form method="POST" enctype="multipart/form-data">
  <div class="form-row">Name<br><input type="text" name="name" value="<?=htmlspecialchars($product['name'])?>" required></div>
  <div class="form-row">Category<br><input type="text" name="category" value="<?=htmlspecialchars($product['category'])?>"></div>
  <div class="form-row">Price<br><input type="number" name="price" step="0.01" value="<?=htmlspecialchars($product['price'])?>" required></div>
  <div class="form-row">Quantity<br><input type="number" name="quantity" value="<?=htmlspecialchars($product['quantity'])?>" required></div>
  <div class="form-row">Description<br><textarea name="description"><?=htmlspecialchars($product['description'])?></textarea></div>
  <div class="form-row">Image<br><input type="file" name="image"> Current: <?=htmlspecialchars($product['image'])?></div>
  <button type="submit" name="update">Update Product</button>
</form>

<?php
if (isset($_POST['update'])) {
  $imgName = $product['image'];
  if (!empty($_FILES['image']['name'])) {
    $targetDir = __DIR__.'/uploads/';
    if (!is_dir($targetDir)) mkdir($targetDir,0755,true);
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imgName = time().'-'.bin2hex(random_bytes(4)).'.'.$ext;
    move_uploaded_file($_FILES['image']['tmp_name'], $targetDir.$imgName);
  }
  $stmt = $conn->prepare("UPDATE products SET name=?,category=?,price=?,quantity=?,description=?,image=? WHERE id=?");
  $stmt->bind_param("ssdisii", $_POST['name'], $_POST['category'], $_POST['price'], $_POST['quantity'], $_POST['description'], $imgName, $id);
  // Note: last param types adjusted below to avoid mismatch
  $stmt = $conn->prepare("UPDATE products SET name=?,category=?,price=?,quantity=?,description=?,image=? WHERE id=?");
  $stmt->bind_param("ssdissi", $_POST['name'], $_POST['category'], $_POST['price'], $_POST['quantity'], $_POST['description'], $imgName, $id);
  if ($stmt->execute()) { header("Location: products.php"); exit; } else { echo "<p style='color:red'>Error: ".htmlspecialchars($conn->error)."</p>"; }
}
?>

<?php include 'footer.php'; ?>
