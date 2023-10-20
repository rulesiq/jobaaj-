  <?php require('inc/head.php'); 
    require('inc/sidenav.php'); 
    $a = "dash";
  ?>
   <!-- plugin css -->
        <link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

        <link href="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
        <link href="assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
        <style>
            .select2-container .select2-selection--multiple .select2-selection__choice {
                background-color: #5369f8;
                border: none;
                color: #fff;
                border-radius: 3px;
                padding: 0 7px;
                margin-top: 6px;
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                color: #fff;
                cursor: pointer;
                display: inline-block;
                font-weight: bold;
                margin-right: 6px;
            }

            .select2-container .select2-selection--single{
                height:38px;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 26px;
                position: absolute;
                top: 3px;
                right: 4px;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #444;
                line-height: 36px;
                
                }h5{
                        font-size: 15px;

                }
                .col-sm-4, .col-sm-6, .col-sm-3, .col-sm-12 {
                margin-top: 15px;
                }
        </style>
  <?php
  

  
  if(isset($_GET['delete'])){
      $done = mysqli_query($db,"DELETE FROM `authors` WHERE `id` = '$_GET[delete]' ");
      if($done){
          echo "<script>alert('Author Deleted!');location.href='allUsers';</script>";
         }
  }
    if(isset($_GET['edit'])) {
        $p = mysqli_fetch_array(mysqli_query($db,"select * from users where id = '$_GET[edit]'"));        
    }
    
  ?>
  <style>
      table img {
          width:53px;border-radius:100px;height:50px;
      }
      label {
    display: block; 
    text-align:left;}
  </style>



        <!-- Left Sidebar End -->
   
         <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    
                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                          <div class="row page-title">
                            <div class="col-md-12">
                                <nav  id="dd" aria-label="breadcrumb" class="float-right mt-1">
                                </nav>
                                <h4 class="mb-1 mt-0" id="Htitle">Add Author </h4>
 </h4>
                            </div>
                        </div>
                        
                        
                         <form action="fun/user_login.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" style="padding: 30px;">

                                              <div class="row">
                                    <div class="col-xl-12">
                                        
                                        <div class="row">
                                            
                                                <div class="col-sm-6">
                                                 <div class="form-group">
                                                      <label>Name</label>
                                                <input name="name" required  value="<?php echo $p['name'];?>"  class="form-control">
                                                </div>
                                                </div>
                                                <div class="col-sm-6">
                                                 <div class="form-group">
                                                      <label>Email</label>
                                                <input name="email"    type="email" required value="<?php echo $p['email'];?>"  class="form-control"  >
                                                </div>
                                                </div>
                                                <div class="col-sm-6">
                                                <div class="form-group">
                                                <label>Password</label>
                                                <input type="hidden"  value="<?php echo $p['id'];?>" name="u_id">
                                                <input name="secure" required   value="<?php echo $p['pass'];?>"  class="form-control"  >
                                                </div>
                                                </div>
                                              
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                <label>Role</label>
                                                    <select required class="form-control" name="role">
                                                        <option value=>Select</option>
                                                        <option value=1>Admin</option>
                                                        <option value=2>Manager</option>
                                                        <option value=3>Editor</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                
                                               <div id="session" class="form-group">
                                                <?php if($p['id'] != null){ ?>
                                                 <input type="submit" name="updateUser" value="Update User" style="width:200px;" class="btn btn-danger"/>
                                                <?php } else { ?>
                                                 <input type="submit" name="addUser" value="Add User" style="float: right; margin-top: 12px;" class="btn btn-danger"/>
                                                <?php } ?>
                                        </form>

                                               </div>

                                               
                                               </div>

                                    </div>
                                  <div class="col-xl-1"></div>
                                   
                                        </div> 
                                        
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        
                        
                   
                        <style>
                            .filter{
                                width:200px!important;
                                float:left; 
                            }
                            .bootstrap-select.form-control:not([class*="col-"]) {
                                width: 200px!important;
                                float:left!important;
                            }
                        </style>
                      

                        <!-- onchange="this.form.submit()" -->
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" style="padding: 30px;">
                                  <div class="table-responsive">
                                            <table id="basic-datatable" class="table ">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Role</th>
                                                    <th scope="col">Status</th>
                                                    <th  scope="col">Edit</th>
                                                    <th  scope="col">Delete</th>
                                                    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $role=$_SESSION['user_role']+1;
                                                    $q=mysqli_query($db,"select a.id,a.name,a.user,r.role,a.status from authors a join roles r on a.role_id = r.id order by a.id desc ");
                                                    while($pl=mysqli_fetch_assoc($q))
                                                    {
                                                        
                                                ?>
                                                    <tr>
                                                    <td><?php echo $pl['name']; ?></td>
                                                       <td><?php echo $pl['user']; ?></td>
                                                       <td><?php echo $pl['role']; ?></td>
                                                       <td><?php echo ($pl['status'] == 1) ? 'Active' : 'Inactive'; ?></td>
                                                     <td><a href="?edit=<?php echo $pl['id'];?>">Change</a></td>
                                                     <td><?php if($pl['role']!='Admin') { ?><a href="?delete=<?php echo $pl['id'];?>">Delete</a><?php } ?></td>
                                                    </tr>
                                                
                                                  <?php $i++;} ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        
                                        
    
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        
                        
                        

                        <!-- end row-->
        
           
                        <!-- end row-->

                    </div> <!-- container-fluid -->

                        <!-- end row-->
        
           
                        <!-- end row-->

                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                

                <!-- end Footer -->

            </div>

