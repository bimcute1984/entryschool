<<<<<<< HEAD
<!--  Header Start -->
<header class="app-header">
      


        <nav class="navbar navbar-expand-lg navbar-light">
          

          
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <p><?php echo $_SESSION['prefix']. $_SESSION['fullName']. "  ".$_SESSION['surName'];?><br>
              <?php echo "โรงเรียน".$_SESSION['SCHOOLNAME'];?></p>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
           
                    <a href="logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
              

            </ul>
          </div>
          



          
        </nav>
        
      </header>
      <!--  Header End -->

      


      
=======
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Header Start -->
<header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        <p>
          <?php
            $prefix = $_SESSION['prefix'] ?? '';
            $fullName = $_SESSION['fullName'] ?? '';
            $surName = $_SESSION['surName'] ?? '';
            $schoolName = $_SESSION['SCHOOLNAME'] ?? '';

            echo $prefix . $fullName . " " . $surName . "<br>";
            echo "โรงเรียน" . $schoolName;
          ?>
        </p>

        <li class="nav-item dropdown">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
            aria-expanded="false">
            <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
            <div class="message-body">
              <a href="logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!-- Header End -->
>>>>>>> 29b51cc (Test commit)
