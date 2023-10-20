<?php 
    
    require('pin/head.php');
    require('pin/left_side.php');
    require('pin/right_side.php');
    
    if($_SESSION['test'] == 0){
        echo "<script>location.href='$url';</script>"; 
    }
    
if(isset($_GET['result'])){
    
   if(!isset($_SESSION['learner_id'])) 
     echo "<script>location.href='$url';</script>"; 
    
    $data = mysqli_fetch_assoc(mysqli_query($db,"select score,test_id from testResult where id = '$_SESSION[test]' order by id desc"));
    
    $test = $data['test_id'];
    $score = $data['score'];
    $user = $_SESSION['learner_id'];
    
    $result = "fail";
        
        if($score > 50)
            $result = "success";
            
            
    //$_SESSION['test'] = 0;
    
    if($score)
     $certificate = "certificate-".$user."-".$test.".jpeg";
}
?>

<link rel="stylesheet" type="text/css" href="<?php echo $url;?>question.css" />

<style>
.certificate {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
padding:5px;    width: 70%;
}

#question_div ol {
    margin-top:20px;
    list-style:none;
    background:#fafafa;
    
}
 .container {
    max-width:100% !important;
  }


  .check .ans-mock {
    width: 36px;
    height: 24px;
    margin: 5px 2px 10px 10px;
  }
  .ansTypeText {
      font-size:.7rem;
      font-weight:600;
  }
  .ansTypeBox {
      display:flex; 
      justify-content: space-around;
  }
  .ansTypeBox .ans-mock{
      width:1.7rem !important;
      border-radius:.2rem;
  }
  
  .valueAns {
      width:2rem;
      line-height:2rem;
  }
  
  .card-body {
    flex: 1 1 auto;
    padding: 0.6rem 1rem;
  }
