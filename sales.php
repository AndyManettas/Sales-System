<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Homepage" />
    <meta name="keywords" content="PHP, Javascript, HTML5, CSS, XML" />
    <meta name="author" content="Saber Ali" />
    <title>Sales records</title>
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
    <h2>Sales record management</h2>
    <p>Add a sales record</p>
	
	<form id="salesFindItemForm" method="post" action="sales.php">
        <!-- Sales Record ID and Sales Item ID are different. Record ID represents each transaction/record. Record ID can be handled by the database -->
		Item ID:<br>
        <input type="text" name="addSalesItemId" id="addSalesItemId"><br>
		<input type="submit" name="salesFindItemForm" value="Find"><br>
	</form><br>
	
	<form id="salesAddForm" method="post" action="salesQuery.php">
		<?php
			/*DATABASE CONNECTION*/
			require_once("conn-settings.php");
			
			if (!$conn)
				echo "<p> Unable to connect to database!</p>";
			else {
				if(isset($_POST["addSalesItemId"]))
				{
					$product_id = $_POST["addSalesItemId"];
					$get_item_id_query = "SELECT * FROM products WHERE product_id = '$product_id'";
					$get_item_id_result = mysqli_query($conn, $get_item_id_query);
					$get_product_id_row = mysqli_fetch_assoc($get_item_id_result);	
					
					if (!empty($get_product_id_row)) {
						echo "Item ID: ";
						echo '<span>',$get_product_id_row['product_id'],'</span><br>';
						echo '<input name="addSalesItemId" id="addSalesItemId" type="number" hidden="hidden" value=',$get_product_id_row["product_id"],'>'; /* POST to salesQuery */
						echo "Item Name: ";
						echo '<span>',$get_product_id_row['product_name'],'</span><br>';
						echo '<input name="addSalesItemName" id="addSalesItemName" type="text" hidden="hidden" value=',$get_product_id_row["product_name"],'>';
						echo "Unit price: $";
						echo '<span>',$get_product_id_row['price'],'</span><br>';
						echo '<input name="addSalesItemUnitPrice" id="addSalesItemUnitPrice" type="number" hidden="hidden" step="0.01" value=',$get_product_id_row["price"],'>';
					} else {
						echo "<p>Item ID not found</p><br>";
					}
				}
			}
		?>
        Quantity:<br>
        <input type="number" name="addSalesItemQuantity" id="addSalesItemQuantity" min="1" max="999" placeholder="0"><br>
        Total price: $<span name="addSalesTotalPriceViewer" id="addSalesTotalPriceViewer"></span><br> <!-- JS performs calculation for total price -->
		<input name="addSalesTotalPrice" id="addSalesTotalPrice" type="hidden" hidden="hidden">
        <input type="submit" name="salesAddForm" value="Add"><br> <!-- Does nothing for now -->
    </form><br>
	
	<p>Edit a sales record</p>
	<form id="salesFindRecordForm" method="post" action="sales.php">
        <!-- Edit/Delete action method later for php -->
		Sales ID:<br>
		<input type="text" name="editSalesRecordId" id="editSalesRecordId"><br>
		<input type="submit" name="salesFindRecordForm" value="Find"><br>
	</form><br>
	<form id="salesEditForm" method="post" action="salesQuery.php">
		<?php
			/*DATABASE CONNECTION*/
			require_once("conn-settings.php");
			
			if (!$conn)
				echo "<p> Unable to connect to database!</p>";
			else {
				if(isset($_POST["editSalesRecordId"]))
				{
					$sales_record_id = $_POST["editSalesRecordId"];
					$get_sales_id_query = "SELECT * FROM records WHERE record_id = '$sales_record_id'";
					$get_sales_id_result = mysqli_query($conn, $get_sales_id_query);
					$get_sales_id_row = mysqli_fetch_assoc($get_sales_id_result);	
					$get_sales_product_id = $get_sales_id_row['product_id'];
					$get_item_id_query = "SELECT * FROM products WHERE product_id = '$get_sales_product_id'";
					$get_item_id_result = mysqli_query($conn, $get_item_id_query);
					$get_product_id_row = mysqli_fetch_assoc($get_item_id_result);	
					
					if (!empty($get_product_id_row)) {
						echo "Sales ID: ";
						echo '<span>',$get_sales_id_row['record_id'],'</span><br>';
						echo '<input name="editSalesRecordIdViewer" id="editSalesRecordIdViewer" type="number" hidden="hidden" value=',$get_sales_id_row['record_id'],'>'; /* POST to salesQuery */
						echo "Item ID: ";
						echo '<span>',$get_product_id_row['product_id'],"</span><br>";
						echo '<input name="editSalesItemId" id="editSalesItemId" type="number" hidden="hidden" value=',$get_product_id_row["product_id"],'>'; /* POST to salesQuery */
						echo "Item Name: ";
						echo '<span>',$get_product_id_row['product_name'],'</span><br>';
						echo '<input name="editSalesItemName" id="editSalesItemName" type="text" hidden="hidden" value=',$get_product_id_row["product_name"],'>';
						echo "Unit Price: $";
						echo '<span>',$get_product_id_row['price'],'</span><br>';
						echo '<input name="editSalesItemUnitPrice" id="editSalesItemUnitPrice" type="number" hidden="hidden" step="0.01" value=',$get_product_id_row["price"],'>';
						echo "Purchase Quantity: <br>";
						echo '<input name="editSalesItemQuantity" id="editSalesItemQuantity" type="number" min="1" max="999" placeholder="0" value=',$get_sales_id_row["purchase_quantity"],'><br>';
						echo "Total Price: $";
						echo '<span name="editSalesTotalPriceViewer" id="editSalesTotalPriceViewer">',$get_sales_id_row["total_price"],'</span><br>';
						echo '<input name="editSalesTotalPrice" id="editSalesTotalPrice" type="number" hidden="hidden" value=',$get_sales_id_row["total_price"],'>';
						echo '<input type="submit" name="salesEditForm" value="Edit"><br>';
					} else {
						echo "<p>Sales ID not found</p>";
					}
				}
			}
		?>
    </form><br>
	
	<p>Delete a sales record</p>
	<form id="salesFindRecordDeleteForm" method="post" action="sales.php">
        <!-- Edit/Delete action method later for php -->
        Sales ID:<br>
        <input type="text" name="deleteSalesRecordId" id="deleteSalesRecordId"><br>
        <input type="submit" name="salesFindRecordDeleteForm" value="Find"><br> 
    </form><br>
	<form id="salesDeleteForm" method="post" action="salesQuery.php">
	<?php
			/*DATABASE CONNECTION*/
			require_once("conn-settings.php");
			
			if (!$conn)
				echo "<p> Unable to connect to database!</p>";
			else {
				if(isset($_POST["deleteSalesRecordId"]))
				{
					$sales_record_id = $_POST["deleteSalesRecordId"];
					$get_sales_id_query = "SELECT * FROM records WHERE record_id = '$sales_record_id'";
					$get_sales_id_result = mysqli_query($conn, $get_sales_id_query);
					$get_sales_id_row = mysqli_fetch_assoc($get_sales_id_result);	
					$get_sales_product_id = $get_sales_id_row['product_id'];
					$get_item_id_query = "SELECT * FROM products WHERE product_id = '$get_sales_product_id'";
					$get_item_id_result = mysqli_query($conn, $get_item_id_query);
					$get_product_id_row = mysqli_fetch_assoc($get_item_id_result);	
					
					if (!empty($get_product_id_row)) {
						echo "Sales ID: ";
						echo '<span>',$get_sales_id_row['record_id'],'</span><br>';
						echo '<input name="deleteSalesRecordIdViewer" id="deleteSalesRecordIdViewer" type="number" hidden="hidden" value=',$get_sales_id_row['record_id'],'>'; /* POST to salesQuery */
						echo "Item ID: ";
						echo '<span>',$get_product_id_row['product_id'],"</span><br>";
						echo '<input name="deleteSalesItemId" id="deleteSalesItemId" type="number" hidden="hidden" value=',$get_product_id_row["product_id"],'>'; /* POST to salesQuery */
						echo "Item Name: ";
						echo '<span>',$get_product_id_row['product_name'],'</span><br>';
						echo '<input name="deleteSalesItemName" id="deleteSalesItemName" type="text" hidden="hidden" value=',$get_product_id_row["product_name"],'>';
						echo "Unit Price: $";
						echo '<span>',$get_product_id_row['price'],'</span><br>';
						echo '<input name="deleteSalesItemUnitPrice" id="deleteSalesItemUnitPrice" type="number" hidden="hidden" step="0.01" value=',$get_product_id_row["price"],'>';
						echo "Purchase Quantity: ";
						echo '<span>',$get_sales_id_row["purchase_quantity"],'</span><br>';
						echo '<input name="deleteSalesItemQuantity" id="deleteSalesItemQuantity" type="number" hidden="hidden" min="1" max="999" placeholder="0" value=',$get_sales_id_row["purchase_quantity"],'>';
						echo "Total Price: $";
						echo '<span name="deleteSalesTotalPriceViewer" id="deleteSalesTotalPriceViewer">',$get_sales_id_row["total_price"],'</span><br>';
						echo '<input name="deleteSalesTotalPrice" id="deleteSalesTotalPrice" type="number" hidden="hidden" value=',$get_sales_id_row["total_price"],'>';
						echo '<input type="submit" name="salesDeleteForm" value="Delete"><br>'; 
					} else {
						echo "<p>Sales ID not found</p><br>";
					}
				}
			}
		?>
</body>
</html>