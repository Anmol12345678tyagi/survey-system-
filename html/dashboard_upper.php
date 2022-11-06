
<?php
session_start();

if(!isset($_SESSION['name'])){
  header("location:login.php");
}

include_once 'header.php';
include_once 'footer.php';

?>
  
<div class="wrapper">
        <!-- Sidebar  -->
      <nav id="sidebar" style="">
          <div class="sidebar-header">
              <h3>Create A Survey</h3>
          </div>

          <ul class="list-unstyled components first_ul">
              
              <li class="active">
              <a href="#">Dashboard</a>
              </li>
              <li>
                  <a href="">Home</a>
              </li>
              <li>
                  <!-- <a href="#pageSubmenu">Surveys</a> -->
                  <div class="dropdown">
                      <button class="btn dropdown-toggle" style="text-align:start;color:white;width:98%" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Survey
                      </button>
                       <!-- <a href="#drop" data-toggle="collapse"  aria-expanded="false" class="dropdown-toggle" >SURVEY</a> -->
                      <ul class="dropdown-menu bg-dark" aria-labelledby="dropdownMenuButton1" id="drop">
                        <li><a class="dropdown-item" href="survey_desc.php">Create Survey</a></li>
                        <li><a class="dropdown-item" href="survey_list.php">Survey List</a></li>
                      </ul>
                    </div>

              </li>
              <li>
                  <!-- <a href="#target_con">users</a> -->
                  <div class="dropdown">
                      <button class="btn dropdown-toggle " style="text-align:start;color:white;width:98%" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Users
                      </button>
                      <ul class="dropdown-menu bg-dark" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="new_user.php">Add New User</a></li>
                        <li><a class="dropdown-item" href="user_table.php">Users list</a></li>
                      </ul>
                    </div>
              </li>
              <li>
                  <a href="report.php">Report</a>
              </li>
              <li>
                  <a href="#">Setting</a>
              </li>
          </ul>
              <div style="margin-left:10px;margin-top:50px;">
              <p style="color:white">fOOTPRINTS_SURVEY.COM</p>
              </div>
      </nav>

        <!-- Page Content  -->
       <div class="container-fluid con_fluid" style="background-color: white;">
          <!-- navbar -->
              <div class="nav_div">
                  <nav class="navbar p-2 m-0 navbar-expand navbar-dark" style="background-color:#7386D5">
                      <div class="container-fluid">
                          <button type="button" id="sidebarCollapse" class="btn btn-info" style="width:40px">
                          <i class="fas fa-align-left"></i>
                          <!-- <span>Toggle Sidebar</span> -->
                          </button>

                          <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                              <li class="nav-item">
                                <a style="font-size:25px" class="nav-link active" aria-current="page" href="#">Survey System</a>
                              </li>
                            </ul>
                            <form class="d-flex">
                              <!-- session -->
                              <div class="dropdown mx-3">
                                    <a href="#" class="text-white text-decoration-none dropdown-toggle ms-5" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                      <span class="me-5" ><?php echo $_SESSION['name']; ?></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-light ">
                                      <!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->
                                      <li><a class="dropdown-item " href="user_profile.php">Profile</a></li>
                                        <!-- <li>
                                          <hr class="dropdown-divider">
                                        </li> -->
                                      <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                                    </ul>
                                  </div>
                              <!-- <button class="btn btn-outline-success" type="submit" style="color:white"><a href="log  in.php">Log Out</a></button> -->
                            </form>
                          </div>
                        </div>
                    </nav>
                </div>

                <div class="content_div" id="target_con" >
                 