<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 3;
  $root_url = "../customer/";
  $page_name = "newBooking.php";
  $page_section = 1;
  $page_url = $root_url . $page_name;
  $list_page = $root_url . 'index.php';

  // Security check
  if($_SESSION['role_id'] != $role_id) {
    header('location:  ../login.php');
  }
  
  // Page variables for data manipulation
  $mode = "edit";
  $recid = 0;
  
  $guest_id = 0; 
  $room_id = 0;
  // =---------------- 
  $rate_id = 0;
  // =---------------
  $booking_no = ''; 
  $booking_date = ''; 
  $guest_name = ''; 
  $adults = 1;
  $children = 0; 
  $arrival_on = '';
  $departure_on = ''; 
  $rate_name = "";
  $rate = 0;
  $status = 1; 
  $remarks = ""; 
  $extra_bed_active = '0'; 
  $extra_bed_count = 0; 
  $extra_bed_rate = 1000;
  $extra_bed_amount = 0; 
  $airportpickup = '0';

  // Select Guest for drop down.
  $query = "SELECT GUEST_ID, NAME, EMAIL FROM guest where ACTIVE = 1 AND CREATED_BY = $user_id";
  $guest_list = mysqli_query($db, $query);

  // Select Room Types for drop down.
  $query = "SELECT r.ROOM_ID, CONCAT(r.ROOM_NO, '-', t.SHORT_NAME) AS ROOM_NO
              FROM room as r inner join room_type as t on
                  r.TYPE_ID = t.TYPE_ID
              WHERE r.ACTIVE = 1";
  $rooms = mysqli_query($db, $query);

  $query = "SELECT RATE_ID, CONCAT(RATE_NAME, ' - ', RATE) AS ROOM_RATE, RATE FROM room_rate where ACTIVE = 1";
  $room_rates = mysqli_query($db, $query);

  // Add record to database
  if ( isset($_POST['btn_add']) && $recid == 0 )
  {
    $guest_id = mysqli_real_escape_string($db, $_POST['guest_id']);
    $guest_name = mysqli_real_escape_string($db, $_POST['guest_name']);
    $room_id  = mysqli_real_escape_string($db, $_POST['room_id']); 
    $booking_no  = mysqli_real_escape_string($db, $_POST['booking_no']);
    $booking_date = mysqli_real_escape_string($db, $_POST['booking_date']);
    $adults  = mysqli_real_escape_string($db, $_POST['adults']);
    $children  = mysqli_real_escape_string($db, $_POST['children']);
    $arrival_on = mysqli_real_escape_string($db, $_POST['arrival_on']);
    $departure_on = mysqli_real_escape_string($db, $_POST['departure_on']);
    $remarks = mysqli_real_escape_string($db, $_POST['remarks']);
    $extra_bed_active = mysqli_real_escape_string($db, $_POST['extra_bed_active']); 
    $extra_bed_count = mysqli_real_escape_string($db, $_POST['extra_bed_count']);
    $extra_bed_rate = mysqli_real_escape_string($db, $_POST['extra_bed_rate']);
    $extra_bed_amount = mysqli_real_escape_string($db, $_POST['extra_bed_amount']);
    $airportpickup = ( (isset($_POST['airportpickup']) == true) ? '1' : '0' );
    
    // form validation: ensure that the form is correctly filled
    if (empty($guest_id)) { array_push($errors, "Guest Name is required.");  }
    if (empty($room_id)) { array_push($errors, "Room is required.");  }
    if (empty($booking_date)) { array_push($errors, "Booking Date is required.");  }
    if (empty($arrival_on)) { array_push($errors, "Arrival Date is required.");  }
    if (empty($departure_on)) { array_push($errors, "Departure Date is required.");  }
    if (empty($booking_no)) { array_push($errors, "Booking No. is required.");  }
    if (empty($adults)) { array_push($errors, "Number of adults is required.");  }
    
    // Get rate name and rate from database.
    $query = "SELECT RATE_NAME, RATE FROM room_rate where RATE_ID = $rate_id";
    $rate_row = mysqli_query($db, $query);
    if(mysqli_num_rows($rate_row) > 0) {
      $obj = mysqli_fetch_object($rate_row);
      $rate_name = $obj->RATE_NAME;
      $rate = $obj->RATE;
    }
    
    // Add to Database
    if (count($errors) == 0) {
        $query = "INSERT INTO 
                  booking (GUEST_ID, ROOM_ID, BOOKING_NO, BOOKING_DATE, 
                          NAME, ADULTS, CHILDREN, ARRIVAL_ON, DEPARTURE_ON, 
                          RATE_NAME, RATE, STATUS, REMARKS, 
                          EXTRA_BED_ACTIVE, EXTRA_BED_COUNT, EXTRA_BED_RATE, EXTRA_BED_AMOUNT, 
                          CREATED_BY, CREATED_ON, UPDATED_BY, UPDATED_ON, AIRPORTPICKUP, RATE_ID) 
                  VALUES(  $guest_id, $room_id, '$booking_no', '$booking_date',
                           '$guest_name', $adults, $children, '$arrival_on', '$departure_on',
                           '$rate_name', $rate, '1', '$remarks', 
                           '$extra_bed_active', $extra_bed_count, $extra_bed_rate, $extra_bed_amount,
                           $user_id, now(), $user_id, now(), '$airportpickup', $rate_id)";
        $pass = mysqli_query($db, $query);
    
        if ($pass==false) {
            array_push($errors, "Unable to create record." . $query);
        } else {
            header('location:  '. $list_page . "?added=1");
        }
    }
  }

  // Select data of editing.
  if (isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['recid'])) {
    $recid = $_GET['recid'];
  
    $query = "SELECT 	BOOKING_ID, GUEST_ID, ROOM_ID, BOOKING_NO, BOOKING_DATE, 
		                  NAME, ADULTS, CHILDREN, ARRIVAL_ON, DEPARTURE_ON, 
                      RATE_NAME, RATE, STATUS, REMARKS, 
                      EXTRA_BED_ACTIVE, EXTRA_BED_COUNT, EXTRA_BED_RATE, EXTRA_BED_AMOUNT, 
                      CREATED_BY, CREATED_ON, UPDATED_BY, UPDATED_ON, AIRPORTPICKUP, RATE_ID
              FROM booking WHERE BOOKING_ID = $recid";

    $edit_result = mysqli_query($db, $query); 
    
    if (mysqli_num_rows($edit_result) == 1 ) {
      $obj = mysqli_fetch_object($edit_result);

      $recid = $obj->BOOKING_ID;
      $guest_id = $obj->GUEST_ID;
      $room_id = $obj->ROOM_ID;
      $booking_no= $obj->BOOKING_NO;
      $booking_date = $obj->BOOKING_DATE;
      $guest_name = $obj->NAME; 
      $adults = $obj->ADULTS;
      $children= $obj->CHILDREN;
      $arrival_on = $obj->ARRIVAL_ON;
      $departure_on = $obj->DEPARTURE_ON;
      $rate_name = $obj->RATE_NAME;
      $rate = $obj->RATE;
      $status = $obj->STATUS;
      $remarks = $obj->REMARKS;
      $extra_bed_active = $obj->EXTRA_BED_ACTIVE;
      $extra_bed_count = $obj->EXTRA_BED_COUNT;
      $extra_bed_rate= $obj->EXTRA_BED_RATE;
      $extra_bed_amount = $obj->EXTRA_BED_AMOUNT;
      $airportpickup = $obj->AIRPORTPICKUP;
      $rate_id = $obj->RATE_ID;
      
    } else {
      array_push($errors, "Unable to retrieve record.");
    }
  }

  // Save changes to database - update data
  if (isset($_POST['btn_update']) && $mode="edit")
  {
    $guest_id = mysqli_real_escape_string($db, $_POST['guest_id']);
    $guest_name = mysqli_real_escape_string($db, $_POST['guest_name']);
    $room_id  = mysqli_real_escape_string($db, $_POST['room_id']); 
    $booking_no  = mysqli_real_escape_string($db, $_POST['booking_no']);
    $booking_date = mysqli_real_escape_string($db, $_POST['booking_date']);
    $adults  = mysqli_real_escape_string($db, $_POST['adults']);
    $children  = mysqli_real_escape_string($db, $_POST['children']);
    $arrival_on = mysqli_real_escape_string($db, $_POST['arrival_on']);
    $departure_on = mysqli_real_escape_string($db, $_POST['departure_on']);
    $remarks = mysqli_real_escape_string($db, $_POST['remarks']);
    $extra_bed_active = mysqli_real_escape_string($db, $_POST['extra_bed_active']); 
    $extra_bed_count = mysqli_real_escape_string($db, $_POST['extra_bed_count']);
    $extra_bed_rate = mysqli_real_escape_string($db, $_POST['extra_bed_rate']);
    $extra_bed_amount = mysqli_real_escape_string($db, $_POST['extra_bed_amount']);
    $airportpickup = ( (isset($_POST['airportpickup']) == true) ? '1' : '0' );

    // form validation: ensure that the form is correctly filled
    if (empty($guest_id)) { array_push($errors, "Guest Name is required.");  }
    if (empty($room_id)) { array_push($errors, "Room is required.");  }
    if (empty($booking_date)) { array_push($errors, "Booking Date is required.");  }
    if (empty($arrival_on)) { array_push($errors, "Arrival Date is required.");  }
    if (empty($departure_on)) { array_push($errors, "Departure Date is required.");  }
    if (empty($booking_no)) { array_push($errors, "Booking No. is required.");  }
    if (empty($adults)) { array_push($errors, "Number of adults is required.");  }

    // Get rate name and rate from database.
    $query = "SELECT RATE_NAME, RATE FROM room_rate where RATE_ID = $rate_id";
    $rate_row = mysqli_query($db, $query);
    if(mysqli_num_rows($rate_row) > 0) {
      $obj = mysqli_fetch_object($rate_row);
      $rate_name = $obj->RATE_NAME;
      $rate = $obj->RATE;
    }

    // Update in database
    if (count($errors) == 0) {
      $query = "UPDATE booking
                    SET
                        GUEST_ID = $guest_id, 
                        ROOM_ID = $room_id, 
                        BOOKING_NO = '$booking_no',
                        BOOKING_DATE = '$booking_date',
                        NAME = '$guest_name',
                        ADULTS = $adults,
                        CHILDREN = $children,
                        ARRIVAL_ON = '$arrival_on',
                        DEPARTURE_ON = '$departure_on',
                        RATE_NAME = '$rate_name', 
                        RATE = $rate,
                        REMARKS = '$remarks',
                        EXTRA_BED_ACTIVE = '$extra_bed_active',
                        EXTRA_BED_COUNT = $extra_bed_count,
                        EXTRA_BED_RATE = $extra_bed_rate,
                        EXTRA_BED_AMOUNT = $extra_bed_amount,
                        UPDATED_BY = $user_id, 
                        UPDATED_ON = now(),
                        AIRPORTPICKUP = '$airportpickup',
                        RATE_ID = $rate_id
                WHERE BOOKING_ID = '$recid' ";
      
      $pass = mysqli_query($db, $query);

      if ($pass==false) {
        array_push($errors, "Unable to update record." . $query);
      } else {
        header('location:  ' . $list_page  . '?updated=1');
      }
    }
  }
 
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Booking Details</title>

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
                            <h1 class="m-0 text-dark"><?php echo ($recid == 0) ? 'New Booking' : 'Edit Booking'; ?></h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->


            <section class="content">
                <div class="container-fluid">
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="container-fluid">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Booking Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form role="form" action="<?php $page_name ?>" method="post">
                                        <div class="input-group mb-1">
                                            <?php include('../errors.php'); ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Booking No.</label>
                                                    <input type="text" class="form-control" name="booking_no" placeholder="Booking No." value="<?php echo $booking_no; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Booking Date </label>
                                                    <input id="booking_date" type="date" class="form-control" name="booking_date" placeholder="" value="<?php echo $booking_date; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">

                                                    <label>Guest Name</label>
                                                    <select id="guest_list" class="custom-select" name="guest_id" style="width: 100%;" onchange="setGuestName();">
                                                        <option value="0"
                                                            <?php echo ($guest_id == "0") ? 'selected=true' : ''; ?>>
                                                            Select Guest</option>
                                                        <?php
                                                    if (mysqli_num_rows($guest_list) > 0 ) {
                                                        while($obj = mysqli_fetch_object($guest_list)){
                                                            echo '<option value="' . $obj->GUEST_ID . '" ';
                                                            echo ($guest_id == $obj->GUEST_ID )? 'selected=true' : '';
                                                            echo '>' . $obj->NAME .'</option>' ;
                                                        }
                                                    }
                                                ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status" id="status" disabled style="width: 100%;">
                                                        <option value="1" <?php echo ($status=="1") ? 'selected=true':''; ?> >New</option>
                                                        <option value="2" <?php echo ($status=="2") ? 'selected=true':''; ?> >Confirm</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="container-fluid">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Guest Details</label>
                                                    <textarea id="guest_name" name="guest_name" style="resize: none;" class="form-control" rows="3"
                                                        placeholder="" ><?php echo $guest_name; ?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">

                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Room No.</label>
                                                    <select id="room_types" class="custom-select" name="room_id">
                                                        <option value="0"
                                                            <?php echo ($rooms == "0") ? 'selected=true' : ''; ?>>Select
                                                            Room No.</option>
                                                        <?php
                                                    if (mysqli_num_rows($rooms) > 0 ) {
                                                        while($obj = mysqli_fetch_object($rooms)){
                                                            echo '<option value="' . $obj->ROOM_ID . '" ';
                                                            echo ($room_id == $obj->ROOM_ID )? 'selected=true' : '';
                                                            echo '>' . $obj->ROOM_NO . '</option>' ;
                                                        }
                                                    }
                                                ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Room Rate</label>
                                                    <select id="room_rates" class="custom-select" disabled name="rate_id">
                                                        <option value="0"
                                                            <?php echo ($rate_id == "0") ? 'selected=true' : ''; ?>>
                                                            Select Room Rate</option>
                                                        <?php
                                                    if (mysqli_num_rows($room_rates) > 0 ) {
                                                        while($obj = mysqli_fetch_object($room_rates)){
                                                            echo '<option value="' . $obj->RATE_ID . '" ';
                                                            echo ($rate_id == $obj->RATE_ID )? 'selected=true' : '';
                                                            echo '>' . $obj->ROOM_RATE . '</option>' ;
                                                        }
                                                    }
                                                ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Arrival On</label>
                                                    <input class="form-control" type="date" name="arrival_on"  value="<?php echo $arrival_on; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Departure On</label>
                                                    <input class="form-control" type="date" name="departure_on"  value="<?php echo $departure_on; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Adults</label>
                                                    <input class="form-control" type="text" name="adults"  value="<?php echo $adults; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Children</label>
                                                    <input class="form-control" type="text" name="children"  value="<?php echo $children; ?>">
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Extra Bed</label>
                                                    <select class="form-control" name="extra_bed_active" id="extra_bed_active" style="width: 100%;" onchange="calcExtraBed();">
                                                        <option value="0" <?php echo ($extra_bed_active=="0") ? 'selected=true':''; ?> >No</option>
                                                        <option value="1" <?php echo ($extra_bed_active=="1") ? 'selected=true':''; ?> >Yes</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>No. Beds</label>
                                                    <input class="form-control" type="text" name="extra_bed_count"  id="extra_bed_count" value="<?php echo $extra_bed_count;?>" <?php echo ($extra_bed_active=="0") ? 'readonly':''; ?>   onchange="calcExtraBed();">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Extra Bed Rate</label>
                                                    <input class="form-control" type="text" name="extra_bed_rate"  id="extra_bed_rate" value="<?php echo $extra_bed_rate;?>" readonly onchange="calcExtraBed();">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Extra Bed Amount</label>
                                                    <input class="form-control" type="text" name="extra_bed_amount" id="extra_bed_amount" value="<?php echo $extra_bed_amount; ?>" readonly>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="container-fluid">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Remarks</label>
                                                    <textarea style="resize: none;" class="form-control" name="remarks" rows="6" placeholder=""><?php echo $remarks; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" name="airportpickup" value="<?php echo $airportpickup; ?>" id="airportpickup"
                                                    <?php echo ($airportpickup == '1')?"checked":""; ?>>
                                                <label for="airportpickup">
                                                    Airport Pickup
                                                </label>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="container-fluid">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <!-- <button type="button" class="btn btn-danger float-right" name="btn_cancel"><i class="far fa-ban"></i>&nbsp;&nbsp;Cancel</button> -->
                                                    <a href="<?php echo $list_page ?>"
                                                        class="btn btn-danger float-right"><i class="fas fa-plus-square"
                                                            aria-hidden="true"></i> Cancel</a>
                                                    <?php
                                                  if(isset($_GET['action']) && $_GET['action'] == 'edit'){
                                                    echo '<button type="submit" class="btn btn-success float-right" name="btn_update"><i class="far fa-plus-square"></i>&nbsp;&nbsp;Update Booking</button>';                                     
                                                  }
                                                  else {
                                                    echo '<button type="submit" class="btn btn-success float-right" name="btn_add"><i class="far fa-plus-square"></i>&nbsp;&nbsp;Add Booking</button>';                                     
                                                  }
                                                ?>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </section>
                        <!-- /.Left col -->
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>


            <!-- /.control-sidebar -->
        </div>
        <?php include('../footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <!-- Coommon JS -->
    <?php include('commonjs.php'); ?>

    <!-- Logout Modal Dialog -->
    <?php include('modal_logout.php'); ?>

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
        if (isset($_GET['updated']) && htmlspecialchars($_GET['updated']) == "1") {
            echo "msg = 'Record sucessfully changed.';";
        }
        ?>

        if (msg != "") {
            Toast.fire({
                type: 'success',
                title: msg
            });
        }
    });
    </script>
    <script>
    $(document).ready(function() {
        $("#extra_bed_active").change(function() {
            var active = $(this).val();
            if (active === "0") {
                $('#extra_bed_count').prop("readonly", true);
                $('#extra_bed_count').val(0);
                $('#extra_bed_rate').val(1000);
                $('#extra_bed_amount').val(0);
            } 
            else {
                $('#extra_bed_count').prop("readonly", false);
            }

        });
    });

    function calcExtraBed() {
      var count = $('#extra_bed_count').val();
      var rate = $('#extra_bed_rate').val();
    
      var amount = count * rate;
      $('#extra_bed_amount').val(amount);
    }

    function setGuestName() {
        var guestName = $("#guest_list option:selected").html();
        $('#guest_name').val(guestName);
    }
    </script>

</body>

</html>