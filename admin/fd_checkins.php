<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 2;
  $root_url = "../admin/";
  $page_name = "fd_checkins.php";
  $page_section = 1;
  $page_url = $root_url . $page_name;
  $report_page = $root_url . 'rpt_guestFolio.php';

  // Security check
  if($_SESSION['role_id'] > $role_id) {
    header('location:  ../login.php');
  }
  
  // Page variables for data manipulation
  $mode = 'add';
  $recid = 0;

  // Select grid data.
  $query = "SELECT  BOOKING_ID, BOOKING_NO, t2.NAME, ARRIVAL_ON, DEPARTURE_ON, CONCAT(t3.ROOM_NO, '-', t4.SHORT_NAME) ROOM_NO , t3.RATE, STATUS
            FROM    booking t1, guest t2, room t3, room_type t4
            WHERE   t1.guest_id = t2.guest_id
                AND t1.room_id = t3.room_id
                AND t4.TYPE_ID = t3.TYPE_ID
                AND t1.STATUS = '3'
            ORDER BY BOOKING_NO";
  $results = mysqli_query($db, $query);

  // Check-out guest
  if(isset($_GET['action']) && isset($_GET['recid']) && htmlspecialchars($_GET['action']) == "checkin" )  
  {
    $recid = mysqli_real_escape_string($db, $_GET['recid']);
    
    $query = "UPDATE booking 
                SET STATUS = '8',
                    UPDATED_BY = '$user_id', 
                    UPDATED_ON = NOW()
                WHERE BOOKING_ID = $recid";
    $pass = mysqli_query($db, $query);

    if ($pass==false) {
        array_push($errors, "Unable to checkout guest." . $query);
    } else {
        header('location:  ' . $page_url . '?updated=1');
    }
  }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Check-Ins</title>

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
                            <h1 class="m-0 text-dark">Check-Ins</h1>
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
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="<?php echo $report_page; ?>" class="btn btn-success"><i
                                            class="fas fa-plus-square" aria-hidden="true"></i> New</a>
                                </h3>
                            </div>

                            <!-- /.card-header -->
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
                                                <th></th>
                                                <th></th>
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
                            
                              echo "<td><a href='#' onclick='return doCheckout(".$row[0].", ".$row[1].");' class='identifyingClass' data-toggle='modal' data-target='#modal-checkout' ><i class='fa fa-running' aria-hidden='true'></i></a></td>";
                              echo "<td><a href='" . $report_page . "?recid=". $row[0] ."' name = 'btn_print'><i class='fa fa-print    '></i></td>";
                              
                            echo "</tr>";
                            
                            }
            
                          }
                        
                        ?>

                                            <script>
                                            function doCheckout(recID, recNo) {
                                                //code
                                                if (recID != null || recNo != 0)
                                                    $('#pCheckout').html('ID : ' + recNo);
                                                var oldUrl = $('#btnCheckoutOK').attr("href"); // Get current url
                                                var newUrl = oldUrl + recID;
                                                $('#btnCheckoutOK').attr("href", newUrl); // Set herf value
                                            }
                                            </script>
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

    <div class="modal fade" id="modal-checkout">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Check-Out | Confirm</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Do you want to Check-Out?</p>
                    <p id="pCheckout"></p>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                    <a id="btnCheckoutOK" href="<?php $page_url ?>?action=checkout&recid="
                    class="btn btn-outline-light">OK</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Coommon JS -->
    <?php include('commonjs.php'); ?>

    <!-- page script -->
    <script>
    $(document).ready(function() {
        $.urlParam = function(name) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return results[1] || 0;
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        var msg = "";

        <?php
        if (isset($_GET['added']) && htmlspecialchars($_GET['added']) == "1") {
            echo "msg = 'Record sucessfully created.';";
        }

        if (isset($_GET['updated']) && htmlspecialchars($_GET['updated']) == "1") {
            echo "msg = 'Record sucessfully changed.';";
        }

        if (isset($_GET['deleted']) && htmlspecialchars($_GET['deleted']) == "1") {
            echo "msg = 'Record sucessfully deleted.';";
        } ?>

        if (msg != "") {
            Toast.fire({
                type: 'success',
                title: msg
            });
        }
    });
    </script>

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