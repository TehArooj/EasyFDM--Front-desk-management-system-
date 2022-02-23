<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $user_id = $_SESSION['user_id'];
  $role_id = 1;
  $root_url = "../admin/";
  $page_name = "am_users.php";
  $page_section = 3;
  $page_url = $root_url . $page_name;
  $edit_page = $root_url . 'am_newUser.php';

  // Security check
  if($_SESSION['role_id'] != $role_id) {
    header('location:  ../login.php');
  }
  
  // Page variables for data manipulation
  $mode = 'add';
  $recid = 0;
 
  // Select grid data.
  $query = "SELECT U.USER_ID, U.USER_NAME, U.FULL_NAME, U.EMAIL , R.DESCRIPTION,  U.ACTIVE FROM app_user U, app_role R WHERE U.ROLE_ID = R.ROLE_ID ORDER BY U.USER_ID";
  $results = mysqli_query($db, $query);
  
  // Delete record from database
  if(isset($_GET['action']) && isset($_GET['recid']) && htmlspecialchars($_GET['action']) == "delete" )  
  {
    $recid = mysqli_real_escape_string($db, $_GET['recid']);
    
    if($recid == 1) {
        array_push($errors, "System Administrator can not be deleted." . $query);
        exit;
    }
    
    $query = "DELETE FROM app_user WHERE USER_ID = $recid AND USER_ID <> 1";
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
    <title>Users</title>

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
                            <h1 class="m-0 text-dark">Users</h1>
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
                                <a href="<?php echo $edit_page; ?>" class="btn btn-success"><i class="fas fa-plus-square" aria-hidden="true"></i> New</a>
                            </h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tblList" class="table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User Name</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
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
                              echo "<td>".$row[3]."</td>";
                              echo "<td>".$row[4]."</td>";
                              echo "<td>
                                        <div class='icheck-primary d-inline ml-2'>
                                            <input type='checkbox' " . ($row[5] == 1 ? 'checked' : '') . " disabled>
                                            <label />
                                        </div>
                                      </td>";
                              echo "<td><a href='" . $edit_page . "?action=edit&recid=". $row[0] ."' name = 'btn_edit'><i class='fas fa-edit    '></i></td>";
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