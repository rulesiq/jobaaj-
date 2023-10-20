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
            <h4 class="mb-1 mt-0" id="Htitle">Add Poll </h4>
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

                            <label>Poll Cetegory</label>
                            <select name="cat" value="<?php echo $p['id']; ?>" class="form-control wide">
                              <option value="">Select Post Category</option>
                              <?php
                              $ca_id = explode(",", $p['cat_id']);
                              $cat = mysqli_query($db, "select id,name from com_category order by name desc");

                              while ($row = mysqli_fetch_assoc($cat)) {
                              ?>
                                <option <?php echo in_array($row['id'], $ca_id) ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                              <?php }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group">
                            <label>Poll Question</label>
                            <input name="title" id="post-title" value="<?php echo $p['post_title']; ?>" class="form-control">
                          </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div id="outcomes_area">
                                        <div class="d-flex mt-2">
                                            <div class="flex-grow-1 px-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="outcomes[]" id="outcomes" placeholder="Add option">
                                                </div>
                                            </div>
                                            <div class="">
                                                <button type="button" class="btn btn-success btn-sm" style="" name="button" onclick="appendOutcome()"> <i class="fa fa-plus"></i> </button>
                                            </div>
                                        </div>
                                        <div id="blank_outcome_field" style="display: none;">
                                            <div class="d-flex mt-2">
                                                <div class="flex-grow-1 px-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="outcomes[]" id="outcomes" placeholder="Add option">
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <button type="button" class="btn btn-danger btn-sm" style="margin-top: 0px;" name="button" onclick="removeOutcome(this)"> <i class="fa fa-minus"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </div>



                        <div class="col-sm-12">
                          <?php if (isset($_GET['edit'])) { ?>
                            <input type="hidden" value="<?php echo $p['thumbnail']; ?>" name="old_thumbnail">
                            <input type="hidden" value="<?php echo $p['ID']; ?>" name="edit_id">

                            <input type="submit" name="updateBlog" value="Update" style="float: right; margin-top: 12px;" class="btn btn-danger" />
                          <?php } else { ?>
                            <input type="submit" name="addBlog" value="Add Blog" style="float: right; margin-top: 12px;" class="btn btn-danger" />

                          <?php } ?>
                        </div>

                      </div>
                    </div>
                  </div>
                </form>
              </div>


            </div>

          </div>
          <div class="col-xl-1"></div>

        </div>



        <h4 class="mb-1 mt-0" id="Htitle" style="margin-bottom: 1.25rem!important;">All Polls <br></h4>
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
                          <th scope="col">Question</th>
                          <th scope="col">Result</th>
                          <th scope="col">User</th>
                          <th scope="col">Edit</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $i = 1;
                        $as = mysqli_query($db, "select *,u.full_name from com_poll p join users u on u.id = p.user_id order by p.id desc");
                        
                        while ($us = mysqli_fetch_assoc($as)) {

                        ?>

                          <tr>
                            <th scope="row"><input name="cUser[]" value="<?php echo $us['id']; ?>" type="checkbox" /></th>
                            <td><?php echo $us['p_id']; ?></td>
                             <td><?php echo $us['title']; ?></td>
                            <td>
                                <div >
                                <?php
                                $option = json_decode($us['options']);
                                
                                $score = json_decode($us['vote_count']);
                                $arr = [];
                                foreach($score as $cid=>$cval){ 
                                          $arr[] = $cval;     
                                    }
                                $i=0;
                                foreach ($option as $key) {
                                    echo "<div style='display:flex;justify-content: space-between;font-size:1rem'>";
                                           echo "<span>".$key."</span>";
                                           echo " - <span style='font-weight:700'>$arr[$i] % </span>";
                                           echo "</div><br>";
                                           $i++;
                                }
                               ?>
                               </div>
                            </td>
                            <td><b><?php echo $us['full_name']; ?></b></td>

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
  
    var blank_outcome = jQuery('#blank_outcome_field').html();
    function appendOutcome() {
      jQuery('#outcomes_area').append(blank_outcome);
    }

</script>


  <?php


  if (isset($_GET['delete'])) {

    $rthumb = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `st_post` WHERE `ID`='$_GET[delete]' "));
    unlink("thumb/" . $rthumb['thumbnail']);
    $done = mysqli_query($db, "DELETE FROM `st_post` WHERE `ID` = '$_GET[delete]' ");
    echo "<script>alert('blog Deleted!');location.href='add-post';</script>";
  }


  if (isset($_POST['addBlog'])) {
  
    $date = date("Y-m-d H:i:s");
    
      $out = array();
      $result = array();
    foreach ($_POST['outcomes'] as $o) {
        if ($o != '') { 
            $out[] = $o;
            $result[] = 0;
        }
            
    }
    $out = json_encode($out);
    $result = json_encode($result);

    $run = mysqli_query($db, "INSERT INTO `com_poll` (`id`, `title`, `options`, `vote_count`, `cat_id`,`user_id`) 
                            VALUES (NULL, '$_POST[title]', '$out', '$result', '$_POST[cat]','0');");

    if ($run) {
      echo "<script>alert('Poll Added Successfully !')</script>";
      echo "<script>location.href='add-post';</script>";
    } else {
      echo mysqli_error($db);
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