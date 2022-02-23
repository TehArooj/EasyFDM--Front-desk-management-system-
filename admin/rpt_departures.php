<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 2;
  $root_url = "../admin/";
  $page_name = "rpt_departures.php";
  $page_section = 1;
  $page_url = $root_url . $page_name;

  // Security check
  if($_SESSION['role_id'] > $role_id) {
    header('location:  ../login.php');
  }

  // Select grid data.
  $query = "SELECT  BOOKING_ID, BOOKING_NO, t2.NAME, ARRIVAL_ON, DEPARTURE_ON, CONCAT(t3.ROOM_NO, '-', t4.SHORT_NAME) ROOM_NO , t3.RATE, STATUS
            FROM    booking t1, guest t2, room t3, room_type t4
            WHERE   t1.guest_id = t2.guest_id
                AND t1.room_id = t3.room_id
                AND t4.TYPE_ID = t3.TYPE_ID
                AND t1.DEPARTURE_ON < NOW()
                AND STATUS = 3
            ORDER BY BOOKING_NO";
  $results = mysqli_query($db, $query);

  if ( mysqli_num_rows($results) <= 0) {
      array_push($errors, "No data found.");
  }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Departure List</title>

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
                            <h1 class="m-0 text-dark">Departure List</h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">

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
                                                <th>Booking No.</th>
                                                <th>Name</th>
                                                <th>Arrival</th>
                                                <th>Departure</th>
                                                <th>Room</th>
                                                <th>Rate</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                        if (mysqli_num_rows($results) > 0 ) {
                          while($row = mysqli_fetch_array($results)){
                            echo "<tr>";
                              echo "<td>".$row[1]."</td>";
                              echo "<td>".$row[2]."</td>";
                              echo "<td>".$row[3]."</td>";
                              echo "<td>".$row[4]."</td>";
                              echo "<td>".$row[5]."</td>";
                              echo "<td>".$row[6]."</td>";
                              
                              switch ($row[7]) {
                                case '1':
                                    $badge = '<td><span class="badge bg-warning ">New</span></td>';
                                    break;
                                case '2':
                                    $badge = '<td><span class="badge bg-success ">Confirm</span></td>';
                                    break;
                                case '3':
                                    $badge = '<td><span class="badge bg-success ">In-House</span></td>';
                                    break;
                                case '8':
                                    $badge = '<td><span class="badge bg-danger ">Checked-Out</span></td>';
                                    break;
                                case '9':
                                    $badge = '<td><span class="badge bg-danger ">Canceled</span></td>';
                                    break;
                                default:
                                   $badge = '<td><span class="badge bg-warning ">New</span></td>';
                              }
                              echo $badge;
                            
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

    });
    </script>

</body>

</html>