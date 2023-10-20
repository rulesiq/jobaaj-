   <body>
       
       <!-- Begin page -->
       <div id="wrapper">

           <div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
               <div class="container-fluid">
                   <!-- LOGO -->
                   <a href="dashboard" class="navbar-brand mr-0 mr-md-2 logo">
                       <span class="logo-lg">
                           <img src="" alt="" height="24" />
                           <span class="d-inline h5 ml-1">Jobaaj Stories</span>
                       </span>
                       <span class="logo-sm">
                           <img src="" alt="" height="24">
                       </span>
                   </a>

                   <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
                       <li class="">
                           <button class="button-menu-mobile open-left disable-btn">
                               <i data-feather="menu" class="menu-icon"></i>
                               <i data-feather="x" class="close-icon"></i>
                           </button>
                       </li>
                   </ul>

                   <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">
                       <li class="d-none d-sm-block">
                           <div class="app-search">
                               <form>
                                   <div class="input-group">
                                       <input type="text" class="form-control" placeholder="Search...">
                                       <span data-feather="search"></span>
                                   </div>
                               </form>
                           </div>
                       </li>


                       <li class="dropdown notification-list" data-toggle="tooltip" data-placement="left" title="Logout">
                           <a href="logout.php" class="nav-link right-bar-toggle">
                               <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                           </a>
                       </li>

                   
                   </ul>
               </div>

           </div>


           <div class="left-side-menu">
               <div class="media user-profile mt-2 mb-2">
                   <img src="assets/avatar.png" class="avatar-sm rounded-circle mr-2" alt="Shreyu" />
                   <img src="assets/avatar.png" class="avatar-xs rounded-circle mr-2" alt="Shreyu" />
                    
                     <?php 
                        $role_id = $_SESSION['user_role'];
                        $role = mysqli_fetch_assoc(mysqli_query($db,"select role from com_roles where id = '$role_id'"));
                        $user_role =  $role['role'];
                        
                        $user_id = $_SESSION['user'];
                        
                        $user = mysqli_fetch_assoc(mysqli_query($db,"select name from authors where id = '$user_id'"));
                        $user_name =  $user['name'];
                           
                       ?>
                           
                           
                   <div class="media-body">
                       <h6 class="pro-user-name mt-0 mb-0"><?php echo $user_name;?></h6>
                       <span class="pro-user-desc">
                          <?php echo $user_role;?>
                           
                       </span>
                   </div>
                   <div class="dropdown align-self-center profile-dropdown-menu">
                       <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                           <span data-feather="chevron-down"></span>
                       </a>
                       <div class="dropdown-menu profile-dropdown">
                           <a href="#" class="dropdown-item notify-item">
                               <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
                               <span>My Account</span>
                           </a>

                           <a href="javascript:void(0);" class="dropdown-item notify-item">
                               <i data-feather="settings" class="icon-dual icon-xs mr-2"></i>
                               <span>Settings</span>
                           </a>
                       </div>
                   </div>
               </div>
               <div class="sidebar-content">
                   <!--- Sidemenu -->
                   <div id="sidebar-menu" class="slimscroll-menu">
                       <ul class="metismenu" id="menu-bar">
                           <li class="menu-title">Navigation</li>

                           <li>
                               <a href="javascript: void(0);">
                                   <i data-feather="trending-up"></i>
                                   <span> Posts </span>
                                   <span class="menu-arrow"></span>
                               </a>
                               <ul class="nav-second-level" aria-expanded="false">
                                   <li>
                                       <a href="all_posts">Manage Posts</a>
                                   </li>
                                   
                                    <li>
                                       <a href="add-comments">Manage Comments</a>
                                   </li>
                               </ul>
                           </li>
                           
                           <?php if($role_id == 1) { ?>
                           
                           <li>
                               <a href="category">
                                   <i data-feather="trending-up"></i>
                                   <span> Post Category </span>
                               </a>
                           </li>
                           
                           
                            <li>
                               <a href="javascript: void(0);">
                                   <i data-feather="trending-up"></i>
                                   <span> Polls </span>
                                   <span class="menu-arrow"></span>
                               </a>
                               <ul class="nav-second-level" aria-expanded="false">
                                   <li>
                                       <a href="add-poll">Manage Polls</a>
                                   </li>
                               </ul>
                           </li>
                           
                           <li>
                               <a href="javascript: void(0);">
                                   <i data-feather="trending-up"></i>
                                   <span> Notifications </span>
                                   <span class="menu-arrow"></span>
                               </a>
                               <ul class="nav-second-level" aria-expanded="false">
                                   <li>
                                       <a href="post-notify">Post Notify</a>
                                   </li>
                                    <li>
                                       <a href="user-notify">User Notify</a>
                                   </li>
                               </ul>
                           </li>
                           
                           

        
                           <li>
                               <a href="allUsers">
                                   <i data-feather="users"></i>
                                   <span> Users </span>
                               </a>
                           </li>
                           
                          <?php } ?>


                       </ul>
                   </div>
                   <!-- End Sidebar -->

                   <div class="clearfix"></div>
               </div>
               <!-- Sidebar -left -->

           </div>