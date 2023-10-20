
<!-- Upload Image Modal -->
<style>
  /* Container needed to position the overlay. Adjust the width as needed */
  .img-container {
    position: relative;
    width: fit-content;
    /* max-width: 300px; */
    padding: 5px;
    margin: 5px;
    border: 1px solid #0000003b;
  }

  /* Make the image to responsive */
  .image {
    display: block;
    width: 100px;
    height: 100px;
  }

  /* The overlay effect - lays on top of the container and over the image */
  .overlay {
    position: absolute;
    bottom: 0;
    background: rgb(0, 0, 0);
    background: rgba(0, 0, 0, 0.5);
    /* Black see-through */
    color: #f1f1f1;
    width: 100%;
    transition: .5s ease;
    opacity: 0;
    color: white;
    font-size: 20px;
    margin-left: -5px;
    padding: 5px;
    text-align: center;
  }

  .close {
    position: absolute;
    top: 0;
    right: 0;
    color: white;
    border-radius: 50px;
    padding: 2px;
    background-color: #da3260;
    cursor: pointer;
    opacity: 0;
    margin-top: -10px;
    margin-right: -8px;
  }

  /* When you mouse over the container, fade in the overlay title */
  .img-container:hover .overlay {
    opacity: 1;
  }

  .img-container:hover .close {
    opacity: 1;
  }
</style>
<!-- <div class="modal show" id="uploadimageModal" tabindex="-1" aria-labelledby="uploadimageModalLabel" aria-hidden="false"> -->
<div class="modal fade" id="uploadimageModal" tabindex="-1" role="dialog" aria-labelledby="uploadimageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 70rem!important;">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="uploadimageModalLabel">Images Library</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="img_lib_close" onclick="closepopup()" aria-label="Close">close</button>
      </div>
      <div class="modal-body">
        <form action="" enctype="multipart/form-data" id="img_upload">
          <div class="mb-3 d-flex justify-content-center alig-items-center">
            <input class="form-control" type="file" name="img_file" id="img_file">
            <!-- <input type="submit" value="Upload" name="upload_img" id="upload_img" class="btn btn-primary"> -->
          </div>
        </form>
        <button name="upload_img" id="upload_img" class="btn btn-primary">Upload</button>
        <hr>
        <div class="mb-3">
          <div class="d-flex justify-content-center" style="flex-wrap: wrap;" id="img_lib">
            <?php
            $q = mysqli_query($db, "SELECT * FROM `upload_images` ORDER BY `id` DESC");
            while ($row = mysqli_fetch_assoc($q)) { ?>
              <div class="img-container" id="<?php echo $row['id']; ?>">
                <div class="close" onclick="dltimg('<?php echo $row['id']; ?>');">
                  <i class="bi bi-x"></i>
                </div>
                <img src="<?php echo $row['name']; ?>" alt="Avatar" class="image">
                <div class="overlay">
                  <!-- <div class="btn btn-success" onclick="putImg('<?php echo $row['name']; ?>');">Add</div> -->
                  <div class="btn btn-success" onclick="editimg('<?php echo $row['name']; ?>')">Edit</div>
                </div>

              </div>
            <?php } ?>
          </div>
          <div id="img_data" style="display: none;">
            <form>
              <div class="row">
                <div class="col">
                  <input type="text" class="form-control" id="alttext" placeholder="Alt Text">
                </div>
                <div class="col">
                  <input type="text" class="form-control" id="titletext" placeholder="Title">
                </div>
                <div class="col">
                  <input type="text" class="form-control" id="height" placeholder="Height">
                </div>
                <div class="col">
                  <input type="text" class="form-control" id="width" placeholder="Width">
                </div>
                <div class="col">
                  <button class="btn btn-primary" onclick="addimg(event);">Add</button>
                </div>
                <!--  -->
                <input type="hidden" id="imgname">
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer pt-2 pb-3 border-0">
                      <button type="button" class="btn btn-secondary btn-sm" id="close-popup" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary btn-sm" id="add_seeker" >Upload</button>
                    </div> -->
    </div>
  </div>
</div>
<script>
   $("#upload_img").on("click", function(e) {
    e.preventDefault();
    var fileInput = document.getElementById('img_file');
    var filePath = fileInput.value;
    var filename = filePath.split("\\").pop();

    // Allowing file type
    alert(filename);
    var allowedExtensions = /(\.png|\.jpg)$/i;
    var imageurl = "https://stories.jobaaj.com/files/manage/assets/images/" + filename;

    // $("#spec_resume_name").text(filename);        
    if (!allowedExtensions.exec(filePath)) {
      // showMsg('Invalid file type');
      alert('Invalid file type');
      fileInput.value = '';
      return false;
    }
    var file_data = $("#img_file").prop("files")[0]; // Getting the properties of file from file field
    var form_data = new FormData(); // Creating object of FormData class
    form_data.append("imgfile", file_data)
    $.ajax({
      url: "fun/programFun",
      data: form_data,
      cache: false,
      processData: false,
      contentType: false,
      type: 'POST',
      success: function(response) {
        if (response == 1) {
          $("#img_lib").append("<div class='img-container'><img src='assets/images/" + filename + "' alt='Avatar' class='image'><div class='overlay'><div class='btn btn-success' onclick='editimg(" + '"' + imageurl + '"' + ")'>Edit</div></div></div>");
          fileInput.value = '';
        } else if (response == 2) {
          alert("Image Not Move");
        } else if (response == 3) {
          alert("Query error");
        } else if (response == 4) {
          alert("Please Select Image");
        }
      }
    });
  });

  function dltimg(imgid) {
    // alert(imgid);

    $.ajax({
      url: "fun/programFun",
      type: "POST",
      data: {
        deleteimg: '1',
        imgid: imgid
      },
      success: function(res) {
        if (res == 1) {
          $("#" + imgid).fadeOut();
        } else {
          alert("Error Occured");
        }
      }
    });
  }

</script>