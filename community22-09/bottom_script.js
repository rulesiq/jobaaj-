 
    $(".close").click(function(){
        $("#showPost").hide();
    })
    
     $(".close2").click(function(){
        $("#showUpdate").hide();
    })
    
     $(".closeLogin").click(function(){
        $("#showLogin").hide();
    })
    
     $(".closeShare").click(function(){
        $("#showShare").hide();
    })
    
     $(".closeImg").click(function(){
         
       $("#file_url").val('');
       $(".modal-content").css('height',"405px")
       $(".emojionearea-editor").keyup();
       $(".img-box").hide();
       $(".img-choosen").hide();
       $("#img-preview").html('')
       
       $("#thumb_file").val('');
               
    })
    
    
   


    
    $(function () {
        
        
        
        
    $('.emojionearea-editor').keyup(function() {
        
        let post = $('.post-editor')
        
        let text = post.val();
         
        btnSubmit  = $("#postNow");
        
          if ($(this).val().trim() != "")
             btnSubmit.removeAttr("disabled");
          else 
             btnSubmit.attr("disabled", "disabled");
        
        if(text.length > 85)
            $(this).css('font-size',".9rem");
        else
            $(this).css('font-size',"1.2rem");
       
        });
    
    });


     $("#thumb_file").change(function () {
         
     const total_file = document.getElementById("thumb_file").files.length;

             for(var i=0;i<total_file;i++)
             {
              $('#img-preview').append("<div style='width:50%'><img class='pimg' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
             }
             
            $(".img-choosen").show();
            $("#postNow").removeAttr("disabled");
    });
    
  function chooseImg(){
      uploadNow();
  }
  function uploadNow(){
    
      $(".emojionearea-editor").css({'font-size':'.9rem','min-height':'2rem'});
       $("#thumb_file").click();
  }
  
  function loginNow(){
         $("#showLogin").show();
         $("#email-login").focus();
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
                      console.log(result)
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
    
     $(document).ready(function(){
            $("#postEditor").emojioneArea({
                pickerPosition:'bottom'
            });
            
     });
    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
   
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }
    

   function checkCookie(poll) {
     
      let poll_cookie = getCookie("463d773cad30c5b74940d5e586e88a75");
      if (poll != "" && poll_cookie == poll) {
         return 0;
      } else {
          setCookie("463d773cad30c5b74940d5e586e88a75",poll,100);
          return 1;
      }
      
    }
    
   function optionSelected(poll,e){
                
        $(".score"+poll).fadeIn();
        var count_index = e.target.value;
        
        poll_key = poll+','+count_index;
        
        if(checkCookie(poll_key) == 0)
         return false;
        
        $.ajax({
          url: "<?php echo $url;?>fun/addPost",
          type: "POST",
          data: {
            updatePoll: poll,
            count_key:count_index
          },
          cache: false,
          success: function(result) {
            
          }
        }).fail(function(jqXHR, textStatus, error) {
         // alert(error);
    
        });
        
        
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
    
          }
        }).fail(function(jqXHR, textStatus, error) {
         // alert(error);
    
        });
        
    }
    
    
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
                      
                      console.log(result)
                  }
                }).fail(function(jqXHR, textStatus, error) {  });
                
        
    }


   var post_global = 0;
  
  
  function showShare(id){
     
     post_global = id;
      
     let share_url = 'https://community.jobaajlearnings.com/post/'+id;
      
        $(".myPostUrl").html('https://community.jobaajlearnings.com/post/'+id);
        
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
    
    
  function copyLink(id){
        url = 'https://community.jobaajlearnings.com/post/'+id;
        navigator.clipboard.writeText(url);
        showToast('Link Copied to Clipboard!',3000);
  }
    
    
function enterComment(e){
   
    console.log(e)
    if(e.keyCode == 13) {
     <?php if(!isset($_SESSION['learner_id'])) { ?>
      loginNow();
      return false;
     <?php } ?>
     writeComment(e);
     
    }
}

function postComment(comment_box_id){
    
    $(`#comment${comment_box_id}`).trigger($.Event('keydown', { keyCode: 13 }));
    
}

function writeComment(e){
     
      cmt = e.target.value;
      
      if(cmt.trim()=='')
      return;
      
      postId = e.target.dataset.post
      
      cmtName = $(".post-name").html();
      cmtSrc = $(".user-profile").attr('src');
      
      e.target.value = ''
      
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
    
    
// $(".modal").click(function(){
//   $(".modal").hide(); 
// });
    