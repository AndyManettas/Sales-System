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
        $price="";
        $id=0;
        $update=false;

        if(isset($_POST['submit']))
        {
            $productName = $_POST['productName'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];

            mysqli_query($conn, "INSERT INTO products (product_name, price, quantity) VALUES ('$productName', '$price', '$quantity')");
            $_SESSION['message'] = "Added to Inventory";
        }
    }
    
    //Update product using new details from the edit form
    if (isset($_POST['edit']))
    {
        $id = mysql_real_escape_string($_POST['id']);
        $productName = mysql_real_escape_string($_POST['productName']);
        $quantity= mysql_real_escape_string($_POST['quantity']);
        $price=mysql_real_escape_string($_POST['price']);
        
        mysqli_query($conn, "UPDATE products SET product_name = $productName WHERE id=$id");
        $_SESSION['message'] = "Product Updated!";
        header('location: supplies.php');
    }
    //Delete product
    if (isset($_GET['del']))
    {
        $id = $_GET['del'];
        mysqli_query($conn, "DELETE FROM products WHERE id=$id");
        $_SESSION['message'] = "Product Deleted!";
        header('location: supplies.php');
    }
?>