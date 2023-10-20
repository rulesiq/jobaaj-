  <?php require('inc/head.php'); 
  require('inc/sidenav.php'); 
    $a = "dash";
  ?>
  
   <!-- plugin css -->
        <link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
  <?php
  
  
  
  if(isset($_GET['edit'])) {
        $p = mysqli_fetch_array(mysqli_query($db,"select * from blog_category where id = '$_GET[edit]'"));        
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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
                                <h4 class="mb-1 mt-0" id="Htitle">Add Category </h4>
 </h4>
                            </div>
                        </div>
                       
                        
                         <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" style="padding: 30px;">
                                        <form action="" method="post" enctype="multipart/form-data">
                                              <div class="row">
                                               <div class="col-xl-12">
                                        
                                        <div class="row">
                                            
                                                <div class="col-sm-6">
                                                 <div class="form-group">
                                                      <label>Category Name</label>
                                                <input name="name" id="title_slug_id"  value="<?php echo $p['title'];?>"  class="form-control">
                                                </div>
                                                </div>
                                               
                                                <div class="col-sm-6">
                                                <div class="form-group">
                                                <label>Category Parent</label>
                                                <select required  data-plugin="customselect" class=" form-control" name="parent">
                                                    <option selected value="0">Select Category</option>
                                                    <?php
                                                    $data = mysqli_query($db,"select * from blog_category where parent = 0 order by id desc");
                                                    while($cat = mysqli_fetch_array($data)) {
                                                    ?>
                                                    <option <?php echo ($cat['parent']==$p['id'])?'selected':''; ?>  value="<?php echo $cat['id'];?>"><?php echo $cat['title'];?></option>
                                                    <?php } ?>
                                                  </select>
                                                </div>
                                                 </div>
                                                 
                                                 <div class="col-sm-6">
                                                 <div class="form-group">
                                                      <label>Slug</label>
                                                <input name="slug" id="slug_id"  value="<?php echo $p['slug'];?>"  class="form-control">
                                                </div>
                                                </div>
                                               
                                                <!--<div class="col-sm-6">-->
                                                <!--  <div class="form-group">-->
                                                <!--      <label>Category Icon ( Optional ) </label>-->
                                                <!--<input name="thumb" type="file"   class="form-control"  >-->
                                                <!--</div>-->
                                                <!-- </div>-->
                                                
                                                <input type="hidden" name="update_id" value="<?php echo $_GET['edit']; ?>" >
                                               
                                              
                                               <div id="session" class="form-group" style="    width: 100%;margin-top:10px;">
                                               
                                                    <?php if($p['id'] != null){ ?>
                                                 <input type="submit" name="updateCat" value="Update Category" style="float: right; margin-top: 12px;" class="btn btn-danger"/>
                                                <?php } else { ?>
                                                    <input type="submit" name="addCat" value="Add Category" style="float: right; margin-top: 12px;" class="btn btn-danger"/>

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
                        
                          <h4 class="mb-1 mt-0" id="Htitle" style="margin-bottom: 1.25rem!important;">Categories <br></h4>

                        <form action="" method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" style="padding: 30px;">

                                  <div class="table-responsive">
                                            <table id="basic-datatable" class="table ">
                                                <thead>
                                                    <tr>
                                                    <th scope="col"><input id="checkAll" type="checkbox"></th>
                                                    <!--<th scope="col">Icon</th>-->
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Parent</th>
                                                    <th scope="col">Slug</th>
                                                    <th  scope="col">Edit</th>
                                                    <th  scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $i=1;
                                                    $as=mysqli_query($db,"select * from blog_category order by id desc");
                                                    while($us=mysqli_fetch_assoc($as))
                                                    {

                                                ?>
                                                    <tr>
                                                    <th scope="row"><input name="cUser[]" value="<?php echo $us['id'];?>" type="checkbox"/></th>
                                                    <!--<td><img  src="../data/cat/<?php echo $us['thumbnail']; ?>" width=100/></td>-->
                                                    <td><?php echo $us['title']; ?></td>
                                                    
                                                    <td>
                                                        <?php 
                                                            if($us['parent']!=0){
                                                                $p_title=mysqli_fetch_assoc(mysqli_query($db,"select * from blog_category where id='$us[parent] '"));
                                                                echo $p_title['title']; 
                                                            }else{
                                                                echo '';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $us['slug']; ?></td>
                                                     <td><a href="?edit=<?php echo $us['id'];?>">Edit</a></td>
                                                     <td><a href="?delete=<?php echo $us['id'];?>">Delete</a></td>
                                                    </tr>
                                                
                                                  <?php $i++;} ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
    
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </from>
                        </div>
                        
                        
                        

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


if(isset($_GET['delete'])){
    
    $done = mysqli_query($db,"DELETE FROM blog_category WHERE id = '$_GET[delete]' ");
    echo "<script>alert('Category Deleted!');location.href='category';</script>";
}


    if(isset($_POST['addCat'])){
    
        // if(isset($_FILES['thumb']))
        // {
            // $thumb = $_FILES['thumb']['name'];
            // $thumbpath = $_FILES['thumb']['tmp_name'];
            
            // $rand = rand(100,999);
            // $thumb = $rand.$thumb;
            // }
            // $date = time();
            $run = mysqli_query($db,"INSERT INTO `blog_category` (`id`, `title`, `parent`,`slug` ) VALUES (NULL,'$_POST[name]', '$_POST[parent]', '$_POST[slug]');");
            
            if($run){
            // move_uploaded_file($thumbpath, "../data/cat/".$thumb);
            echo "<script>location.href='category';</script>";
         }else{
             
         }
    }
    
    

if(isset($_POST['updateCat'])){

    // if(isset($_FILES['thumb']))
    // {
    //     $thumb = $_FILES['thumb']['name'];
    //     $thumbpath = $_FILES['thumb']['tmp_name'];
    //     $rand = rand(100,999);
    //     $thumb = $rand.$thumb;
    
    //     if($_FILES['thumb']['name']==''){
    //         $thumb = $_POST['pre_thumb'];
    //     }
    // }
    $run = mysqli_query($db,"update blog_category set title = '$_POST[name]', parent = '$_POST[parent]', slug = '$_POST[slug]'
    where id = '$_POST[update_id]'");
    
    if($run){
    // move_uploaded_file($thumbpath, "../content/logo/".$thumb);
    echo "<script>location.href='category';</script>";
    }else {
    echo mysqli_error($db);
    }
}



        
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

  <?php require('inc/foot.php'); ?>
  
  <script>
      
      $("#title_slug_id").focusout(function(){
      
        var slug = $(this).val();
        slug = slug.replaceAll(" ","-");
        slug = slug.toLowerCase();
        
        $("#slug_id").val(slug);
      
      });
      
  </script>
       
       
       