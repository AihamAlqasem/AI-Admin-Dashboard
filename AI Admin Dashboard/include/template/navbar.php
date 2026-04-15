	<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="direction: ltr; text-align: center;">
            <!-- Navbar Brand-->
           
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                   
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-2 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['Sessionid']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <!-- <li><a class="dropdown-item" href="#!">Activity Log</a></li> -->
                        <li><a class="dropdown-item" href="logout.php">تسجيل الخروج</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="navbar-brand ps-3" href="dashboard.php">مشروع الدكتور عدي</a>
                </li>

            </ul>
        </nav>
