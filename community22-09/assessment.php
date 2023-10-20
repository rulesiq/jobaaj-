<!DOCTYPE html>
<?php 

require('config.php');

if(isset($_GET['testId'])){
    
     if(!isset($_SESSION['user'])) 
     echo "<script>location.href='https://combat.jobaaj.com/';</script>"; 
 
    $user = $_SESSION['user'];
    
    if($user != '00') {
        
    $userCount = mysqli_num_rows(mysqli_query($db,"select id from users where id = '$user'"));

    if($userCount == 0)
      echo "<script>location.href='https://combat.jobaaj.com/';</script>";
    
    }
    
    $test = mysqli_fetch_assoc(mysqli_query($db,"select * from TestCat where slug = '$_GET[testId]'"));
    $didTest = mysqli_fetch_assoc(mysqli_query($db,"select count(id) as total from testResult where test_id = '$test[testId]' and st_id = '$user' "));
    
    if($didTest['total'] > 0)
     echo "<script>location.href='https://combat.jobaaj.com/';</script>";
    
}else{
     echo "<script>location.href='https://combat.jobaaj.com/';</script>"; 
}


?>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Prepration</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta name="description"  content="Jobaaj Combet for Fight with each other"/>
<!--<meta name="MobileOptimized" content="320" />-->

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<!-- favicon links -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">

<link rel="shortcut icon" type="image/png" href="images/header/favicon.png" />
<link rel="stylesheet" type="text/css" href="<?php echo $url;?>question.css" />


<script type="text/javascript">

<?php


$pack = mysqli_fetch_array(mysqli_query($db,"select * from packDetails where id = '$test[pack_id]'"));

?>
  
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,700;1,300&display=swap" rel="stylesheet">


<style>

.instruction {
    display:block;
}
.question_div{
    height: 45px;margin: 0px 30px;border-bottom: 1px solid #e5e5e5;
}
.question_title {
        font-family: sans-serif;
    padding-left:10px;font-size: 18px;word-spacing:2px;line-height: 35px;color: #222;padding-top: 20px
}

.question_box {
    height: 600px;padding-top:20px;
}
@media only screen and (max-width: 980px) {  
.footer {
    width:100%;
}
.question_title {
    padding-top: 5px;
    padding-left:0px;
}

.question_box {
    height: auto;
}

.instruction {
    display:none;
}
.data {
    width: 164px;
    font-size:.8rem;
}
 
 .headder img {
     margin-left:0px;
 }   
 
 .tab00 {
     padding:0px;
 }
 .tab0 ol{
     margin-left:-2.5rem;
 }
 .question_div{
    height: 45px;margin: 0px 0px;border-bottom: 1px solid #e5e5e5;
}

.modal-dialog {
    left: 10%;
    top: 25%;
}

}



.modal-footer {
    -ms-flex-align: center;
    align-items: center;
    justify-content: center;
    
}
#progress {
	position: fixed;
	z-index: 1;
	top: 0;
	left: -6px;
	width: 1%;
	height: 3px;
    background-color: #2196f3;
  -moz-border-radius: 1px;
	-webkit-border-radius: 1px;
	border-radius: 1px;
  -moz-transition: width 600ms ease-out,opacity 500ms linear;
	-ms-transition: width 600ms ease-out,opacity 500ms linear;
	-o-transition: width 600ms ease-out,opacity 500ms linear;
	-webkit-transition: width 600ms ease-out,opacity 500ms linear;
	transition: width 1000ms ease-out,opacity 500ms linear;
  
  b, i {
    position: absolute;
    top: 0;
    height: 3px;
    
    -moz-box-shadow: #777777 1px 0 6px 1px;
    -ms-box-shadow: #777777 1px 0 6px 1px;
    -webkit-box-shadow: #777777 1px 0 6px 1px;
    box-shadow: #777777 1px 0 6px 1px;
    -moz-border-radius: 100%;
    -webkit-border-radius: 100%;
    border-radius: 100%;
  }

  b {
    clip: rect(-6px, 22px, 14px, 10px);
    opacity: .6;
    width: 20px;
    right: 0;
  }
  
  i {
    clip: rect(-6px, 90px, 14px, -6px);
  	opacity: .6;
    width: 180px;
    right: -80px;
  }    
}


html, body {
  height: 100%;
  margin: 0;
  
}

.stopTestScreen {
    z-index:11111;
    
    overflow: hidden;
    position:fixed;
  height: 100%;
  display:none;
  width:100%;
  background: #000000de;
      /*display: flex;*/
    align-items: center;
    justify-content: center;
}
</style>

<!--srart theme style -->
<!-- end theme style -->

<!--Full Screen Div-->

<div class="stopTestScreen">
        <!--<button class="btn btn-success" id="backToTest">Back to Test</button>-->
