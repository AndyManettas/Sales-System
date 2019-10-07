<?php
require_once('settings.php');

$sql_table = "products";

$sum_query = "SELECT purchase_date, SUM(total_price) FROM records GROUP BY purchase_date WHERE NOW() - 7 < purchase_date";
$sum_result = mysqli_query($conn, $sum_query);
//$array = mysqli_fetch_assoc($sum_result);
//$array['purchase_date']
while ($array = mysqli_fetch_assoc($sum_result)) {
  echo $array['purchase_date'];
  echo $array['SUM(total_price)'];
}

SELECT purchase_date, SUM(total_price) FROM records WHERE NOW() - INTERVAL 7 DAY < purchase_date GROUP BY purchase_date

$no_sales_query = "SELECT purchase_date, SUM(purchase_quantity) FROM records GROUP BY purchase_date";
$no_sales_result = mysqli_query($conn, $no_sales_query);
$no_sales_array = mysqli_fetch_assoc($no_sales_result);

?>