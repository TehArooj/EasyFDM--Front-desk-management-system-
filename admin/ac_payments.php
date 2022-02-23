<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 2;
  $root_url = "../admin/";
  $page_name = "ac_payments.php";
  $page_section = 2;
  $page_url = $root_url . $page_name;

  // Security check
  if($_SESSION['role_id'] > $role_id) {
    header('location:  ../login.php');
  }
  
  // Page variables for data manipulation
  $mode = 'add';
  $recid = 0;
  $booking_id = '0';
  $charge_id = '0';
  $doc_date = '';
  $amount = 0;
  $narration = "";

  // Select Bookings for combo.
  $query = "SELECT BOOKING_ID, BOOKING_NO, NAME, r.ROOM_NO FROM booking b, room r WHERE b.ROOM_ID = r.ROOM_ID AND STATUS < 8 ORDER BY BOOKING_NO";
  $bookings = mysqli_query($db, $query);

  // Select payment charge codes for combo.
  $query = "SELECT CHARGE_ID, DESCRIPTION FROM charge_code WHERE ACTIVE = 1 AND FOR_PAYMENT = 1 ORDER BY CHARGE_ID;";
  $charge_codes = mysqli_query($db, $query);

  // Select grid data.
  $query = "SELECT PAYMENT_ID,PAYMENT_DATE,T2.BOOKING_NO,T2.NAME,T3.DESCRIPTION,AMOUNT, NARRATION
            FROM payment T1,BOOKING T2,CHARGE_CODE T3
            WHERE T1.BOOKING_ID=T2.BOOKING_ID
            AND T1.CHARGE_ID=T3.CHARGE_ID
            ORDER BY PAYMENT_ID";

  $results = mysqli_query($db, $query);
  
  // Add record to database
  if ( isset($_POST['btn_add']) )
  {
    $booking_id = mysqli_real_escape_string($db, $_POST['booking_id']);
    $charge_id = mysqli_real_escape_string($db, $_POST['charge_id']);
    $doc_date = mysqli_real_escape_string($db, $_POST['doc_date']);
    $amount = mysqli_real_escape_string($db, $_POST['amount']);
    $narration = mysqli_real_escape_string($db, $_POST['narration']);
    
    // form validation: ensure that the form is correctly filled
    if (empty($booking_id) || $booking_id == "0") { array_push($errors, "Booking is required.");  }
    if (empty($charge_id) || $charge_id == "0") { array_push($errors, "Charge Code is required."); }
    if (empty($doc_date)) { array_push($errors, "Date is required."); }
    
    // Add to Database
    if (count($errors) == 0) {
        $query = "INSERT INTO payment (BOOKING_ID, CHARGE_ID, PAYMENT_DATE, AMOUNT, NARRATION, CREATED_BY, CREATED_ON, UPDATED_BY, UPDATED_ON) 
                    VALUES($booking_id, $charge_id, '$doc_date', $amount, '$narration', $user_id,now(),$user_id,now())";
        $pass = mysqli_query($db, $query);
    
        if ($pass==false) {
            array_push($errors, "Unable to create record." . $query);
        } else {
            header('location:  '. $page_url . "?added=1");
        }
    }
  }

  // Populate edit controls for update
  if(isset($_GET['action']) && isset($_GET['recid']) && htmlspecialchars($_GET['action']) == "edit" ) 
  {
    // Set flag for editing. 
    $mode="edit";
    $recid = mysqli_real_escape_string($db, $_GET['recid']);

    $query = "SELECT PAYMENT_ID, BOOKING_ID, CHARGE_ID, PAYMENT_DATE, AMOUNT, NARRATION FROM payment WHERE PAYMENT_ID = $recid";
    $edit_result = mysqli_query($db, $query);

    if (mysqli_num_rows($edit_result) == 1 ) {
        $obj = mysqli_fetch_object($edit_result);
        $booking_id = $obj->BOOKING_ID;
        $charge_id = $obj->CHARGE_ID;
        $doc_date = $obj->PAYMENT_DATE;
        $amount = $obj->AMOUNT;
        $narration = $obj->NARRATION;
    }  
  } 
  
  // Save changes to database - update data
  if (isset($_POST['btn_update']) && $mode="edit")
  {
    $recid = mysqli_real_escape_string($db, $_POST['recid']);
    $booking_id = mysqli_real_escape_string($db, $_POST['booking_id']);
    $charge_id = mysqli_real_escape_string($db, $_POST['charge_id']);
    $doc_date = mysqli_real_escape_string($db, $_POST['doc_date']);
    $amount = mysqli_real_escape_string($db, $_POST['amount']);
    $narration = mysqli_real_escape_string($db, $_POST['narration']);
        
    // form validation: ensure that the form is correctly filled
    if (empty($booking_id) || $booking_id == "0") { array_push($errors, "Booking is required.");  }
    if (empty($charge_id)) { array_push($errors, "Charge Code is required."); }
    if (empty($doc_date)) { array_push($errors, "Date is required."); }

    // Add to Database
    if (count($errors) == 0) {
    $query = "UPDATE payment
                    SET BOOKING_ID = $booking_id,
                    CHARGE_ID = $charge_id,
                    PAYMENT_DATE = '$doc_date',
                    AMOUNT = $amount,  
                    NARRATION = '$narration',
                    UPDATED_BY = $user_id, 
                    UPDATED_ON = NOW()
                WHERE PAYMENT_ID = $recid";
    $pass = mysqli_query($db, $query);

    if ($pass==false) {
        array_push($errors, "Unable to update record." . $query);
    } else {
        header('location:  ' . $page_url  . '?updated=1');
    }
    }
  }

  // Delete record from database
  if(isset($_GET['action']) && isset($_GET['recid']) && htmlspecialchars($_GET['action']) == "delete" )  
  {
    $recid = mysqli_real_escape_string($db, $_GET['recid']);
    $query = "DELETE FROM payment WHERE PAYMENT_ID = $recid";
    $pass = mysqli_query($db, $query);

    if ($pass==false) {
        array_push($errors, "Unable to delete record." . $query);
    } else {
        header('location:  ' . $page_url . '?deleted=1');
    }
  }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payments</title>

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
                            <h1 class="m-0 text-dark">Payments</h1>
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
                                    <form action="<?php $page_name ?>" method="post">
                                        <div class="input-group mb-1">
                                            <?php include('../errors.php'); ?>
                                        </div>
                                        <div class="input-group">
                                            <input id='docDate' type="date" class="form-control" name="doc_date"
                                                value="<?php echo $doc_date; ?>" placeholder="">
                                            <select id="booking_id" class="custom-select" name="booking_id">
                                                <option value="0" <?php echo ($booking_id == "0") ? ' selected=true' : ''; ?>>Select
                                                    Booking</option>
                                                <?php
                                                    if (mysqli_num_rows($bookings) > 0 ) {
                                                        while($obj = mysqli_fetch_object($bookings)){
                                                            echo '<option value="' . $obj->BOOKING_ID . '" ';
                                                            echo ($booking_id == $obj->BOOKING_ID )? 'selected=true' : '';
                                                            echo '>' . $obj->BOOKING_NO . ' - ' . $obj->ROOM_NO . ' - ' . $obj->NAME . '</option>' ;
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <select id="charge_id" class="custom-select" name="charge_id">
                                                <option value="0" <?php echo ($charge_id == "0") ? ' selected=true' : ''; ?>>Select
                                                    Charge Code</option>
                                                <?php
                                                    if (mysqli_num_rows($charge_codes) > 0 ) {
                                                        while($obj = mysqli_fetch_object($charge_codes)){
                                                            echo '<option value="' . $obj->CHARGE_ID . '" ';
                                                            echo ($charge_id == $obj->CHARGE_ID )? 'selected=true' : '';
                                                            echo '>' . $obj->CHARGE_ID . ' - ' . $obj->DESCRIPTION . '</option>' ;
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <input style="display: none" type="text" class="form-control" name="recid"
                                                value="<?php echo $recid; ?>" placeholder="ID">
                                            <input type="text" class="form-control" name="amount"
                                                value="<?php echo $amount; ?>" placeholder="Amount">
                                            <input type="text" class="form-control" name="narration"
                                                value="<?php echo $narration; ?>" placeholder="Narration">
                                            <span class="input-group-append">
                                                <?php
                                            if($mode == 'edit'){
                                            echo "<button type='submit' name='btn_update' class='btn btn-info btn-flat'>Update</button>";                                          

                                            }
                                            else {
                                            echo "<button type='submit' name='btn_add' class='btn btn-info btn-flat'>Add</button>";                                    
                                            }
                                            ?>
                                            </span>
                                        </div>
                                    </form>
                                </h3>
                            </div>

                            <script>
                            const checkbox = document.getElementById('active_room_type')
                            checkbox.addEventListener('change', (event) => {
                                if (event.target.checked) {
                                    event.target.value = '1';
                                } else {
                                    event.target.value = '0';
                                }
                            })
                            </script>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tblList" class="table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Booking No.</th>
                                                <th>Guest Name</th>
                                                <th>Charge Code</th>
                                                <th>Amount</th>
                                                <th>Narration</th>
                                                <th></th>
                                                <th></th>
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
                              echo "<td>".$row[5]."</td>";
                              echo "<td>".$row[6]."</td>";
                              echo "<td><a href='" . $page_url . "?action=edit&recid=". $row[0] ."' name = 'btn_edit'><i class='fas fa-edit    '></i></td>";
                              echo "<td><a href='#' onclick='return runMyFunction(".$row[0].");' class='identifyingClass' data-toggle='modal' data-target='#modal-delete' ><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
                              
                            echo "</tr>";
                            
                            }
            
                          }
                        
                        ?>

                                            <script>
                                            function runMyFunction(idToDelete) {
                                                //code
                                                if (idToDelete != null || idToDelete != 0)
                                                    $('#myP').html('ID : ' + idToDelete);
                                                var oldUrl = $('#btnDeleteOK').attr("href"); // Get current url
                                                var newUrl = oldUrl + idToDelete;
                                                $('#btnDeleteOK').attr("href", newUrl); // Set herf value
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

    $(function() {
        $('#tblList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });

    });
    </script>

</body>

</html>