</div>



</head>

<body>

<div class="container" style="width: 100%;">

	<div class="row headder" style="display:flex;justify-content:space-around">
        <div class=""><img src="https://www.jobaaj.com//assets/svg/logos/jobaaj.png"/></div>


        <div class="" style="padding-top:10px;"><div class="data">Remaining&nbsp;&nbsp;&nbsp; <span id="min">00</span>&nbsp;:&nbsp;<span id="sec">00</span></div></div>
        <div class="">
		<div class="finalBtn hidden" style="padding-top:10px;">
            <div class="row">
              <div class="col-sm-6"><button type="button" class="btn btn-success instruction" style="    font-size: 1rem;
    font-weight: 500;background: #2196f3;border:none;
    height: 35px;">Rules</button></div>
              <div  class="col-sm-6"><button type="button" style="    font-size: 1rem;
    font-weight: 500;background: #494949;border:none;
    height: 35px;" class="btn btn-danger submitTest">Finish</button></div>
              <!--<div class="col-sm-12"><button type="button"  class="btn btn-primary submitTest">Submit Test</button></div>-->
            </div>
         </div>
</div>
         
	</div>
	<div class="row">


<div class="col-12 col-sm-9 tabMain">

<?php include('rules.php'); ?>

<form id="TestBookForm" name="formSubmit" action="<?php echo $url;?>/functions" method="post">
    
<input type="hidden" value="<?php echo  $test['testId']; ?>" name="submit_assessment"/>

<?php 
  
$fetch_questions = mysqli_query($db,"SELECT * FROM questions where cat_id = '$test[testId]' and status = '1'");
$totalQ = mysqli_num_rows($fetch_questions);

 $i = 1; while($row = mysqli_fetch_array($fetch_questions)){ ?>
 
 <div class="tab<?php echo $i;?> hidden ccc question_box">
     
 	<div style="question_div">
 		<p style="font-weight: 700;font-size: 17px;margin-top:10px">Question no. <?php echo $i; ?></p>
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
             &nbsp;&nbsp;<?php echo $row['o'.($k+1)]; ?></label> 
 		</li>
 	
    <?php } ?>

      <?php  } ?>
      
      <li>&nbsp;</li>
      <li>&nbsp;</li>
 	</ol>
 	<input type="radio" value="not_attempt" checked="checked" style="display:none" name="<?php echo $row['id']; ?>">

 	</div>
 </div>
 <?php $i++; }  ?>
 
</form>

<input type="hidden" class="currentTab" value="1">

<style type="text/css">
  .container {
    max-width:100% !important;
  }
