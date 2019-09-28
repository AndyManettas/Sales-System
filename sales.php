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
	
	<form id="salesFindIdForm" method="post" action="sales.php">
        <!-- Sales Record ID and Sales Item ID are different. Record ID represents each transaction/record. Record ID can be handled by the database -->
		Item ID:<br>
        <input type="text" name="addSalesItemId" id="addSalesItemId"><br>
		<input type="submit" name="salesFindIdForm" value="Find"><br>
	</form><br>
	
	<form id="salesAddForm" method="post" action="salesQuery.php">
		<?php
			/*DATABASE CONNECTION*/
			require_once("conn-settings.php");
			
			if (!$conn)
				echo "<p> Unable to connect to database!</p>";
			else {
				$query = "SELECT * FROM products";
				$result = mysqli_query($conn, $query);
				if(isset($_POST["addSalesItemId"]))
				{
					$product_id = $_POST["addSalesItemId"];
					$get_item_id_query = "SELECT * FROM products WHERE product_id = '$product_id'";
					$get_item_id_result = mysqli_query($conn, $get_item_id_query);
					$get_product_id_row = mysqli_fetch_assoc($get_item_id_result);	
					
					echo "Item ID: ";
					echo '<span>',$get_product_id_row['product_id'],"</p>";
					echo '<input name="addSalesItemId" id="addSalesItemId" type="number" hidden="hidden" value=',$get_product_id_row["product_id"],'>'; /* POST to salesQuery */
					echo "Item Name: ";
					echo '<span>',$get_product_id_row['product_name'],'</p>';
					echo '<input name="addSalesItemName" id="addSalesItemName" type="text" hidden="hidden" value=',$get_product_id_row["product_name"],'>';
					echo "Unit price: $";
					echo '<span>',$get_product_id_row['price'],'</span><br>';
					echo '<input name="addSalesItemUnitPrice" id="addSalesItemUnitPrice" type="number" hidden="hidden" step="0.01" value=',$get_product_id_row["price"],'>';
				} else {
					echo "<p> in else </p><br>";
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
	<form id="salesEditForm" method="post" action="salesQuery.php">
        <!-- Edit/Delete action method later for php -->
		Sales ID:<br>
		<input type="text" name="editSalesRecordId" id="editSalesRecordId"><br>
        Item ID:<br>
        <input type="text" name="editSalesItemId" id="editSalesItemId"><br>
        Item name:<br>
        <input type="text" name="editSalesItemName id="editSalesItemName"><br>
        Unit Price:<br>
        <input type="number" name="editSalesItemUnitPrice" id="editSalesItemUnitPrice" min="0.00" max="10000.00" step="0.01" placeholder="0.00"/><br>
        Quantity:<br>
        <input type="number" name="editSalesItemQuantity" id="editSalesItemQuantity" min="1" max="999" placeholder="0"><br>
        Total price: $<span name="editSalesTotalPrice" id="editSalesTotalPrice"></span><br> <!-- JS performs calculation for total price -->
	
        <input type="submit" name="salesEditForm" value="Edit"><br> <!-- Does nothing for now -->
    </form><br>
	
	<p>Delete a sales record</p>
	<form id="salesDeleteForm" method="post" action="salesQuery.php">
        <!-- Edit/Delete action method later for php -->
        Sales ID:<br>
        <input type="text" name="deleteSalesRecordId" id="deleteSalesRecordId"><br>
        <input type="submit" name="salesDeleteForm" value="Delete"><br> <!-- Does nothing for now -->
    </form><br>
</body>
</html>