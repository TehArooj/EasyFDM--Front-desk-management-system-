<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 2;
  $root_url = "../admin/";
  $page_name = "fd_newGuest.php";
  $page_section = 1;
  $page_url = $root_url . $page_name;
  $list_page = $root_url . 'fd_guests.php';

  // Security check
  if($_SESSION['role_id'] > $role_id) {
    header('location:  ../login.php');
  }
  
  // Page variables for data manipulation
  $mode = "edit";
  $recid = 0;
  $guest_name="";
  $cnic="";
  $passport_no = "";
  $phone = "";
  $fax = "";
  $email = "";
  $is_active = 1;

  // Add record to database
  if ( isset($_POST['btn_add']) && $recid == 0 )
  {

    $guest_name = mysqli_real_escape_string($db, $_POST['guest_name']);
    $cnic = mysqli_real_escape_string($db, $_POST['cnic']);
    $passport_no = mysqli_real_escape_string($db, $_POST['passport_no']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $fax = mysqli_real_escape_string($db, $_POST['fax']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $is_active = ( (isset($_POST['is_active']) == true) ? '1' : '0' );

    // form validation: ensure that the form is correctly filled
    if (empty($guest_name)) { array_push($errors, "Guest Name is required.");  }

    // Add to Database
    if (count($errors) == 0) {
        $query = "INSERT INTO guest (NAME, CNIC, PASSPORT_NO, PHONE, FAX, EMAIL, ACTIVE, CREATED_BY, CREATED_ON, UPDATED_BY, UPDATED_ON) 
                VALUES('$guest_name', '$cnic', '$passport_no', '$phone', '$fax', '$email', $is_active, $user_id, now(), $user_id,now() )";
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
  
    $query = "SELECT GUEST_ID, NAME, CNIC, PASSPORT_NO, PHONE, FAX, EMAIL, ACTIVE FROM guest WHERE GUEST_ID = $recid";
    $edit_result = mysqli_query($db, $query); 
    
    if (mysqli_num_rows($edit_result) == 1 ) {
      $obj = mysqli_fetch_object($edit_result);

      $recid = $obj->GUEST_ID;
      $guest_name = $obj->NAME;
      $cnic = $obj->CNIC;
      $passport_no = $obj->PASSPORT_NO;
      $phone = $obj->PHONE;
      $fax = $obj->FAX;
      $email = $obj->EMAIL;
      $is_active = $obj->ACTIVE;
    } else {
      array_push($errors, "Unable to retrieve record.");
    }
  }

  // Save changes to database - update data
  if (isset($_POST['btn_update']) && $mode="edit")
  {
    $guest_name = mysqli_real_escape_string($db, $_POST['guest_name']);
    $cnic = mysqli_real_escape_string($db, $_POST['cnic']);
    $passport_no = mysqli_real_escape_string($db, $_POST['passport_no']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $fax = mysqli_real_escape_string($db, $_POST['fax']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $is_active = ( (isset($_POST['is_active']) == true) ? '1' : '0' );

    // form validation: ensure that the form is correctly filled
    if (empty($guest_name)) { array_push($errors, "Guest Name is required.");  }

    // Update in database
    if (count($errors) == 0) {
      $query = "UPDATE guest
                    SET NAME = '$guest_name',
                      CNIC = '$cnic',
                      PASSPORT_NO = '$passport_no',
                      PHONE = '$phone',
                      FAX = '$fax',
                      EMAIL = '$email',
                      ACTIVE = $is_active,
                      UPDATED_BY = $user_id, 
                      UPDATED_ON = NOW()
                WHERE GUEST_ID = '$recid' ";
      
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
    <title>Guest Information</title>

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
                            <h1 class="m-0 text-dark"><?php echo ($recid == 0) ? 'New Guest' : 'Edit Guest'; ?></h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="container-fluid">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Guest Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form role="form" action="<?php $page_name ?>" method="post">

                                         <div class="input-group mb-1">
                                            <?php include('../errors.php'); ?>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" placeholder="" name="guest_name" value="<?php echo $guest_name; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>CNIC</label>
                                                    <input type="text" class="form-control" placeholder="" name="cnic" value="<?php echo $cnic; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Passport No.</label>
                                                    <input type="text" class="form-control" placeholder="" name="passport_no" value="<?php echo $passport_no; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                          <label>Phone</label>
                                          <input type="text" class="form-control" placeholder="" name="phone" value="<?php echo $phone; ?>">
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                              <label>Fax</label>
                                              <input type="text" class="form-control" placeholder="" name="fax" value="<?php echo $fax; ?>">
                                            </div>
                                          </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                        <!-- text input -->
                                        <div class="form-group">
                                          <label>Email</label>
                                          <input type="text" class="form-control" placeholder="" name="email" value="<?php echo $email; ?>">
                                        </div>
                                      </div>
                                    </div>

                                        <div class="row">
                                            <div class="col">
                                                <!-- text input -->
                                                <div class="form-group clearfix ">
                                                    <div class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" name="is_active"
                                                            value="<?php echo $is_active; ?>" id="is_active"
                                                            <?php echo ($is_active == '1')?"checked":""; ?>>
                                                        <label for="is_active">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="container-fluid">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <!-- <button type="button" class="btn btn-danger float-right" name="btn_cancel"><i class="far fa-ban"></i>&nbsp;&nbsp;Cancel</button> -->
                                                    <a href="<?php echo $list_page ?>" class="btn btn-danger float-right"><i class="fas fa-plus-square" aria-hidden="true"></i> Cancel</a>
                                                <?php
                                                  if(isset($_GET['action']) && $_GET['action'] == 'edit'){
                                                    echo '<button type="submit" class="btn btn-success float-right" name="btn_update"><i class="far fa-plus-square"></i>&nbsp;&nbsp;Update User</button>';                                     
                                                  }
                                                  else {
                                                    echo '<button type="submit" class="btn btn-success float-right" name="btn_add"><i class="far fa-plus-square"></i>&nbsp;&nbsp;Add User</button>';                                     
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
            <!-- Main content -->

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