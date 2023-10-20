<?php
session_start();

include '../db.php';

if(isset($_POST['username']) && isset($_POST['password'])) {
    
$uname = mysqli_real_escape_string($db, $_POST['username']);
$password = mysqli_real_escape_string($db, $_POST['password']);
    
    
    $select = mysqli_query($db,"select * from authors where user = '$uname' ");
  
   $d = array();
   
    if(mysqli_num_rows($select) > 0) {
        
        $user = mysqli_fetch_assoc($select);
        
        $password_user = $user['secure'];
        if (base64_encode(sha1($password, true)) != $password_user) {
       
        
            if($user['status']==1) {
               
                $_SESSION['user'] = $user['id'];
                $_SESSION['user_role'] = $user['role_id'];
                
                 $d[0] = 201;
                 $d[1] = $user['role_id'];
                
            }else{
                 $d[0] = 400;
                 $d[1] = $user['role_id'];
            }

        }else{
             $d[0] = 404;
             $d[1] = $user['role_id'];
        }
        
       echo json_encode($d);
    
        
    }else{
        $d[0] = 404;
        $d[1] = $user['role_id'];
        
     echo json_encode($d);
        
    }


}

else if(isset($_POST['addUser'])){
    
    $password = base64_encode(sha1($_POST['secure'], true));
    $date = time();
    
        $done = mysqli_query($db,"INSERT INTO `authors` (`id`, `user`, `name`, `secure`, `date_added`, `role_id`, `status`)
        VALUES (NULL, '$_POST[email]', '$_POST[name]', '$password', '$date', '$_POST[role]', '1')");
        
        echo "<script>location.href='../allUsers';</script>";
}
