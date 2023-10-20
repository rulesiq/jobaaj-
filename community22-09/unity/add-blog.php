  <?php
  $page = "blog";
  require('inc/head.php');
  require('inc/sidenav.php');
  $a = "dash";
  mysqli_set_charset($db, 'utf8mb4');

  ?>

  <!-- plugin css -->
  <link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

  <link href="assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

  <link href="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
  <link href="assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />



  <?php

  if (isset($_GET['edit'])) {
    $p = mysqli_fetch_array(mysqli_query($db, "select * from com_posts where p_id = '$_GET[edit]'"));
  }
  
   if (isset($_GET['status']) && isset($_GET['post']) ) {
    $p = mysqli_query($db, "update com_posts set status = '$_GET[status]' where p_id = '$_GET[post]'");
    
    if($_GET['status'] == 0){
        $st = "Pending";
    }else{
        $st = "Approved";
    }
    $post = $_GET['post_id'];
    notification($_GET['user'],"Your post has been  ".$st,$post,1);

    echo "<script>location.href='https://community.jobaajlearnings.com/unity/add-blog';</script>";
  }
  
  
  ?>
  <style>
    table img {
      width: 53px;
      border-radius: 100px;
      height: 50px;
    }

    label {
      display: block;
      text-align: left;
    }
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


        <h4 class="mb-1 mt-0" id="Htitle" style="margin-bottom: 1.25rem!important;">All Posts <br></h4>
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
                          <th scope="col">Id</th>
                          <th scope="col">Thumbnail</th>
                          <th scope="col">Title</th>
                          <th scope="col">Status</th>
                          <th scope="col">User</th>
                          <th scope="col">DatePosted</th>
                          <th scope="col">Edit</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $i = 1;
                        $as = mysqli_query($db, "select p.*,u.full_name,u.id as user_id from com_posts p join users u on u.id = p.posted_user  where p.cat_id <> 10 order by p.p_id desc");
                        
                        while ($us = mysqli_fetch_assoc($as)) {
                            $user = $us['user_id'];
                            $post = $us['p_id'];
                        ?>
                          <tr>
                            <th scope="row"><input name="cUser[]" value="<?php echo $us['id']; ?>" type="checkbox" /></th>
                            <td><?php echo $us['p_id']; ?></td>
                            <td>
                                <?php if($us['img']!=''){ ?>
                                <img src="<?php echo $us['img']; ?>"  alt="">
                                <?php } ?>
                                </td>
                            <td>
                                <a href="https://community.jobaajlearnings.com/post/<?php echo $us['p_id']; ?>/admin" target="_blank">
                                    <?php echo substr($us['content'],0,20)."..."; ?>
                                </a>
                                </td>
                            <td>
                                <?php 
                                echo ($us['status'] == 1) ? "<a href='?post_id=$post&user=$user&status=0&post=$us[p_id]' class='btn btn-primary'>Active</a>" : "<a href='?post_id=$post&user=$user&status=1&post=$us[p_id]' class='btn btn-danger'>Inactive</a>"; ?>
                            </td>
                            <td><b><?php echo $us['full_name']; ?></b></td>
                            <td><b><?php echo date('h:i:s m-d',$us['date_posted']); ?></b></td>

                            <td><a href="?edit=<?php echo $us['p_id']; ?>">Edit</a></td>
                            <td><a href="?delete=<?php echo $us['p_id']; ?>">Delete</a></td>
                          </tr>

                        <?php $i++;
                        } ?>
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
              <!-- end card-->
            </div>
          </div>
          </from>

      </div>
      <!-- container fluid -->
    </div>
    <!-- end content-->
  </div>
  <!-- end content-page-->




  <!-- end Footer -->

  </div>


  <?php

  if (isset($_GET['delete'])) {
    $done = mysqli_query($db, "DELETE FROM `com_posts` WHERE `p_id` = '$_GET[delete]' ");
    echo "<script>alert('Post Deleted!');location.href='add-blog';</script>";
  }


  if (isset($_POST['updateBlog'])) {

    // $date = date("Y-m-d H:i:s");
    $date = date("Y-m-d H:i:s");
    $editor = mysqli_real_escape_string($db,$_POST['editor1']);
    $cat = mysqli_real_escape_string($db,$_POST['category']);
    $poststatus = mysqli_real_escape_string($db,$_POST['poststatus']);


    $run = mysqli_query($db, "UPDATE `com_posts` SET `content`='$editor', `status`='$poststatus', `cat_id`='$cat' WHERE `p_id`='$_POST[edit_id]' ");

    if ($run) {
      echo "<script>alert('Post Updated Successfully !')</script>";
      echo "<script>location.href='add-blog';</script>";
    } else {
      echo mysqli_error($db);
    }
  }

  ?>
  <!-- ============================================================== -->
  <!-- End Page content -->

  <script src="assets/libs/datatables/dataTables.keyTable.min.js"></script>
  <script src="assets/libs/datatables/dataTables.select.min.js"></script>
  <script src="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
  <script src="assets/libs/select2/select2.min.js"></script>

  <script src="assets/libs/multiselect/jquery.multi-select.js"></script>
  <script src="assets/js/pages/form-advanced.init.js"></script>
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
  <script>
    $('#ins_img').on('click', function() {
      $("#uploadimageModal").css("opacity", "1");
      $("#uploadimageModal").css("display", "block");

    });

    function editimg(imgname) {
      $("#img_data").show();
      $("#imgname").val(imgname);
    }

    function addimg(e) {
      e.preventDefault();
      var alttext = $("#alttext").val();
      var titletext = $("#titletext").val();
      var imgname = $("#imgname").val();
      var imgheight = $("#height").val();
      var imgwidth = $("#width").val();

      $("#img_lib_close").click();
      $("#img_data").hide();
      img = `<img src='${imgname}' alt=${alttext} title=${titletext}  height=${imgheight} width=${imgwidth} />'`;
      let cuur_data = CKEDITOR.instances['description'].getData();
      let new_data = cuur_data + img;


      CKEDITOR.instances['description'].setData(new_data);
      $("#alttext").val('');
      $("#titletext").val('');
      $("#imgname").val('');

      // alert(alttext+" "+titletext+" "+imgname);
    }

    function putImg(imgname) {
      // alert(imgname);
      $("#img_lib_close").click();
      // $("#imgupload").val('');
      // $("#answer").html(imgname);
      var img = document.createElement('img');
      img.src = imgname;
      img.height = "50";
      img.width = "50";
      //   document.getElementById('description').appendChild(img);
      // document.getElementsByClassName('ql-editor')[0].appendChild(img);
      CKEDITOR.instances['description'].setData(img)
    }
  </script>
  <script>
    function change() {
      $(".tab2").hide();
      $(".tab1").show();
    }

    function addCat() {

      var ctitle = $("#ctitle").val();
      var subtitle = $("#sub_title").val();
      var slug = $("#slug").val();

      $.ajax({
        url: "fun/courseFun.php",
        type: "POST",
        data: {
          ctitle: ctitle,
          subtitle: subtitle,
          slug: slug
        },
        cache: false,
        success: function(result) {
          if (result == 1) {
            hide();
            location.reload();
          } else {
            alert('Problem!');
          }

        }
      });
    }
  </script>
  <script>
    CKEDITOR.replace('editor1');
  </script>
  <?php require('inc/foot.php'); ?>


  <script>
    $("#post-title").focusout(function() {

      var slug = $(this).val();
      slug = slug.replaceAll(" ", "-");
      slug = slug.toLowerCase();

      // $("#slug-title").val(slug);

    });

    function closepopup() {
      $("#uploadimageModal").css("opacity", "0");
      $("#uploadimageModal").css("display", "none");
    };
  </script>
  <?php require('imagelibrary.php'); ?>