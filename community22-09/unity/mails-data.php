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



    if (isset($_GET['edit'])) {
        $p = mysqli_fetch_array(mysqli_query($db, "select * from mails where id = '$_GET[edit]'"));
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
                      <h4 class="mb-1 mt-0" id="Htitle">Add Mails </h4>
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
                                                      <label>Subject Line</label>
                                                      <input name="subject" id="subject" value="<?php echo $p['subject']; ?>" class="form-control">
                                                  </div>
                                              </div>

                                              <div class="col-sm-6">
                                                  <div class="form-group">
                                                      <label>Post Ids</label>
                                                      <input name="post_id" id="post_id" value="<?php echo $p['post_id']; ?>" class="form-control">
                                                  </div>
                                              </div>

                                              <div class="col-sm-6">
                                                  <div class="form-group">
                                                      <label>Message</label>
                                                      <textarea name="message" id="message" cols="30" rows="3" class="form-control"><?php echo $p['message']; ?></textarea>
                                                  </div>
                                              </div>

                                              <input type="hidden" name="update_id" value="<?php echo $_GET['edit']; ?>">

                                              <div class="form-group" style="width:100%; margin-top:10px;">

                                                  <?php if ($p['id'] != null) { ?>
                                                      <input type="submit" name="updateMail" value="Update Mail" style="float: right; margin-top: 12px;" class="btn btn-danger" />
                                                  <?php } else { ?>
                                                      <input type="submit" name="addMail" value="Add Mail" style="float: right; margin-top: 12px;" class="btn btn-danger" />

                                                  <?php } ?>
                                              </div>


                                          </div>


                                      </div>

                                  </div>
                              </form>

                          </div>

                      </div>
                  </div> <!-- end card-->
              </div> <!-- end col-->


              <h4 class="mb-4 mt-0" id="Htitle" style="margin-bottom: 1.25rem!important;">All Mails</h4>

              <div class="row">
                  <div class="col-12">
                      <div class="card">
                          <div class="card-body" style="padding: 30px;">

                              <div class="table-responsive">
                                  <table id="basic-datatable" class="table ">
                                      <thead>
                                          <tr>
                                              <th scope="col"><input id="checkAll" type="checkbox"></th>
                                              <th scope="col">#</th>
                                              <th scope="col">Subject</th>
                                              <th scope="col">Post Ids</th>
                                              <th scope="col">Message</th>
                                              <th scope="col">Edit</th>
                                              <th scope="col">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                            $i = 1;
                                            $as = mysqli_query($db, "select * from mails order by id desc");
                                            while ($us = mysqli_fetch_assoc($as)) {

                                            ?>
                                              <tr>
                                                  <th scope="row"><input name="cUser[]" value="<?php echo $us['id']; ?>" type="checkbox" /></th>
                                                  <td><?php echo $i++; ?></td>
                                                  <td><?php echo $us['subject']; ?></td>

                                                  <td><?php echo $us['post_id']; ?></td>
                                                  <td><?php echo $us['message']; ?></td>
                                                  <td><a href="?edit=<?php echo $us['id']; ?>">Edit</a></td>
                                                  <td><a href="?delete=<?php echo $us['id']; ?>">Delete</a></td>
                                              </tr>

                                          <?php } ?>
                                      </tbody>
                                  </table>
                              </div>


                          </div> <!-- end card-->
                      </div> <!-- end col-->
                  </div>
              </div>
          </div>

      </div>
  </div>


  <script>
      $(document).ready(function() {
          $("#checkAll").click(function() {
              $('input:checkbox').not(this).prop('checked', this.checked);
          });
      });
  </script>


  <?php


    if (isset($_GET['delete'])) {

        $done = mysqli_query($db, "DELETE FROM `mails` WHERE id = '$_GET[delete]' ");
        echo "<script>alert('Mail Deleted!');location.href='mails-data.php';</script>";
    }


    if (isset($_POST['addMail'])) {

        $subject = mysqli_real_escape_string($db, $_POST['subject']);
        $post_id = mysqli_real_escape_string($db, $_POST['post_id']);
        $message = mysqli_real_escape_string($db, $_POST['message']);


        $run = mysqli_query($db, "INSERT INTO `mails` (`id`, `subject`, `post_id`,`message` ) VALUES (NULL,'$subject', '$post_id', '$message');");

        if ($run) {
            echo "<script>alert('Added Successfully !');location.href='mails-data.php';</script>";
        } else {
        }
    }



    if (isset($_POST['updateMail'])) {

        $subject = mysqli_real_escape_string($db, $_POST['subject']);
        $post_id = mysqli_real_escape_string($db, $_POST['post_id']);
        $message = mysqli_real_escape_string($db, $_POST['message']);

        $run = mysqli_query($db, "update mails set subject = '$subject', post_id = '$post_id', message = '$message' where id = '$_POST[update_id]'");

        if ($run) {
            echo "<script>alert('Update Successfully !');location.href='mails-data.php';</script>";
        } else {
            // echo mysqli_error($db);
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
      $("#title_slug_id").focusout(function() {

          var slug = $(this).val();
          slug = slug.replaceAll(" ", "-");
          slug = slug.toLowerCase();

          $("#slug_id").val(slug);

      });
  </script>