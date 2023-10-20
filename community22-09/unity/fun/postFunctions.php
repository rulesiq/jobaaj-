<?php
require('../db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


if (isset($_POST['updatePostStatus'])) {

    $date = date('Y-m-d H:i:s');

    $st = $_POST['status'];
        
    foreach ($_POST['postIds'] as $post) {
  
        if ($st == '1') {
            //$notify = mysqli_query($db, "INSERT INTO `job_notifications` (`id`, `sender_id`, `owner_id`, `product_id`, `type`, `message`, `created_at`,`status`) VALUES (NULL, '0', '$job[user_id]', '$val', 'approve', '', '$date','1');");
        } 
    
        $done = mysqli_query($db, "update com_posts set status = '$st' WHERE `p_id` = '$post'");

    }

    echo 1;
}


if (isset($_POST['delPosts'])) {

    $st = $_POST['status'];
        
    foreach ($_POST['postIds'] as $post) {
  
        $done = mysqli_query($db, "delete from com_posts  WHERE `p_id` = '$post'");
    }

    echo 1;
}

if (isset($_POST['statusUpdate'])) {

    $st = $_POST['status'];
    $post = $_POST['post'];
        
    $done = mysqli_query($db, "update com_posts set status = '$st' WHERE `p_id` = '$post'");
    if($done)
    echo 1;
    else
    echo 0;
}

