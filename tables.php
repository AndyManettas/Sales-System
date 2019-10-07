<?php
require_once('settings.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT products.product_id, products.product_name, products.quantity AS stock_level, products.price, SUM(purchase_quantity) as units_sold, SUM(total_price) as total_revenue, records.purchase_date AS date_sold FROM products LEFT JOIN records ON records.product_id = products.product_id WHERE NOW() - INTERVAL 7 DAY GROUP BY products.product_id ORDER BY total_revenue DESC";

$result = mysqli_query($conn, $sql);

if (isset($_POST["submit-button"]) && !empty($_POST["input-name"]) && !empty($_POST["input-price"]) && !empty($_POST["input-qty"])) {
    $output = '';
    $item_name = trim($_POST["input-name"]);
    $item_price = trim($_POST["input-price"]);
	$item_qty = trim($_POST["input-qty"]);
	
    $add_query = "INSERT INTO products (product_name, price, quantity) VALUES ('$item_name', '$item_price', '$item_qty')";
    
    $add_query_result = mysqli_query($conn, $add_query);
    if(mysqli_affected_rows($conn) > 0)
    {
        $output = 'Product added!';
    }
    else
    {
        $output = 'Error adding product';
    }
	
	header("Refresh:0");
	echo "<script type='text/javascript'>alert('$output');</script>";
}

if (isset($_POST["update-button"]) && isset($_POST["productName"])) {
    $output = '';
    $product_name = $_POST["productName"];
    $product_price = $_POST["priceId"];
	$product_stock = $_POST["stockId"];
	$product_code = $_POST["codeId"];
	
    $update_query = "UPDATE products SET product_name='$product_name', price='$product_price', quantity='$product_stock' WHERE product_id='$product_code'";
    
    $update_result = mysqli_query($conn, $update_query);
    if(mysqli_affected_rows($conn) > 0)
    {
        $output = 'Product updated!';
    }
    else
    {
        $output = 'Error Updating';
    }
    
    header("Refresh:0");
	echo "<script type='text/javascript'>alert('$output');</script>";
}

if (isset($_POST["delete-button"])) {
    $delete_output = '';
	$product_code_delete = $_POST["codeId"];
	
	$delete_records_query = "DELETE FROM records WHERE product_id='$product_code_delete'";
	
	$delete_records_result = mysqli_query($conn, $delete_records_query);
	
    $delete_query = "DELETE FROM products WHERE product_id='$product_code_delete'";
    
    $delete_result = mysqli_query($conn, $delete_query);
    if(mysqli_affected_rows($conn) > 0)
    {
        $delete_output = 'Product deleted';
    }
    else
    {
        $delete_output = 'Error Deleting';
    }
    
    header("Refresh:0");
	echo "<script type='text/javascript'>alert('$delete_output');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Argon Dashboard - Free Dashboard for Bootstrap 4 by Creative Tim
  </title>
  <!-- Favicon -->
  <link href="assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>

<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
        aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="index.html">
        <img src="assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right"
            aria-labelledby="navbar-default_dropdown_1">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="assets/img/theme/profile.jpg">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>Settings</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-calendar-grid-58"></i>
              <span>Activity</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-support-16"></i>
              <span>Support</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#!" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item  class=" active" ">
          <a class=" nav-link " href="index.php"> <i class="ni ni-tv-2 text-primary"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  active " href="tables.php">
              <i class="ni ni-bullet-list-67 text-red"></i> Inventory
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="sales.php">
              <i class="ni ni-money-coins text-green"></i> Sales
            </a>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="index.html">Inventory</a>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="assets/img/theme/profile.jpg">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold">Robert Smith</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>
              <a href="examples/profile.html" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>My profile</span>
              </a>
              <a href="examples/profile.html" class="dropdown-item">
                <i class="ni ni-settings-gear-65"></i>
                <span>Settings</span>
              </a>
              <a href="examples/profile.html" class="dropdown-item">
                <i class="ni ni-calendar-grid-58"></i>
                <span>Activity</span>
              </a>
              <a href="examples/profile.html" class="dropdown-item">
                <i class="ni ni-support-16"></i>
                <span>Support</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#!" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-andy-8">
    </div>
    <div class="container-fluid mt--7">
      <!-- Table -->
            <div class="row andygap">
        <div class="col-xl-12 order-xl-1">
          <div class="card bg-secondary shadow">
            <form id="table-form" method="post" action="tables.php">
                <div class="card-header bg-white border-0">
                  <div class="row">
                    <div class="col-10">
                      <h3 class="mb-0">Add Product</h3>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-name">Product Name</label>
                          <input type="text" id="input-name" name="input-name" class="form-control form-control-alternative" placeholder="Enter product name...">
                          <div id="productList"></div>
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label class="form-control-label" for="input-price">Price ($)</label>
                          <input type="text" id="input-price" name="input-price" class="form-control form-control-alternative" placeholder="$">
                        </div>
                      </div>
                        <div class="col-lg-1">
                        <div class="form-group">
                          <label class="form-control-label" for="input-qty">Stock</label>
                          <input type="text" id="input-qty" name="input-qty" class="form-control form-control-alternative" placeholder="Qty" value="1">
                          <div class="column">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group marginme">
                          <button class="btn btn-primary" id="submit-button" name="submit-button" type="submit">Add</button>
                        </div>
                      </div>
                    </div>
                </div>
                </div>
            </form>
          </div>
        </div>
        </div>
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
                <!-- Search Form -->
              <form id="myForm" class="navbar-search navbar-search-light form-inline">
                <div class="form-group mb-0">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control" name="search" id="search" placeholder="Search" type="text">
                  </div>
                </div>
              </form>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="product_table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Price ($)</th>
                    <th scope="col">Stock Level</th>
                    <th scope="col">Units Sold</th>
                    <th scope="col">Revenue ($)</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
<?php
$og_product = '';
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
                  echo '<tr>'
                    . '<th scope="row"><span class="mb-0 text-sm">' . $row["product_name"]. '</span></th>'
                    . '<td>' . $row["price"]. '</td>'
                    . '<td>' . $row["stock_level"]. '</td>';
                    if (is_null($row["units_sold"]) || is_null( $row["total_revenue"]))
                        echo '<td>' . 0 . '</td>'
                    . '<td>' . 0 . '</td>';
                    else
                        echo '<td>' . $row["units_sold"] . '</td>'
                        . '<td>' . $row["total_revenue"] . '</td>';
                    if ($row["stock_level"] == 0) {
                        echo '<td><span class="badge badge-dot"><i class="bg-danger"></i> out of stock</span></td>';
                    } else if ($row["stock_level"] <= 15) {
                        echo '<td><span class="badge badge-dot"><i class="bg-warning"></i> low</span></td>';
                    } else if ($row["stock_level"] > 15 && $row["stock_level"] <= 35) {
                        echo '<td><span class="badge badge-dot"><i class="bg-info"></i> moderate</span></td>';
                    }  else if ($row["stock_level"] > 35) {
                        echo '<td><span class="badge badge-dot"><i class="bg-success"></i> high</span></td>';
                    }
                    echo '<td class="text-right">'
                    . '<div class="dropdown">'
                        . '<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                            . '<i class="fas fa-ellipsis-v"></i>'
                        . '</a>'
                        . '<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">'
                            . '<a class="open-modal-form dropdown-item" data-toggle="modal" href="#modal-form" data-product="'.$row["product_name"].'" data-price="'.$row["price"].'" data-stock="'.$row["stock_level"].'" data-code="'.$row["product_id"].'">Edit</a>'
                        . '</div>'
                    . '</div>'
                . '</td>'
            . '</tr>';
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-body px-lg-5 py-lg-5">
                          <div class="text-center text-muted mb-4">
                            <h1 class="mb-0">Edit Item</h1>
                          </div>
                          <form id="ModalForm" action="" method="post" role="form">
                            <div class="form-group mb-3">
                              <div class="modal-body-find input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-app"></i></span>
                                </div>
                                <input name="productName" id="productName" class="form-control" placeholder="Product" type="text">
                                <input name="codeId" id="codeId" class="form-control" placeholder="code" type="hidden">
                              </div>
                            </div>
                            <div class="form-group mb-3">
                              <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-money-coins"></i></span>
                                </div>
                                <input name="priceId" id="priceId" class="form-control" placeholder="Price" type="text">
                              </div>
                            </div>
                            <div class="form-group mb-3">
                              <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-sound-wave"></i></span>
                                </div>
                                <input name="stockId" id="stockId" class="form-control" placeholder="Stock Level" type="text">
                              </div>
                            </div>
                            <div class="text-center">
                              <button id="update-button" name="update-button" type="submit" class="btn btn-info my-4">Update</button>
                              <button id="delete-button" name="delete-button" type="submit" class="btn btn-danger my-4">Delete Product</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer">
    </footer>
</div>
</div>
  <!--   Core   -->
  <script src="assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
  </script>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#search').keyup(function(){
            search_table($(this).val());
        });
        
        function search_table(value){
            $('#product_table tr').each(function(){
                var found = 'false';
                $(this).each(function(){
                    if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
                        found = 'true';
                    }
                    if($(this).text().toLowerCase().indexOf('item') >= 0) {
                        found = 'true';
                    }
                });
                if(found == 'true') {
                    $(this).show();
                }
                else {
                    $(this).hide();
                }
            });
            
            $('#product_table th').show();
        }
    });
    
$(document).on("click", ".open-modal-form", function () {
    var myProductName = $(this).data('product');
    $(".modal-body #productName").val(myProductName);
    var myPrice = $(this).data('price');
    $(".modal-body #priceId").val(myPrice);
    var myStock = $(this).data('stock');
    $(".modal-body #stockId").val(myStock);
    var myCode = $(this).data('code');
    $(".modal-body #codeId").val(myCode);
});
</script>