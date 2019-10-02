<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Inventory" />
    <meta name="keywords" content="PHP, Javascript, HTML5, CSS, XML" />
    <meta name="author" content="Salesforce DP2" />

    <title>Sales Record</title>

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
    <div class="wrapper">
        <h1>Sales Record</h1>
		<?php
			/*DATABASE CONNECTION*/
			require_once("conn-settings.php");
			
			if (!$conn)
				echo "<p> Unable to connect to database!</p>";
			else {
				if(isset($_POST["salesAddForm"]))
				{
					$sales_item_id= $_POST["addSalesItemId"];
					$get_item_id_query = "SELECT * FROM products WHERE product_id = '$sales_item_id'";
					$sales_item_name = $_POST["addSalesItemName"];
					$sales_item_unit_price = $_POST["addSalesItemUnitPrice"];
					$sales_quantity = $_POST["addSalesItemQuantity"];
					$sales_total_price = $_POST["addSalesTotalPrice"];
					
					/* Insert to database with new sales record */
					$insert_sales_record_query = "INSERT INTO records (product_id, purchase_date,  purchase_quantity, total_price) VALUES ('$sales_item_id', NOW(), '$sales_quantity', '$sales_total_price')";
					$insert_sales_record_result = mysqli_query($conn, $insert_sales_record_query);
					$update_product_quantity_query = "UPDATE products SET quantity=quantity-'$sales_quantity' WHERE product_id='$sales_item_id'";
					$update_product_quantity_result = mysqli_query($conn, $update_product_quantity_query);
					if (!$insert_sales_record_result || !$update_product_quantity_result)
					{
						echo("Error description: " . mysqli_error($conn));
					}
					
					echo "<p>New sales record added.</p>";
					echo "<p>Item ID: ",$sales_item_id,"</p>";
					echo "<p>Item Name: ",$sales_item_name,"</p>";
					echo "<p>Unit Price: $",$sales_item_unit_price,"</p>";
					echo "<p>Purchase Quantity: ",$sales_quantity,"</p>";
					echo "<p>Total Price: $",$sales_total_price,"</p>";
				}
				else if(isset($_POST["salesEditForm"]))
				{
					$sales_record_id = $_POST["editSalesRecordIdViewer"];
					$sales_item_id = $_POST["editSalesItemId"];
					$sales_item_name = $_POST["editSalesItemName"];
					$sales_item_unit_price = $_POST["editSalesItemUnitPrice"];
					$new_sales_quantity = $_POST["editSalesItemQuantity"];
					$sales_total_price = $_POST["editSalesTotalPrice"];
					
					/* Update to database with edited sales record */
					$get_sales_record_quantity = "SELECT purchase_quantity FROM records WHERE record_id='$sales_record_id'"; /* Get original purchase quantity and check the difference with new purchase quantity */
					$get_sales_record_quantity_result = mysqli_query($conn, $get_sales_record_quantity);
					$get_sales_record_quantity_row = mysqli_fetch_assoc($get_sales_record_quantity_result);	
					$old_sales_quantity = $get_sales_record_quantity_row['purchase_quantity'];
					
					$insert_sales_record_query = "UPDATE records SET purchase_quantity='$new_sales_quantity', total_price='$sales_total_price' WHERE record_id='$sales_record_id'";
					$insert_sales_record_result = mysqli_query($conn, $insert_sales_record_query);
					
					if ($new_sales_quantity > $old_sales_quantity) {
						$quantity_difference = $new_sales_quantity - $old_sales_quantity;
						$update_product_quantity_query = "UPDATE products SET quantity=quantity-'$quantity_difference' WHERE product_id='$sales_item_id'";
						$update_product_quantity_result = mysqli_query($conn, $update_product_quantity_query);
					} else {
						$quantity_difference = $old_sales_quantity - $new_sales_quantity;
						$update_product_quantity_query = "UPDATE products SET quantity=quantity+'$quantity_difference' WHERE product_id='$sales_item_id'";
						$update_product_quantity_result = mysqli_query($conn, $update_product_quantity_query);
					}
					
					
					if (!$insert_sales_record_result || !$update_product_quantity_result)
					{
						echo("Error description: " . mysqli_error($conn));
					}
					
					echo "<p>Sales record updated.</p>";
					echo "<p>Sales ID: ",$sales_record_id,"</p>";
					echo "<p>Item ID: ",$sales_item_id,"</p>";
					echo "<p>Item Name: ",$sales_item_name,"</p>";
					echo "<p>Unit Price: $",$sales_item_unit_price,"</p>";
					echo "<p>Purchase Quantity: ",$new_sales_quantity,"</p>";
					echo "<p>Total Price: $",$sales_total_price,"</p>";
				}
				else if(isset($_POST["salesDeleteForm"]))
				{
					$sales_record_id = $_POST["deleteSalesRecordIdViewer"];
					$sales_item_id = $_POST["deleteSalesItemId"];
					$sales_item_name = $_POST["deleteSalesItemName"];
					$sales_item_unit_price = $_POST["deleteSalesItemUnitPrice"];
					$sales_quantity = $_POST["deleteSalesItemQuantity"];
					$sales_total_price = $_POST["deleteSalesTotalPrice"];
					
					/* Delete chosen sales record */
					$delete_sales_record_query ="DELETE FROM records WHERE record_id='$sales_record_id'";
					$delete_sales_record_result = mysqli_query($conn, $delete_sales_record_query);
					if (!$delete_sales_record_result)
					{
						echo("Error description: " . mysqli_error($conn));
					}
					
					echo "<p>Sales record deleted.</p>";
					echo "<p>Sales ID: ",$sales_record_id,"</p>";
					echo "<p>Item ID: ",$sales_item_id,"</p>";
					echo "<p>Item Name: ",$sales_item_name,"</p>";
					echo "<p>Unit Price: $",$sales_item_unit_price,"</p>";
					echo "<p>Purchase Quantity: ",$sales_quantity,"</p>";
					echo "<p>Total Price: $",$sales_total_price,"</p>";
				}
				else
				{
					echo "<p>Error! Unable to process your request. Please try again.</p>";
				}
			
			}
		?>
    </div>
    <!-- end of wrapper div -->
</body>

</html>