<script>
    $(document).ready(function(){
       $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
}); 
    });
</script>
         
<?php



?>


    <!-- ============================================================== -->
            <!-- End Page content -->

        <!-- Right bar overlay-->
          <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>
        
        <script src="assets/libs/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/libs/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/libs/datatables/buttons.html5.min.js"></script>
        <script src="assets/libs/datatables/buttons.flash.min.js"></script>
        <script src="assets/libs/datatables/buttons.print.min.js"></script>

        <script src="assets/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="assets/libs/datatables/dataTables.select.min.js"></script>
                <!-- Datatables init -->
        <!-- select  -->
        <script src="assets/libs/select2/select2.min.js"></script>
        <script src="assets/libs/multiselect/jquery.multi-select.js"></script>
        <script src="assets/js/pages/form-advanced.init.js"></script>

        <script type="text/javascript">
            var last_valid_selection = null;
            $('.singleselect').change(function(event) {
                if ($(this).val().length >1) {
                    alert('Please select only one option \n Otherwise it will not work');
                    // console.log('hi');
                    $(this).val(last_valid_selection);

                    // alert('Only one option is allowed');
                } 
                else 
                {
                last_valid_selection = $(this).val();
                }
                
            });
            // $(".singleselect").change(function() {
            //     if ($("select option:selected").length > 2) {
            //         $(this).removeAttr("selected");
            //         alert('You can select upto 2 options only');
            //     }
            // });
        </script>
        

  <?php require('inc/foot.php'); ?>
  <style>
.mark, mark {
    padding: 0.2em;
    background-color: #FCF9A2;
}
</style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/mark.min.js"integrity="sha512-5CYOlHXGh6QpOFA/TeTylKLWfB3ftPsde7AnmhuitiTX4K5SqCLBeKro6sPS8ilsz1Q4NRx3v8Ko2IBiszzdww==" crossorigin="anonymous"></script>
     <script>
            // Select the whole paragraph
            var ob = new Mark(document.querySelector("#basic-datatable"));
  
            // First unmark the highlighted word or letter
            ob.unmark();
  
            // Highlight letter or word
            ob.mark(
                document.getElementById("hkey").value,
               
            );
    </script>
    <!-- <script>
        let searched = document.getElementById("hkey").value.trim();
        if (searched !== "") {
                
            let re = new RegExp(searched,"g"); // search for all instances
                let newText = text.replace(re, `<mark>${searched}</mark>`);
                document.getElementById("basic-datatable").innerHTML = newText;
        }
    </script> -->