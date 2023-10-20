  <?php
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
  
   if (isset($_GET['status']) && isset($_GET['comment']) ) {
    $p = mysqli_query($db, "update com_comments set status = '$_GET[status]' where cmt_id = '$_GET[comment]'");
    echo "<script>location.href='https://community.jobaajlearnings.com/unity/add-comments';</script>";
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
        <div class="row page-title">
          <div class="col-md-12">
            <nav id="dd" aria-label="breadcrumb" class="float-right mt-1">
            </nav>
          </div>
        </div>

        <h4 class="mb-1 mt-0" id="Htitle" style="margin-bottom: 1.25rem!important;">All Comments <br></h4>
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
                          <th scope="col">User</th>
                          <th scope="col">Post</th>
                          <th scope="col">Comment</th>
                          <th scope="col">Added</th>
                          <th scope="col">Status</th>
                          <th scope="col">Edit</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $i = 1;
                        $as = mysqli_query($db, "select p.p_id,c.cmt_id,c.comment,c.status,c.added,u.full_name,c.user_id from com_comments as c join users as u on c.user_id = u.id join com_posts p on p.p_id = c.post_id  order by c.cmt_id desc");
                        
                        while ($us = mysqli_fetch_assoc($as)) {

                        ?>
                          <tr>
                            <th scope="row"><input name="cUser[]" value="<?php echo $us['id']; ?>" type="checkbox" /></th>
                            <td><?php echo $us['p_id']; ?></td>
                            <td>
                                <?php echo $us['full_name']; ?>
                                </td>
                            <td>
                                <a href="https://community.jobaajlearnings.com/post/<?php echo $us['p_id']; ?>" target="_blank">
                                    Post
                                </a>
                                </td>
                                
                                <td>
                                    <b><?php echo $us['comment'];?></b>
                                </td>
                                                            <td><b><?php echo date('h:i:s m-d',$us['added']); ?></b></td>

                            <td>
                                <?php 
                                echo ($us['status'] == 1) ? "<a href='?status=0&comment=$us[cmt_id]' class='btn btn-primary'>Active</a>" : "<a href='?status=1&comment=$us[cmt_id]' class='btn btn-danger'>Inactive</a>"; ?>
                            </td>
                            

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



  <script>
  
  
    $(document).ready(function() {
      $("#checkAll").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
      });
      
      
      $("#thumb_file").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgshow').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    
    
    });
    
    
    

    function openPopup(id) {
      $(".modal-backdrop").css('display', 'block');
      $(".modal-backdrop").css('opacity', '.5');
      $("#" + id).css('opacity', '1');

      $("#" + id).fadeIn();
    }

    function hide() {
      $(".modal-backdrop").css('display', 'none');
      $(".modal-backdrop").css('opacity', '0');
      $(".modal").fadeOut();
    }
  </script>


  <?php


  if (isset($_GET['delete'])) {
    $done = mysqli_query($db, "DELETE FROM `com_comments` WHERE `cmt_id` = '$_GET[delete]' ");
    echo "<script>alert('Comment Deleted!');location.href='add-comments';</script>";
  }


  if (isset($_POST['addBlog'])) {
    $date = date("Y-m-d H:i:s");
    $editor = str_replace("'", "\'", $_POST['editor1']);
    $title = str_replace("'", "\'", $_POST['title']);
    $poststatus = str_replace("'", "\'", $_POST['poststatus']);
    $slug = str_replace("'", "\'", $_POST['slug']);
    $slug = preg_replace('/[^a-zA-Z0-9-]/','',$slug);
   // $slug = preg_replace('/[^w/]/','',$slug);
    
    $key = str_replace("'", "\'", $_POST['key']);
    $alt = str_replace("'", "\'", $_POST['thumbnail_alt']);
    $mdesc = str_replace("'", "\'", $_POST['meta_desc']);

    $catids = '';
    foreach ($_POST['category'] as $val) {
      $catids .= $val;
      $catids .= ",";
    }
    $catids = rtrim($catids, ",");

    $filename = '';
    $uploadOk = false;
    if ($_FILES["thumbnail"]["name"] != '') {

      $extension = pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION);
      $filename = uniqid() . "." . $extension;
      $target_file = "thumb/" . $filename;
      $temp_name = $_FILES["thumbnail"]["tmp_name"];
      $uploadOk = move_uploaded_file($temp_name, $target_file);
      
    }

    if ($filename != '' && $uploadOk) {


      $run = mysqli_query($db, "INSERT INTO `st_post` (`ID`, `post_date`, `post_content`, `post_title`, `post_status`, `post_name`, `cat_id`, `keywords`, `thumbnail`, `alt`, `meta_desc`,`auth_id`) VALUES (NULL, '$date', '$editor', '$title', '$poststatus', '$slug', '$catids', '$key', '$filename', '$alt', '$mdesc','$user_id') ");
    } else {
      echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
      echo "<script>location.href='add-blog';</script>";
    }




    if ($run) {
      echo "<script>alert('Post Added Successfully !')</script>";
      echo "<script>location.href='add-blog';</script>";
    } else {
      echo mysqli_error($db);
      echo "<br>$editor";
    }
  }


  if (isset($_POST['updateBlog'])) {

    // $date = date("Y-m-d H:i:s");
    $date = date("Y-m-d H:i:s");
    $editor = str_replace("'", "\'", $_POST['editor1']);
    $title = str_replace("'", "\'", $_POST['title']);
    $poststatus = str_replace("'", "\'", $_POST['poststatus']);
    $slug = str_replace("'", "\'", $_POST['slug']);
    $key = str_replace("'", "\'", $_POST['key']);
    $alt = str_replace("'", "\'", $_POST['thumbnail_alt']);
    $mdesc = str_replace("'", "\'", $_POST['meta_desc']);


    $catids = '';
    foreach ($_POST['category'] as $val) {
      $catids .= $val;
      $catids .= ",";
    }
    $catids = rtrim($catids, ",");

    $filename = '';
    $uploadOk = false;
    if ($_FILES["thumbnail"]["name"] != '') {
      $filename = str_replace(" ", "-", $_FILES["thumbnail"]["name"]);
      $target_file = "thumb/" . $filename;
      $temp_name = $_FILES["thumbnail"]["tmp_name"];
      $uploadOk = move_uploaded_file($temp_name, $target_file);



      if ($uploadOk) {
        $rthumb = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `st_post` WHERE `ID`='$_POST[edit_id]' "));
        unlink("thumb/" . $rthumb['thumbnail']);
      }
    } else {
      $filename = $_POST['old_thumbnail'];
    }


    if ($_FILES["thumbnail"]["name"] != '' && $uploadOk == false) {

      echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
      echo "<script>location.href='add-blog';</script>";
    } else {

      $run = mysqli_query($db, "UPDATE `st_post` SET `post_content`='$editor', `post_title`='$title', `post_status`='$poststatus', `post_name`='$slug', `cat_id`='$catids', `keywords`='$key', `thumbnail`='$filename', `alt`='$alt', `meta_desc`='$mdesc', `update_at`='$date' WHERE `ID`='$_POST[edit_id]' ");
    }


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
