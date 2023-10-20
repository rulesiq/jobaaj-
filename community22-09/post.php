<?php 
    
    require('pin/head.php');
    require('pin/left_side.php');
    require('pin/right_side.php');

?>
    
<style>

#showLogin .modal-dialog{
    max-width: 30%;
}
@media only screen and (max-width: 767px) {
    #showLogin .modal-dialog{
        margin:1rem;
       max-width: 100%;

    }
    #iframe{
        margin-top:3rem;
    }
    #showLogin{
        z-index: 11111111111 !important;
    }
    
}
</style>

    <style>
    video{
        width:100%;
        height:30rem;
    }
    
    .news-feed-area .news-feed-post .post-header .info {
    width: 634px;
    }

    .form-outline input {
        border:none;
        border-radius:0px !important;
        padding: 0px;
        padding-bottom: 0.3rem;
        border-bottom:1px solid #888;
    }
    .list-group-item {
    position: relative;
    display: block;
    padding: 0.5rem 0rem !important;
    margin-bottom: 1.3rem !important;
    color: #212529;
    border:none;
    border-radius: 0px;
    text-decoration: none;
    background-color: #fff;
    border-bottom: 1px solid rgba(0,0,0,.125) !important;
}
.score {
        font-weight: 600;
    float: right;
    display:none;
}
    

    .panel-title{
        margin-top:20px !important;
            margin-bottom: 20px !important;
    font-size: 1.5rem;
    }
    .post-body a {
        color:#3644d9;
    }
        .img-choosen {
            display:none;
                margin-bottom: 2.4rem;
                padding:.7rem;
        }
        .closeImg {
            font-size: 1.5rem;
            float: right;
            position: relative;
            top: 10px;
            background: #fff;
            border-radius: 1rem;
        }
        
        .radio input[type='radio']{
                margin-right: 0.3rem;
        }
        
        .panel-body {
            margin-left:.8rem;
        }
        .post-strip {
            margin-bottom:10px;
            width: 100%;border:1px solid #555;justify-content: space-between;padding:.3rem 1rem;border-radius:.4rem;height:2.6rem;display:flex
        }
        
        .modal-footer{
            border: none;
        }
    </style>
            <!-- Start Content Page Box Area -->
            <div class="content-page-box-area">
                <div class="row">
                    
                   
          <div class="col-lg-3 side_home">
              <div style="width:16rem;background:#fff;">
                  <p style="padding-top:.5rem;margin:0 .5rem;font-weight:600;font-size:.8rem">Categories</p>
                  <ul style="padding-left:0px !important;" class="menu_sidebar metisMenu">

                      <?php
                        $q = mysqli_query($db, "select * from com_category order by position");
                        $i = 0;
                        while ($c = mysqli_fetch_array($q)) {
                            ++$i; ?>
                          <li class="nav-item">
                              <a onclick="" href="https://community.jobaajlearnings.com/#<?php echo str_replace(" ", "", str_replace("&", "", $c['name'])); ?>" class="nav-link cat<?php echo $c['id']; ?>">
                                  <span class="icon">
                                      <i style="color:<?php echo $c['color_code'];?>" class="<?php echo $c['thumb']; ?>"></i>
                                   </span>
                                  <span class="menu-title"><?php echo $c['name']; ?></span>
                              </a>
                          </li>
                      <?php } ?>

                  </ul>
                  <img style="padding-left:1rem;margin-top: 22px;max-width: 238px;cursor:pointer;" onclick="location.href='https://www.jobaajlearnings.com/workshop'" src="<?php echo $url; ?>assets/offer-banner-workshop.jpg" />

                  <br /><br />
              </div>

          </div>
          
          <div id="gameNow" class="col-lg-6  col-md-12">
              
                <div style="width:100%;text-align:center;">
						<iframe src="https://games.jobaaj.com/" id="iframe" class="px-2 mb-3" style="border-radius: 1rem;overflow: hidden;display:none;width:100%;height:650px"></iframe>
					
				</div>
				
				
				<?php if (!$postExist) { 
				    
				        echo "
				            <h5 class='text-center mt-3'><img src='$url/assets/not-found.png' class='w-75'/><br/><a href='/' class='btn btn-success'>Go to Feeds</a></h5>";
				        
				      
				        } else { ?>
                        <div class="news-feed-area">
                            
                            <?php 
                    
                            require('placeholder.php');
                           
                            ?>
                            
                            <div class="mainBox">
                               
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
                            
                           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

                            <div class="single-post news-feed-area">
                            
                            </div>
                            
                          <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

                            

                            </div>
                            
                        </div>
                        
                        <?php } ?>
                    </div>

          <div class="col-lg-3">
              <aside class="" style="padding: 0 .5rem;">
                  
                  <div class="py-2 px-3 tranding">
                      <h5 class="py-3">#Trending Now</h5>
                      
                     <?php 
                     $fetch = mysqli_query($db,"select * from com_hashtags order by id desc");
                     while($row = mysqli_fetch_assoc($fetch)) { 
                         $tag = ucfirst($row['hashtag']);
                         echo '
                              <div class="d-flex mb-3 flex-column">
                              <span class="cat">'.$row['category'].'</span>
                              <a href="https://stories.jobaaj.com/search/'.$tag.'" target="_blank">#'.$tag.'</a>
                              <span class="view">'.rand(10,50).'.'.rand(1,5).'K views</span>
                              </div>';
                       } ?>
                  
                  
                  </div>
                  
                  
                  <div class="mt-5 widget-area">
                      <a href='javascript:;' onclick="gameOpen()">
                      <img src="<?php echo $url;?>assets/game.jpeg"/>
                      </a>
                  </div>

              </aside>
          </div>
                </div>
            </div>
            <!-- End Content Page Box Area -->




