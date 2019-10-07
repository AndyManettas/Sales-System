<?php
require_once('settings.php');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST["query"]))
{
    $output = '';
    $query = "SELECT * FROM products WHERE product_name LIKE '%". $_POST["query"] ."%'";
    $gatherResult = mysqli_query($conn, $query);
    $output = '<ul class="list-unstyled">';
    if(mysqli_num_rows($gatherResult) > 0)
    {
        while($row = mysqli_fetch_array($gatherResult))
        {
            $output .= '<li>'. $row["product_name"] .'</li>';
        }
    }
    else
    {
        $output .= '<li>Product not found</li>';
    }
    $output .= '</ul>';
    echo $output;
}
?>