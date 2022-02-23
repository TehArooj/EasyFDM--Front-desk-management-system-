<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 2;
  $root_url = "../admin/";
  $page_name = "rpt_receiptsSummary.php";
  $page_section = 2;
  $page_url = $root_url . $page_name;

  // Security check
  if($_SESSION['role_id'] > $role_id) {
    header('location:  ../login.php');
  }

  // Select for summary grid.
  $query = "SELECT c.DESCRIPTION,  SUM(b.AMOUNT) AS AMOUNT
            FROM receipt b, charge_code c
            WHERE b.CHARGE_ID = c.CHARGE_ID
            GROUP BY c.DESCRIPTION
            ORDER BY c.DESCRIPTION";
  $summary = mysqli_query($db, $query);

  if ( mysqli_num_rows($summary) <= 0) {
      array_push($errors, "No data found for summary.");
  }    

  // Select for detail grid.
  $query = "SELECT r.ROOM_NO, k.BOOKING_NO, k.NAME, c.DESCRIPTION,  SUM(b.AMOUNT) AS AMOUNT
            FROM receipt b, booking k, charge_code c, room r
            WHERE b.BOOKING_ID = k.BOOKING_ID
                AND k.ROOM_ID = r.ROOM_ID
                AND b.CHARGE_ID = c.CHARGE_ID
            GROUP BY r.ROOM_NO, k.BOOKING_NO, k.NAME, c.DESCRIPTION
            ORDER BY r.ROOM_NO, c.DESCRIPTION";
  $results = mysqli_query($db, $query);

  if ( mysqli_num_rows($results) <= 0) {
      array_push($errors, "No data found for details.");
  }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Receipt Summary</title>

    <?php include('styles.php'); ?>

</head>

<body class="sidebar-mini layout-fixed control-sidebar-open" style="height: auto;">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include('../navbar.php'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 725px;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Receipt Summary</h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-5">

                        <div class="card">
                            <h3 class="card-title">
                                <div class="input-group mb-1">
                                    <?php include('../errors.php'); ?>
                                </div>
                            </h3>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tblSummary" class="table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>Item / Charge</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if (mysqli_num_rows($summary) > 0 ) {
                                                while($row = mysqli_fetch_array($summary)){
                                                    echo "<tr>";
                                                    echo "<td>".$row[0]."</td>";
                                                    echo "<td>".$row[1]."</td>";
                                                    echo "</tr>";
                                                    
                                                    }
                                    
                                                }                        
                                                ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="col-7">

                        <div class="card">
                            <h3 class="card-title">
                                <div class="input-group mb-1">
                                    <?php include('../errors.php'); ?>
                                </div>
                            </h3>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tblList" class="table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>Room No.</th>
                                                <th>Booking No.</th>
                                                <th>Guest Name</th>
                                                <th>Item / Charge</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                        if (mysqli_num_rows($results) > 0 ) {
                          while($row = mysqli_fetch_array($results)){
                            echo "<tr>";
                              echo "<td>".$row[0]."</td>";
                              echo "<td>".$row[1]."</td>";
                              echo "<td>".$row[2]."</td>";
                              echo "<td>".$row[3]."</td>";
                              echo "<td>".$row[4]."</td>";
                            echo "</tr>";
                            
                            }
            
                        }
                        ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Page Footer -->
        <?php include('../footer.php'); ?>

        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Logout Modal Dialog -->
    <?php include('modal_logout.php'); ?>

    <!-- Coommon JS -->
    <?php include('commonjs.php'); ?>

    <!-- page script -->

    <script>
    $(function() {
        $('#tblList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });

        $('#tblSummary').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
    </script>

</body>

</html>