<?php
require_once('settings.php');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT products.product_id, records.purchase_date AS date_sold, products.product_name, records.purchase_quantity AS quantity_sold, records.total_price AS revenue FROM products INNER JOIN records ON records.product_id = products.product_id WHERE NOW() - INTERVAL 1 DAY ORDER BY purchase_date DESC";

$result = mysqli_query($conn, $sql);

if (isset($_POST["submit-button"]) && !empty($_POST["input-name"]) && !empty($_POST["input-price"]) && !empty($_POST["input-qty"])) {
    $output = '';
    $sales_item_name = $_POST["input-name"];
    $sales_item_id = 0;
    $sales_item_unit_price = $_POST["input-price"];
	$sales_quantity = $_POST["input-qty"];
	$sales_total_price = $sales_item_unit_price * $sales_quantity;
	
    $get_item_id_query = "SELECT * FROM products WHERE product_name = '$sales_item_name'";
    
    $id_query_result = mysqli_query($conn, $get_item_id_query);
    if(mysqli_num_rows($id_query_result) > 0)
    {
        while($row = mysqli_fetch_array($id_query_result))
        {
            $sales_item_id = $row["product_id"];
            $output = $sales_item_name .' added!';
        }
    }
    else
    {
        $output = 'Product not found';
    }
    
    $insert_sales_record_query = "INSERT INTO records (product_id, purchase_date, purchase_quantity, total_price) VALUES ('$sales_item_id', NOW(), '$sales_quantity', '$sales_total_price')";
    $insert_sales_record_result = mysqli_query($conn, $insert_sales_record_query);
    $update_product_quantity_query = "UPDATE products SET quantity=quantity-'$sales_quantity' WHERE product_id='$sales_item_id'";
	$update_product_quantity_result = mysqli_query($conn, $update_product_quantity_query);
	if (!$insert_sales_record_result || !$update_product_quantity_result)
	{
		$output .= " and the sale has not been added";
	}
	
	header("Refresh:0");
	echo "<script type='text/javascript'>alert('$output');</script>";
}

// if (isset($_POST["update-button"]) && isset($_POST["productName"])) {
//     $output = '';
//     $product_name = $_POST["productName"];
//     $product_name = $_POST["dateId"];
// 	$product_qty = $_POST["qtyId"];
// 	$product_code = $_POST["codeId"];
	
//     $update_query = "UPDATE records SET product_name='$product_name', price='$product_price', quantity='$product_stock' WHERE product_id='$product_code'";
    
//     $update_result = mysqli_query($conn, $update_query);
//     if(mysqli_affected_rows($conn) > 0)
//     {
//         $output = 'Product updated!';
//     }
//     else
//     {
//         $output = 'Error Updating';
//     }
    
//     header("Refresh:0");
// 	echo "<script type='text/javascript'>alert('$output');</script>";
// }

