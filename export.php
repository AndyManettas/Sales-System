<?php
if (isset($_POST["export"])) {
  require_once("settings.php");
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=data.csv');
  $output = fopen("php://output", "w");
  fputcsv($output, array('Record ID', 'Product ID', 'Total Price', 'Purchase Qty', 'Purchase Date'));
  if(!empty($_POST["start_date"])){
    $start_date = $_POST["start_date"];
    $get_weekly_report_query = "SELECT * FROM records WHERE purchase_date BETWEEN '$start_date' AND '$start_date' + INTERVAL 7 DAY";
    $get_weekly_report_result = mysqli_query($conn, $get_weekly_report_query);
    while ($row = mysqli_fetch_assoc($get_weekly_report_result)) {
    fputcsv($output, $row);
    }
  }else {
    $get_weekly_report_query = "SELECT * FROM records";
    $get_weekly_report_result = mysqli_query($conn, $get_weekly_report_query);
     while ($row = mysqli_fetch_assoc($get_weekly_report_result)) {
    fputcsv($output, $row);
    }
  }
  fclose($output);
}
?>
