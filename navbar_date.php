<nav class="main-header navbar navbar-expand navbar-dark navbar-info">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item" style="height:41px;">
        <form action="" method="GET">

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="date" class="form-control float-right" name="from" id="from">
                    <input type="date" class="form-control float-right" name="todate" id="todate">
                    <button type="submit" class="btn btn-secondary btn-flat">Go</button>
                </div>
                <!-- /.input group -->
            </div>
        </form>
        </li>

    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#modal-logout">
                <i class="nav-icon fas fa-sign-out-alt"></i>
            </a>
        </li>

    </ul>
</nav>

<!-- ./wrapper -->
<div class="modal fade" id="modal-logout">
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
                <a href="index.php?logout=1" class="btn btn-outline-light">OK</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>