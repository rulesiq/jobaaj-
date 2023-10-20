    <?php 
    
    require('pin/head.php');
    
    require('pin/left_side.php');
    
    $userId = mysqli_real_escape_string($db,$_GET['user']);
    $find_user = mysqli_query($db,"select * from users where metaname = '$userId'");
   
       
    $user = mysqli_fetch_assoc($find_user);
    $user['metaname'];
    $username = $user['metaname'];
    $username = "@".strtolower($username);
    if($user['image']!='')
    $profile = $l_url.'data/pro/'.$user['image'];
    else
    $profile = $url.'/assets/images/avatar.png';
    
    
    $userd = mysqli_fetch_assoc(mysqli_query($db,"select * from users_details where u_id = '$user[id]'"));
    $linkedin = $userd['linkedin'];
    $twitter = $userd['twitter'];
    $github = $userd['github'];


    $tick = '';
    if($user['verification_code']=='101')
    $tick = "<img   src='$url/assets/images/tick.svg' class='tick'>";
    
    
    $cover ="https://i.pinimg.com/originals/a3/af/35/a3af356c5d57a46a1abdf37421ce3ac3.jpg";
    $user_owner = $user['id'] == $learner_id ? true : false;
    ?>
    
    
    <style>
    
     /* Chrome,
    Safari,
    Edge,
    Opera */ input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    
    
    .dropdown {
        cursor:pointer;
    }
    #error{
        display:none;
        font-size: .8rem;
    color: #dc3545;
    }
    .my-profile-inner-box .profile-info-box .profile-social {
    top: 84px;
    }
    .my-profile-inner-box .profile-info-box {
    padding: 0 24px 20px;
    position: relative;
}

    .my-profile-inner-box .profile-info-box .inner-info-box .info-text {
    width: 475px;
    }

