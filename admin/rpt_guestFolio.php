<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 2;
  $root_url = "../admin/";
  $page_name = "rpt_guestFolio.php";
  $page_section = 2;
  $page_url = $root_url . $page_name;

  // Security check
  if($_SESSION['role_id'] > $role_id) {
    header('location:  ../login.php');
  }
  
  // Page variables for data manipulation
  $booking_id = '0';

  // Select Bookings for combo.
  $query = "SELECT BOOKING_ID, BOOKING_NO, NAME, r.ROOM_NO FROM booking b, room r WHERE b.ROOM_ID = r.ROOM_ID AND STATUS < 8 ORDER BY BOOKING_NO";
  $bookings = mysqli_query($db, $query);
  
  // Get parameter from URL
  if( isset($_GET['recid']) && isset($_POST['btn_retrieve'])==false ) 
  { 
    $booking_id = $_GET['recid']; 
  } 
  
  // Get parameter from dropdown selection
  if( $booking_id == 0 && isset($_POST['btn_retrieve']) && isset($_POST['booking_id']) ) 
  {
    $booking_id = $_POST['booking_id']; 
  }
  
  // Build query to populate grid data.
  $query = "SELECT t.TRN_DATE, t.TYPE, t.BOOKING_NO, t.NAME, t.DESCRIPTION, t.AMOUNT, t.NARRATION FROM
            (
                SELECT 'Bill' as TYPE, b.BILL_DATE as TRN_DATE, k.BOOKING_NO, k.NAME, c.DESCRIPTION, b.AMOUNT, b.NARRATION
                FROM  bill b,BOOKING k,CHARGE_CODE c
                WHERE   b.BOOKING_ID=k.BOOKING_ID
                AND b.CHARGE_ID=c.CHARGE_ID
                AND b.BOOKING_ID = $booking_id
                UNION ALL
                SELECT 'Payment' as TYPE, b.PAYMENT_DATE as TRN_DATE, k.BOOKING_NO, k.NAME, c.DESCRIPTION, b.AMOUNT, b.NARRATION
                FROM  payment b,BOOKING k,CHARGE_CODE c
                WHERE   b.BOOKING_ID=k.BOOKING_ID
                AND b.CHARGE_ID=c.CHARGE_ID
                AND b.BOOKING_ID = $booking_id
                UNION ALL
                SELECT 'Receipt' as TYPE, b.RECEIPT_DATE as TRN_DATE, k.BOOKING_NO, k.NAME, c.DESCRIPTION, b.AMOUNT, b.NARRATION
                FROM  receipt b,BOOKING k,CHARGE_CODE c
                WHERE   b.BOOKING_ID=k.BOOKING_ID
                AND b.CHARGE_ID=c.CHARGE_ID
                AND b.BOOKING_ID = $booking_id      
            ) AS t
            ORDER BY t.TRN_DATE";

  $results = mysqli_query($db, $query);

  if ( $booking_id > 0 && mysqli_num_rows($results) <= 0) {
      array_push($errors, "No data found for selected booking.");
  }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Guest Folio</title>

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
                            <h1 class="m-0 text-dark">Guest Folio</h1>
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
                                            <select id="booking_id" class="custom-select" name="booking_id">
                                                <option value="0"
                                                    <?php echo ($booking_id == "0") ? ' selected=true' : ''; ?>>Select
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
                                            <span class="input-group-append">
                                                <button type='submit' name='btn_retrieve'
                                                    class='btn btn-info btn-flat'>Retrieve</button>
                                            </span>
                                        </div>
                                    </form>
                                </h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tblList" class="table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Booking No.</th>
                                                <th>Guest Name</th>
                                                <th>Charge Code</th>
                                                <th>Amount</th>
                                                <th>Narration</th>
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
            "autoWidth": false
        });
    });
    </script>

</body>

</html>