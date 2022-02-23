<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Signup</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <style>
   #footer-MyLogin {
      position: relative;
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
    <a href="#"><img src="./logo.png" alt="PUCIT | LOGO" width="180px;" height="140px"></a>
  </div>
  <div class="login-logo m-0" >
      <p class="login-box-msg">Easy FDM</p>
    </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">SIGN UP</p>

      <form action="signup.php" method="post">
        <div class="input-group mb-3">
          <?php include('errors.php'); ?>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="full_name" value="<?php echo $full_name; ?>" placeholder="Name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control"  name="user_name" value="<?php echo $user_name; ?>" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password_1"  placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" class="form-control" name="password_2" placeholder="Re-Type Your Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
        <div class="row mb-3">
          
          <!-- /.col -->
          <div class="col">
            <button type="submit" name="reg_user" class="btn btn-primary btn-block btn-flat">Create New Account</button>
          </div>
          <!-- /.col -->
        </div>

        
        <div class="row text-center">
          <div class="col">
            <p>Already have an account? <a href="login.php">Sign In</a></p>   
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

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
