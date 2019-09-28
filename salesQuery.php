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
		<p>New sales record added.</p>
		<?php
			/*DATABASE CONNECTION*/
			require_once("conn-settings.php");
			
			if (!$conn)
				echo "<p> Unable to connect to database!</p>";
			else {
				$query = "SELECT * FROM products";
				$result = mysqli_query($conn, $query);
				$product_id = $_POST["addSalesItemId"];
				$get_item_id_query = "SELECT * FROM products WHERE product_id = '$product_id'";
				if(isset($_POST["salesAddForm"]))
				{
					$sales_item_id = $_POST["addSalesItemId"];
					$sales_item_name = $_POST["addSalesItemName"];
					$sales_item_unit_price = $_POST["addSalesItemUnitPrice"];
					$sales_quantity = $_POST["addSalesItemQuantity"];
					$sales_total_price = $_POST["addSalesTotalPrice"];
					echo "<p>Item ID: ",$sales_item_id,"</p>";
					echo "<p>Item Name: ",$sales_item_name,"</p>";
					echo "<p>Unit Price: $",$sales_item_unit_price,"</p>";
					echo "<p>Purchase Quantity: ",$sales_quantity,"</p>";
					echo "<p>Total Price: $",$sales_total_price,"</p>";
					
					/* Update database with new sales record */
					$insert_sales_record_query = "INSERT INTO records (product_id, product_name, purchase_date, unit_price, purchase_quantity, total_price) VALUES ('$sales_item_id', '$sales_item_name', NOW(), '$sales_item_unit_price', '$sales_quantity', '$sales_total_price')";
					$insert_sales_record_result = mysqli_query($conn, $insert_sales_record_query);
					if (!$insert_sales_record_result)
					{
						echo("Error description: " . mysqli_error($conn));
					}
				}
				else if(isset($_POST["salesEditForm"]))
				{
					
				}
				else if(isset($_POST["salesDeleteForm"]))
				{
					
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

