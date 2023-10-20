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
    #showLogin{
        z-index: 11111111111 !important;
    }
    
}
</style>
    
    <div class="content-page-box-area mt-5">
                <div class="all-notifications-body">
                    <div class="all-notifications-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-3">Notifications</h3>
                        
                        <!--<div class="dropdown">-->
                        <!--    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flaticon-menu"></i></button>-->
                        <!--    <ul class="dropdown-menu" style="">-->
                        <!--        <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="flaticon-private"></i> Hide Notifications</a></li>-->
                        <!--        <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="flaticon-trash"></i> Delete Notifications</a></li>-->
                        <!--    </ul>-->
                        <!--</div>-->
                    </div>
                    
                    
                    <?php
                                              $sel = mysqli_query($db,"SELECT c.*,u.full_name,u.image,u.verification_code FROM com_notify c join users u on u.id = c.fromUser where (toUser = '$user[id]' or toUser = 0) order by nid desc");
                                              if(mysqli_num_rows($sel)>0){ 
                                                  
                                                while($not = mysqli_fetch_assoc($sel)) { 
                                                    
                                                $post_url = $url."/post/".$not['post'];
                                                
                                                if($not['image']!='')
                                                    $profileNotify = $l_url.'data/pro/'.$not['image'];
                                                    else
                                                    $profileNotify = $l_url.'/assets/images/avatar.png';
                                                    
                                                $tick = '';
                                                if($not['verification_code']=='101')
                                                $tick = "<img src='$url/assets/images/tick.svg' class='tick'>";
                                                
                                                ?>
                                                
                    <div class="item d-flex justify-content-between align-items-center">
                        <div class="figure">
                            <a href="javascript:;"><img src="<?php echo  $profileNotify;?>" onerror="this.onerror=null;this.src='http://community.jobaajlearnings.com/assets/images/avatar.png'"  class="rounded-circle" alt="image"></a>
                        </div>
                        <div class="text">
                            <h4><a href="javascript:;"><?php echo $not['full_name'].' '.$tick;?></a></h4>
                            <div style="cursor:pointer" onclick="location.href='<?php echo $post_url;?>'">
                            <span><?php echo $not['msg'];?></span>
                            <span class="main-color"><?php echo timeago(date('Y-m-d H:i:s',$not['date_added'])); ?></span>
                            </div>
                        </div>
                        <div class="icon">
                            <a href="#"><i class="flaticon-x-mark"></i></a>
                        </div>
                    </div>
                   <?php } }  ?>
                </div>
            </div>

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

    
  function copyLink(id){
        url = 'https://community.jobaajlearnings.com/post/'+id;
        navigator.clipboard.writeText(url);
        showToast('Link Copied to Clipboard!',3000);
  }
    
    


function postComment(comment_box_id){
    
    <?php if(!isset($_SESSION['learner_id'])) { ?>
      loginNow();
      return false;
     <?php } ?>
     
     writeComment(comment_box_id);
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
    
    function rightOpen() {
                     // $("#mySidenav").removeClass('open-class');

          $(".right-sidebar-area").toggleClass('right-size');
          $("#arrowBtn").toggleClass('right-size2');

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