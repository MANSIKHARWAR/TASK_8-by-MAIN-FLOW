<?php
include 'db.php';

// Add buyer
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    mysqli_query($conn, "INSERT INTO buyers(name,email,phone) VALUES('$name','$email','$phone')");
}

// Delete buyer
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM buyers WHERE id=$id");
}
$result = mysqli_query($conn, "SELECT * FROM buyers");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Buyers</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Buyers</h2>

    <form method="POST">
        <input type="text" name="name" placeholder="Enter Name" required>
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="text" name="phone" placeholder="Enter Phone" required>
        <button type="submit" name="add">Add Buyer</button>
    </form>

    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Action</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td>
                <a href="buyers.php?delete=<?= $row['id'] ?>" class="btn">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="index.php" class="btn">⬅ Back</a>
</div>
</body>
</html>