<?php  

$profile = $l_url.'data/pro/'.$user['image']; 
   
?>

        </div>
        <!-- End Main Content Wrapper Area -->
        
        <!-- Start Copyright Area -->
       
        <!-- End Copyright Area -->

        <!-- Start Go Top Area -->
        <div class="go-top">
            <i class="ri-arrow-up-line"></i>
        </div>
        <!-- End Go Top Area -->

<div class="modal" id="showLogin" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
  
  <div class="modal-dialog"  style="top:8%">
    <div class="modal-content">

      <div class="modal-header" style="display:flex;">
        <h4 class="modal-title" id="myModalLabel">Login</h4>
            <i  class="fa-solid fa-xmark closeLogin"></i>

      </div>
      <div class="modal-body">
          <form id="loginForm" style="padding:1rem">
              
                               <!-- Email input -->
                  <div class="form-outline mb-4">
                    <input placeholder = "Email " type="email" id="email-login" class="form-control" />
                  </div>
                
                  <!-- Password input -->
                  <div class="form-outline">
                    <input placeholder = "Password " type="password" id="pass-login" class="form-control" />
                  </div>
                  <span style='color: #ea584d;font-size: .9rem;' class="error-login"></span>
                  <!-- Register buttons -->
                  <div class="text-center" style="margin-top:.5rem">
                    <p>Not a member? <a href="http://jobaajlearnings.com/login">Register</a></p>
                    
                  </div>
          </form>
        
      </div>
        
      <button style="width: 100%;" onclick="loginProcess()"  id="LoginNow" type="button" class="btn btn-primary">Login</button>
      
      
      </div>
      
      <div class="post-loader">
          
      
      
    </div>
  </div>
</div>

<div class="modal" style="    padding: 1rem;z-index:1" id="showShare" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-dialog-centered shareDialog"  role="document">
      <div class="modal-content border-0 shadow" style="border-radius:1.5rem;">

  <i style="    text-align: right;"  class="fa-solid fa-xmark closeShare"></i>
  
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
            <input type="text" readonly style="height:1rem" disabled class="w-100 p-2 border-0 bg-transparent myPostUrl"/>
            <button style="font-size:.8rem" class="btn btn-primary rounded-pill" onclick="copyLink(post_global)">Copy</button>
          </div>
        </div>
      </div>
    </div>
    
</div>


</div>


    <!-- Links of JS files -->
    <script src="<?php echo $url;?>assets/js/jquery.min.js"></script>
    <script src="<?php echo $url;?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $url;?>assets/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo $url;?>assets/js/jquery-ui.min.js"></script>
    <script src="<?php echo $url;?>assets/js/simplebar.min.js"></script>
    <script src="<?php echo $url;?>assets/js/metismenu.min.js"></script>
    <script src="<?php echo $url;?>assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo $url;?>assets/js/wow.min.js"></script>
    <script src="<?php echo $url;?>assets/js/main.js"></script>
    
    </body>
    
<script>
 
    $(".closeLogin").click(function(){
        $("#showLogin").hide();
    })
    
    $(".closeShare").click(function(){
        $("#showShare").hide();
    })
    
    
