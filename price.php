<?php
require_once('settings.php');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST["name"]))
{
    $price_output = '';
    $price_query = "SELECT product_name, price FROM products WHERE product_name = '". mysqli_real_escape_string($conn, $_POST['name']) ."'";
    $price_result = mysqli_query($conn, $price_query);
    if(mysqli_num_rows($price_result) > 0)
    {
        while($row = mysqli_fetch_array($price_result))
        {
            $price_output = $row["price"];
        }
    }
    else
    {
        $price_output .= 'Price not found';
    }
    
    echo $price_output;
}
?>