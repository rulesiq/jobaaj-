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
            <h4 class="mb-1 mt-0" id="Htitle">Notifications </h4>
            </h4>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body" style="padding: 30px;">
                <form action="" method="post">
                  <div class="row">
                    <div class="col-xl-10 offset-2">

                      <div class="row">
                        <div class="col-sm-8">
                          <div class="form-group">

                            <label>Post - </label>
                            <input type="hidden" value="<?php echo $_GET['post_id']; ?>" name="post_id">
                            <h5 class="f-b"><?php echo $_GET['post'];?>.....</h5>
                          </div>
                          <br/>
                          
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="msg" required class="form-control"><?php echo $p['msg']; ?></textarea>
                        </div>
                        
                        <br/>
                        
                        <div class="form-group">
                         <?php if (isset($_GET['edit'])) { ?>
                            <input type="hidden" value="<?php echo $p['thumbnail']; ?>" name="old_thumbnail">
                            <input type="hidden" value="<?php echo $p['ID']; ?>" name="edit_id">

                            <input type="submit" name="updateMsg" value="Update Notification" style="float: right; margin-top: 12px;" class="btn btn-danger" />
                          <?php } else { ?>
                            <input type="submit" name="sendNow" value="Send Notification" style="float: right; margin-top: 12px;" class="btn btn-danger" />
                            <!--<input type="submit" name="Schedule Mail" value="Send Notification" style="float: right; margin-top: 12px;" class="btn btn-danger" />-->
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



     
    
      </div>
      <!-- container fluid -->
    </div>
    <!-- end content-->
  </div>
  <!-- end content-page-->

  <?php 
  
  
  if(isset($_POST['sendNow'])) { 
      
      $msg = mysqli_real_escape_string($db,$_POST['msg']);
      $post = $_POST['post_id'];
      
      $added = time();
      
      
      $posted_user_id = mysqli_fetch_assoc(mysqli_query($db,"select posted_user as user from com_posts where p_id = '$post'"))['user'];
      
      $insert = mysqli_query($GLOBALS['db'],"INSERT INTO `com_notify` (`nid`, `msg`, `fromUser`, `toUser`, `post`, `status`, `date_added`)
      VALUES (NULL, '$msg', '$posted_user_id', '0', '$post', '1', '$added');");
      
      echo "<script>alert('Notification Sent to All!');location.href='all_posts'</script>";
      
    
  } 
     
     ?>


  <!-- end Footer -->

  </div>



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