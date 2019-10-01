<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Homepage" />
    <meta name="keywords" content="PHP, Javascript, HTML5, CSS, XML" />
    <meta name="author" content="Anthony Sam" />
    <title>Supplies</title>
	<script src="scripts/saleRecordApplication.js"></script>
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
    <p>Adding Supplies</p>
    <form id= "addSupplyForm" method="post" action="suppliesQuery.php" >
        <?php
            /*Datebase Connection*/
            require_once("conn-settings.php");
            if (!$conn)
                echo "<p> Unable to connent to database!</p>";
            else
            {
                //initialize variables
                $productName = "";
                $quantity= "";
                $expiryDate="";
                $id=0;
                $update=false;

                if(isset($_POST['save']))
                {
                    $productName = $_POST['productName'];
                    $quantity = $_POST['quantity'];
                    $expiryDate = $_POST['expiryDate']

                    mysqli_query($conn, "INSERT INTO supply (productName, quantity, expiryDate) VALUES ('$productName', '$quantity', "$expiryDate")");
                    $_SESSION['message'] = "Added to Inventory";
                }
            }
        ?>
    </form>
    <!--Display comfimation message-->
    <?php if (isset($_SESSION['message'])): ?>
    <div class="msg">
        <?php 
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        ?>
    </div>
    <?php endif ?>

    <!--Display Result onto Table-->
    <?php $result = mysqli_query($conn, "SELECT * FROM supply"); ?>
    <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $row['productName']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['expiryDate']; ?></td>
                    <td>
                        <a href="supplies.php?edit=<?php echo $row['id']; ?>" class="edit_btn">Edit</a>
                    </td>
                    <td>
                        <a href="supplies.php?delete=<?php echo $row['id']; ?>" class="delete_btn">Delete</a>
                    </td>
                </tr>
    </table>
    <?php
    //Update product using new details from the edit form
    if (isset($_POST['update']))
    {
        $id = $_POST['id'];
        $productName = $POST['productName'];
        $quantity= $POST['quantity'];
        $expiryDate=$POST['expiryDate'];
        
        mysqli_query($conn, "UPDATE supply SET productName")
        $_SESSION['message'] = "Product Updated!";
        header('Location: supplies.php');
    }
    //Delete product
    if (isset($_GET['del']))
    {
        $id = $_GET['del'];
        mysqli_query($conn, "DELETE FROM supply WHERE id=$id")
        $_SESSION['message'] = "Product Deleted!";
        header('location: supplies.php');
    }

    ?>
</body>
</html>