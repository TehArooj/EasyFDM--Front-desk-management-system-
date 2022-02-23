<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $role_id = 2;
  $root_url = "../admin/";
  $page_name = "index.php";
  $page_section = 0;
  $page_url = $root_url . $page_name;

  // Security check
  if($_SESSION['role_id'] > $role_id) {
    header('location:  ../login.php');
  }

  // Select New Booking data.
  $newBooking = 0;
  $query = "SELECT BOOKING_ID FROM booking WHERE STATUS = '1'" ;
  $results = mysqli_query($db, $query);
  $newBooking = mysqli_num_rows($results);

  // Select Total Checkins data.
  $totalcheckins = 0;
  $query = "SELECT BOOKING_ID FROM booking WHERE STATUS = '3'" ;
  $results = mysqli_query($db, $query);
  $totalcheckins = mysqli_num_rows($results);

  // Select Billing data.
  $totalBilling = 0;
  $query = "SELECT AMOUNT FROM bill";
  $results = mysqli_query($db, $query);
  if (mysqli_num_rows($results) > 0 ) {
    while($obj = mysqli_fetch_object($results)){
        $totalBilling = $totalBilling + $obj->AMOUNT;
    }
  }

  // Select Total Checkins data.
  $totalcheckouts = 0;
  $query = "SELECT BOOKING_ID FROM booking WHERE STATUS = '8'" ;
  $results = mysqli_query($db, $query);
  $totalcheckouts = mysqli_num_rows($results);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    
    <!-- Include style sheets -->
    <?php include("styles.php"); ?>

</head>


<body class="sidebar-mini layout-fixed control-sidebar-open" style="height: auto;">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include("../navbar.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("sidebar.php"); ?>
        <!-- /.sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 725px;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo $newBooking?></h3>

                                    <p>New Bookings</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="<?php echo $root_url.'fd_bookings.php' ?>" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php echo $totalcheckins?></h3>

                                    <p>Current Check-Ins</p>
                                </div>

                                <div class="icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <a href="<?php echo $root_url.'fd_checkins.php' ?>" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>Rs.<?php echo $totalBilling?></h3>

                                    <p>Total Billing</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <a href="<?php echo $root_url.'ac_bills.php' ?>" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo $totalcheckouts?></h3>

                                    <p>Total Check-Outs</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-running"></i>
                                </div>
                                <a href="<?php echo $root_url.'fd_checkouts.php' ?>" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->

                        <!-- right col -->
                        <section class="container-fluid">
                            <!-- STACKED BAR CHART -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Accounting Analysis</h3>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="stackedBarChart" style="height:330px; min-height:300px"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </section>
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            Semester Project - <a href="https://pucit.edu.pk/" target="_blank">PUCIT</a>.
        </footer>


        <!-- /.control-sidebar -->
    </div>

    <!-- Include JavaScript plugins -->
    <?php include('commonjs.php'); ?>
    <!-- AdminLTE dashboard -->
    <script src="dist/js/pages/dashboard.js"></script>

    <!-- Include Charting plugins -->
    <?php include('chartjs.php'); ?>

    <?php
        // Select SALES data FOR GRAPH.
        $query = "SELECT T.M AS MONTH, SUM(T.AMOUNT) AS SALE 
        FROM (
            SELECT 1 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 2 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 3 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 4 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 5 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 6 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 7 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 8 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 9 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 10 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 11 AS M, 0 AS AMOUNT
            UNION ALL
            SELECT 12 AS M, 0 AS AMOUNT
            UNION ALL                
            SELECT MONTH(BILL_DATE) AS M, SUM(AMOUNT) AS AMOUNT
            FROM bill 
            GROUP BY M
        ) AS T
        GROUP BY T.M" ;

        $results = mysqli_query($db, $query);
        // $row = mysqli_num_rows($results)
        // $salesArray = mysqli_fetch_array($results, MYSQLI_NUM);
    ?>

    <!-- Scripts for charts.  -->
    <script>
        var salesArray = new Array();
        <?php  while($row = mysqli_fetch_array($results)) {?>
            salesArray.push('<?php echo $row[1] ?>');
            // alert(pausecontent);
        <?php } ?>

        <?php
            // Select SALES data FOR GRAPH.
            $query = "SELECT T.M AS MONTH, SUM(T.AMOUNT) AS SALE 
            FROM (
                SELECT 1 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 2 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 3 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 4 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 5 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 6 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 7 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 8 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 9 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 10 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 11 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 12 AS M, 0 AS AMOUNT
                UNION ALL                
                SELECT MONTH(PAYMENT_DATE) AS M, SUM(AMOUNT) AS AMOUNT
                FROM payment 
                GROUP BY M
            ) AS T
            GROUP BY T.M" ;

            $results = mysqli_query($db, $query);
            // $row = mysqli_num_rows($results)
            // $salesArray = mysqli_fetch_array($results, MYSQLI_NUM);
        ?>

    var paymentsArray = new Array();
        <?php  while($row = mysqli_fetch_array($results)) {?>
            paymentsArray.push('<?php echo $row[1] ?>');
            // alert(pausecontent);
        <?php } ?>

        <?php
            // Select SALES data FOR GRAPH.
            $query = "SELECT T.M AS MONTH, SUM(T.AMOUNT) AS SALE 
            FROM (
                SELECT 1 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 2 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 3 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 4 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 5 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 6 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 7 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 8 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 9 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 10 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 11 AS M, 0 AS AMOUNT
                UNION ALL
                SELECT 12 AS M, 0 AS AMOUNT
                UNION ALL                
                SELECT MONTH(RECEIPT_DATE) AS M, SUM(AMOUNT) AS AMOUNT
                FROM receipt 
                GROUP BY M
            ) AS T
            GROUP BY T.M" ;

            $results = mysqli_query($db, $query);
            // $row = mysqli_num_rows($results)
            // $salesArray = mysqli_fetch_array($results, MYSQLI_NUM);
        ?>

    var receiptsArray = new Array();
        <?php  while($row = mysqli_fetch_array($results)) {?>
            receiptsArray.push('<?php echo $row[1] ?>');
            // alert(pausecontent);
        <?php } ?>

        

    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');
    var stackedBarChartData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept',
            'Oct', 'Nov', 'Dec'
        ],
        datasets: [{
                label: 'Sale',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: salesArray
            },
            {
                label: 'Payment',
                backgroundColor: 'rgba(210, 214, 222, 1)',
                borderColor: 'rgba(210, 214, 222, 1)',
                pointRadius: false,
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: paymentsArray
            },
            {
                label: 'Reciept',
                backgroundColor: 'rgb(255, 193, 7)',
                borderColor: 'rgba(210, 214, 222, 1)',
                pointRadius: false,
                pointColor: 'rgba(210, 214, 222, 1)',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data: receiptsArray
            }
        ],
    }
    var stackedBarChartOptions = {

        responsive: true,
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                stacked: true,
            }],
            yAxes: [{
                stacked: true
            }]
        }
    }

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
        type: 'bar',
        data: stackedBarChartData,
        options: stackedBarChartOptions
    })
    </script>

</body>
</html>




