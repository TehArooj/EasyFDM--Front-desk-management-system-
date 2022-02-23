<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 1;
  $root_url = "../admin/";
  $page_name = "am_newUser.php";
  $page_section = 3;
  $page_url = $root_url . $page_name;
  $list_page = $root_url . 'am_users.php';

  // Security check
  if($_SESSION['role_id'] != $role_id) {
    header('location:  ../login.php');
  }
  
  // Page variables for data manipulation
  $mode = "edit";
  $recid = 0;
  $user_role_id = 2;
  $user_user_name = "";
  $user_full_name = "";
  $user_email = "";
  $user_password1 = "";
  $user_password2 = "";
  $is_active = 1;

  // Add record to database
  if ( isset($_POST['btn_add']) && $recid == 0 )
  {

    $user_role_id = mysqli_real_escape_string($db, $_POST['role_id']);
    $user_user_name = mysqli_real_escape_string($db, $_POST['user_name']);
    $user_full_name = mysqli_real_escape_string($db, $_POST['full_name']);
    $user_email = mysqli_real_escape_string($db, $_POST['email']);
    $user_password1 = mysqli_real_escape_string($db, $_POST['password1']);
    $user_password2 = mysqli_real_escape_string($db, $_POST['password2']);
    $is_active = ( (isset($_POST['is_active']) == true) ? '1' : '0' );

    // form validation: ensure that the form is correctly filled
    if (empty($user_user_name)) { array_push($errors, "User Name is required.");  }
    if (empty($user_email)) { array_push($errors, "Email is required."); }
    if (empty($user_role_id)) { array_push($errors, "Role is required."); }
    if (empty($user_password1)) { array_push($errors, "Password is required."); }
    if (empty($user_password2)) { array_push($errors, "Confirm Password is required."); }
    if ($user_password1 != $user_password2) { array_push($errors, "Confirm Password does not match."); }

    // Add to Database
    if (count($errors) == 0) {
        $password = md5($user_password1); // Encrypt password.

        $query = "INSERT INTO app_user (ROLE_ID, USER_NAME, FULL_NAME, EMAIL, ACTIVE, PASSWORD, CREATED_BY, CREATED_ON, UPDATED_BY, UPDATED_ON) 
                VALUES($user_role_id, '$user_user_name', '$user_full_name', '$user_email',$is_active, '$password', $user_id, now(), $user_id,now() )";
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
  
    $query = "SELECT USER_ID, ROLE_ID, USER_NAME, FULL_NAME, EMAIL , ACTIVE FROM app_user WHERE USER_ID = $recid";
    $edit_result = mysqli_query($db, $query); 
    
    if (mysqli_num_rows($edit_result) == 1 ) {
      $obj = mysqli_fetch_object($edit_result);

      $recid = $obj->USER_ID;
      $user_role_id = $obj->ROLE_ID;
      $user_user_name = $obj->USER_NAME;
      $user_full_name = $obj->FULL_NAME;
      $user_email = $obj->EMAIL;
      $is_active = $obj->ACTIVE;
    } else {
      array_push($errors, "Unable to retrieve record.");
    }
  }

  // Save changes to database - update data
  if (isset($_POST['btn_update']) && $mode="edit")
  {
    $user_role_id = mysqli_real_escape_string($db, $_POST['role_id']);
    $user_user_name = mysqli_real_escape_string($db, $_POST['user_name']);
    $user_full_name = mysqli_real_escape_string($db, $_POST['full_name']);
    $user_email = mysqli_real_escape_string($db, $_POST['email']);
    $is_active = ( (isset($_POST['is_active']) == true) ? '1' : '0' );

    // form validation: ensure that the form is correctly filled
    if (empty($user_user_name)) { array_push($errors, "User Name is required");  }
    if (empty($user_email)) { array_push($errors, "Email is required"); }
    if (empty($user_role_id)) { array_push($errors, "Role is required"); }

    // Update in database
    if (count($errors) == 0) {
      $query = "UPDATE app_user
                    SET ROLE_ID = $user_role_id,
                      USER_NAME = '$user_user_name',
                      FULL_NAME = '$user_full_name',
                      EMAIL = '$user_email',
                      ACTIVE = $is_active,
                      UPDATED_BY = $user_id, 
                      UPDATED_ON = NOW()
                WHERE USER_ID = '$recid' ";
      
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
    <title>User Information</title>

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
                            <h1 class="m-0 text-dark"><?php echo ($recid == 0) ? 'New User' : 'Edit User'; ?></h1>
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
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">User Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form role="form" action="<?php $page_name ?>" method="post">

                                         <div class="input-group mb-1">
                                            <?php include('../errors.php'); ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" placeholder="" name="email" value="<?php echo $user_email; ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Role</label>
                                                    <select id="role_id" class="custom-select" name="role_id">
                                                        <option value="1"
                                                            <?php echo ($user_role_id == "1") ? 'selected=true' : ''; ?>>
                                                            Administor</option>
                                                        <option value="2"
                                                            <?php echo ($user_role_id == "2") ? 'selected=true' : ''; ?>>
                                                            Cashier</option>
                                                        <option value="3"
                                                            <?php echo ($user_role_id == "3") ? 'selected=true' : ''; ?>>
                                                            Customer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                          <label>User Name</label>
                                          <input type="text" class="form-control" placeholder="" name="user_name" value="<?php echo $user_user_name; ?>">
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                              <label>Full Name</label>
                                              <input type="text" class="form-control" placeholder="" name="full_name" value="<?php echo $user_full_name; ?>">
                                            </div>
                                          </div>
                                    </div>

                                    <div class="row" <?php echo (isset($_GET['action']) && $_GET['action'] == 'edit') ? "style='display:none'" : ""; ?>">
                                        <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                          <label>Password</label>
                                          <input type="password" class="form-control" placeholder="" name="password1" value="<?php echo $user_password1; ?>">
                                        </div>
                                      </div>
                                      <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                              <label>Confirm Password</label>
                                              <input type="password" class="form-control" placeholder="" name="password2" value="<?php echo $user_password2; ?>">
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