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
mysqli_set_charset($db, 'utf-8');
$url = "https://www.jobaajlearnings.com/";




if (!isset($_SESSION['learner_id']) || isset($_COOKIE['jobaaj_user'])) {

  $id = $_COOKIE['jobaaj_user'];
  $row = mysqli_fetch_array(mysqli_query($db, "select id from users where id = '$id'"));

  $_SESSION['learner_id'] = $row['id'];
} else {

  if (isset($_SESSION['learner_id']) and !isset($_COOKIE['jobaaj_user'])) {
    $val = $_SESSION['learner_id'];
    setcookie('jobaaj_user', $val, time() + 432000,"/");
  }
}

if (isset($_GET['redirecting'])) {

  $learner_id = base64_decode($_GET['redirecting']);

  $_SESSION['learner_id'] = $learner_id;

  $login = true;
}


$login = false;
$user = "";


if (isset($_SESSION['learner_id'])) {
  $login = true;
  $user = $_SESSION['learner_id'];
} else {

  if (!isset($_COOKIE['learner_id'])) {
    setcookie('learner_id', uniqid(), time() + (86400 * 300), "/"); // 86400 = 1 day
    $user = $_COOKIE['learner_id'];
  } else {
    $user = $_COOKIE['learner_id'];
  }
}
