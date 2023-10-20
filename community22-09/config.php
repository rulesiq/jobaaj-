<?php
session_start();

date_default_timezone_set('Asia/Kolkata'); 

$search_db = array(
    "Database_Server" => "localhost",
  	"User_Id" => "jobaajstories_learnings",
	"Password" => "Tm3aJW2RifX*",
	"Database_Name" => "jobaajstories_learnings"
);

$search_db_server      = $search_db['Database_Server'];
$search_db_user        = $search_db['User_Id'];
$search_db_password    = $search_db['Password'];
$search_db_name        = $search_db['Database_Name'];

$db = new mysqli($search_db_server, $search_db_user, $search_db_password, $search_db_name);
mysqli_set_charset($db, 'utf-8');

$url = "https://community.jobaajlearnings.com/";
$l_url = "https://jobaajlearnings.com/";

if(isset($_GET['learner_id']) && !isset($_SESSION['learner_id'])){

  $_SESSION['learner_id'] = base64_decode($_GET['learner_id']);
  
  if(!isset($_GET['myPost']))
  echo "<script>location.href='https://community.jobaajlearnings.com/';</script>";
  

} else{
    
    if(isset($_SESSION['learner_id']) && isset($_GET['learner_id'])){
          if(!isset($_GET['myPost']))
           echo "<script>location.href='https://community.jobaajlearnings.com/';</script>";
    }else{
        
        // if(!isset($_GET['learner_id']) && !isset($_SESSION['learner_id'])){
        //      echo "<script>location.href='https://jobaajlearnings.com/login';</script>";
        // } 
    }
    
}

  $learner_id = $_SESSION['learner_id'];
            
  $user = mysqli_fetch_assoc(mysqli_query($db,"select * from users where id = '$learner_id'"));
  
  if($user['id']!='' && $user['metaname'] == ''){
       
    $userId = $user['id'];
    $username = strtolower(str_replace(" ","",$user['full_name']));
    $username = strtolower(str_replace("'","",$username));
   
    updateAdd($username,$userId,$db,'');
    
  }
  
  
  function notification($toU,$msg,$post,$userId){
      $added = time();
      $insert = mysqli_query($GLOBALS['db'],"INSERT INTO `com_notify` (`nid`, `msg`, `fromUser`, `toUser`, `post`, `status`, `date_added`)
      VALUES (NULL, '$msg', '$userId', '$toU', '$post', '1', '$added');");
  }
  
  function updateAdd($uname,$userId,$db,$i){
        
      $usern = $uname.$i;
      $count_check = mysqli_num_rows(mysqli_query($db,"select id from users where metaname = '$usern'"));
        
      if($count_check>0){
          $i = (int) $i+1;
          updateAdd($uname,$userId,$db,$i);
      }else{
          $updated = trim($usern);
          mysqli_query($db,"update users set metaname = '$updated' where id = '$userId'");
          return;
      }
    }
    
    


