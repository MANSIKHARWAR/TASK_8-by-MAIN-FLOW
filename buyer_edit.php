<?php include 'header.php';
$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM buyers WHERE id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$buyer = $stmt->get_result()->fetch_assoc();
if (!$buyer) { echo "<p>Buyer not found</p>"; include 'footer.php'; exit; }
?>

<h2>Edit Buyer</h2>
<form method="POST">
  <div class="form-row">Name<br><input type="text" name="name" value="<?=htmlspecialchars($buyer['name'])?>" required></div>
  <div class="form-row">Email<br><input type="email" name="email" value="<?=htmlspecialchars($buyer['email'])?>" required></div>
  <div class="form-row">Phone<br><input type="text" name="phone" value="<?=htmlspecialchars($buyer['phone'])?>"></div>
  <div class="form-row">Address<br><textarea name="address"><?=htmlspecialchars($buyer['address'])?></textarea></div>
  <button type="submit" name="update">Update</button>
</form>

<?php
if (isset($_POST['update'])) {
  $stmt = $conn->prepare("UPDATE buyers SET name=?, email=?, phone=?, address=? WHERE id=?");
  $stmt->bind_param("ssssi", $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'], $id);
  if ($stmt->execute()) {
    header("Location: buyers.php");
    exit;
  } else {
    echo "<p style='color:red'>Error: ".htmlspecialchars($conn->error)."</p>";
  }
}
?>

<?php include 'footer.php'; ?>
