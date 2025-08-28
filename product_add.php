<?php include 'header.php'; ?>

<h2>Add Product</h2>
<form method="POST" enctype="multipart/form-data">
  <div class="form-row">Name<br><input type="text" name="name" required></div>
  <div class="form-row">Category<br><input type="text" name="category"></div>
  <div class="form-row">Price<br><input type="number" name="price" step="0.01" required></div>
  <div class="form-row">Quantity<br><input type="number" name="quantity" required></div>
  <div class="form-row">Description<br><textarea name="description"></textarea></div>
  <div class="form-row">Image<br><input type="file" name="image" accept="image/*"></div>
  <button type="submit" name="save">Save Product</button>
</form>

<?php
if (isset($_POST['save'])) {
  $imgName = null;
  if (!empty($_FILES['image']['name'])) {
    $targetDir = __DIR__.'/uploads/';
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imgName = time().'-'.bin2hex(random_bytes(4)).'.'.$ext;
    move_uploaded_file($_FILES['image']['tmp_name'], $targetDir.$imgName);
  }
  $stmt = $conn->prepare("INSERT INTO products (name,category,price,quantity,description,image) VALUES (?,?,?,?,?,?)");
  $stmt->bind_param("ssdiss", $_POST['name'], $_POST['category'], $_POST['price'], $_POST['quantity'], $_POST['description'], $imgName);
  if ($stmt->execute()) {
    header("Location: products.php"); exit;
  } else { echo "<p style='color:red'>Error: ".htmlspecialchars($conn->error)."</p>"; }
}
?>

<?php include 'footer.php'; ?>
