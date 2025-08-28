<?php
include 'db.php';
$id = intval($_GET['id'] ?? 0);
if ($id) {
  // optionally delete image file first (fetch name)
  $stmt = $conn->prepare("SELECT image FROM products WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute();
  $img = $stmt->get_result()->fetch_assoc()['image'];
  if ($img && file_exists(__DIR__."/uploads/".$img)) unlink(__DIR__."/uploads/".$img);

  $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
  $stmt->bind_param("i",$id); $stmt->execute();
}
header("Location: products.php"); exit;
