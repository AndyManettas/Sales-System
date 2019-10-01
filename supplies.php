<!--Edit a supply-->
<?php
 if (isset($_GET['edit']))
 {
     $id = $_GET['edit'];
     $update = true;
     $record = mysqli_query($conn, "SELECT * FROM supply WHERE id=$id");

     if (count($record) == 1)
     {
         $n = mysqli_fetch_array($record);
         $productName = $n['productName'];
         $quantity = $n['quantity'];
         $expiryDate = $n['expiryDate'];
     }
 }
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Homepage" />
    <meta name="keywords" content="PHP, Javascript, HTML5, CSS, XML" />
    <meta name="author" content="Anthony Sam" />

    <title>Supplies</title>

    <link rel="stylesheet" href="styles/style.css" />
    <link rel="shortcut icon" type="image/png" href="images/logosmall.png" />
    <link href="https://fonts.googleapis.com/css?family=Heebo:100,300,400,500,700,800,900" rel="stylesheet">
</head>

<body>
    <header class="header-wrapper">
        <nav>
            <ul>
                <li><a href="index.php">Overview</a></li>
                <li><a href="sales.php">Sales records</a></li>
                <li><a href="inventory.php">Inventory</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </nav>
    </header>
<h2>Supplies List</h2>
<p>Adding Supply</p>
<form method="post" action="conn-setting">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="input">
        <label for="productName">Product Name:</label>
        <input type="text" name="productName" id="productName" value= "<?php echo $productName; ?>" required>
    </div>
    <div class="input">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" max="999" value= "<?php echo $quantity; ?>" required>
    </div>
    <div class="input">
        <label for="expirydate">Expiry Date:</label>
        <input type="date" name="expirydate" id="expirydate" value= "<?php echo $expiryDate; ?>" required>
    </div>
    
    <?php if ($update == true): ?>
        <button class="btn" type="submit" name="update">Update</button>
    <?php else: ?>
        <button class="btn" type="submit" name="submit">Submit</button>
    <?php endif ?>
</form>

</body>

</html>