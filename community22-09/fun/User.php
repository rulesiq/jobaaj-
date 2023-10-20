<?php

require '../config.php';
$userId = $user['id'];


if (isset($_POST['login'])) {

    $uname = mysqli_real_escape_string($db, $_POST['login']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $email = str_replace("c", "\c", $uname);

    $login_query = mysqli_query($db, "select id,email,password,status from users where email = '$email'");
    
     if (mysqli_num_rows($login_query) == 1) {
        
        $data = mysqli_fetch_array($login_query);

        $user_pass = $data['password'];

        if (sha1($password) == $user_pass || base64_encode(sha1($password, true)) == $user_pass) {

            $status = $data['status'];

            if ($status == 1) {
                $_SESSION['learner_id'] = $data['id'];
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}



if (isset($_FILES['avatar']['name'])) {


    $pro = $_FILES['avatar']['name'];
    $proU = $url . $_FILES['avatar']['name'];

    $proPath = $_FILES['avatar']['tmp_name'];

    $pro = time() . "pro-" . $user . ".png";

    move_uploaded_file($proPath, "../../jobaajlearnings.com/data/pro/" . $pro);
    $q = mysqli_query($db, "update users set image = '$pro' where id ='$userId'");
    if ($q) {
        echo 1;
    } else {
        echo mysqli_error($db);
    }
}



if (isset($_POST['updateProfile'])) {
  
  $fname = mysqli_real_escape_string($db,$_POST['fname']);
  $bio = mysqli_real_escape_string($db,$_POST['bio']);
  $gen = mysqli_real_escape_string($db,$_POST['gender']);
  $contact = mysqli_real_escape_string($db,$_POST['mobile']);
  $uname = mysqli_real_escape_string($db,$_POST['uname']);
  $city = mysqli_real_escape_string($db,$_POST['city']);
  
  $count = mysqli_num_rows(mysqli_query($db,"select u_id from users_details where u_id = '$userId'"));

  if($count > 0)
  $social = mysqli_query($db,"update users_details set city = '$city' where u_id  = '$userId'"); 
  else 
  $social = mysqli_query($db,"INSERT INTO `users_details` (`u_id`, `city`) VALUES ('$userId', '$city')");
 
  $update  = mysqli_query($db,"update users set full_name = '$fname', metaname = '$uname', contact = '$contact',
                                        biography = '$bio', gender = '$gen'
                                        where id  = '$userId' "); 
  if($update){
      echo 1;
  } else{
      echo mysqli_error($db);
  }
 
}

if (isset($_POST['updateSocial'])) { 
  
  $git = mysqli_real_escape_string($db,$_POST['git']);
  $lnk = mysqli_real_escape_string($db,$_POST['link']);
  $tweet = mysqli_real_escape_string($db,$_POST['tweet']);
  
  $count = mysqli_num_rows(mysqli_query($db,"select u_id from users_details where u_id = '$userId'"));
    
  if($count > 0)
  $social = mysqli_query($db,"update users_details set city = '$city', github = '$git', linkedin = '$lnk', twitter = '$tweet' where u_id  = '$userId'"); 
  else 
  $social = mysqli_query($db,"INSERT INTO `users_details` (`u_id`, `city`, `github`, `linkedin`, `twitter`) VALUES ('$userId', '$city', '$git', '$lnk', '$tweet')");
  
   if($social){
       echo 1;
   } else{
       echo mysqli_error($db);
   }
 
}



if (isset($_POST['check_user_name'])) { 
  
  $username = mysqli_real_escape_string($db,$_POST['check_user_name']);
  
  $count = mysqli_num_rows(mysqli_query($db,"select metaname from users where metaname = '$username' and id != '$userId'"));
    
  if($count > 0)
       echo 0;
   else
       echo 1;
 
}


if (isset($_POST['updateCat'])) {
  
  $cat = $_POST['cat'];
  $sel  = mysqli_query($db,"update users set com_category = '$cat' where id  = '$userId'"); 
 
}


if (isset($_POST['getMentors'])) {

  $cat = $_POST['cat_id'];
  
  $mentors = "";

  $result = mysqli_query($db, "select * from com_category where id = '$cat'");

  $row = mysqli_fetch_assoc($result);
  $ids = explode(",",$row['mentors']);
    
if($row['mentors'] != '') {
       
  foreach ($ids as $id) {
      
    $user = mysqli_fetch_assoc(mysqli_query($db, "select biography,full_name,image from users where id='$id'"));
    $profile = $l_url.'data/pro/'.$user['image'];
    
    $mentors .= ' <div class="widget widget-view-profile">
                                <div class="profile-box d-flex justify-content-between align-items-center">
                                    <a href="'.$user['biography'].'"><img src="'.$profile.'" style="    width: 8rem;" alt="image"></a>
                                    <div class="text ms-2">
                                        <h3><a href="'.$user['biography'].'">'.$user['full_name'].'</a></h3>
                                        <span>'.$row['name'].'</span>
                                    </div>
                                </div>
                                
                                <div class="profile-btn">
                                    <a target="_blank" href="'.$user['biography'].'" class="default-btn">View profile</a>
                                </div>
                            </div>';
    
    
  }
    }else{
        $mentors = 0;
    }
    
  
  $data = array();
  $data['mentors'] = $mentors;

  echo $form = json_encode($data);
}


if (isset($_POST['getWorkshops'])) {

  $workshop = "";

  $result = mysqli_query($db, "select * from workshop");

  while ($work = mysqli_fetch_assoc($result)) {
    $img_url = $l_url."assets/workshop/".$work['cover'];
    $workshop .= ' <div class="widget widget-view-profile">
                                <img src="'.$img_url.'"/>
                                
                                <div class="profile-btn">
                                    <a target="_blank" href="'.$work['work_url'].'" class="default-btn">Register</a>
                                </div>
                            </div>';
    
    
  }    
  
  $data = array();
  $data['workshop'] = $workshop;

  echo $form = json_encode($data);
}




?>

