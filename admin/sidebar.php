<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-info">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link navbar-info">
        <img src="logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light text-white">Easy FDM</span>
    </a>

    <!-- Sidebar -->
    <div
        class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
        <div class="os-resize-observer-host">
            <div class="os-resize-observer observed" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer observed"></div>
        </div>
        <div class="os-content-glue" style="margin: 0px -8px;"></div>
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible"
                style="overflow-y: scroll; right: 0px; bottom: 0px;">
                <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block"><?php echo $_SESSION['user_name']; ?>
                                <span class="float-right badge bg-success ml-4 mt-1">Online</span>
                            </a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                            <li class="nav-item has-treeview menu-open  pb-3">
                                <a href="index.php" class="nav-link <?php echo ($page_name == "index.php")? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item has-treeview menu-open">
                                <a href="#" class="nav-link <?php echo ($page_section == 1)? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        FRONT DESK
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="fd_guests.php" class="nav-link <?php echo ($page_name == "fd_guests.php"  || $page_name == "fd_newGuest.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-window-maximize"></i>
                                            <p>
                                                Guests
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="fd_bookings.php" class="nav-link <?php echo ($page_name == "fd_bookings.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-window-maximize"></i>
                                            <p>
                                                Booking
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="fd_checkins.php" class="nav-link <?php echo ($page_name == "fd_checkins.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-window-maximize"></i>
                                            <p>
                                                Check-Ins
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="fd_checkouts.php" class="nav-link <?php echo ($page_name == "fd_checkouts.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-window-maximize"></i>
                                            <p>
                                                Check-Outs
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="rpt_airportPickup.php" class="nav-link <?php echo ($page_name == "rpt_airportPickup.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-list-alt"></i>
                                            <p>
                                                Airport Pickup List
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="rpt_arrivals.php" class="nav-link <?php echo ($page_name == "rpt_arrivals.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-list-alt"></i>
                                            <p>
                                                Arrivals List
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="rpt_departures.php" class="nav-link <?php echo ($page_name == "rpt_departures.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-list-alt"></i>
                                            <p>
                                                Departure List
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item user-panel">
                                        <a href="rpt_cancellations.php" class="nav-link <?php echo ($page_name == "rpt_cancellations.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-list-alt"></i>
                                            <p>
                                                Cancelled List
                                            </p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item has-treeview menu-open">
                                <a href="#" class="nav-link <?php echo ($page_section == 2)? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-dollar-sign"></i>
                                    <p>
                                        ACCOUNTING
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="ac_bills.php" class="nav-link <?php echo ($page_name == "ac_bills.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-window-maximize"></i>
                                            <p>
                                                Bills
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="ac_receipts.php" class="nav-link <?php echo ($page_name == "ac_receipts.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-window-maximize"></i>
                                            <p>
                                                Receipts
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="ac_payments.php" class="nav-link <?php echo ($page_name == "ac_payments.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-window-maximize"></i>
                                            <p>
                                                Payments
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="rpt_guestFolio.php" class="nav-link <?php echo ($page_name == "rpt_guestFolio.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-list-alt"></i>
                                            <p>
                                                Guest Folio
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="rpt_salesSummary.php" class="nav-link <?php echo ($page_name == "rpt_salesSummary.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-list-alt"></i>
                                            <p>
                                                Sales Summary
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="rpt_receiptsSummary.php" class="nav-link <?php echo ($page_name == "rpt_receiptsSummary.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-list-alt"></i>
                                            <p>
                                                Receipts Summary
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="rpt_paymentsSummary.php" class="nav-link <?php echo ($page_name == "rpt_paymentsSummary.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-list-alt"></i>
                                            <p>
                                                Payment Summary
                                            </p>
                                        </a>
                                    </li>


                                </ul>
                            </li>

                            <li class="nav-item has-treeview menu-open" <?php if($_SESSION['role_id'] != 1) echo 'style="display:none"' ?> >
                                <a href="#" class="nav-link <?php echo ($page_section == 3)? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-lock-open"></i>
                                    <p>
                                        ADMINISTRATION
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="am_rooms.php" class="nav-link <?php echo ($page_name == "am_rooms.php")? 'active' : ''; ?>">
                                            <i class="fab fa-buromobelexperte nav-icon"></i>
                                            <p>
                                                Rooms
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="am_roomTypes.php" class="nav-link <?php echo ($page_name == "am_roomTypes.php")? 'active' : ''; ?>">
                                            <i class="fab fa-buromobelexperte nav-icon"></i>
                                            <p>
                                                Room Types
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="am_roomRate.php" class="nav-link <?php echo ($page_name == "am_roomRate.php")? 'active' : ''; ?>">
                                            <i class="fab fa-buromobelexperte nav-icon"></i>
                                            <p>
                                                Room Rates
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="am_chargeCodes.php" class="nav-link <?php echo ($page_name == "am_chargeCodes.php")? 'active' : ''; ?>">
                                            <i class="fab fa-buromobelexperte nav-icon"></i>
                                            <p>
                                                Charge Codes
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="am_users.php" class="nav-link <?php echo ($page_name == "am_users.php" || $page_name == "am_newUser.php")? 'active' : ''; ?>">
                                            <i class="fas fa-user-cog nav-icon"></i>
                                            <p>
                                                Users
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="am_roles.php" class="nav-link <?php echo ($page_name == "am_roles.php")? 'active' : ''; ?>">
                                            <i class="nav-icon fas fa-tags"></i>
                                            <p>
                                                Roles
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="am_company.php" class="nav-link <?php echo ($page_name == "am_company.php")? 'active' : ''; ?>">
                                            <i class="fas fa-plus-circle nav-icon"></i>
                                            <p>
                                                Company
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item has-treeview ">
                                <a href="index.php?logout=1" class="nav-link">
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        LOGOUT
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="height: 73.8117%; transform: translate(0px, 0px);">
                </div>
            </div>
        </div>
        <div class="os-scrollbar-corner"></div>
    </div>
    <!-- /.sidebar -->
</aside>