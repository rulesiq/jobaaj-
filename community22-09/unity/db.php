<?php
@session_start();

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
mysqli_set_charset($db, 'utf8');
$url = "https://www.jobaajlearnings.com/";


 function notification($toU,$msg,$post,$userId){
      $added = time();
      $insert = mysqli_query($GLOBALS['db'],"INSERT INTO `com_notify` (`nid`, `msg`, `fromUser`, `toUser`, `post`, `status`, `date_added`)
      VALUES (NULL, '$msg', '$userId', '$toU', '$post', '1', '$added');");
  }
  
  

