<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 1;
  $root_url = "../admin/";
  $page_name = "am_company.php";
  $page_section = 3;
  $page_url = $root_url . $page_name;

  // Security check
  if($_SESSION['role_id'] != $role_id) {
    header('location:  ../login.php');
  }
  
  // Page variables for data manipulation
  $mode = "edit";
  $recid = "";
  $leagal_name = "";
  $business_name = "";
  $phone = "";
  $fax = "";
  $email = "";
  $contact_person = "";
  $address = "";

  // Select data.
  $query = "SELECT LEAGAL_NAME, BUSINESS_NAME, PHONE, FAX, EMAIL, CONTACT_PERSON, ADDRESS FROM company";
  $edit_result = mysqli_query($db, $query); 
  
  if (mysqli_num_rows($edit_result) == 1 ) {
    $obj = mysqli_fetch_object($edit_result);

    $recid = $obj->LEAGAL_NAME;
    $leagal_name = $obj->LEAGAL_NAME;
    $business_name = $obj->BUSINESS_NAME;
    $phone = $obj->PHONE;
    $fax = $obj->FAX;
    $email = $obj->EMAIL;
    $contact_person = $obj->CONTACT_PERSON;
    $address = $obj->ADDRESS;

  } else {
    array_push($errors, "Unable to retrieve record.");
  }

  // Save changes to database - update data
  if (isset($_POST['btn_update']) && $mode="edit")
  {
    if ( isset($_POST['leagal_name']) ) 
    {
      
      $leagal_name = mysqli_real_escape_string($db, $_POST['leagal_name']);
      $business_name = mysqli_real_escape_string($db, $_POST['business_name']);
      $phone = mysqli_real_escape_string($db, $_POST['phone']);
      $fax = mysqli_real_escape_string($db, $_POST['fax']);
      $email = mysqli_real_escape_string($db, $_POST['email']);
      $contact_person = mysqli_real_escape_string($db, $_POST['contact_person']);
      $address = mysqli_real_escape_string($db, $_POST['address']);

      // form validation: ensure that the form is correctly filled
      if (empty($leagal_name)) { array_push($errors, "Legal Name is required");  }

      // Update in database
      if (count($errors) == 0) {
        $query = "UPDATE company
                      SET LEAGAL_NAME = '$leagal_name',
                        BUSINESS_NAME = '$business_name',
                        PHONE = '$phone',
                        FAX = '$fax',
                        EMAIL = '$email',
                        CONTACT_PERSON = '$contact_person',
                        `ADDRESS` = '$address',  
                        UPDATED_BY = $user_id, 
                        UPDATED_ON = NOW()
                  WHERE LEAGAL_NAME = '$recid' ";
        
        $pass = mysqli_query($db, $query);

        if ($pass==false) {
          array_push($errors, "Unable to update record." . $query);
        } else {
          header('location:  ' . $page_url  . '?updated=1');
        }
      }
    }
  }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Company Information</title>

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
                            <h1 class="m-0 text-dark">Company Information</h1>
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
                                    <label>Leagal Name</label>
                                    <input type="text" class="form-control" placeholder="" name="leagal_name" value="<?php echo $leagal_name; ?>">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                    <div class="col">
                                    <!-- text input -->
                                    <div class="form-group">
                                      <label>Business Name</label>
                                    <input type="text" class="form-control" placeholder="" name="business_name" value="<?php echo $business_name; ?>">
                                    </div>
                                  </div>
                                </div>

                              <div class="row">
                                    <div class="col">
                                    <!-- text input -->
                                    <div class="form-group">
                                      <label>Contact Person</label>
                                    <input type="text" class="form-control" placeholder="" name="contact_person" value="<?php echo $contact_person; ?>">
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
                                                <div class="container-fluid">
                                                    <!-- text input -->
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <textarea style="resize: none;" class="form-control" rows="3" placeholder="" name="address"><?php echo $address; ?></textarea>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        
                              
                              <div class="row">
                                  <div class="container-fluid">
                                      <!-- text input -->
                                      <div class="form-group">
                                          <button type="submit" class="btn btn-success float-right" name='btn_update'><i class="far fa-save"></i> 
                                              &nbsp;&nbsp;Save
                                          </button>
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
        }?>

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