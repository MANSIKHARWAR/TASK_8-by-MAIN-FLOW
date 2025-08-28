<?php
include 'db.php';
$id = intval($_GET['id'] ?? 0);
if ($id) {
  $stmt = $conn->prepare("DELETE FROM buyers WHERE id = ?");
  $stmt->bind_param("i",$id);
  $stmt->execute();
}
header("Location: buyers.php");
exit;