if (isset($_POST["delete-button"])) {
    $delete_output = '';
	$product_code = $_POST["codeId"];
	
	$delete_query = "DELETE FROM records WHERE product_id='$product_code'";
	
	$deletion_result = mysqli_query($conn, $delete_query);

    if(mysqli_affected_rows($conn) > 0)
    {
        $delete_output = 'Record deleted';
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
    SalesDash by SalesForce
  </title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap.3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap.3.3.6/js/bootstrap.min.js"></script>
  <!-- Ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <!-- Favicon -->
  <link href="assets/img/brand/favicon.png" rel="icon" type="image/png" />
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Icons -->
  <link href="assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />
  <style>
      form ul {
          cursor:pointer;
          background-color:white;
      }
      form li {
          padding:12px;
      }
      
  </style>
</head>

<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="index.html">
        <img src="assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
      </a>
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
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
                <img alt="Image placeholder" src="assets/img/theme/team-1-800x800.jpg">
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
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="index.html">
                <img src="assets/img/brand/blue.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item  class=" active" ">
          <a class=" nav-link " href=" index.php"> <i class="ni ni-tv-2 text-primary"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="tables.php">
              <i class="ni ni-bullet-list-67 text-red"></i> Inventory
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="sales.html">
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
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="index.html">Sales</a>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="./assets/img/theme/profile.jpg">
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
              <a href="../examples/profile.html" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>My profile</span>
              </a>
              <a href="../examples/profile.html" class="dropdown-item">
                <i class="ni ni-settings-gear-65"></i>
                <span>Settings</span>
              </a>
              <a href="../examples/profile.html" class="dropdown-item">
                <i class="ni ni-calendar-grid-58"></i>
                <span>Activity</span>
              </a>
              <a href="../examples/profile.html" class="dropdown-item">
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
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row andygap">
        <div class="col-xl-12 order-xl-1">
          <div class="card bg-secondary shadow">
            <form id="sales-form" method="post" action="sales.php">
                <div class="card-header bg-white border-0">
                  <div class="row">
                    <div class="col-10">
                      <h3 class="mb-0">Add Sale</h3>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-name">Product Name</label>
                          <input type="text" id="input-name" name="input-name" class="form-control form-control-alternative" placeholder="Enter product here...">
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
                          <label class="form-control-label" for="input-qty">Qty</label>
                          <input type="number" id="input-qty" name="input-qty" class="form-control form-control-alternative" placeholder="Enter quantity..." value="1">
                          <div class="column">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group marginme">
                          <button class="btn btn-primary" id="submit-button" name="submit-button" type="submit">Add Sale</button>
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
            <div class="card-header bg-white border-0">
                <form method="post" action="export.php">
              <div class="row">
                <div class="col-8 alignings">
                  <h3 class="mb-0 aligner">Sales Records</h3>
                </div>
                <div class="col-2 text-right">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input type="date" class="form-control datepicker" name="start_date" id="start_date" placeholder="Select date">
                        </div>
                </div>
                </form>
                <div class="col-2 text-right">
                        <button type="submit" name="export" class="btn btn-icon btn-3 btn-primary" >
                            <span class="btn-inner--icon"><i class="ni ni-chart-bar-32"></i></span>
                             <span class="btn-inner--text">CSV Export</span>
                        </button>
                </div>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="sales_table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Product</th>
                    <th scope="col">Qty Sold</th>
                    <th scope="col">Revenue ($)</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo '<tr>'
                        . '<th scope="row"><span class="mb-0 text-sm">' . $row["date_sold"] . '</span></th>'
                        . '<td>' . $row["product_name"] . '</td>'
                        . '<td>' . $row["quantity_sold"] . '</td>'
                        . '<td>' . $row["revenue"] . '</td>'
                        . '<td class="text-right">'
                        . '<div class="dropdown">'
                        . '<a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                        . '<i class="fas fa-ellipsis-v"></i>'
                        . '</a>'
                        . '<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">'
                            . '<a class="open-modal-form dropdown-item" data-toggle="modal" href="#modal-form" data-product="'.$row["product_name"].'" data-date="'.$row["date_sold"].'" data-qty="'.$row["quantity_sold"].'" data-code="'.$row["product_id"].'">Edit</a>'
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
                            <h1 class="mb-0">Edit Sale</h1>
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
                                  <span class="input-group-text"><i class="ni ni-sound-wave"></i></span>
                                </div>
                                <input name="qtyId" id="qtyId" class="form-control" placeholder="Stock Level" type="text">
                              </div>
                            </div>
                            <div class="form-group mb-3">
                              <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                <input name="dateId" id="dateId" class="form-control" placeholder="Date" type="text">
                              </div>
                            </div>
                            <div class="text-center">
                              <button id="update-button" name="update-button" type="submit" class="btn btn-info my-4">Update</button>
                              <button id="delete-button" name="delete-button" type="submit" class="btn btn-danger my-4">Delete Sale</button>
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
        $('#input-name').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                $.ajax({
                    url:"search.php",
                    method:"POST",
                    data:{query:query},
                    success:function(data)
                    {
                        $('#productList').fadeIn();
                        $('#productList').html(data);
                    }
                });
            }
            else {
                $('#productList').fadeOut();
                $('#productList').html("");
            }
        });
        $(document).on('click', 'li', function(){
            $('#input-name').val($(this).text());
            $('#productList').fadeOut();
            var name = $(this).text();
            $.post('price.php', {name: name}, function(data){
                $('#input-price').val(data);
            });
        });
    });
    
    $(document).ready(function() {
        $('#select-date').keyup(function(){
            search_table($(this).val());
        });
        
        function search_table(value){
            $('#sales_table tr').each(function(){
                var found = 'false';
                $(this).each(function(){
                    if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
                        found = 'true';
                    }
                    if($(this).text().toLowerCase().indexOf('date') >= 0) {
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
            
            $('#sales_table th').show();
        }
    });


        
$(document).on("click", ".open-modal-form", function () {
    var myProductName = $(this).data('product');
    $(".modal-body #productName").val(myProductName);
    var myDate = $(this).data('date');
    $(".modal-body #dateId").val(myDate);
    var myQty = $(this).data('qty');
    $(".modal-body #qtyId").val(myQty);
    var myCode = $(this).data('code');
    $(".modal-body #codeId").val(myCode);
});
</script>