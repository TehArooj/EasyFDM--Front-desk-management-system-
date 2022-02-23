<?php include('server.php') ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="plugins/ionicons/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

  <style>
   #footer-MyLogin {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 2.5rem;
      text-align: center;
    }

  
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo" >
    <a href="#"><img src="./logo.png" alt="Royal Customer Service" width="300px;" height="240px"></a>
  </div>
  <div class="login-logo m-0" >
      <p class="login-box-msg">Easy FDM</p>
    </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">SIGN IN</p>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <?php include('errors.php'); ?>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          
          <!-- /.col -->
          <div class="col">
            <button type="submit" class="btn btn-primary btn-block btn-flat" name="login_user">Sign In</button>
          </div>
          <!-- /.col -->
        </div>

        
        <div class="row text-center">
          <div class="col">
            <a href="signup.php">Create New Account</a>

          </div>
        </div>
      </form>


     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<footer id="footer-MyLogin" class="">
    Semester Project - <a href="https://pucit.edu.pk/" target="_blank">PUCIT</a>.
</footer>



<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function(){
      $.urlParam = function(name){
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      return results[1] || 0;
    }

    if($.urlParam('signup') == 1){
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      Toast.fire({
        type: 'success',
        title: 'Signup successfull. Please login.'
      });
    }

  });
</script>

</body>
</html>
