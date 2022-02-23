<?php include('session.php') ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customer</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">

</head>


  <body class="sidebar-mini layout-fixed control-sidebar-open" style="height: auto;">
      <div class="wrapper">
      
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-info">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
              </li>
             
              
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
              <!-- Messages Dropdown Menu -->
              <li class="nav-item" >
                <a class="nav-link" href="#" data-toggle="modal" data-target="#modal-primary">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                </a>
              </li>
        
            </ul>
        </nav>
        <!-- /.navbar -->
      
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-light-info">
          <!-- Brand Logo -->
          <a href="index.html" class="brand-link navbar-info">
            <img src="logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light text-white">Easy FDM</span>
          </a>
      
          <!-- Sidebar -->
          <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition"><div class="os-resize-observer-host"><div class="os-resize-observer observed" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer observed"></div></div><div class="os-content-glue" style="margin: 0px -8px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll; right: 0px; bottom: 0px;"><div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                  <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                  <a href="#" class="d-block">
                  <?php  if (isset($_SESSION['user_name'])) : ?>
                     <?php echo $_SESSION['user_name']; ?>
              
                    <?php endif ?>
    
                      <span class="float-right badge bg-success ml-4 mt-1">Online</span>
                  </a>
                </div>
              </div>
      
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview menu-open  pb-3">
              <a href="index.php" class="nav-link active">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Booking
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview pb-3">
              <a href="myProfile.php" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  My Profile
                </p>
              </a>
            </li>
  
  
            

            <li class="nav-item has-treeview ">
            <?php  if (isset($_SESSION['user_name'])) : ?>
              <a href="index.php?logout='1'" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  LOGOUT
                </p>
              </a>
              <?php endif ?>
            </li>
            
                </ul>
              </nav>
            <!-- /.sidebar-menu -->
          </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 73.8117%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar-corner"></div></div>
          <!-- /.sidebar -->
        </aside>
      
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
          <!-- Main content -->
    <section class="content">
            <div class="row">
              <div class="col-12">
      
              <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">
                        <a href="newBooking.html" class="btn btn-success"><i class="fas fa-plus-square" aria-hidden="true"></i> New</a>
                    </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                      <div class="table-responsive">
                          <table id="example1" class="table table-bordered table-striped ">
                      <thead>
                          <tr>
                              <th>Booking No.</th>
                              <th>Arrival</th>
                              <th>Departure</th>
                              <th>Room Type</th>
                              <th>Room Rate</th>
                              <th>Adults</th>
                              <th>Children</th>
                              <th>Status</th>
                              <th></th>
                              <th></th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                        <tr>
                              <td>1912002</td>
                              <td>13/12/2019</td>
                              <td>15/12/2019</td>
                              <td>STD</td>
                              <td>3500</td>
                              
                          
                            <td>1</td>
                              <td>1</td>
                              <td>
                                <span class="badge bg-warning ">New</span>
                            </td>
                            <td><a href="#" data-toggle="modal" data-target="#modal-checkin"><i class="fas fa-home    "></i>
                                <!-- <span class="badge bg-success">Edit</span></a> --></a>
                            </td>
                             
                              <td><a href="#"><i class="fas fa-edit    "></i>
                                  <!-- <span class="badge bg-success">Edit</span></a> --></a>
                              </td>

                             

                                <td>
                                    <a href="#" data-toggle="modal" data-target="#modal-cancelbooking">
                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                      </a>
                                  </td>
                        </tr>
                        <tr>
                                <td>1912003</td>
                                <td>10/12/2019</td>
                                <td>11/12/2019</td>
                                <td>STD</td>
                                <td>3500</td>
                             
                              <td>1</td>
                              <td>0</td>
                              <td>
                                <span class="badge bg-success ">Confirm</span>
                            </td>
                              <td><a href=""><i class="fas fa-home    "></i>
                                <!-- <span class="badge bg-success">Edit</span></a> --></a>
                            </td>
                                <td><a href=""><i class="fas fa-edit    "></i>
                                    <!-- <span class="badge bg-success">Edit</span></a> --></a>
                                </td>
                                
                                  <td>
                                      <a href="#" data-toggle="modal" data-target="#modal-cancelbooking">
                                          <i class="fa fa-ban" aria-hidden="true"></i>
                                        </a>
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
        <footer class="main-footer">
            Semester Project - <a href="https://pucit.edu.pk/" target="_blank">PUCIT</a>.
        </footer>
      
        
    <!-- /.control-sidebar -->
    </div>
      <!-- ./wrapper -->
      <div class="modal fade" id="modal-primary">
          <div class="modal-dialog">
            <div class="modal-content bg-primary">
              <div class="modal-header">
                <h4 class="modal-title">Session</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to Logout?</p>
              </div>
              <div class="modal-footer justify-content-right">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                <a href="index.php?logout='1'" class="btn btn-outline-light">OK</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-delete">
                <div class="modal-dialog">
                  <div class="modal-content bg-danger">
                    <div class="modal-header">
                      <h4 class="modal-title">Delete | Booking</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                      <p>Are you sure you want to Delete?</p>
                    </div>
                    <div class="modal-footer justify-content-right">
                      <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                      <a href="#" class="btn btn-outline-light">OK</a>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>

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
                      </div>
                      <div class="modal-footer justify-content-right">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                        <a href="#" class="btn btn-outline-light">OK</a>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>


              <div class="modal fade" id="modal-cancelbooking">
                  <div class="modal-dialog">
                    <div class="modal-content bg-warning">
                      <div class="modal-header">
                        <h4 class="modal-title">Cancel | Booking</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                      </div>
                      <div class="modal-body">
                        <p>Do you want to send Cancel request?</p>
                      </div>
                      <div class="modal-footer justify-content-right">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                        <a href="#" class="btn btn-outline-light">Yes</a>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
        
              
                <script src="plugins/jquery/jquery.min.js"></script>
                <!-- jQuery UI 1.11.4 -->
                <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
                <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
                <script>
                  $.widget.bridge('uibutton', $.ui.button)
                </script>
                
                <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> -->
                
                <!-- Bootstrap 4 -->
                <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                <!-- ChartJS -->
                <script src="plugins/chart.js/Chart.min.js"></script>
                <!-- Sparkline -->
                <script src="plugins/sparklines/sparkline.js"></script>
                <!-- JQVMap -->
                <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
                <script src="plugins/jqvmap/maps/jquery.vmap.world.js"></script>
                <!-- jQuery Knob Chart -->
                <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
                <!-- daterangepicker -->
                <script src="plugins/moment/moment.min.js"></script>
                <script src="plugins/daterangepicker/daterangepicker.js"></script>
                <!-- Tempusdominus Bootstrap 4 -->
                <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
                <!-- Summernote -->
                <script src="plugins/summernote/summernote-bs4.min.js"></script>
                <!-- overlayScrollbars -->
                <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
                <!-- AdminLTE App -->
                <script src="dist/js/adminlte.js"></script>
                <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
                <script src="dist/js/pages/dashboard.js"></script>
                <!-- AdminLTE for demo purposes -->
                <script src="dist/js/demo.js"></script>
                
                <!-- Bootstrap 4 -->
                <!-- Select2 -->
                <script src="plugins/select2/js/select2.full.min.js"></script>
                <!-- Bootstrap4 Duallistbox -->
                <script src="plugins/inputmask/jquery.inputmask.bundle.js"></script>
                <script src="plugins/moment/moment.min.js"></script>
                <!-- date-range-picker -->
                <script src="plugins/daterangepicker/daterangepicker.js"></script>
                <!-- bootstrap color picker -->
                <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
                <!-- Tempusdominus Bootstrap 4 -->
                <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
                <!-- AdminLTE App -->
                <!-- AdminLTE for demo purposes -->
                <script src="plugins/datatables/jquery.dataTables.js"></script>
                <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
                <!-- AdminLTE App -->
                <!-- AdminLTE for demo purposes -->
                <script src="dist/js/demo.js"></script>
                <!-- page script -->
                <script>
                  $(function () {
                    $('#example1').DataTable({
                      "paging": true,
                      "lengthChange": true,
                      "searching": true,
                      "ordering": true,
                      "info": true,
                      "autoWidth":false,
                    });
                    
                  });
                </script>
                
                <script>
                  $(function () {
                    //Initialize Select2 Elements
                    $('.select2').select2({
                      theme: 'bootstrap4'
                    })
                
                    //Datemask dd/mm/yyyy
                    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
                    //Datemask2 mm/dd/yyyy
                    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
                    //Money Euro
                    $('[data-mask]').inputmask()
                
                    //Date range picker
                    $('#reservation').daterangepicker()
                    //Date range picker with time picker
                    $('#reservationtime').daterangepicker({
                      timePicker: true,
                      timePickerIncrement: 30,
                      locale: {
                        format: 'MM/DD/YYYY hh:mm A'
                      }
                    })
                    //Date range as a button
                    $('#daterange-btn').daterangepicker(
                      {
                        ranges   : {
                          'Today'       : [moment(), moment()],
                          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        startDate: moment().subtract(29, 'days'),
                        endDate  : moment()
                      },
                      function (start, end) {
                        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                      }
                    )
                
                    //Timepicker
                    $('#timepicker').datetimepicker({
                      format: 'LT'
                    })
                    
                    //Bootstrap Duallistbox
                    $('.duallistbox').bootstrapDualListbox()
                
                    //Colorpicker
                    $('.my-colorpicker1').colorpicker()
                    //color picker with addon
                    $('.my-colorpicker2').colorpicker()
                
                    $('.my-colorpicker2').on('colorpickerChange', function(event) {
                      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
                    });
                  })
                </script>
                
                <script>
                    var acdonutChartCanvas = $('#donutChart').get(0).getContext('2d')
                     var donutData        = {
                       labels: [
                           'Completed', 
                           'Assigned',
                           
                       ],
                       datasets: [
                         {
                           data: [10,5],
                           backgroundColor : ['#f56954', '#00a65a'],
                         }
                       ]
                     }
                     var donutOptions     = {
                       maintainAspectRatio : false,
                       responsive : true,
                     }
                     //Create pie or douhnut chart
                     // You can switch between pie and douhnut using the method below.
                     var donutChart = new Chart(acdonutChartCanvas, {
                       type: 'doughnut',
                       data: donutData,
                       options: donutOptions      
                     })
                 
                 
                 </script>
                
                <script>
                    var ocdonutChartCanvas = $('#ocdonutChart').get(0).getContext('2d')
                     var donutData = {
                       labels: [
                           'Open', 
                           'Closed',
                       ],
                       datasets: [
                         {
                           data: [5,10],
                           backgroundColor : ['#C7D0E0','#4A7AB2'],
                         }
                       ]
                     }
                     var donutOptions     = {
                       maintainAspectRatio : false,
                       responsive : true,
                     }
                     //Create pie or douhnut chart
                     // You can switch between pie and douhnut using the method below.
                     var donutChart = new Chart(ocdonutChartCanvas, {
                       type: 'doughnut',
                       data: donutData,
                       options: donutOptions      
                     })
                 
                 </script>
                <script>
                
                  var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');
                  var stackedBarChartData = {
                    labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug' , 'Sept',
                      'Oct', 'Nov', 'Dec'
                    ],
                    datasets: [
                      {
                        label               : 'Sale',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : [28, 48, 40, 19, 86, 27, 90, 10,20,5]
                      },
                      {
                        label               : 'Payment',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : [65, 59, 80, 81, 56, 55, 40, 10, 11, 5]
                      },
                      {
                        label               : 'Reciept',
                        backgroundColor     : 'rgb(255, 193, 7)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : [65, 59, 80, 81, 56, 55, 40, 10, 20, 10]
                      },
                      {
                        label               : 'Guest',
                        backgroundColor     : 'rgb(220, 53, 69)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : [65, 59, 80, 81, 56, 55, 40, 10, 11, 5]
                      }
                    ],
                  }
                  var stackedBarChartOptions = {
                    
                    responsive              : true,
                    maintainAspectRatio     : false,
                    scales: {
                      xAxes: [{
                        stacked: true,
                      }],
                      yAxes: [{
                        stacked: true
                      }]
                    }
                  }
                
                  var stackedBarChart = new Chart(stackedBarChartCanvas, {
                    type: 'bar', 
                    data: stackedBarChartData,
                    options: stackedBarChartOptions
                  })
                 
                 </script>
                </body>
                </html>