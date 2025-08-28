<?php include 'header.php'; ?>

<h2>Add Buyer</h2>
<form method="POST">
  <div class="form-row">Name<br><input type="text" name="name" required></div>
  <div class="form-row">Email<br><input type="email" name="email" required></div>
  <div class="form-row">Phone<br><input type="text" name="phone"></div>
  <div class="form-row">Address<br><textarea name="address"></textarea></div>
  <button type="submit" name="save">Save</button>
</form>

<?php
if (isset($_POST['save'])) {
  $stmt = $conn->prepare("INSERT INTO buyers (name,email,phone,address) VALUES (?,?,?,?)");
  $stmt->bind_param("ssss", $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address']);
  if ($stmt->execute()) {
    header("Location: buyers.php");
    exit;
  } else {
    echo "<p style='color:red'>Error: " . htmlspecialchars($conn->error) . "</p>";
  }
}
?>

<?php include 'footer.php'; ?>