.account-setting-form .default-btn{
    padding: 8px 24px;
}
    .news-feed-area .news-feed-post .post-header .info {
        width: 634px;
    }
    .profile-social img{
        width:25px;
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
        #uploadPreview{
                width: 140px;
                height: 140px;
                border-radius: 100px;
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
        #btnUpdate{
            background: #fff;
    color: #222;
    }
    
    @media only screen and (max-width: 767px) {

    .profile-cover-image {
            padding-top: 4rem;
    }
    #uploadPreview {
    width: 100px;
    height: 100px;
    border-radius: 100px;
    margin-top: -4rem;
    }
    .my-profile-inner-box .profile-info-box .inner-info-box.d-flex
    {
            display: flex!important;
    }
    
    .btn-icon {
        height: 2rem;
        width: 2rem;
    }
    .btn-icon i {
        font-size: 1rem;
        line-height: 1rem;
    }
    
    
    }
    
    
    </style>
            <!-- Start Content Page Box Area -->
            <div class="content-page-box-area mt-0" >
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        
            <div class="">
                <div class="my-profile-inner-box">
                    <div class="profile-cover-image">
                        <a href="#">
                            <img src="<?php echo $cover;?>" alt="image">
                        </a>
                        <?php if($user_owner) { ?>
                        <!--<a href="#" class="edit-cover-btn">Edit Cover</a>-->
                        <?php } ?>
                    </div>

                    <div class="profile-info-box">
                        <div class="inner-info-box mt-3 d-flex  align-items-center">
                            <div class="info-image">
                               
                                <form id="profileImage">
                                  <input type="file" style="display:none" name="avatar" onchange="loadFile1(event)" id="uploadImage">
                                    <img src="<?php echo $profile;?>" id="uploadPreview" alt="image">

                                  <?php if($user_owner) { ?>
                                  <button type="button" onclick="openfileDialog()" id="btnUpdate" class="icon btn btn-icon  btn-sm border rounded-circle shadow-sm position-absolute bottom-0 end-0 mt-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Change picture">
                                    <i class="flaticon-photo-camera"></i>
                                  </button>
                                  <?php }?>
                                </form>
                                
                            </div>
                            <ul class="statistics">
                               
                                <!--<li>
                                    <a href="#">
                                        <span class="item-number">8591</span> 
                                        <span class="item-text">Following</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="item-number">784514</span> 
                                        <span class="item-text">Followers</span>
                                    </a>
                                </li>-->
                            </ul>
                        </div>
                        
                        <div class="info-text mt-2">
                                <h4><a href="#"><?php echo $user['full_name']." ".$tick;?> </a></h4>
                                <span style='font-size:.8rem'><a href="#"><?php echo $username;?></a></span>
                                <br/>
                            </div>

                        <div class="profile-list-tabs">
                            
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                
                                <li class="nav-item">
                                    <a class="nav-link active" id="timeline-tab" data-bs-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" aria-selected="true">Posts</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link " id="about-tab" data-bs-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false">About</a>
                                </li>
                                
                                
                            <?php if($user_owner) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" id="update-tab" data-bs-toggle="tab" href="#update" role="tab" aria-controls="friends" aria-selected="false">Update</a>
                                </li>
                            <?php } ?>
        
                            </ul>
                        </div>

                        <ul class="profile-social">
                            <?php if($linkedin!=''){?>
                            <li>
                                <a href="<?php echo $linkedin;?>" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" alt="image">
                                </a>
                            </li>
                            <?php } if($github!=''){?>
                            <li>
                                <a href="<?php echo $github;?>" target="_blank">
                                    <img src="https://cdn-icons-png.flaticon.com/512/25/25231.png" alt="image">
                                </a>
                            </li>
                            <?php } if($twitter!=''){?>
                            <li>
                                <a href="<?php echo $twitter;?>" target="_blank" >
                                    <img src="https://cdn-icons-png.flaticon.com/512/3670/3670151.png" alt="image">
                                </a>
                            </li>
                            <?php } ?>
                           
                        </ul>
                    </div>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="timeline" role="tabpanel">
                        <div class="row">
                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

                            <div class="col-lg-12 col-md-12">
                                <div class="news-feed-area">
                                    <div class="mainBox">
                                        
                                    </div>
                                </div>
                            </div>
        
                            <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="about" role="tabpanel">
                        <div class="row">
                            
                            <div class="col-lg-12 col-md-12">
                                <div class="about-details-information">
                                    <div class="information-box-content">
                                        <div class="information-header d-flex justify-content-between align-items-center">
                                            <div class="title">About Me!</div>
                                            <?php if($user_owner){ ?>
                                            <div  class="dropdown" onclick="openUpdate()">
                                               <i class="flaticon-edit"></i> Edit</a>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="content">
                                            <p><?php echo $user['biography'];?></p>
                                        </div>
                                    </div>

                                </div>
                            </div>  
                        </div>
                    </div>
                    <?php if($user_owner) { ?>
                    <div class="tab-pane fade" id="update" role="tabpanel">
                       <form class="account-setting-form">
                            <h3>Account Information</h3>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" id="fname" value="<?php echo $user['full_name'];?>" class="form-control" placeholder="Full name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input  type="text" oninput="restrictInput(event)" id="uname" value="<?php echo $user['metaname'];?>" class="form-control" placeholder="Username">
                                        <span id="error">Username not available!</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input disabled type="email" value="<?php echo $user['email'];?>" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" id="mobile" class="form-control" value="<?php echo $user['contact'];?>" placeholder="Mobile number">
                                    </div>
                                </div>
                                 <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" id="city" value="<?php echo $userd['city'];?>" class="form-control" placeholder="City, Location">
                                    </div>
                                </div>
                                
                                 <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select id="gender" class="form-control">
                                            <option <?php echo ($user['gender'] == 'male') ? 'selected' : '';?> value="male">Male</option>
                                            <option <?php echo ($user['gender'] == 'female') ? 'selected' : '';?> value="female">Female</option>
                                            <option <?php echo ($user['gender'] == 'other') ? 'selected' : '';?> value="other">Other</option>
                                            <option <?php echo ($user['gender'] == '0') ? 'selected' : '';?> value="0">Rather not say</option>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                     <label>About</label>
                                    <textarea type="text" style="height:200px;" id="bio" class="form-control" placeholder="About yourself"><?php echo $user['biography'];?></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-md-12">
                                    <button style="float:right" type="button"  id="update1" class="default-btn">Update</button>
                                </div>
                            </div>
                            
                            <br/>
                            <h3>Social Information</h3>

                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Linkedin Profile</label>
                                        <input type="text" value="<?php echo $userd['linkedin'];?>" id="linkedin" class="form-control" placeholder="Linkedin">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Twitter </label>
                                        <input type="text" value="<?php echo $userd['twitter'];?>" id="twitter" class="form-control" placeholder="Twitter">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Github</label>
                                        <input type="text" value="<?php echo $userd['github'];?>" id="github" class="form-control" placeholder="Github">
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 col-md-12">
                                    <button style="float:right" type="button" onclick="updateSocial()" id="update2"  class="default-btn">Update</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                    <?php } ?>
                </div>
            </div>
            
                            
              <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

                            

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
                  
                  
                  <!--<div class="mt-5 widget-area">
                      <a href='javascript:;' onclick="gameOpen()">
                      <img src="<?php echo $url;?>assets/game.jpeg"/>
                      </a>
                  </div>-->

              </aside>
                    </div>    
                        </div>
                    </div>

                    
                </div>
            </div>
            <!-- End Content Page Box Area -->





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
  
  <div class="modal-dialog"  style="max-width: 30%;top:8%">
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
                          <a target="_blank" id="shareMyCoursesLinkedin" class="btn btn-icon rounded-circle" style="background:#0a66c2;" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=https://www.jobaajlearnings.com/join-referral/jl-financialmodellingvaluations-c_5-4822">
                              <i class="fa-brands fa-linkedin-in"></i>
                          </a>
                          <span class="fw-bold" style="font-size:14px">Linkedin</span>
                      </span>
                      
                      <span class="text-center">
                          <a target="_blank" id="shareMyCoursesWhatsapp" class="btn btn-icon rounded-circle" style="background:#25D366;" href="whatsapp://send?text=https://www.jobaajlearnings.com/join-referral/jl-financialmodellingvaluations-c_5-4822">
                              <i class="fa-brands fa-whatsapp"></i>
                          </a>
                          <span class="fw-bold" style="font-size:14px">Whatsapp</span>
                      </span>
                      
                     
                      
                      <span class="text-center">
                          <a target="_blank" id="shareMyCoursesFacebook" class="btn btn-icon rounded-circle" style="background:#3b5998;" href="http://www.facebook.com/sharer.php?u=https://www.jobaajlearnings.com/join-referral/jl-financialmodellingvaluations-c_5-4822">
                              <i class="fa-brands fa-facebook-f"></i>
                          </a>
                          <span class="fw-bold" style="font-size:14px">Facebook</span>
                      </span>
                      
                       <span class="text-center">
                          <a target="_blank" id="shareMyCoursesmail" class="btn btn-icon rounded-circle" style="background:#f44336;" href="mailto:?subject=Financial Modelling &amp; Valuations by Jobaaj Learnings&amp;body=Dear Iqbal Shah,%0D%0A%0D%0AUse this link to enroll yourself into Financial Modelling &amp; Valuations by Jobaaj Learnings!%0D%0A%0D%0A%0D%0Ahttps://www.jobaajlearnings.com/join-referral/jl-financialmodellingvaluations-c_5-4822%0D%0A%0D%0AFeel free to reach out to us if you're facing any issues.%0D%0A%0D%0ARegards,%0D%0ATeam Jobaaj Learnings">
                              <i class="fa-regular fa-envelope"></i>
                          </a>
                          <span class="fw-bold" style="font-size:14px">Gmail</span>
                      </span>
                      <!-- <span class="text-center">
              <a href="" target="_blank" id="shareMyCoursesTelegram" class="btn btn-icon rounded-circle" style="background:#0088cc;">
                <i class='bx bxl-telegram'></i>
              </a>
              <span class="fw-bold" style="font-size:14px">Telegram</span>
            </span> -->
                     

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

<div style="height:200px;"></div>

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
 
    var user_accept = true;
    
    $(".closeShare").click(function() {
          $("#showShare").hide();
    })
    
    $("#uname").focusout(function(){
        $("#error").hide();
        
       let username = $(this).val().trim();
       
       
         $.ajax({
              url: "<?php echo $url; ?>fun/User",
              type: "POST",
              data: {
                  check_user_name:username,
              },
              cache: false,
              dataType: 'JSON',
              success: function(result) {
                  console.log(result)
                  if(result==0){
                      user_accept = false;
                      $("#error").show();
                  }else{
                      user_accept = true;
                  }
              }
         });
        
         
    });
      
      
  function getPosts(cat) {
            
          search_key = '';

          $(".placeholder").show();
          
          loadData(cat,search_key,0);

      }
      
  getPosts('-2');
  
  
  function restrictInput(event) {
  const inputElement = event.target;
  let inputValue = inputElement.value;

  // Convert any uppercase letters to lowercase
  inputValue = inputValue.toLowerCase();

  // Define a regular expression pattern that allows only lowercase letters, numbers, underscores, and spaces.
  const pattern = /^[a-z0-9_ ]*$/;

  if (!pattern.test(inputValue)) {
    // Remove any characters that don't match the pattern.
    inputElement.value = inputValue.replace(/[^a-z0-9_ ]/g, '');
  }
}



  
      
  function loadData(cat,search_key,offset){
          
          console.log(<?php echo $user['id'];?>)
            $.ajax({
              url: "<?php echo $url; ?>fun/getPost",
              type: "GET",
              data: {
                  userPosts: <?php echo $user['id'];?>,
                  offset: 0,
              },
              cache: false,
              dataType: 'JSON',
              success: function(result) {
                  
                  console.log(result)
                  
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
      
  function openUpdate(){
      var someTabTriggerEl = document.querySelector('#update-tab')
      var tab = new bootstrap.Tab(someTabTriggerEl)
    
      tab.show()
  }


  $("#update1").click(function(){
        
        
        
        if(!user_accept) {
         $("#uname").focus();
         
         var scrollDiv = document.querySelector(".account-setting-form").offsetTop;
         window.scrollTo({ top: scrollDiv, behavior: 'smooth'});

         return false;
        }
        
        $(this).html('Updating...');
    
        var fname = $("#fname").val();
        var mobile = $("#mobile").val();
        var bio = $("#bio").val();
        
        var uname = $("#uname").val();
        var city = $("#city").val();
        var uname = $("#uname").val().trim();
        var gen = $("#gender").val();
        
        if(uname == '') { 
            $("#uname").focus();
            return;
        }
    
        $.ajax({
          url: "<?php echo $url; ?>fun/User.php",
          type: "POST",
          data: {
            updateProfile: true,
            fname: fname,
            uname: uname,
            bio: bio,
            mobile: mobile,
            uname: uname,
            city: city,
            gender: gen
          },
          cache: false,
          success: function(result) {
                 showToast('Profile details updated!', 3000);

             $("#update1").html('Updated!');
    
          }
        });

  });
  
      function loginNow() {
          $("#showLogin").show();
          $("#email-login").focus();
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




  function updateSocial() {

        $("#update2").html('Updating...');

        var git = $("#github").val();
        var link = $("#linkedin").val();
        var tweet = $("#twitter").val();
    
        $.ajax({
          url: "<?php echo $url; ?>fun/User",
          type: "POST",
          data: {
            updateSocial: true,
            git: git,
            link: link,
            tweet: tweet
          },
          cache: false,
          success: function(result) {
             showToast('Social media updated!', 3000);
             $("#update2").html('Updated!');
    
          }
        });

  }
  
  
  var loadFile1 = function(event) {
    var reader = new FileReader();
    reader.onload = function() {
      var output = document.getElementById('uploadPreview');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);

    updateProfile();

  };

  function openfileDialog() {
    $("#uploadImage").click();
  }

  function updateProfile() {

    var fileInput = document.getElementById('uploadPreview');
    var filePath = fileInput.value;
    console.log(filePath);

    $("#btnUpdate").html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>');
    let myform = document.getElementById("profileImage");
    let fd = new FormData(myform);
    $.ajax({
      url: "<?php echo $url; ?>fun/User",
      data: fd,
      cache: false,
      processData: false,
      contentType: false,
      type: 'POST',
      success: function(response) {
          showToast('Profile updated!', 3000);
        $("#btnUpdate").html(' <i class="flaticon-photo-camera"></i>');
      }
    });

  }
   
   
    
</script>
<?php require('toast.php');?>


</html>