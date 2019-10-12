<?php
require_once("settings.php");
$no_sales_query = "SELECT purchase_date, SUM(total_price) as 'total_price' FROM records, (SELECT DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY) as START_DATE) as start_date WHERE purchase_date BETWEEN start_date.START_DATE AND start_date.START_DATE + INTERVAL 7 DAY GROUP BY purchase_date";
$no_sales_result = mysqli_query($conn, $no_sales_query);

$no_sales_rows = mysqli_num_rows($no_sales_result);
$no_predicted_rows = 7 - $no_sales_rows;

$sum = 0;
$temp3 = array();

while ($array = mysqli_fetch_assoc($no_sales_result)) {
  array_push($temp3, $array['total_price']);
  }
 
$mid = (max($temp3) + min($temp3)) / 2;
for ($i = 0; $i < $no_predicted_rows; $i++) {
    $predict_sales = rand($mid - 500, $mid + 500);
    array_push($temp3, $predict_sales);
}

$sum = array_sum($temp3);

$_SESSION['sum'] = $sum;
?>