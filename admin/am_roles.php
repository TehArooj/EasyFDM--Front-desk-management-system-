<?php 
  // Includes
  include('../session.php');

  // Array to hold errors.
  $errors = array(); 
  
  // Page variables
  $role_id = 1;
  $root_url = "../admin/";
  $page_name = "am_roles.php";
  $page_section = 3;
  $page_url = $root_url . $page_name;

  // Security check
  if($_SESSION['role_id'] != $role_id) {
    header('location:  ../login.php');
  }
 ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Roles</title>

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
                            <h1 class="m-0 text-dark">Roles</h1>
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

                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Description</th>
                                                <th>Permission Remarks</th>
                                                <th>Active</th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Adminstration</td>
                                                <td>Full Access</td>
                                                <td>
                                                    <div class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" id="checkboxPrimary1" checked disabled>
                                                        <label for="checkboxPrimary1">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><a href=""><i class="fas fa-edit    "></i>
                                                        <!-- <span class="badge bg-success">Edit</span></a> --></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Cashiers</td>
                                                <td>Front Desk Operations Access</td>
                                                <td>
                                                    <div class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" id="checkboxPrimary1" checked disabled>
                                                        <label for="checkboxPrimary1">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><a href=""><i class="fas fa-edit    "></i>
                                                        <!-- <span class="badge bg-success">Edit</span></a> --></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Customers</td>
                                                <td>Signup / Create New Bookings</td>
                                                <td>
                                                    <div class="icheck-primary d-inline ml-2">
                                                        <input type="checkbox" id="checkboxPrimary1" checked disabled>
                                                        <label for="checkboxPrimary1">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><a href=""><i class="fas fa-edit    "></i>
                                                        <!-- <span class="badge bg-success">Edit</span></a> --></a>
                                                </td>
                                            </tr>


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

</body>

</html>