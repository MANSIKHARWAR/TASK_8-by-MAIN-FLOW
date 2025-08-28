<?php
include 'db.php';
$id = intval($_GET['id'] ?? 0);
$status = $_GET['status'] ?? '';
$allowed = ['Completed','Pending','Canceled'];
if ($id && in_array($status, $allowed)) {
  $stmt = $conn->prepare("UPDATE transactions SET status = ? WHERE id = ?");
  $stmt->bind_param("si",$status,$id); $stmt->execute();
}
header("Location: transactions.php"); exit;
