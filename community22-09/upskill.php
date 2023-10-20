<?php 
    
    require('pin/head.php');
    require('pin/left_side.php');
    require('pin/right_side.php');
    
if(isset($_GET['test'])){
    
   if(!isset($_SESSION['learner_id'])) 
     echo "<script>location.href='$url';</script>"; 
 
    $user = $_SESSION['learner_id'];
    
    $userCount = mysqli_num_rows(mysqli_query($db,"select id from users where id = '$user'"));

    if($userCount == 0)
      echo "<script>location.href='$url';</script>";
    
    $test = mysqli_fetch_assoc(mysqli_query($db,"select * from TestCat where slug = '$_GET[test]'"));
    
    $didTest = mysqli_fetch_assoc(mysqli_query($db,"
    
    select count(id) as total from testResult where test_id = '$test[testId]' and st_id = '$user' and CURRENT_DATE < DATE(testDate) + INTERVAL 30 Day"));
    
    if($didTest['total'] > 0)
     echo "<script>location.href='$url';</script>";
    
    }else{
         echo "<script>location.href='$url';</script>"; 
    }

?>

<link rel="stylesheet" type="text/css" href="<?php echo $url;?>question.css" />

<script>
     
  function timeout()
  {
    var min = Math.floor(timeLeft/60);
    var sec = timeLeft%60;
    var Csec = checkTime(sec);
    var Cmin = checkTime(min);
    color(timeLeft);
    if(timeLeft<=0)
    {
        document.getElementById("TestBookForm").submit();
    }
    else
    {
      if(min < 10)
      {
        min = "0"+min;
      }
      document.getElementById("min").innerHTML=Cmin;
      document.getElementById("sec").innerHTML=Csec;
    }
    timeLeft--;
    
    var tm = setTimeout(function(){timeout()},1000); 
  }
  
  function color(msg)
  {
    if(msg<=30)
    {
      $("#time").css('color','red');
    }
    return msg;
  }
  
  function checkTime(msg)
  {
    if(msg < 10)
    {
      msg = "0"+msg;
    }
    return msg;

  }
  
</script>

<script> var timeLeft = <?php echo $test['testTime'];?>*60; </script> 

<style>

.topics .d-flex i  {
    margin-right:8px;
     text-align:left;
}
.topics .d-flex   {
    margin-bottom:6px;
}
#progress {
        width: 100%;
        position:relative;
    border-radius: 0px;
    height: 5px;
    
}

progress::-moz-progress-bar { background: #6399e9; }
progress::-webkit-progress-value { background: #6399e9; }
progress { color: #6399e9; }


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
        
                            
                            
                            <div class="d-flex py-2" style="justify-content: space-between;align-items: center;">
                                
                                <h2><?php echo $test['title'];?></h2>
                                <div class="data">Remaining&nbsp;&nbsp;&nbsp; 
                                    <span id="min">00</span>&nbsp;:&nbsp;<span id="sec">00</span>
                                </div>
                                
                            </div>


                            <div class="mainBox p-5" style="background-color:#fff;border-radius:.3rem;">
                                
                             <div class="tabMain">
                                     
                                <div class="m5 tab0">
                                       <div class="display-flex flex-column pt3">
                                            <div>
                                            <div class="ivm-image-view-model  mb2 ">
                                                
                                            <div class="ivm-view-attr__img-wrapper display-flex">
                                              <img width="48" src="https://media.licdn.com/media/AAYQAQSZAAgAAQAAAAAAABYQDnbtgNYvTNG8bYmJfDY3AQ.png" loading="lazy" height="48" alt="Skill assessment logo." id="ember838" class="ivm-view-attr__img--centered ivm-view-attr__img   evi-image lazy-image ember-view">
                                            </div>
                                          
                                      </div>
                                          
                                              <h1 class="heading">
                                                <?php echo $test['title'];?>
                                              </h1>
                                              <div class="mv2 t-14">
                                                <span>
                                                  Topics: Browser Management, CSS Styles and Layout, Frameworks, HTML Fundamentals, JavaScript Coding
                                                </span>
                                              </div>
                                              <div class="mt-2 fs-10">
                                                    1.2M people took this
                                              </div>
                                              <br/>
                                            </div>
                                        
                                            <div class="mt2 topics" style="font-size:.8rem">
                                        
                                                <span class="d-flex">
                                                  <i class="fa-regular fa-clock"></i> <span>15 multiple choice questions</span>
                                                </span>
                                               
                                                <span class="d-flex">
                                                 &nbsp;<i class="fa-solid fa-question"></i> <span> 1.5 minutes per question</span>
                                                </span>
                                                <span class="d-flex">
                                                 <i class="fa-regular fa-star"></i> <span>Score in the top&nbsp;<span class="t-bold">65% &nbsp;to earn a badge</span>
                                                </span>
                                              </div>
                                        
                                            <hr class="artdeco-divider mb0 mt4">
                                        
                                            <h5  class="mt-4 mb2 t-18 t-bold">
                                              Before you start
                                            </h5>
                                            <ul class="details-points">
                                              <li class="mv2">If you didn't pass the Test! you'll get the another chance to retake the assessment in next 1 month</li>
                                              <li class="mv2">You must complete this assessment in one session — make sure your internet is reliable.</li>
                                              <li class="mv2"><span class="t-bold">You can retake this assessment once</span> if you don’t earn a badge.</li>
                                              <li class="mv2">We won’t show your results to anyone without your permission.</li>
                                            </ul>
                                            <br/>
                                          </div>
                                        <hr/>
                                        <div  style="justify-content: space-between;" class="d-flex">
                                            <h6>Language : English</h6>
                                            <div class="d-flex">
                                                <button class="btnC btn btn-danger">Learn now</button>
                                                
                                                <button type="button" class="btnC startTest ms-2 btn btn-primary">Start test</button>
                                            </div>
                                        </div>
                                        </div>
                                
                                <div class="m5 hidden tabFail">
                                        
                                          
                                              <h1 class="heading">
                                                Unfortunately, you didn't pass the test.
                                              </h1>
                                              <div class="mv2 t-14">
                                                <span>
                                                  In next 3 months, you'll get the another chance to retake the assessment. In the meantime, Jobaajlearnings can help you to prepare.
                                                </span>
                                              </div>
                                              <div class="mt-2 fs-10">
                                                 <i class="fa fa-eye"></i>  Private for you
                                              </div>
                                              <div class="mv2 t-14">
                                                <span>
                                                 Your score is 40%. Score above 75% can earn a certificate.
                                                </span>
                                              </div>
                                              <br/>
                                        
                                            <div class="mt2 t-14">
                                             
                                             <h4>Free courses that may  help you improve</h4>
                                             <span>Courses are avaible for 24 hours after you start them.</span>
                                            </div>
                                            
                                        
                                            <hr class="artdeco-divider mb0 mt4">
                                            
                                            
                                            
                                        <div  style="justify-content: space-between;" class="d-flex">
                                            <div class="d-flex">
                                                <button type="button" class="btnC startTest ms-2 btn btn-primary">Back to Home</button>
                                            </div>
                                        </div>
                                </div>
                                        
                                <form id="TestBookForm" name="formSubmit" action="<?php echo $url;?>/fun/testFunctions.php" method="post">
                                
                                <input type="hidden" value="<?php echo  $test['testId']; ?>" name="submit_assessment"/>
                                
                                <?php 
                                  
                                $fetch_questions = mysqli_query($db,"SELECT * FROM com_questions where cat_id = '$test[testId]' and status = '1'");
                                $totalQ = mysqli_num_rows($fetch_questions);
                                
                                
                                 $i = 1; while($row = mysqli_fetch_array($fetch_questions)){ ?>
                                 
                                 <div class="tab<?php echo $i;?> hidden ccc question_box">
                                     
                                 	<div id="question_div">
                                 		<p class="question_title">
                                      <?php echo $row['qustion']; if($row['qImg'] != '0' && $row['qImg'] != '') { ?>
                                      <img src="web-admin/content/qimg/<?php echo $row['qImg'];?>" style="height:300px";/>
                                      <?php } ?>
                                 	</p>
                                 	<ol style="margin-left: -30px;">
                                 	    
                                    <?php for($k=0;$k<=3;$k++) { ?>
                                
                                        <?php if(isset($row['o'.($k+1)])) { ?>
                                 		<li>
                                 		     <label><input class="ans" value="<?php echo $k; ?>"  name="<?php echo $row['id']; ?>" type="radio" id="checkbox_<?php echo $i.'_'.$k; ?>" data-qid="<?php echo $i; ?>">
                                             <?php echo $row['o'.($k+1)]; ?></label> 
                                 		</li>
                                 	
                                    <?php } ?>
                                
                                      <?php  } ?>
                                      
                                      
                                 	</ol>
                                 	<input type="radio" value="not_attempt" checked="checked" style="display:none" name="<?php echo $row['id']; ?>">
                                
                                 	</div>
                                 </div>
                                 <?php $i++; }  ?>
                                 
                                 


                                </form>


                                <div class="d-flex " style="flex-direction: row-reverse;">
                                    <button type="button" disabled class="btnC hidden next ms-2 btn btn-primary">Next</button>
                                </div>
                    
                                <input type="hidden" class="currentTab" value="1">
                                
                                </div>
                                        
                            </div>
                            
                        </div>
                       <progress  id="progress" value="0" max="100"> </progress>

                    </div>

     
                </div>
            </div>
            <!-- End Content Page Box Area -->
           <input type="hidden" id="totalQuestion" value="<?php echo $totalQ; ?>">




        </div>
        
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
    

<script type="text/javascript">
var warnings = 0;

var curTab = 0;

  $(document).ready(function() {
      
    $("input[class='ruleCheck']").on('change', function() {
        
            var i =0 ;
            $(".ruleCheck:checkbox:checked").each(function() {
                i++
            });
            
            if(i==5){
                $(".next").removeAttr('disabled');
            }else{
                $(".next").attr('disabled','disabled');
            }
    });
    
       
 $(".submitTest").click(function (){
    
    $("#myModal").show();

  });

  $(".yesBtn").click(function (){

        $("#TestBookForm").submit();
  });

  $(".noBtn").click(function (){

    $("#myModal").fadeToggle();

  });
  
  var totalQuestions = $('#totalQuestion').val();
  var nextCount = 100 / totalQuestions;
  var currentCount = nextCount;


  
  $(".startTest").click(function (){
         
         
          $(".tab0").addClass('hidden');
          $(".next").removeClass('hidden');
            
        var currentTab = $('.currentTab').val();
        var nextTab = parseInt(currentTab) + 1;
        
        $(".finalBtn").removeClass('hidden');
        curTab = currentTab;
        $(".tab"+currentTab).removeClass('hidden');
          $(".tab00").addClass('hidden');
        $(this).html('Submit');
        timeout();
        $('.qBox').removeClass('hidden');
        
  });
  

  $('.qb1').addClass('currentQues');

  console.log('Current Tab : ' + curTab);
  
  $(`input[class='ans']`).on('change', function() {
      $(".next").removeAttr('disabled');
  });   

  
  $(".next").click(function (){
      
        var totalQ = $('#totalQuestion').val();
        
        var btn = $(this).html();
        
        var currentTab = $('.currentTab').val();
        var nextTab = parseInt(currentTab) + 1;
    
        if(totalQ == currentTab){
             
              $("#TestBookForm").submit();
              return;
        }
   
       $(".next").attr('disabled','disabled');
    
      if($(".tab"+currentTab+" input[class='ans']").is(':checked')) {
        
    
        $("#progress").val(currentCount);
        
        currentCount = currentCount + nextCount;

         $(".tab"+nextTab).removeClass('hidden');
                  $(".tab"+currentTab).addClass('hidden');
                  $(".currentTab").val(nextTab);
                  
                  globalTab = nextTab;
        
                  $(".tab"+nextTab).removeClass('hidden');
                  $(".tab"+currentTab).addClass('hidden');
        
        
                  $(".qb"+currentTab).removeClass('currentQues');
                  
                  
          $(".qb"+currentTab).addClass('answered');

          $("#aH").val(parseInt(aH)+1);
          $("#ans").html(parseInt(aH)+1);
           
          $(".qb"+nextTab).addClass('currentQues');
      $("#vH").val(parseInt(vH) - 1);
      $("#notvisit").html(parseInt(vH) - 1);
      

    }

        
  });

});

   
</script>

<?php require('toast.php');?>


</html>