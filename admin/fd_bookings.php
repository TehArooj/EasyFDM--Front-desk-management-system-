<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 2;
  $root_url = "../admin/";
  $page_name = "fd_bookings.php";
  $page_section = 1;
  $page_url = $root_url . $page_name;
  $edit_page = $root_url . 'fd_newBooking.php';

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
            ORDER BY BOOKING_NO";
  $results = mysqli_query($db, $query);
  
  // Delete record from database
  if(isset($_GET['action']) && isset($_GET['recid']) && htmlspecialchars($_GET['action']) == "delete" )  
  {
    $recid = mysqli_real_escape_string($db, $_GET['recid']);
    
    $query = "DELETE FROM booking WHERE BOOKING_ID = $recid";
    $pass = mysqli_query($db, $query);

    if ($pass==false) {
        array_push($errors, "Unable to delete record." . $query);
    } else {
        header('location:  ' . $page_url . '?deleted=1');
    }
  }

  // Do checkin - Mark booking as In-House
  if(isset($_GET['action']) && isset($_GET['recid']) && htmlspecialchars($_GET['action']) == "checkin" )  
  {
    $recid = mysqli_real_escape_string($db, $_GET['recid']);
    
    $query = "UPDATE booking 
                SET STATUS = '3',
                    UPDATED_BY = '$user_id', 
                    UPDATED_ON = NOW()
                WHERE BOOKING_ID = $recid";
    $pass = mysqli_query($db, $query);

    if ($pass==false) {
        array_push($errors, "Unable to checkin booking." . $query);
    } else {
        header('location:  ' . $page_url . '?updated=1');
    }
  }

  // Mark booking as Canceled
  if(isset($_GET['action']) && isset($_GET['recid']) && htmlspecialchars($_GET['action']) == "cancel" )  
  {
    $recid = mysqli_real_escape_string($db, $_GET['recid']);
    
    $query = "UPDATE booking 
                SET STATUS = '9',
                    UPDATED_BY = '$user_id', 
                    UPDATED_ON = NOW()
                WHERE BOOKING_ID = $recid";
    $pass = mysqli_query($db, $query);

    if ($pass==false) {
        array_push($errors, "Unable to cancel booking." . $query);
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
    <title>Bookings</title>

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
                            <h1 class="m-0 text-dark">Bookings</h1>
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
                                    <a href="<?php echo $edit_page; ?>" class="btn btn-success"><i
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
                            
                              echo "<td><a href='#' onclick='return doCheckin(".$row[0].", ".$row[1].");' class='identifyingClass' data-toggle='modal' data-target='#modal-checkin' ><i class='fa fa-home' aria-hidden='true'></i></a></td>";
                              echo "<td><a href='" . $edit_page . "?action=edit&recid=". $row[0] ."' name = 'btn_edit'><i class='fas fa-edit    '></i></td>";
                              echo "<td><a href='#' onclick='return doDelete(".$row[0].", ".$row[1].");' class='identifyingClass' data-toggle='modal' data-target='#modal-delete' ><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
                              echo "<td><a href='#' onclick='return doCancel(".$row[0].", ".$row[1].");' class='identifyingClass' data-toggle='modal' data-target='#modal-cancel' ><i class='fa fa-ban' aria-hidden='true'></i></a></td>";
                              
                            echo "</tr>";
                            
                            }
            
                          }
                        
                        ?>

                                            <script>
                                            function doDelete(recID, recNo) {
                                                //code
                                                if (recID != null || recID != 0)
                                                    $('#myP').html('ID : ' + recNo);
                                                var oldUrl = $('#btnDeleteOK').attr("href"); // Get current url
                                                var newUrl = oldUrl + recID;
                                                $('#btnDeleteOK').attr("href", newUrl); // Set herf value
                                            }

                                            function doCheckin(recID, recNo) {
                                                //code
                                                if (recID != null || recNo != 0)
                                                    $('#pCheckin').html('ID : ' + recNo);
                                                var oldUrl = $('#btnCheckinOK').attr("href"); // Get current url
                                                var newUrl = oldUrl + recID;
                                                $('#btnCheckinOK').attr("href", newUrl); // Set herf value
                                            }

                                            function doCancel(recID, recNo) {
                                                //code
                                                if (recID != null || recID != 0)
                                                    $('#pCancel').html('ID : ' + recNo);
                                                var oldUrl = $('#btnCancelOK').attr("href"); // Get current url
                                                var newUrl = oldUrl + recID;
                                                $('#btnCancelOK').attr("href", newUrl); // Set herf value
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

    <!-- Delete Modal Dialog -->
    <?php include('modal_delete.php'); ?>

    <div class="modal fade" id="modal-checkin">
        <div class="modal-dialog">
            <div class="modal-content bg-success">
                <div class="modal-header">
                    <h4 class="modal-title">Check-In | Confirm</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Do you want to Check-In?</p>
                    <p id="pCheckin"></p>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                    <a id="btnCheckinOK" href="<?php $page_url ?>?action=checkin&recid="
                    class="btn btn-outline-light">OK</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modal-cancel">
        <div class="modal-dialog">
            <div class="modal-content bg-warning">
                <div class="modal-header">
                    <h4 class="modal-title">Cancel | Booking</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to Cancel?</p>
                    <p id="pCancel"></p>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                    <a id="btnCancelOK" href="<?php $page_url ?>?action=cancel&recid="
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