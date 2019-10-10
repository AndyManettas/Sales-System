<?php
require_once('settings.php');

session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: login.php");
    die();
}

// storing logged in user from session
$user_check = $_SESSION['login_user'];
// query to check if user exists in database
$session_query = "SELECT * FROM users WHERE username='$user_check'";
// performing query
$session_result = @mysqli_query($conn, $session_query);
// fetching result row
$row = mysqli_fetch_assoc($session_result);
// storing value from user column into variable
$login_session = $row['username'];
// returning user to login page and terminating script

$no_sales_query = "SELECT purchase_date, SUM(total_price) as 'total_price' FROM records, (SELECT DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY) as START_DATE) as start_date WHERE purchase_date BETWEEN start_date.START_DATE AND start_date.START_DATE + INTERVAL 7 DAY GROUP BY purchase_date";
$no_sales_result = mysqli_query($conn, $no_sales_query);

$no_sales_rows = mysqli_num_rows($no_sales_result);

$temp = array_fill(0, 7, 0);
$i = 0;
while ($array = mysqli_fetch_assoc($no_sales_result)) {
  $temp[$i] = $array['total_price'];
  $i = $i + 1;
  }
 

$day = 7;
$prev = 0;
$temp2 = array_fill(0, 4, 0);
$i = 0;
while ($day <= 28) {
    $query = "SELECT SUM(total_price) as 'total_price' FROM records WHERE MONTH(purchase_date) = MONTH(NOW()) AND DAY(purchase_date) <= $day AND DAY(purchase_date) > $prev";
    $result = mysqli_query($conn, $query);
    $array = mysqli_fetch_assoc($result);
    $temp2[$i] = $array['total_price'];
    if (is_null($temp2[$i]))
        $temp2[$i] = 0;
    $i = $i + 1;
    $prev = $day;
    $day = $day + 7;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Sales System by Salesforce
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
            <a href="examples/profile.html" class="dropdown-item">
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
            <a href="logout.php" class="dropdown-item">
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
          <a class=" nav-link active " href="index.php"> <i class="ni ni-tv-2 text-primary"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="tables.php">
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
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./index.html">Dashboard</a>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">
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
              <a href="logout.php" class="dropdown-item">
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
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Sales Prediction</h5>
                      <span class="h2 font-weight-bold mb-0">$774</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-chart-bar"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Till next week</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                      <span class="h2 font-weight-bold mb-0">115</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-chart-pie"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
                    <span class="text-nowrap">Since yesterday</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Customers</h5>
                      <span class="h2 font-weight-bold mb-0">301</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                    <span class="text-nowrap">Since last week</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>
                      <span class="h2 font-weight-bold mb-0">49,65%</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-percent"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                    <span class="text-nowrap">Since last month</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-8 mb-5 mb-xl-0">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row">
                <div class="col-9">
                  <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                  <h2 class="mb-0 Aligner">Weekly Sales</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <!-- Chart wrapper -->
                <canvas id="chart-sales" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card shadow">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                  <h2 class="mb-0">Monthly Sales</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <canvas id="chart-orders" class="chart-canvas"></canvas>
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
  <script src="./assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="./assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <script src="./assets/js/plugins/chart.js/dist/Chart.min.js"></script>
  <script src="./assets/js/plugins/chart.js/dist/Chart.extension.js"></script>
  <!--   Argon JS   -->
  <script src="./assets/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
  </script>
  <script>
  OrdersChart = (function() {
    var e,
      a,
      t = $("#chart-orders");
    $('[name="ordersSelect"]');
    t.length &&
      ((e = t),
      (a = new Chart(e, {
        type: "bar",
        options: {
          scales: {
            yAxes: [
              {
                gridLines: {
                  lineWidth: 1,
                  color: "#dfe2e6",
                  zeroLineColor: "#dfe2e6"
                },
                ticks: {
                  callback: function(e) {
                    if (!(e % 10)) return e;
                  }
                }
              }
            ]
          },
          tooltips: {
            callbacks: {
              label: function(e, a) {
                var t = a.datasets[e.datasetIndex].label || "",
                  o = e.yLabel,
                  n = "";
                return (
                  1 < a.datasets.length &&
                    (n +=
                      '<span class="popover-body-label mr-auto">' +
                      t +
                      "</span>"),
                  (n += '<span class="popover-body-value">' + o + "</span>")
                );
              }
            }
          }
        },
        data: {
          labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
          datasets: [{ label: "Sales", data: [<?php echo json_encode($temp2[0]) . "," . json_encode($temp2[1]) . "," . json_encode($temp2[2]) . "," . json_encode($temp2[3]); ?>] }]
        }
      })),
      e.data("chart", a));
  })(),
  SalesChart = (function() {
    var e,
      a,
      t = $("#chart-sales");
    t.length &&
      ((e = t),
      (a = new Chart(e, {
        type: "line",
        options: {
          scales: {
            yAxes: [
              {
                gridLines: {
                  lineWidth: 1,
                  color: Charts.colors.gray[900],
                  zeroLineColor: Charts.colors.gray[900]
                },
                ticks: {
                  callback: function(e) {
                    if (!(e % 10)) return "$" + e + "k";
                  }
                }
              }
            ]
          },
          tooltips: {
            callbacks: {
              label: function(e, a) {
                var t = a.datasets[e.datasetIndex].label || "",
                  o = e.yLabel,
                  n = "";
                return (
                  1 < a.datasets.length &&
                    (n +=
                      '<span class="popover-body-label mr-auto">' +
                      t +
                      "</span>"),
                  (n += '<span class="popover-body-value">$' + o + "k</span>")
                );
              }
            }
          }
        },
        data: {
          labels: ["Mon", "Tue", "Wed", "Thur", "Fri", "Sat", "Sun"],
          datasets: [
            { label: "Performance", data: [<?php echo json_encode($temp[0]) . "," . json_encode($temp[1]) . "," . json_encode($temp[2]) . "," . json_encode($temp[3]) . "," . json_encode($temp[4]) . "," . json_encode($temp[5]) . "," . json_encode($temp[6]); ?>] }
          ]
        }
      })),
      e.data("chart", a));
  })();
  </script>
</body>

</html>