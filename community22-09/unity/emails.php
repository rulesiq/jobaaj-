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
 </h4>
                            </div>
                        </div>
                       
                        
                    
                        
                          <h4 class="mb-1 mt-0" id="Htitle" style="margin-bottom: 1.25rem!important;">Emails <br></h4>

                        <form action="" method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body" style="padding: 30px;">

                                  <div class="table-responsive">
                                            <table id="basic-datatable" class="table ">
                                                <thead>
                                                    <tr>
                                                    <!--<th scope="col">Icon</th>-->
                                                    <th scope="col">Email</th>
                                                    <th  scope="col">Register On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $i=1;
                                                    $as=mysqli_query($db,"select * from stories_subscribe order by id desc");
                                                    while($us=mysqli_fetch_assoc($as))
                                                    {

                                                ?>
                                                    <tr>
                                                    <td><?php echo $us['email']; ?></td>
                                                    
                                                    <td><?php echo $us['date_added']; ?></td>
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
       
       
       