* {
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: -moz-none;
    -o-user-select: none;
    user-select: none;
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
  
</style>
</div> <!-- End fo Main Tab -->
 
	<div class="col-sm-3" style="padding: 10px 0px;">
		<div class="qBox hidden">
        <div class="check" style="margin-top: 20px;margin-bottom: 10px;display:flex;    justify-content: space-around;">
          <div>
           <span class="ansTypeText">Completed</span><br>
           <div class="ansTypeBox"><span class="ans-mock answered"  title="Answered"></span> <span class="valueAns"  id="ans">0</span></div>
           </div>
<div>
           <span class="ansTypeText">Not Answered</span><br>
           <div class="ansTypeBox"><span class="ans-mock"   title="Not Visited"></span><span class="valueAns" id="notvisit"><?php echo $totalQ; ?></span></div>
         </div>
        <div>   
            <span class="ansTypeText">Current </span><br>
           <div class="ansTypeBox"><span class="ans-mock marked review"  title="Answered &amp; Marked"></span> </div>
           </div>

           
           <input type="hidden" id="aH" value="0">
           <input type="hidden" id="totalQuestion" value="<?php echo $totalQ; ?>">
           <input type="hidden" id="mH" value="0">
           <input type="hidden" id="vH" value="<?php echo $totalQ; ?>">
           <input type="hidden" id="amH" value="0">
           <input type="hidden" id="naH" value="0">
        </div>


				<div class="secAns"><b><?php echo $totalQ;?></b> Questions </div>
				<div class="qList" style="padding-bottom:20px;padding-left:24px;
    overflow:auto;height: 530px;">
				<?php $i = 1; while ($i<=$totalQ) {?>
					 <span class="ans-mock sideQues qb<?php echo $i;?>" id="<?php echo $i;?>"  title="Not Visited"><?php echo $i;?></span>
				<?php $i++;  } ?>
				</div>

			<br>
		</div>
	</div>
  </div>	

<div class="footer" style="z-index: 1111;">
	<!--<button  type="button" class="btn btn-success previous hidden">Previous</button>-->
	<!--<button  type="button" class="btn btn-danger clear hidden">Clear</button>-->
	<button type="button"  class="btn btn-primary next" style="    display: block;
    margin: 0 auto;">Next</button>
</div>
</div>


<!-- The Modal -->
<div class="modal" id="myModal" style="padding-top: 15%;">
  <div class="modal-dialog" style="width:20rem;">
    <div class="modal-content" style="border:none;">

      <!-- Modal Header -->
      <div class="modal-header" style="border-bottom: 0px;text-align: center;">
        <h4 class="modal-title" style="font-size: 1.4rem;margin: auto;"> Are you sure, you want to finish the quiz!</h4>

      </div>

      <!-- Modal body -->
     <!--  <div class="modal-body">
        Modal body..
      </div> -->

      <!-- Modal footer -->
      <div class="modal-footer" style="border-top: 0px;">
        <button type="button" class="btn btn-danger noBtn"  style=" background-color: #00934f !important;border-color: #00934f; " data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger yesBtn"  style=" background-color: #333 !important; border-color: #333;" data-dismiss="modal">Finish</button>
      </div>

    </div>
  </div>
</div>

<div class="modal modalSecond" id="myModal2" style="padding-top: 10%;">
  <div class="modal-dialog" style="width:30rem;">
    <div class="modal-content" style="border:none;">

      <!-- Modal Header -->
      <div class="modal-header" style="text-align:center;">   <h4 class="modal-title" style="display:flex;font-weight:600;">
          <img style="width: 2.2rem;" src="<?php echo $url;?>/assets/warning.png"/>
          &nbsp;Caution !</h4><br>
        <p style="font-weight:600;color:#f44336;line-height: 2rem;">Warning -  <span class="countWarning">1</span></p>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       	<p style="font-size:.9rem;">
       	    We noticed that you moved out of the test window.
       	    You may be penalized by the hiring team if you do so again.<br>
       	    
       	    We recommend that you remain in the test window until after you submit your test.<br>
       	    <br>
       	    <span style="color:#ff0000;font-size:1rem;">Otherwise test will be Terminated!</span>
       	    
       	    
       	</p>
      </div> 

      <!-- Modal footer -->
      <div class="modal-footer" style="display:block;">
        <button type="button" style="float:right;width:10rem" id="backToTest" class="btn btn-primary" data-dismiss="modal">Continue Quiz</button>
      </div>

    </div>
  </div>
</div>


<script type="text/javascript">
var warnings = 0;

// window.addEventListener('resize', (evt) => { 
//     if (window.innerHeight == screen.height) {
//         //alert('FULL SCREEN');
//     } else {
        
//         $(".stopTestScreen").css('display','flex');
//          $("#myModal2").show();
//          warnings = (parseInt(warnings) + parseInt(1));
         
//         let war = Math.round(warnings);
//         if(war>=5)
//           document.getElementById("TestBookForm").submit();
        
        
//         $(".countWarning").html(war);
        
//     }
// });


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
    
    // $(".clear").click(function(){
     
    //  var currentTab = $('.currentTab').val();

    //   if($(".tab"+currentTab+" input[class='ans']").is(':checked')) {
          
    //      $(".tab"+currentTab+" input[class='ans']:checked").prop('checked', false);
    //                  $(".clear").addClass('hidden');
    //   }
             

    // });



 
    
 $(".submitTest").click(function (){
    
    $("#myModal").show();

  });

  $(".yesBtn").click(function (){

        $("#TestBookForm").submit();
  });

  $(".noBtn").click(function (){

    $("#myModal").fadeToggle();

  });

  $('.qb1').addClass('currentQues');

  $('.qPaper').click(function (){
    
    if($('.tab0').hasClass('hidden'))
    {
         $(this).css("background-color","#435072");
         $(".ccc").addClass('hidden');
         $(this).html('Close Ques Paper');
         $(".tab0").removeClass('hidden');
    }
    else
    {
      $(this).css('background-color','#909dbe');
        $(".tab0").addClass('hidden');
                 $(this).html('QUESTION PAPER');
          var currentTab = $('.currentTab').val();
        $(".tab"+currentTab).removeClass('hidden');
    }
    
  });

  $('.instruction').click(function (){
    if($('.tab00').hasClass('hidden'))
    {
         $(this).css("background-color","#435072");
         $(".ccc").addClass('hidden');
         //$(this).html('Close Inst.');
         $(".tab00").removeClass('hidden');
    }
    else
    {

      $(this).css('background-color','#2196f3');
        $(".tab00").addClass('hidden');
        // $(this).html('INSTRUCTIONS');

      var currentTab = $('.currentTab').val();
        $(".tab"+currentTab).removeClass('hidden');

    }
  });
  
  $(".sideQues").click(function(){
      
     var currentTab = $('.currentTab').val();
     var selTab =  $(this).attr('id');
     
     if(selTab == currentTab){
         return;
     }
            
          $(".tab"+selTab).removeClass('hidden');
          $(".tab"+currentTab).addClass('hidden');
          
          $('.sideQues').removeClass('currentQues');
          $(this).addClass('currentQues');

          $(".currentTab").val(selTab);
          globalTab = selTab;
          
          

  });
  
 

  
  
  console.log('Current Tab : ' + curTab);
  
//   if($(".tab"+curTab+" input[class='ans']").is(':checked')) {
//       alert('check')
//   }
  
  $(`input[class='ans']`).on('change', function() {
      
      $(".next").removeAttr('disabled');
      
  });   

  
  $("#backToTest").click(function(){
      
     document.documentElement.requestFullscreen().catch(console.log);
      $(".stopTestScreen").hide();
      $("#myModal2").hide();
  });
    
  $(".next").click(function (){
      
        var totalQ = $('#totalQuestion').val();

        var aH = $('#aH').val();
        var mH = $('#mH').val();
        var naH = $('#naH').val();
        var vH = $('#vH').val();

        var btn = $(this).html();
        var currentTab = $('.currentTab').val();
        var nextTab = parseInt(currentTab) + 1;

    
        if(totalQ == currentTab){
             $("#myModal").show();
             return;
        }
      if(btn == "Next"){

        $(".tab00").removeClass('hidden');
        $(".tab0").addClass('hidden');
         
        $(this).attr('disabled','disabled');
        $(this).html('Start Quiz');

      }
      else if (btn == "Start Quiz")
      {
          $(".next").attr('disabled','disabled');
          
        //document.documentElement.requestFullscreen().catch(console.log);
        $(".finalBtn").removeClass('hidden');
        curTab = currentTab;
        $(".tab"+currentTab).removeClass('hidden');
          $(".tab00").addClass('hidden');
        $(this).html('Submit');
        timeout();
        $('.qBox').removeClass('hidden');

      }
      else if(btn == "Submit") {
          
          $(".next").attr('disabled','disabled');
        
          if($(".tab"+currentTab+" input[class='ans']").is(':checked')) {

             if ($("#progress").length === 0) {
                // inject the bar..
                $("body").append($("<div><b></b><i></i></div>").attr("id", "progress"));
                
                // animate the progress..
                $("#progress").width("101%").delay(800).fadeOut(1000, function() {
                  // ..then remove it.
                  $(this).remove();
                });  
              }
              

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
        else
        {
            return false;
            //   $(".qb"+currentTab).addClass('not-answered');
            //   $("#naH").val(parseInt(naH)+1);
            //   $("#notans").html(parseInt(naH)+1);
        }

          
      }
        
  });

//   $(".previous").click(function (){
        
//         var mH = $('#mH').val();
//         var vH = $('#vH').val();
//       var amH = $('#amH').val();


//       var btn = $(this).html();
//         var currentTab = $('.currentTab').val();
//         var nextTab = parseInt(currentTab) + 1;

//         if(btn == "Previous")
//         {
//           $(".tab00").addClass('hidden');
//           $(".tab0").removeClass('hidden');
//           $(".previous").addClass('hidden');
//         }
//         else if(btn == "mark for review &amp; next"){
      
//         $(".tab"+nextTab).removeClass('hidden');
//           $(".tab"+currentTab).addClass('hidden');
//           $(".currentTab").val(nextTab);
//           globalTab = nextTab;

//           $(".qb"+currentTab).removeClass('currentQues');
//           $(".qb"+nextTab).addClass('currentQues');


//             $(".qb"+currentTab).removeClass('currentQues');

//           if($(".tab"+currentTab+" input[class='ans']").is(':checked')) {
//             var ans = $("input[name='ans']:checked").val();
//               $(".qb"+currentTab).addClass('review');

//               $("#amH").val(parseInt(amH)+1);
//               $("#ansmark").html(parseInt(amH)+1);


//         }
//         else
//         {
//             $(".qb"+currentTab).addClass('marked');
           
//              $("#mH").val(parseInt(mH)+1);
//               $("#mark").html(parseInt(mH)+1);
//         }

//           $(".qb"+nextTab).addClass('currentQues');
//           $("#vH").val(parseInt(vH) - 1);
//           $("#notvisit").html(parseInt(vH) - 1);




//       }
       
//   });

});
/*
   
    
$(document).ready(function(){
   


$(document).bind("contextmenu",function(e) {
 e.preventDefault();
});

$(document).keydown(function(e){
    if(e.which === 123){
       return false;
    }
});


document.onkeydown = function(e) {
if(event.keyCode == 123) {
return false;
}
if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'H'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'A'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'F'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'E'.charCodeAt(0)){
return false;
}
}



 //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });

    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });

 
});

*/


/*Add Proctoring Basic*/


    
   
   
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>


<!--main js file end-->
</body>
</html>