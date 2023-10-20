  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" />
 

  <?php

    require('pin/head.php');
    $skill = '-1';

    require('pin/left_side.php');
    
    ?>

  <!-- Start Content Page Box Area -->
  <div class="content-page-box-area">
      <div class="row">

          <div class="col-lg-3 side_home">
              <div style="width:16rem;background:#fff;padding-right:1rem">
                  <p style="padding-top:.5rem;margin:0 .5rem;font-weight:600;font-size:.8rem">Categories</p>
                  <ul style="padding-left:0px !important;" class="menu_sidebar metisMenu">

                      <?php
                        //
                        $q = mysqli_query($db, "select * from com_category order by position");
                        $i = 0;
                        while ($c = mysqli_fetch_array($q)) {
                            ++$i; ?>
                          <li class="nav-item">
                              <a onclick="getPosts('<?php echo $c['id']; ?>')" href="#<?php echo str_replace(" ", "", str_replace("&", "", $c['name'])); ?>" id="cat<?php echo $c['id']; ?>" class="nav-link ">
                                  <span class="icon"><img src="<?php echo $url; ?>assets/cat/<?php echo $c['thumb']; ?>" /></span>
                                  <span class="menu-title"><?php echo $c['name']; ?></span>
                              </a>
                          </li>
                      <?php } ?>

                  </ul>
                  <img style="padding-left:1rem;margin-top: 22px;max-width: 238px;cursor:pointer;" onclick="location.href='https://www.jobaajlearnings.com/workshop'" src="<?php echo $url; ?>assets/offer-banner-workshop.jpg" />

                  <br /><br />
              </div>

          </div>
          <div class="col-lg-6  col-md-12">

              <div class="news-feed-area">
                  <div class="news-feed news-feed-form">
                      <form>
                          <div style="    display: flex;" class="form-group">
                              <img style="height: 44px;margin-right: 1rem;max-width: 44px !important;" src='<?php echo $profile; ?>' onerror=this.onerror=null;this.src='assets/images/avatar.png' class='rounded-circle user-profile'>

                              <input name="message" readonly onclick="openPost()" class="form-control" placeholder="What's on your mind, <?php echo strtok($user['full_name'], ' ') . "?"; ?>" />
                          </div>
                          <ul class="button-group d-flex justify-content-between align-items-center">
                              <li class="photo-btn">
                                  <button type="button" onclick="openPost()"><i class="fa-regular fa-image"></i> Photo</button>
                              </li>
                              <li class="video-btn">
                                  <button type="button" onclick="openPost()"><i class="fa-solid fa-file-image"></i> Gif</button>
                              </li>
                              <li class="tag-btn">
                                  <button type="button" onclick="openPost()"><i class="fa-solid fa-award"></i> Awards / Certificate</button>
                              </li>

                          </ul>
                      </form>
                  </div>

                  <?php

                    require('placeholder.php');

                    ?>


                  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />



                  <div class="mainBox">


                  </div>

                  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>




                  <div>
                      <img src="assets/nopost.png" class="nopost" style="display: none;width: 10rem;margin: 0 auto;" />

                  </div>
                  <div class="load-more-posts-btn">
                      <a href="javascript:;" onclick="getMorePosts()"><i class="flaticon-loading"></i> Load More Posts</a>
                  </div>
              </div>
          </div>
          <div class="col-lg-3">
              <aside class="widget-area" style="padding: 0 .5rem;">

              </aside>
          </div>
      </div>
  </div>
  <!-- End Content Page Box Area -->

  <script>
      var global_cat = '-';
      var offset = 0;

      function rightOpen() {
          $(".right-sidebar-area").toggleClass('right-size');
          $("#arrowBtn").toggleClass('right-size2');
      }

      function openPost() {

          if (global_cat != '-' && global_cat != '-1' && global_cat != '0')
              $(".post-cat").val(global_cat);

          <?php if (isset($_SESSION['learner_id'])) { ?>

              $("#showPost").show();


          <?php } else { ?>
              loginNow();
          <?php } ?>

      }

      function getMorePosts() {
          
          console.log('more')
          offset += 10;
          console.log(offset)

          getPosts(global_cat)
      }

      function searchTopic(input) {

          $(".nopost").hide();

          if (input == 1)
              search_key = $("#search_input").val();
          else
              search_key = $("#search_input2").val();


          if (search_key == '') return false;

          $(".placeholder").show();

          $.ajax({
              url: "<?php echo $url; ?>fun/getPost",
              type: "POST",
              data: {
                  getPosts: 'query',
                  cat_id: global_cat,
                  search: search_key,
                  offset: offset
              },
              cache: false,
              dataType: 'JSON',
              success: function(result) {



                  if (result.count < 5)
                      $(".load-more-posts-btn").hide();
                  else
                      $(".load-more-posts-btn").show();

                  if (result.posts != 0)
                      $(".mainBox").html(result.posts);
                  else {
                      $(".mainBox").html('');
                      $(".nopost").css('display', 'block');
                  }

                  $(".placeholder").hide(1000);




              }
          }).fail(function(jqXHR, textStatus, error) {
              // alert(error);

          });


      }

      $('#search_input').keypress(function(e) {
          if (e.which == 13) {
              searchTopic(1);
              return false; //<---- Add this line
          }
      });

      $('#search_input2').keypress(function(e) {
          if (e.which == 13) {
              searchTopic(2);
              return false; //<---- Add this line
          }
      });

      function getPosts(cat) {


          $(".nav-link").removeClass('nav-link-active');
          $("#cat" + cat).addClass('nav-link-active');


          if (global_cat != cat) {
              $(".mainBox").html('')
          } else {
              return;
          }



        
          global_cat = cat;
          search_key = $("#search_input").val();

          $(".placeholder").show();


          console.log(cat);
          $.ajax({
              url: "<?php echo $url; ?>fun/getPost",
              type: "POST",
              data: {
                  getPosts: 'query',
                  cat_id: cat,
                  search: search_key,
                  offset: offset
              },
              cache: false,
              dataType: 'JSON',
              success: function(result) {
                  console.log(result)
                  if (result.count < 5)
                      $(".load-more-posts-btn").hide();
                  else
                      $(".load-more-posts-btn").show();

                  if (cat != 0 || cat != -1)
                      getMentors(cat);

                  if (cat == -1)
                      getWorkshops();

                  if (result.posts != 0)
                      $(".mainBox").append(result.posts);

                  $(".placeholder").hide(1000);

                  //Swiper js code 
                  var swiper = new Swiper(".mySwiper", {
                      pagination: {
                          el: ".swiper-pagination",
                          type: "fraction",
                      },
                      navigation: {
                          nextEl: ".swiper-button-next",
                          prevEl: ".swiper-button-prev",
                      },
                  });


              }
          }).fail(function(jqXHR, textStatus, error) {
              // alert(error);

          });

      }

      function myPosts() {

          $(".mainBox").html('')
          $(".placeholder").show();


          $.ajax({
              url: "<?php echo $url; ?>fun/getPost",
              type: "GET",
              data: {
                  myPosts: 'query',
                  offset: 0
              },
              cache: false,
              dataType: 'JSON',
              success: function(result) {
                  console.log(result)
                  if (result.count < 5)
                      $(".load-more-posts-btn").hide();
                  else
                      $(".load-more-posts-btn").show();


                  //  getWorkshops();

                  if (result.posts != 0)
                      $(".mainBox").append(result.posts);

                  $(".placeholder").hide(1000);

                  //Swiper js code 
                  var swiper = new Swiper(".mySwiper", {
                      pagination: {
                          el: ".swiper-pagination",
                          type: "fraction",
                      },
                      navigation: {
                          nextEl: ".swiper-button-next",
                          prevEl: ".swiper-button-prev",
                      },
                  });




              }
          }).fail(function(jqXHR, textStatus, error) {
              // alert(error);

          });

      }

      function getMentors(cat) {

          //$(".placeholder").show();

          $.ajax({
              url: "<?php echo $url; ?>fun/User",
              type: "POST",
              data: {
                  getMentors: 'query',
                  cat_id: cat,
              },
              cache: false,
              dataType: 'JSON',
              success: function(result) {

                  if (result.mentors != 0)
                      $(".widget-area").html(result.mentors);
                  $(".placeholder").hide(1000);

              }
          }).fail(function(jqXHR, textStatus, error) {

          });

      }

      function getWorkshops() {


          $.ajax({
              url: "<?php echo $url; ?>fun/User",
              type: "POST",
              data: {
                  getWorkshops: 'query',
              },
              cache: false,
              dataType: 'JSON',
              success: function(result) {

                  $(".widget-area").html(result.workshop);

              }
          }).fail(function(jqXHR, textStatus, error) {

          });

      }

      function addPost() {

          post = $(".post-editor").val();
          post = post.replace(/\n/g, "[nl]");
          $(".post-editor2").val(post);
          cat = $(".post-cat").val();

          $(".post-loader").css('display', 'flex');

          $.ajax({
              url: "<?php echo $url; ?>fun/addPost",
              type: "POST",
              data: new FormData($('#postForm')[0]),
              cache: false,
              processData: false,
              contentType: false,
              success: function(result) {
                  if (result == 1) {
                      $(".post-loader").hide();
                      $("#showPost").hide();
                      $(".post-editor").val('');

                      if ($("#postInput").val() == '0') {
                          showToast('Post added for review!', 5000);
                          myPosts();
                      } else {
                          showToast('Post edited & send for review!', 5000);
                          location.reload();
                      }
                      showToast('Post added for review!', 5000);


                  }

              }
          }).fail(function(jqXHR, textStatus, error) {
              alert(error);

          });
      }


      window.addEventListener('load', function() {
          var editbox = document.getElementsByClassName("emojionearea-editor")[0]

          editbox.addEventListener('keyup', (e) => {
              // and here is how to detect the enter key
              text = e.target.textContent;

              btnSubmit = $("#postNow");

              if (text.trim() != "")
                  btnSubmit.removeAttr("disabled");
              else
                  btnSubmit.attr("disabled", "disabled");

              // if(text.length > 85)
              //     editbox.css('font-size',".9rem");
              // else
              //     editbox.css('font-size',"1.2rem");


          });
      });

      function delPost(post) {

          $.ajax({
              url: "<?php echo $url; ?>fun/addPost",
              type: "POST",
              data: {
                  delPost: true,
                  post: post
              },
              cache: false,
              success: function(result) {
                  $(".post" + post).fadeOut(1000);
              }
          }).fail(function(jqXHR, textStatus, error) {});

      }

      function updateCategory() {

          let selCat = $("input[name='cat']:checked").val();
          console.log(selCat)
          $.ajax({
              url: "<?php echo $url; ?>fun/User",
              type: "POST",
              data: {
                  updateCat: true,
                  cat: selCat
              },
              cache: false,
              success: function(result) {
                  console.log(result)
                  $("#showCategory").hide();
                  showToast('Category Updated!', 3000);
              }
          }).fail(function(jqXHR, textStatus, error) {});

      }

      function delCmt(cmt_id) {

          $.ajax({
              url: "<?php echo $url; ?>fun/addPost",
              type: "POST",
              data: {
                  delComment: true,
                  cmt: cmt_id
              },
              cache: false,
              success: function(result) {
                  $(".cmt" + cmt_id).fadeOut(800);
              }
          });
      }


      function updateCmt(cmt_id) {

          let commentBox = $(".editBox" + cmt_id);
          let commentNew = commentBox.html().trim();
          if (commentNew == '')
              return

          $.ajax({
              url: "<?php echo $url; ?>fun/addPost",
              type: "POST",
              data: {
                  updateComment: true,
                  cmt: cmt_id,
                  cmtText: commentNew
              },
              cache: false,
              success: function(result) {
                  $(".updateBox" + cmt_id).hide();
                  commentBox.attr('contenteditable', 'false');
              }
          });

      }


      function editCmt(cmt_id) {

          let editorCmt = $(".editBox" + cmt_id);
          editorCmt.attr('contenteditable', 'true');
          $(".updateBox" + cmt_id).show();

          setTimeout(function() {

              var selectedText = window.getSelection();

              // create a range
              var selectedRange = document.createRange();

              // set starting position of the cursor in the texts
              selectedRange.setStart(document.querySelector(`.editBox${cmt_id}`).childNodes[0], editorCmt.text().length);

              // collapse the range at boundaries
              selectedRange.collapse(true);

              // remove all ranges
              selectedText.removeAllRanges();

              // add a new range to the selected text
              selectedText.addRange(selectedRange);

              // focus the cursor
              editorCmt.focus();
          }, 10);

      }



      function editPost(post) {

          $("#showPost").show();
          $(".emojionearea-editor").focus();
          con = $(".postContent" + post).html();
          // con = con.replaceAll("<br>","<br>");

          $(".post-editor2").val(con);

          let Editor = $(".emojionearea-editor");

          Editor.html(con);

          setTimeout(function() {

              var selectedText = window.getSelection();
              var selectedRange = document.createRange();
              selectedRange.setStart(document.querySelector(`.emojionearea-editor`).childNodes[0], Editor.html().length);
              selectedRange.collapse(true);
              selectedText.removeAllRanges();
              selectedText.addRange(selectedRange);

              Editor.focus();
          }, 10);

          cat = $(".postCat" + post).html();

          $("#postNow").removeAttr("disabled");

          $(`.post-cat option[val=${cat}]`).attr("selected", "selected");
          $('.post-cat option:selected').attr("selected", null);

          //for single image
          current_src = $(".postImg" + post).attr('src');
          if (current_src != undefined) {
              $(".emojionearea-editor").css({
                  'font-size': '.9rem',
                  'min-height': '2rem'
              });
              $('#img-preview').append("<div style='width:50%'><img class='pimg' src='" + current_src + "'></div>");
              $(".img-choosen").show();
              $("#file_url").val(current_src);
          } else {

              const imgs = document.querySelectorAll(`.swiperWrapper${post} img`)
              if (imgs.length > 0) {
                  $(".emojionearea-editor").css({
                      'font-size': '.9rem',
                      'min-height': '2rem'
                  });
                  $(".img-choosen").show();
                  imgs.forEach(img => {
                      $('#img-preview').append("<div style='width:50%'><img class='pimg' src='" + img.src + "'></div>");
                      var file = $("#file_url")
                      file.val(file.val() + ',' + img.src);

                  });
              }


          }





          //for multiple img 


          $("#postInput").val(post);



      }

      function getCatId(key) {

          var dict = {
              <?php
                $q = mysqli_query($db, "select id,name from com_category");
                while ($c = mysqli_fetch_array($q)) { ?>

                  <?php echo str_replace(" ", "", str_replace("&", "", $c['name'])); ?>: <?php echo $c['id']; ?>,

              <?php } ?>

          };

          getPosts(dict[key])

      }

      if (window.location.hash) {

          var hash = window.location.hash.substring(1);
          if (hash == "myPosts") {
              myPosts();
          } else {
              getCatId(hash);
          }
      } else {
          getPosts('<?php echo $skill; ?>');
          getWorkshops();
      }
  </script>



  </div>
  <!-- End Main Content Wrapper Area -->

  <!-- Start Copyright Area -->

  <!-- End Copyright Area -->

  <!-- Start Go Top Area -->
  <div class="go-top">
      <i class="ri-arrow-up-line"></i>
  </div>
  <!-- End Go Top Area -->

  <div class="modal" id="showPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog postDialog">
          <div class="modal-content" style="height:30rem !important">

              <div class="modal-header" style="display:flex;">
                  <h4 class="modal-title" id="myModalLabel">Create something!</h4>
                  <i class="fa-solid fa-xmark close"></i>
              </div>
              <div class="modal-body">
                  <form enctype="multipart/form-data" id="postForm" accept-charset="UTF-8">

                      <div class="post-header d-flex  align-items-center">
                          <div class="image">
                              <img style="width:2.7rem;" src='<?php echo $profile; ?>' onerror=this.onerror=null;this.src='assets/images/avatar.png' class='rounded-circle user-profile'>
                          </div>
                          <div class="info ms-3">
                              <span class="name post-name"><?php echo $user['full_name']; ?></span>
                              <select name="post-cat" class="post-cat">
                                  <?php

                                    if ($user['id'] == 1)
                                        $q = mysqli_query($db, "select id,name from com_category  order by position");
                                    else
                                        $q = mysqli_query($db, "select id,name from com_category  where id not in (-1,-2) order by position");

                                    while ($c = mysqli_fetch_array($q)) {
                                        $id = $c['id'];
                                        $name = $c['name'];
                                        echo "<option value=$id>$name</option>";
                                    }
                                    ?>
                              </select>
                          </div>

                      </div>
                      <br>
                      <textarea class="form-control post-editor" style="    height: 6.5rem;padding: 2px;white-space: pre-wrap;border:none;font-size: 1.2rem;" id="postEditor" name="post-editor" placeholder="What's on your mind, <?php echo strtok($user['full_name'], ' ') . "?"; ?>"></textarea>
                      <textarea class="form-control post-editor2" style="white-space: pre-wrap;display:none" name="post-editor2"></textarea>

                      <div class="img-choosen" style="">
                          <i class="fa-solid fa-xmark closeImg"></i>
                          <div class="img-selected">
                              <div id="img-preview"></div>
                          </div>
                      </div>
                      <input type="hidden" id="postInput" name="addPost" value="0" />
                      <input type="hidden" id="file_url" name="file_url" value="0" />
                      <input accept="image/*" style="display:none" multiple type="file" id="thumb_file" name="post-img[]" class="form-control">
                      <input accept="" style="display:none" type="file" id="video_file" name="post-video">
                  </form>
                  <div class="img-box">
                      <i class="fa-solid fa-xmark closeImg"></i>
                      <div class="img-upload" onclick="uploadNow()">
                          <i class="fa-regular fa-images" style="font-size: 2.5rem;"></i>
                          <span style="margin-top:.5rem"> Add Photos / Gifs</span>
                      </div>
                  </div>
              </div>

              <div class="modal-footer">

                  <div class="post-strip">
                      <p style="font-weight:600;flex:1">Add to your post</p>

                      <div class="post-elements">

                          <?php

                            if ($user['id'] == 1) { ?>
                              <i onclick="chooseVideo()" class="fa-solid fa-video-camera"></i>
                          <?php } ?>


                          <i onclick="chooseImg()" class="fa-regular fa-image"></i>
                          <i onclick="chooseImg()" class="fa-solid fa-file-image"></i>
                          <i onclick="chooseImg()" class="fa-solid fa-award"></i>

                      </div>
                  </div>


                  <button style="width: 100%;" onclick="addPost()" id="postNow" disabled type="button" class="btn btn-primary">Post</button>


              </div>

              <div class="post-loader">



              </div>
          </div>
      </div>
  </div>


  <div class="modal" id="showUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="max-width: 50%;top:8%">
          <div class="modal-content">
              <div class="modal-header" style="display:flex;padding: 0.5rem 1rem;">
                  <h4 class="modal-title postHead" style="    margin: 0 auto;" id="myModalLabel"></h4>
                  <button type="button" class="btn close2" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

              </div>
              <div class="modal-body">
                  <div class="placeholder2" style="background:transparent">

                      <div class="card" style="padding:20px;">
                          <div class="boxes" style="display:flex;height:15rem">
                              <div class="shine" style="border-radius: 10px;min-width: 69px;
                        height: 61px;
                        margin-right: 27px"></div>
                              <div>
                                  <lines class="shine" style="width:51%;height:12px;"></lines>
                                  <lines class="shine" style="height:11px;width:224px;margin-top:15px;"></lines>
                              </div>

                          </div>


                          <div style="display:flex;justify-content: space-around;margin-top: 10px;">
                              <lines class="shine" style="height:10px;width:100px;"></lines>
                              <lines class="shine" style="height:10px;width:100px;margin-left:10px;"></lines>
                              <lines class="shine" style="height:10px;width:100px;margin-left:10px;"></lines>
                          </div>

                      </div>
                      <br>


                  </div>
                  <div class="single-post news-feed-area">

                  </div>
              </div>

          </div>
      </div>
  </div>

  <div class="modal" id="showLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

      <div class="modal-dialog loginPopup">
          <div class="modal-content">

              <div class="modal-header" style="display:flex;">
                  <h4 class="modal-title" id="myModalLabel">Login</h4>
                  <i class="fa-solid fa-xmark closeLogin"></i>
              </div>
              <div class="modal-body">
                  <form id="loginForm" style="padding:1rem">

                      <div class="form-outline mb-4">
                          <input placeholder="Email " type="email" id="email-login" class="form-control" />
                      </div>

                      <!-- Password input -->
                      <div class="form-outline">
                          <input placeholder="Password" type="password" id="pass-login" class="form-control" />
                      </div>
                      <span style='color: #ea584d;font-size: .9rem;' class="error-login"></span>
                      <!-- Register buttons -->
                      <div class="text-center" style="margin-top:.5rem">
                          <p>Not a member? <a href="http://jobaajlearnings.com/signup">Register</a></p>

                      </div>
                  </form>

              </div>

              <button style="width: 100%;" onclick="loginProcess()" id="LoginNow" type="button" class="btn btn-primary">Login</button>


          </div>

          <div class="post-loader">



          </div>
      </div>
  </div>

  <div class="modal" id="showCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

      <div class="modal-dialog catPopup">
          <div class="modal-content">

              <div class="modal-header" style="display:flex;">
                  <h4 class="modal-title" id="myModalLabel">Update Category<br>
                      <span style="font-size:.7rem;">Choose from the below categories to know what is happening <br />in the respective fields.</span>
                  </h4>

                  <i class="fa-solid fa-xmark closeCat"></i>
              </div>
              <div class="modal-body">
                  <form id="showCat" style="padding:0 1rem">

                      <ul style="padding-left:0px !important;" class="menu_sidebar metisMenu">
                          <?php
                            //
                            $q = mysqli_query($db, "select * from com_category where id not in (-1,-2) order by position");
                            $i = 0;
                            while ($c = mysqli_fetch_array($q)) {
                                ++$i; ?>
                              <li class="nav-item">
                                  <label>
                                      <input name="cat" value="<?php echo $c['id']; ?>" type="radio" />
                                      <span class="icon"><img src="<?php echo $url; ?>assets/cat/<?php echo $c['thumb']; ?>" /></span>
                                      <span class="menu-title"><?php echo $c['name']; ?></span>
                                  </label>
                              </li>
                          <?php } ?>

                      </ul>


                  </form>

              </div>

              <button style="width: 100%;" onclick="updateCategory()" id="updateNow" type="button" class="btn btn-primary">Update</button>


          </div>

          <div class="post-loader">



          </div>
      </div>
  </div>


  <div class="modal" style="padding: 1rem;z-index:1" id="showShare" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

      <div class="modal-dialog modal-dialog-centered shareDialog" role="document">
          <div class="modal-content border-0 shadow" style="border-radius:1.5rem;">

              <i style="    text-align: right;" class="fa-solid fa-xmark closeShare"></i>

              <div class="toast-container position-fixed bottom-0 start-0 p-3">
                  <div class="toast fade" id="myCourses_url_copied" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                      <div class="toast-header bg-secondary">
                          <i class="bx bx-time fs-lg me-2"></i>

                          <button class="btn-close ms-2 mb-1" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                      </div>
                  </div>
              </div>
              <div class="card-body pt-3">

                  <h6 style="margin-bottom:.8rem">Share via</h6>

                  <div class="d-flex justify-content-around gap-3 share  mb-4">

                      <span class="text-center">
                          <a target="_blank" id="shareMyCoursesWhatsapp" class="btn btn-icon rounded-circle" style="background:#25D366;" href="whatsapp://send?text=https://www.jobaajlearnings.com/join-referral/jl-financialmodellingvaluations-c_5-4822">
                              <i class="fa-brands fa-whatsapp"></i>
                          </a>
                          <span class="fw-bold" style="font-size:14px">Whatsapp</span>
                      </span>
                      <span class="text-center">
                          <a target="_blank" id="shareMyCoursesmail" class="btn btn-icon rounded-circle" style="background:#f44336;" href="mailto:?subject=Financial Modelling &amp; Valuations by Jobaaj Learnings&amp;body=Dear Iqbal Shah,%0D%0A%0D%0AUse this link to enroll yourself into Financial Modelling &amp; Valuations by Jobaaj Learnings!%0D%0A%0D%0A%0D%0Ahttps://www.jobaajlearnings.com/join-referral/jl-financialmodellingvaluations-c_5-4822%0D%0A%0D%0AFeel free to reach out to us if you're facing any issues.%0D%0A%0D%0ARegards,%0D%0ATeam Jobaaj Learnings">
                              <i class="fa-regular fa-envelope"></i>
                          </a>
                          <span class="fw-bold" style="font-size:14px">Gmail</span>
                      </span>
                      <span class="text-center">
                          <a target="_blank" id="shareMyCoursesFacebook" class="btn btn-icon rounded-circle" style="background:#3b5998;" href="http://www.facebook.com/sharer.php?u=https://www.jobaajlearnings.com/join-referral/jl-financialmodellingvaluations-c_5-4822">
                              <i class="fa-brands fa-facebook-f"></i>
                          </a>
                          <span class="fw-bold" style="font-size:14px">Facebook</span>
                      </span>
                      <!-- <span class="text-center">
              <a href="" target="_blank" id="shareMyCoursesTelegram" class="btn btn-icon rounded-circle" style="background:#0088cc;">
                <i class='bx bxl-telegram'></i>
              </a>
              <span class="fw-bold" style="font-size:14px">Telegram</span>
            </span> -->
                      <span class="text-center">
                          <a target="_blank" id="shareMyCoursesLinkedin" class="btn btn-icon rounded-circle" style="background:#0a66c2;" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=https://www.jobaajlearnings.com/join-referral/jl-financialmodellingvaluations-c_5-4822">
                              <i class="fa-brands fa-linkedin-in"></i>
                          </a>
                          <span class="fw-bold" style="font-size:14px">Linkedin</span>
                      </span>

                  </div>
                  <div class="card p-1 share" style="flex-direction: row;align-items: center;">
                      <input type="text" style="height:1rem" readonly class="w-100 p-2 border-0 bg-transparent myPostUrl" />
                      <button style="font-size:.8rem" class="btn btn-primary rounded-pill" onclick="copyLink(post_global)">Copy</button>
                  </div>
              </div>
          </div>
      </div>

  </div>



  </div>


  <!-- Links of JS files -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <script src="assets/js/jquery-ui.min.js"></script>
  <script src="assets/js/simplebar.min.js"></script>
  <script src="assets/js/metismenu.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/wow.min.js"></script>
  <script src="assets/js/main.js"></script>

  </body>

  <script>
      var input = document.getElementById("pass-login");

      input.addEventListener("keypress", function(event) {
          if (event.key === "Enter") {
              event.preventDefault();
              loginProcess();
          }
      });



      $(".close").click(function() {
          $("#showPost").hide();
      })

      $(".close2").click(function() {
          $("#showUpdate").hide();
      })

      $(".closeLogin").click(function() {
          $("#showLogin").hide();
      })

      $(".closeCat").click(function() {
          $("#showCategory").hide();
      })

      $(".closeShare").click(function() {
          $("#showShare").hide();
      })

      $(".closeImg").click(function() {

          $("#file_url").val('');
          $(".modal-content").css('height', "405px")
          $(".emojionearea-editor").keyup();
          $(".img-box").hide();
          $(".img-choosen").hide();
          $("#img-preview").html('')

          $("#thumb_file").val('');

      })






      $(function() {


          $('.emojionearea-editor').keyup(function() {

              let post = $('.post-editor')

              let text = post.val();

              btnSubmit = $("#postNow");

              if ($(this).val().trim() != "")
                  btnSubmit.removeAttr("disabled");
              else
                  btnSubmit.attr("disabled", "disabled");

              if (text.length > 85)
                  $(this).css('font-size', ".9rem");
              else
                  $(this).css('font-size', "1.2rem");

          });

      });

      $("#thumb_file").change(function() {

          const total_file = document.getElementById("thumb_file").files.length;

          for (var i = 0; i < total_file; i++) {
              $('#img-preview').append("<div style='width:50%'><img class='pimg' src='" + URL.createObjectURL(event.target.files[i]) + "'></div>");
          }

          $(".img-choosen").show();
          $("#postNow").removeAttr("disabled");
      });

      function chooseImg() {
          uploadNow();
      }

      function chooseVideo() {
          $("#video_file").click();
      }

      function uploadNow() {

          $(".emojionearea-editor").css({
              'font-size': '.9rem',
              'min-height': '2rem'
          });
          $("#thumb_file").click();
      }

      function loginNow() {
          $("#showLogin").show();
          $("#email-login").focus();
      }

      function changeCat() {
          $("#showCategory").show();
      }

      function likePost(postId) {


          <?php if (!isset($_SESSION['learner_id'])) { ?>
              loginNow();
              return;
          <?php } ?>

          likeElem = $(".heart" + postId);

          likeCount = $(".like" + postId);

          if (likeElem.hasClass('fa-regular')) {

              if (likeCount.html().trim() != "")
                  likeCount.html(parseInt(likeCount.html()) + 1);
              else
                  likeCount.html('1');

              likeElem.removeClass("fa-regular");
              likeElem.addClass("fa-solid");

              $.ajax({
                  url: "<?php echo $url; ?>fun/addPost",
                  type: "POST",
                  data: {
                      AddLike: true,
                      post: postId
                  },
                  cache: false,
                  success: function(result) {}
              }).fail(function(jqXHR, textStatus, error) {});


          } else {

              likeElem.addClass("fa-regular");
              likeElem.removeClass("fa-solid");

              if (likeCount.html().trim() != '1')
                  likeCount.html(parseInt(likeCount.html()) - 1);
              else
                  likeCount.html('');


              $.ajax({
                  url: "<?php echo $url; ?>fun/addPost",
                  type: "POST",
                  data: {
                      DelLike: true,
                      post: postId
                  },
                  cache: false,
                  success: function(result) {}
              }).fail(function(jqXHR, textStatus, error) {});


          }
      }

      $(document).ready(function() {
          $("#postEditor").emojioneArea({
              pickerPosition: 'bottom'
          });
      });

      function setCookie(name, value, days) {
          var expires = "";
          if (days) {
              var date = new Date();
              date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
              expires = "; expires=" + date.toUTCString();
          }
          document.cookie = name + "=" + (value || "") + expires + "; path=/";
      }

      function getCookie(name) {
          var nameEQ = name + "=";
          var ca = document.cookie.split(';');
          for (var i = 0; i < ca.length; i++) {
              var c = ca[i];
              while (c.charAt(0) == ' ') c = c.substring(1, c.length);
              if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
          }
          return null;
      }

      function checkCookie(poll) {

          let poll_cookie = getCookie("463d773cad30c5b74940d5e586e88a75");
          if (poll != "" && poll_cookie == poll) {
              return 0;
          } else {
              setCookie("463d773cad30c5b74940d5e586e88a75", poll, 100);
              return 1;
          }
      }

      function optionSelected(poll, e) {

          $(".score" + poll).fadeIn();
          var count_index = e.target.value;

          poll_key = poll + ',' + count_index;

          if (checkCookie(poll_key) == 0)
              return false;

          $.ajax({
              url: "<?php echo $url; ?>fun/addPost",
              type: "POST",
              data: {
                  updatePoll: poll,
                  count_key: count_index
              },
              cache: false,
              success: function(result) {

              }
          }).fail(function(jqXHR, textStatus, error) {
              // alert(error);

          });


      }

      function getPost(postId) {

          $("#showUpdate").show();

          $(".placeholder2").show();

          $.ajax({
              url: "<?php echo $url; ?>fun/getPost",
              type: "POST",
              data: {
                  getPost: postId,
              },
              cache: false,
              dataType: 'JSON',
              success: function(result) {

                  $(".single-post").html(result.post);
                  $(".postHead").html(result.title);
                  $(".placeholder2").hide();

              }
          }).fail(function(jqXHR, textStatus, error) {
              // alert(error);

          });

      }

      function loginProcess() {

          email = $("#email-login")
          pass = $("#pass-login")
          msg = $(".error-login")

          msg.hide();

          if (email.val().trim() == '') {
              email.focus();
              return
          }

          if (pass.val().trim() == '') {
              pass.focus();
              return
          }

          $.ajax({
              url: "<?php echo $url; ?>fun/User",
              type: "POST",
              data: {
                  login: email.val().trim(),
                  password: pass.val().trim()
              },
              cache: false,
              success: function(result) {
                  if (result == 1) {
                      location.reload();
                  } else {
                      msg.show();
                      msg.html('Email or password is invalid!')
                  }

              }
          }).fail(function(jqXHR, textStatus, error) {});


      }

      var post_global = 0;

      function showShare(url) {

          let share_url = url;
          post_global = share_url;

          $(".myPostUrl").val(share_url);

          let whatsapp = 'whatsapp://send?text=' + share_url;
          let facebook = 'http://www.facebook.com/sharer.php?u=' + share_url;
          let linkedin = 'https://www.linkedin.com/shareArticle?mini=true&url=' + share_url;
          let gmail = `mailto:?subject=Post by Community&body=${share_url}`;

          $("#shareMyCoursesWhatsapp").removeAttr('href').attr('href', whatsapp);
          $("#shareMyCoursesFacebook").removeAttr('href').attr('href', facebook);
          $("#shareMyCoursesLinkedin").removeAttr('href').attr('href', linkedin);
          $("#shareMyCoursesmail").removeAttr('href').attr('href', gmail);


          $("#showShare").show();

      }


      function copyLink(url) {
          // url = 'https://community.jobaajlearnings.com/post/'+id;
          navigator.clipboard.writeText(url);
          showToast('Link Copied to Clipboard!', 3000);
      }


      function enterComment(e) {

          if (e.keyCode == 13) {
              <?php if (!isset($_SESSION['learner_id'])) { ?>
                  loginNow();
                  return false;
              <?php } ?>
              writeComment(e);

          }
      }

      function postComment(comment_box_id) {

          $(`#comment${comment_box_id}`).trigger($.Event('keydown', {
              keyCode: 13
          }));

      }

      function writeComment(e) {

          cmt = e.target.value;

          if (cmt.trim() == '')
              return;

          postId = e.target.dataset.post

          cmtName = $(".post-name").html();
          cmtSrc = $(".user-profile").attr('src');

          e.target.value = ''

          $.ajax({
              url: "<?php echo $url; ?>fun/addPost",
              type: "POST",
              data: {
                  AddComment: cmt,
                  post: postId,
              },
              cache: false,
              success: function(result) {
                  if (result == 1) {

                      $(".clist" + postId).append(`<div class="comment-list">
                            <div class="comment-image">
                                <a href="/profile/'.$user_id.'"><img src="${cmtSrc}"" class="rounded-circle"/></a>
                            </div>
                            <div class="comment-info">
                                <h3>
                                    <a href="">${cmtName}</a>
                                </h3>
                                <p>${cmt}</p>
                                <ul class="comment-react">
                                    <li><span>Just Now</span></li>
                                </ul>
                            </div>
                        </div>`)
                  }

              }
          }).fail(function(jqXHR, textStatus, error) {
              // alert(error);

          });

      }
      var skill = '<?php echo $user['com_category']; ?>';
      if (skill != '0' && skill != '') {
          $(`input[name=cat][value=${skill}]`).prop('checked', true);
      } else {
          if (skill != '')
              changeCat();
      }
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js" integrity="sha512-hkvXFLlESjeYENO4CNi69z3A1puvONQV5Uh+G4TUDayZxSLyic5Kba9hhuiNLbHqdnKNMk2PxXKm0v7KDnWkYA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


  <?php require('toast.php'); ?>

  </html>