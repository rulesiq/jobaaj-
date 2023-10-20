<?php
require('../db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


if(isset($_POST['addSection'])){
    
    $add = mysqli_query($db,"INSERT INTO `section` (`id`, `title`, `course_id`, `order`) VALUES (NULL, '$_POST[addSection]', '$_POST[c_id]', '0');");
    
    if($add) {
        echo 1;
    }
    else  { echo 0; }
    
}


