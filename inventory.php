<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Inventory" />
    <meta name="keywords" content="PHP, Javascript, HTML5, CSS, XML" />
    <meta name="author" content="Salesforce DP2" />

    <title>Inventory</title>

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
        <h1>Inventory</h1>
		<?php
			/*DATABASE CONNECTION*/
			require_once("conn-settings.php");
			
			if (!$conn)
				echo "<p> Unable to connect to database!</p>";
			else {
				$query = "SELECT * FROM products";
				$result = mysqli_query($conn, $query);
				if (mysqli_num_rows($result) == 0)
					echo "<p> There is no data to display</p>";
				else {
					echo "<table border=1>";
					echo "<tr><th>Product ID</th><th>Product name</th><th>Price</th><th>Qty</th><th>Expired Date</th></tr>";
					while ($row = mysqli_fetch_array($result)) {
						echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr>";
					}
					echo "</table>";
				}
			}
		?>
    </div>
    <!-- end of wrapper div -->
</body>

</html>

