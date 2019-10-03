<?php include('suppliesManage.php'); 

require_once("conn-settings.php");
//Edit a product
if (isset($_GET['edit']))
{
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");

        $n = mysqli_fetch_assoc($record);
        $productName = $n['productName'];
        $quantity = $n['quantity'];
        $price = $n['price'];
        $id = $n['id'];
    
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
    <!--Display comfimation message-->
    <?php if (isset($_SESSION['message'])): ?>
        <div class='message'>
            <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        </div>
<?php endif ?>
    <!--Display Result onto Table for testing-->
    <?php $result = mysqli_query($conn, "SELECT * FROM products"); ?>
    <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_array($result)) 
            { ?>
                <tr>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td>
                        <a href="supplies.php?edit=<? echo $row['product_id']; ?>" class="edit_btn" >Edit</a>
                    </td>
                    <td>
                        <a href="suppliesManage.php?delete=<? echo $row['product_id']; ?>" class="del_btn" >Delete</a>
                    </td>
            <?php }?>
    </table>

<p>Adding Supply</p>
<form class = productform method="post" action="suppliesManage.php">
    <div class="input">
        <label for="productName">Product Name:</label>
        <input type="text" name="productName" id="productName" value= "<?php echo $productName; ?>" required>
    </div>
    <div class="input">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" max="999" value= "<?php echo $quantity; ?>" required>
    </div>
    <div class="input">
        <label for="price">Price:</label>
        <input type="number" name="price" id="price" value= "<?php echo $price; ?>" required>
    </div>
        <button class="btn" type="submit" name="submit">Submit</button>
</form>
</body>

</html>