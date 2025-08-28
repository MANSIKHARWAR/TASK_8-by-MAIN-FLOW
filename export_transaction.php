<?php
include 'db.php';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=transactions_'.date('Ymd_His').'.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID','Transaction Date','Buyer','Product','Qty','Total','Payment','Status','Notes']);

$sql = "SELECT t.*, b.name as buyer_name, p.name as product_name FROM transactions t JOIN buyers b ON t.buyer_id=b.id JOIN products p ON t.product_id = p.id ORDER BY t.transaction_date DESC";
$res = $conn->query($sql);
while ($r = $res->fetch_assoc()) {
  fputcsv($output, [
    $r['id'],
    $r['transaction_date'],
    $r['buyer_name'],
    $r['product_name'],
    $r['quantity'],
    $r['total_amount'],
    $r['payment_method'],
    $r['status'],
    $r['notes']
  ]);
}
fclose($output);
exit;