.details-points li {
    line-height:2rem;
    font-size:.8rem;
}
.btnC{
    border-radius: 2rem;
    padding: 5px 25px;
}
    .heading {
            font-size: 1.5rem;
    margin-top: 1rem;
    }
    .t-14 {
        font-size:.8rem;
    }
    
    .next{
        min-width: 110px !important;
    font-size: 15px !important;;
    padding: 5px 0;
    font-weight:600;
}
</style>
   
          <div class="content-page-box-area">
                <div class="row">
                    
                     <div class="col-lg-12 col-md-12">
        
                            <div class="mainBox p-5" style="background-color:#fff;border-radius:.3rem;">
                                
                             <div class="tabMain">
                                 
                                <?php 
                                
                                if($result == "fail") {  ?>
                                     
                                <div class="m5 tabFail">
                                          
                                              <h1 class="heading">
                                                Unfortunately, you didn't pass the test.
                                              </h1>
                                              <div class="mv2 t-14">
                                                <span>
                                                  In next 1 months, you'll get the another chance to retake the assessment. In the meantime, Jobaajlearnings can help you to prepare.
                                                </span>
                                              </div>
                                              <div class="mt-5 fs-10 fw-2" style="color:grey">
                                                 <i class="fa fa-eye"></i> Private for you
                                              </div>
                                              <div class="mt-2 t-14">
                                                <span>
                                                 Your score is <?php echo $score;?>%. Score above 65% can earn a certificate.
                                                </span>
                                              </div>
                                              <br/>
                                        
                                            <div class="mt-3 t-14">
                                             <p class="fs-4" style="color:#555">Free courses that may  help you improve</p>
                                             <span>Courses are avaible for 24 hours after you start them.</span>
                                            
                                              <div class="mt-3 row row-cols-1 row-cols-sm-2 row-cols-lg-3 gx-3 gx-md-4" id="c-con">
            
                 <?php
                 
                   $q = mysqli_query($db, "select * from course where category_id = '1' and status = 'active' limit 3");

                  while ($data = mysqli_fetch_assoc($q)) {
            
                    $thumb = $l_url."data/thumb/" . $data['thumbnail'];
            
                    $tSec = mysqli_num_rows(mysqli_query($db, "select id from lesson where course_id = '$data[id]'"));
            
                    $c_url = $data['is_admin'];
                    $c_url = $l_url . 'course/' . $c_url;
                    if ($data['thumbnail'] == '') {
                      $thumb = $url . 'data/place/thumb.jpg';
                    }
                    
                     $time = $data['multi_instructor'];
                     
                   $enrol_student =  mysqli_num_rows(mysqli_query($db, "SELECT id FROM `enrol` where product_id = '$data[id]' and product_type = 0")) * 10;

            
                  ?>
                 
                    <div class="col pb-1 pb-lg-3 mb-4">
                      <a href="<?php echo $c_url;?>" target="_blank">
                         <article class="card h-100 border-0 shadow-sm">
                            <div class="position-relative">
                              <img src="<?php echo $thumb; ?>" style="height: 205px;" class="card-img-top lazyload blur-up" alt="Image">
                            </div>
                            <div class="d-flex pt-2 ps-3 align-items-center fs-sm">
                              <div style="color:#676767" class="d-flex align-items-center me-4">
                                Program : <i class="fa fa-time fs-xl me-1"></i>
                                <?php echo $time; ?>
                              </div>
                              <div style="color:#676767" class="d-flex align-items-center">
                                <i class="fa fa-note me-1"></i>
                                <?php echo $tSec; ?> Lectures
                              </div>
                            </div>
                        <div class="card-body pb-3">
                          <h3 class=" mb-2" style="font-size: 1rem;">
                            <?php echo $data['title']; ?>
                          </h3>
                          <br/>
                          <i class="fa-solid fa-graduation-cap"></i> Students : <?php echo $enrol_student;?>
                        </div>
                        
                      </article>
                      </a>
                    </div>
                 
                  <?php } ?>
                </div>
                                            
                                            </div>
                                            
                                            <hr class="artdeco-divider mb0 mt4">
                                            
                                            <div  style="justify-content: space-between;" class="d-flex">
                                                <div class="d-flex">
                                                    <a href="<?php echo $url;?>"  class="btnC startTest ms-2 btn btn-primary">Back to Home</a>
                                                </div>
                                            </div>
                                </div>
                                
                                <?php } else { ?>

                                <div class="m5 tabSuccess">
                                          
                                              <h1 class="heading">
                                                Yhh! Congratulations you earned a new Skill Badge & Certificate
                                              </h1>
                                              <div class="mv2 t-14">
                                                <span>
                                                  In next 1 months, you'll get the another chance to retake the assessment. In the meantime, Jobaajlearnings can help you to prepare.
                                                </span>
                                              </div>
                                              <div class="mt-5 fs-10 fw-2" style="color:grey">
                                                 <i class="fa fa-eye"></i> Private for you
                                              </div>
                                              <div class="mt-2 t-14">
                                                <span>
                                                 Your score is <?php echo $score;?>%. And you can improve more with Jobaaj Learnings
                                                </span>
                                              </div>
                                              <br/>
                                              <div class="my-4  text-center">
                                                
                                                <img class="certificate" src="<?php echo $url.'certificates/'.$certificate;?>"/>
</div>
                                                <div class="text-center">
                                                    <a href="<?php echo $url;?>/certificates/<?php echo $certificate;?>" download="Jobaajlearnings Skill Assesment Certificate" class="btnC startTest ms-2 btn btn-primary">Download Now</a>
                                                </div>
                                        
                                            <div class="mt-3 t-14">
                                             <p class="fs-4" style="color:#555">Free courses that may  help you improve</p>
                                             <span>Courses are avaible for 24 hours after you start them.</span>
                                            
                                              <div class="mt-3 row row-cols-1 row-cols-sm-2 row-cols-lg-3 gx-3 gx-md-4" id="c-con">
            
                                                 <?php
                                                 
                                                   $q = mysqli_query($db, "select * from course where category_id = '1' and status = 'active' limit 3");
                                
                                                  while ($data = mysqli_fetch_assoc($q)) {
                                            
                                                    $thumb = $l_url."data/thumb/" . $data['thumbnail'];
                                            
                                                    $tSec = mysqli_num_rows(mysqli_query($db, "select id from lesson where course_id = '$data[id]'"));
                                            
                                                    $c_url = $data['is_admin'];
                                                    $c_url = $l_url . 'course/' . $c_url;
                                                    if ($data['thumbnail'] == '') {
                                                      $thumb = $url . 'data/place/thumb.jpg';
                                                    }
                                                    
                                                     $time = $data['multi_instructor'];
                                                     
                                                   $enrol_student =  mysqli_num_rows(mysqli_query($db, "SELECT id FROM `enrol` where product_id = '$data[id]' and product_type = 0")) * 10;
                                
                                            
                                                  ?>
                 
                                                <div class="col pb-1 pb-lg-3 mb-4">
                                                  <a href="<?php echo $c_url;?>" target="_blank">
                                                     <article class="card h-100 border-0 shadow-sm">
                                                        <div class="position-relative">
                                                          <img src="<?php echo $thumb; ?>" style="height: 205px;" class="card-img-top lazyload blur-up" alt="Image">
                                                        </div>
                                                        <div class="d-flex pt-2 ps-3 align-items-center fs-sm">
                                                          <div style="color:#676767" class="d-flex align-items-center me-4">
                                                            Program : <i class="fa fa-time fs-xl me-1"></i>
                                                            <?php echo $time; ?>
                                                          </div>
                                                          <div style="color:#676767" class="d-flex align-items-center">
                                                            <i class="fa fa-note me-1"></i>
                                                            <?php echo $tSec; ?> Lectures
                                                          </div>
                                                        </div>
                                                    <div class="card-body pb-3">
                                                      <h3 class=" mb-2" style="font-size: 1rem;">
                                                        <?php echo $data['title']; ?>
                                                      </h3>
                                                      <br/>
                                                      <i class="fa-solid fa-graduation-cap"></i> Students : <?php echo $enrol_student;?>
                                                    </div>
                                                    
                                                  </article>
                                                  </a>
                                                </div>
                                             
                                              <?php } ?>
                                            </div>
                                            
                                            </div>
                                            
                                            <hr class="artdeco-divider mb0 mt4">
                                            
                                            <div  style="justify-content: space-between;" class="d-flex">
                                                <div class="d-flex">
                                                    <a href="<?php echo $url;?>"  class="btnC startTest ms-2 btn btn-primary">Back to Home</a>
                                                </div>
                                            </div>
                                </div>
                                
                                <?php } ?>
                                        
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Content Page Box Area -->

        </div>
        
        <!-- Start Go Top Area -->
        <div class="go-top">
            <i class="ri-arrow-up-line"></i>
        </div>
        <!-- End Go Top Area -->


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
    

<?php require('toast.php');?>


</html>