<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 1;
  $root_url = "../admin/";
  $page_name = "am_roomTypes.php";
  $page_section = 3;
  $page_url = $root_url . $page_name;

  // Security check
  if($_SESSION['role_id'] != $role_id) {
    header('location:  ../login.php');
  }
  
  // Page variables for data manipulation
  $mode = 'add';
  $recid = 0;
  $full_name = "";
  $short_name = "";
  $is_active = '1';

  // Select grid data.
  $query = "SELECT TYPE_ID, SHORT_NAME, FULL_NAME, ACTIVE, CREATED_BY, CREATED_ON, UPDATED_BY, UPDATED_ON FROM room_type";
  $results = mysqli_query($db, $query);
  
  // Add record to database
  if ( isset($_POST['btn_add']) && ( isset($_POST['full_name']) || isset($_POST['short_name']) ) )
  {
    $short_name = mysqli_real_escape_string($db, $_POST['short_name']);
    $full_name = mysqli_real_escape_string($db, $_POST['full_name']);
    $is_active = ( (isset($_POST['is_active']) == true) ? '1' : '0' );

    // form validation: ensure that the form is correctly filled
    if (empty($short_name)) { array_push($errors, "Short Name is required");  }
    if (empty($full_name)) { array_push($errors, "Full Name is required"); }
    
    // Add to Database
    if (count($errors) == 0) {
        $query = "INSERT INTO room_type (short_name,full_name,active,created_by,created_on,updated_by,updated_on) 
                VALUES('$short_name', '$full_name',$is_active,$user_id,now(),$user_id,now())";
        $pass = mysqli_query($db, $query);
    
        if ($pass==false) {
            array_push($errors, "Unable to create record.");
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
    $query = "SELECT TYPE_ID, SHORT_NAME, FULL_NAME, ACTIVE FROM room_type WHERE TYPE_ID = $recid";
    $edit_result = mysqli_query($db, $query);

    if (mysqli_num_rows($edit_result) == 1 ) {
      $obj = mysqli_fetch_object($edit_result);
      $short_name = $obj->SHORT_NAME;
      $full_name = $obj->FULL_NAME;
      $is_active = $obj->ACTIVE;
    }  
  } 
  
  // Save changes to database - update data
  if (isset($_POST['btn_update']) && $mode="edit")
  {
    if (isset($_POST['full_name']) || isset($_POST['short_name'])) 
    {
      $recid = mysqli_real_escape_string($db, $_POST['recid']);
      $short_name = mysqli_real_escape_string($db, $_POST['short_name']);
      $full_name = mysqli_real_escape_string($db, $_POST['full_name']);
      $is_active = ( (isset($_POST['is_active']) == true) ? '1' : '0' );

      // form validation: ensure that the form is correctly filled
      if (empty($short_name)) { array_push($errors, "Short Name is required.");  }
      if (empty($full_name)) { array_push($errors, "Full Name is required."); }

      // Add to Database
      if (count($errors) == 0) {
        $query = "UPDATE room_type
                      SET SHORT_NAME = '$short_name',
                      FULL_NAME = '$full_name',
                      ACTIVE = $is_active,  
                      UPDATED_BY = $user_id, 
                      UPDATED_ON = NOW()
                  WHERE TYPE_ID = $recid";
        $pass = mysqli_query($db, $query);

        if ($pass==false) {
          array_push($errors, "Unable to update record." . $query);
        } else {
          header('location:  ' . $page_url  . '?updated=1');
        }
      }
    }
  }

  // Delete record from database
  if(isset($_GET['action']) && isset($_GET['recid']) && htmlspecialchars($_GET['action']) == "delete" )  
  {
    $recid = mysqli_real_escape_string($db, $_GET['recid']);
    $query = "DELETE FROM room_type WHERE TYPE_ID = $recid";
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
    <title>Room Types</title>

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
                            <h1 class="m-0 text-dark">Room Types</h1>
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
                                            <input style="display: none" type="text" class="form-control" name="recid"
                                                value="<?php echo $recid; ?>" placeholder="ID">
                                            <input type="text" class="form-control" name="short_name"
                                                value="<?php echo $short_name; ?>" placeholder="Short Name">
                                            <input type="text" class="form-control" name="full_name"
                                                value="<?php echo $full_name; ?>" placeholder="Full Name">
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" name="is_active"
                                                    value="<?php echo $is_active; ?>" id="is_active"
                                                    <?php echo ($is_active == '1')?"checked":""; ?>>
                                                <label for="is_active">
                                                </label>
                                            </div>
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
                            const checkbox = document.getElementById('is_active')
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
                                                <th>Short Name</th>
                                                <th>Full Name</th>
                                                <th>Active</th>
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
                              echo "<td>
                                        <div class='icheck-primary d-inline ml-2'>
                                            <input type='checkbox' " . ($row[3] == 1 ? 'checked' : '') . " disabled>
                                            <label />
                                        </div>
                                      </td>";
                              echo "<td><a href='" . $page_url . "?action=edit&recid=". $row[0] ."' name = 'btn_edit'><i class='fas fa-edit    '></i></td>";
                              echo "<td><a href='#' onclick='return runMyFunction(".$row[0].");' class='identifyingClass' data-toggle='modal' data-target='#modal-delete' ><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
                              
                            echo "</tr>";
                            
                            }
            
                          }
                        
                        ?>

                                            <script>
                                            function runMyFunction(recID) {
                                                //code
                                                if (recID != null || recID != 0)
                                                    $('#myP').html('ID : ' + recID);
                                                var oldUrl = $('#btnDeleteOK').attr("href"); // Get current url
                                                var newUrl = oldUrl + recID;
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