<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>Shop Dashboard</title>
  <style>
    /* --- Content-specific Styles --- */
    table { border-collapse: collapse; width: 100%; margin-top:12px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background: #f4f4f4; }
    .badge { padding: 4px 8px; border-radius: 4px; color: white; font-size: 0.9em; }
    .stock-ok { background: green; }
    .stock-low { background: orange; }
    .stock-out { background: red; }
    .btn { padding:6px 10px; text-decoration:none; background:#007bff; color:white; border-radius:4px; }
    .btn-danger { background:#dc3545; }
    .form-row { margin:8px 0; }
    .small { font-size:0.9em; color:#555; }
  </style>
</head>
<body>

<!-- Professional Header -->
<header>
    <div class="container">
        <h1>LAMA GEMS</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="buyers.php">Buyers</a></li>
                <li><a href="transactions.php">Transactions</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <h2>Shop Dashboard</h2>
    <hr/>

    <!-- Existing Navigation -->
    <nav>
      <a href="index.php">Home</a> |
      <a href="buyers.php">Buyers</a> |
      <a href="products.php">Products</a> |
      <a href="transactions.php">Transactions</a>
    </nav>

    <!-- Add your table / content below -->
    <!-- Example: Products Table -->
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Category</th>
        <th>Stock</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
      <!-- Dynamic rows from PHP can go here -->
    </table>
</div>

<!-- Professional Footer -->
<footer>
    <div class="container">
        <div class="footer-section">
            <h3>About LAMA GEMS</h3>
            <p>High-quality jewelry with professional service and secure transactions.</p>
        </div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="buyers.php">Buyers</a>
            <a href="transactions.php">Transactions</a>
        </div>
        <div class="footer-section">
            <h3>Contact</h3>
            <p>Email: info@lamagems.com</p>
            <p>Phone: +91 1234567890</p>
            <p>Address: Delhi, India</p>
        </div>
    </div>
</footer>

</body>
</html>