function loginNow(){
         $("#showLogin").show();
   }
  
    function gameOpen(){
            $("#iframe").fadeIn();
                $('html, body').animate({
                scrollTop: $("#gameNow").offset().top
            }, 100);
            
            
            
            }
            
 function delCmt(cmt_id){
        
     $.ajax({
                  url: "<?php echo $url;?>fun/addPost",
                  type: "POST",
                  data: {
                    delComment: true,
                    cmt: cmt_id
                  },
                  cache: false,
                  success: function(result) {
                      $(".cmt"+cmt_id).fadeOut(800);
                  }
                });
    }
    
    
   function updateCmt(cmt_id){
       
        let commentBox = $(".editBox"+cmt_id);
        let commentNew = commentBox.html().trim();
        if(commentNew == '')
         return
        
         $.ajax({
                  url: "<?php echo $url;?>fun/addPost",
                  type: "POST",
                  data: {
                    updateComment: true,
                    cmt: cmt_id,
                    cmtText: commentNew
                  },
                  cache: false,
                  success: function(result) {
                      $(".updateBox"+cmt_id).hide();
                      commentBox.attr('contenteditable','false');
                  }
                });
        
   }

 $(document).ready(function() {

    const mainBox = document.querySelector('.mainBox');
      
    let boxActive = 0;
    mainBox.addEventListener('click',(e)=>{
                
                if(e.target.closest('.comment-reply')){
                    
                    if(boxActive==0) {
                 
                        let cmtId = e.target.closest('.comment-reply').dataset.comment;
                        let postId = e.target.closest('.comment-reply').dataset.post;
                        
                        $(`.cmt${cmtId}`).append(`<div class="post-footer"><div class="form-group reply-box reply-comment${cmtId}">
                                                    <textarea name="message" class="form-control" id="reply-comment${cmtId}" data-post='${postId}' placeholder="Write a reply..."></textarea>
                                                    <label class="post-comment-reply" data-post='${postId}' data-reply='${cmtId}'>Reply</label>
                                                </div></div>`);
                        boxActive = 1;
                    }
                }
                
                if(e.target.closest('.post-comment')){
                    let cmtBoxId = e.target.closest('.post-comment').dataset.post;
                    postComment(cmtBoxId);
                }
                
                if(e.target.closest('.post-comment-reply')){
                    
                    let cmtBoxId = e.target.closest('.post-comment-reply').dataset.reply;
                    let postId = e.target.closest('.post-comment-reply').dataset.post;
                    boxActive = 0;
                    postCommentReply(cmtBoxId);
                        
                }
                
                return false;
                
                
        });

});        
        
 function postCommentReply(comment_box_id) {
            
          let e = $(`#reply-comment${comment_box_id}`)
          let cmt = e.val();

          if (cmt.trim() == '')
              return;

          postId = e.data('post');

          cmtName = '<?php echo $user['full_name'];?>';
          cmtSrc = $(".userAvatar").attr('src');
          cmt = cmt.replace(/\n/g, "<br>\n");
          
        
          $.ajax({
              url: "<?php echo $url; ?>fun/addPost",
              type: "POST",
              data: {
                  AddCommentReply: cmt,
                  post: postId,
                  comment_id:comment_box_id,
              },
              cache: false,
              success: function(result) {
                  
                  if (result == 1) {
                      
                      e.val('');
                    
                      $(".reply-comment"+comment_box_id).parent().remove();
          
                        $(".cmt" + comment_box_id).append(`<div class="comment-list  comment-reply ms-5 mt-2">
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
          });
       
      }
  
   function delReplyCmt(cmt_id) {
          
          $.ajax({
              url: "<?php echo $url; ?>fun/addPost",
              type: "POST",
              data: {
                  delReplyComment: true,
                  cmt: cmt_id
              },
              cache: false,
              success: function(result) {
                  $(".cmt-rep" + cmt_id).fadeOut(800);
              }
          });
      }
        

   function editCmt(cmt_id){
       
        let editorCmt = $(".editBox"+cmt_id);
        editorCmt.attr('contenteditable','true');
         $(".updateBox"+cmt_id).show();
    
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
    
  function copyLink(url){
        navigator.clipboard.writeText(url);
        showToast('Link Copied to Clipboard!',3000);
  }
    
  function rightOpen() {

          $(".right-sidebar-area").toggleClass('right-size');
          $("#arrowBtn").toggleClass('right-size2');

      }
      


function postComment(comment_box_id){
    
    <?php if(!isset($_SESSION['learner_id'])) { ?>
      loginNow();
      return false;
     <?php } ?>
     
     let e = $(`#comment${comment_box_id}`)
          let cmt = e.val();


          if (cmt.trim() == '')
              return;

          postId = e.data('post');

          cmtName = '<?php echo $user['full_name'];?>';
          cmtSrc = $(".userAvatar").attr('src');

          e.val('');
          
          cmt = cmt.replace(/\n/g, "<br>\n");
          

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

function writeComment(comment_box_id){
     
          let e = $(`#comment${comment_box_id}`)
          let cmt = e.val();


          if (cmt.trim() == '')
              return;

          postId = e.data('post');

          cmtName = '<?php echo $user['full_name'];?>';
          cmtSrc = $(".userAvatar").attr('src');

          e.val('');
          
          cmt = cmt.replace(/\n/g, "<br>\n");
      
        $.ajax({
          url: "<?php echo $url;?>fun/addPost",
          type: "POST",
          data: {
            AddComment: cmt,
            post: postId,
          },
          cache: false,
          success: function(result) {
            if(result == 1){
                  
                  $(".clist"+postId).append(`<div class="comment-list">
                            <div class="comment-image">
                                <a href="https://community.jobaajlearnings.com/profile/'.$user_id.'"><img src="${cmtSrc}"" class="rounded-circle"/></a>
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

    

function likePost(postId){
        
     <?php if(!isset($_SESSION['learner_id'])) { ?>
        loginNow();
     return;
     <?php } ?>
        
        likeElem = $(".heart"+postId);
        
        likeCount = $(".like"+postId);
        
        if(likeElem.hasClass('fa-regular')) {
            
            if(likeCount.html().trim() != "")
            likeCount.html(parseInt(likeCount.html()) + 1);
            else
            likeCount.html('1');
            
            likeElem.removeClass("fa-regular");
            likeElem.addClass("fa-solid");
            
             $.ajax({
                  url: "<?php echo $url;?>fun/addPost",
                  type: "POST",
                  data: {
                    AddLike: true,
                    post: postId
                  },
                  cache: false,
                  success: function(result) {
                  }
                }).fail(function(jqXHR, textStatus, error) {  });
                
                
        }else{
           
            likeElem.addClass("fa-regular");
            likeElem.removeClass("fa-solid");
            
            if(likeCount.html().trim() != '1')
            likeCount.html(parseInt(likeCount.html()) - 1);
            else
            likeCount.html('');

            
            $.ajax({
                  url: "<?php echo $url;?>fun/addPost",
                  type: "POST",
                  data: {
                    DelLike: true,
                    post: postId
                  },
                  cache: false,
                  success: function(result) {
                  }
                }).fail(function(jqXHR, textStatus, error) {  });
                
                
        }
    }
    
    
function getPost(postId){
       
     $("#showUpdate").show();
       
     $(".placeholder2").show();
    
        $.ajax({
          url: "<?php echo $url;?>fun/getPost",
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
    
function showShare(id){
     
     post_global = id;
      
     let share_url = id;
      
        $(".myPostUrl").val(id);
        
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
  
  
function searchTopic(input){
      
     if(input == 1)
     search_key =  $("#search_input").val();
     else
     search_key =  $("#search_input2").val();
     
     
     if(search_key=='') return false;
     
     location.href="/?search="+search_key;        
      
  }
  $('#search_input').keypress(function (e) {
          if (e.which == 13) {
            searchTopic(1);
            return false;    //<---- Add this line
          }
  });
            
  $('#search_input2').keypress(function (e) {
          if (e.which == 13) {
            searchTopic(2);
            return false;    //<---- Add this line
          }
   });
       
    
getPost(<?php echo $postId;?>)
    
function loginProcess(){
        
         email = $("#email-login")
         pass = $("#pass-login")
         msg = $(".error-login")
         
          msg.hide();
         
         if(email.val().trim() == '') {
           email.focus();
           return
         }  
         
         if(pass.val().trim() == ''){
           pass.focus();
           return
         }
            
         $.ajax({
                  url: "<?php echo $url;?>fun/User",
                  type: "POST",
                  data: {
                    login: email.val().trim(),
                    password: pass.val().trim()
                  },
                  cache: false,
                  success: function(result) {
                      if(result == 1){
                          location.reload();
                      }else{
                          msg.show();
                          msg.html('Email or password is invalid!')
                      }
                      
                  }
                }).fail(function(jqXHR, textStatus, error) {  });
                
        
    }
    
    
</script>
<?php require('toast.php');?>


</html>