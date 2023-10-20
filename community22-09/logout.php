
<?php
require 'config.php';
session_start();
unset($_COOKIE['jobaaj_user']);

setcookie('learner_id', '', time() - 7200, "");
setcookie('jobaaj_user', '', time() - 7200, "");

unset($_SESSION['learner_id']);
session_destroy();
echo "<script>location.href='/';</script>";
// //header('location:/');


?>

