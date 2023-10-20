<?php 

include('../config.php');

if(!isset($_SESSION['learner_id'])) { 
    
 echo "<script>location.href='$url';</script>"; 
 exit();
}
else{
  $user = $_SESSION['learner_id'];
}


if(isset($_POST['submit_assessment'])) {
    
    $didTest = mysqli_fetch_assoc(mysqli_query($db,"select count(id) as total from testResult where test_id = '$testid' and st_id = '$user'"));
    
    // if($didTest['total'] > 0){ 
    //      echo "<script>location.href='https://combat.jobaaj.com/';</script>";
    //      exit();
    // }
        
    $testid = $_POST['submit_assessment'];
   
    $ans = implode(",",$_POST);
    
    $test = mysqli_fetch_array(mysqli_query($db,"select * from TestCat where testId = '$testid'"));
    $slug = $test['slug'];
		$right = 0;
		$wrong = 0;
		$no_ans = 0;
		
		$query=mysqli_query($db,"SELECT * from com_questions WHERE cat_id = '$testid'");
		
		while($qust=$query->fetch_array(MYSQLI_ASSOC))
		{       
				if($qust['ans'] == $_POST[$qust['id']])
					$right++;
				else if($_POST[$qust['id']] == "not_attempt")
					$no_ans++;
				else
					$wrong++;
		}
    
     $array= array();	
     $array['right'] = $right;
     $array['wrong'] = $wrong;
     $array['no_ans'] = $no_ans;
     
	$tqustion = $array['right'] + $array['wrong'] + $array['no_ans'];
  	$tattempt = $tqustion - $array['no_ans'];
  	    
  	    $accu =  ($array['right'] / $tattempt) * 100 ;

        $accu = round($accu);
        
        $score = ($array['right'] / $test['testMarks'])*100;
       
        $score = round($score,2);
        $time = time();
        
        //Add User Score in DB
        $update_test = mysqli_query($db,"INSERT INTO `testResult` (`id`, `st_id`, `answer`, `score`, `test_id`) VALUES (NULL, '$user', '$ans', '$score', '$testid');");
        $result_id = mysqli_insert_id($db);
        $rank = 1;
        
        
        
        $_SESSION['test'] = $result_id;
        
        $result = "fail";
        
        if($score > 20) {
            
            $curl = curl_init();
        
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://community.jobaajlearnings.com/fun/genereate_skill_certificate?user='.$user.'&test='.$testid,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_POSTFIELDS => array('data' => 'this is the title'),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            
            $result = "success";
        }
    
        echo "<script>location.href='../result/$result';</script>";
}



if(isset($_POST['submit_feedback'])){
    
    $date = time();
    $test = $_SESSION['test'];
    
    mysqli_query($db,"INSERT INTO `feedbacks` (`id`, `user`, `feeling`, `msg`, `test`, `feeddate`) VALUES (NULL, '$user', '$_POST[feedback]', '$_POST[msg]', '$test', '$date');");
    
    
    session_destroy();
    echo "<script>location.href='/';</script>";
}



 ?>
 
 