  <?php require('inc/head.php'); 
     require('inc/sidenav.php'); 
     $a = "dash";
    ?>
  
            <div class="content-page" >
                <div class="content">
                    <div class="container-fluid">
                        <div class="row page-title align-items-center" style="margin-top:-20px;">
                            <div class="col-sm-4 col-xl-6">
                                <br>
                                <h4 class="mb-1 mt-0">Dashboard
                                </h4>
                            </div>
                            <div class="col-sm-8 col-xl-6">
                                <form class="form-inline float-sm-right mt-3 mt-sm-0">
                                </form>
                            </div>
                        </div>

                        <!-- content -->
                        <div class="row">
                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="media p-3">
                                            <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">Active Courses</span>
                                                <h2 class="mb-0"><?php ?></h2>
                                            </div>
                                            <div class="align-self-center">
                                                <!--<div id="today-revenue-chart" class="apex-charts"></div>-->
                                                <!--<span class="text-success font-weight-bold font-size-13"><i-->
                                                <!--        class='uil uil-arrow-up'></i> 10.21%</span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="media p-3">
                                            <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">Total Users</span>
                                                <h2 class="mb-0"><?php ?></h2>
                                            </div>
                                            <div class="align-self-center">
                                                <!--<div id="today-product-sold-chart" class="apex-charts"></div>-->
                                                <!--<span class="text-danger font-weight-bold font-size-13"><i-->
                                                <!--        class='uil uil-arrow-down'></i> 5.05%</span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="media p-3">
                                            <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">Total Author </span>
                                                <h2 class="mb-0"><?php ?></h2>
                                            </div>
                                            <div class="align-self-center">
                                                <!--<div id="today-new-customer-chart" class="apex-charts"></div>-->
                                                <!--<span class="text-success font-weight-bold font-size-13"><i-->
                                                <!--        class='uil uil-arrow-up'></i> 25.16%</span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                               <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="media p-3">
                                            <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">Total Lessons </span>
                                                <h2 class="mb-0"><?php  ?></h2>
                                            </div>
                                            <div class="align-self-center">
                                                <!--<div id="today-new-customer-chart" class="apex-charts"></div>-->
                                                <!--<span class="text-success font-weight-bold font-size-13"><i-->
                                                <!--        class='uil uil-arrow-up'></i> 25.16%</span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                               <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="media p-3">
                                            <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold"> Total Enrollments / Students </span>
                                                <h2 class="mb-0"><?php  ?></h2>
                                            </div>
                                            <div class="align-self-center">
                                                <!--<div id="today-new-customer-chart" class="apex-charts"></div>-->
                                                <!--<span class="text-success font-weight-bold font-size-13"><i-->
                                                <!--        class='uil uil-arrow-up'></i> 25.16%</span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                               <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="media p-3">
                                            <div class="media-body">
                                                <span class="text-muted text-uppercase font-size-12 font-weight-bold">Total Transactions </span>
                                                <h2 class="mb-0"><?php  ?></h2>
                                            </div>
                                            <div class="align-self-center">
                                                <!--<div id="today-new-customer-chart" class="apex-charts"></div>-->
                                                <!--<span class="text-success font-weight-bold font-size-13"><i-->
                                                <!--        class='uil uil-arrow-up'></i> 25.16%</span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            

                       
                        </div>

                        <!-- stats + charts -->
                     
                        <!-- end row -->

                        <!-- widgets -->
     
                        <!-- end row -->
                        
                        <div class="row">
                            <div class="col-xl-5">
                               <div class="card">
                                    <div class="card-body">
                                      
                                        <h5 class="card-title mt-0 mb-0 header-title">Recent Users</h5>

                                        <div class="table-responsive mt-4">
                                          
                                            <table class="table table-hover table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    
                                                </tbody>
                                                
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                            <div class="col-xl-7">
                                <div class="card">
                                    <div class="card-body">
                                        <a href="transactions?status=1" class="btn btn-primary btn-sm float-right">
                                            <i class="uil uil-export ml-1"></i> View All
                                        </a>
                                        <h5 class="card-title mt-0 mb-0 header-title">Recent Transactions</h5>

                                        <div class="table-responsive mt-4">
                                            <table class="table table-hover table-nowrap mb-0">
                                               <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">User</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        
                        

                    </div>
                </div> <!-- content -->
  <?php require('inc/foot.php'); ?>
       