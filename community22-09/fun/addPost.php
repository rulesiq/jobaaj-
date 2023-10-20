<?php

require '../config.php';

header('Content-Type: text/html; charset=utf-8');

$userId = $user['id'];

if (isset($_POST['addPost'])) {

  $cat = $_POST['post-cat'];
  $img = "";
    
       $postId = $_POST['addPost'];
      
        $posted = time();
      
        $text = str_replace("'", "\'", $_POST['post-editor2']);
        
        $text = preg_replace("#\[nl\]#","<br>\n", $text);
            
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $text, $match);
        
        foreach($match[0] as $u){
            $link = "<a target='_blank' href=".$u.">".$u."</a>";
            $link = str_replace("'", "\'", $link);
            $text = str_replace($u,$link,$text);
        }
        
        
   if($postId==0) {
       
    $img_array = array();
     
    
    if ($_FILES['post-img']['tmp_name'][0] != "") {
        
        $img_array = array();
        
        for($i=0;$i<count($_FILES["post-img"]["name"]);$i++)
        {
            
           
            $post =  $_FILES['post-img']['name'][$i];
            $postPath = $_FILES['post-img']['tmp_name'][$i];
            $post_ =  time().$i.$userId.".png";
            $post_img = $url ."data/". time().$i.$userId.".png";
            move_uploaded_file($postPath, "../data/" . $post_);
            $img_array[] = mysqli_real_escape_string($db,$post_img);
            
        }
        
        $img_array = count($img_array) > 0 ? json_encode($img_array) : null;
     } 
     
    if($_POST['videoPost']=='true'){
        if($_FILES['post-video']!="") {
            
                $video =  $_FILES['post-video']['name'];
                $videoPath = $_FILES['post-video']['tmp_name'];
                $video_ =  time()."vid_".$i.$userId.".mp4";
                
                $post_video = $url ."data/".$video_; 
                move_uploaded_file($videoPath, "../data/" . $video_);
                
                $img_array = $post_video;
                
                $posted_thumb = $_FILES['posted_thumb_url']['name'];
                $posted_thumbPath = $_FILES['posted_thumb_url']['tmp_name'];
                $video_thumb_ =  time()."thumb_vid_".$i.$userId.".jpg";
                $posted_video_thumb = $url ."data/".$video_thumb_; 
                move_uploaded_file($posted_thumbPath, "../data/" . $video_thumb_);
        }
    }   
         
      
      $query = mysqli_query($db,"insert into com_posts (cat_id, content, img, posted_thumb, date_posted, date_edited, posted_user, status) 
      values ('$cat', '$text', '$img_array', '$posted_video_thumb', '$posted', '$posted', '$userId', '0')");
  
  
     } else{
      
       $img_array = array();
       
       $last_files = ltrim($_POST['file_url'],",");
       if($last_files!='' && $last_files!=0) { 
          
          $lastImgs =  explode(",",$last_files);
         
          foreach($lastImgs as $img){
              if($img!='' && $img!=0)
              $img_array[] = $img;
          }
         
       }
        
        
      if ($_FILES['post-img']['tmp_name'][0] != "") {
        
        for($i=0;$i<count($_FILES["post-img"]["name"]);$i++)
        {
            $post =  $_FILES['post-img']['name'][$i];
            $postPath = $_FILES['post-img']['tmp_name'][$i];
            $post_ =  time().$i.$userId.".png";
            $post_img = $url ."data/". time().$i.$userId.".png";
            move_uploaded_file($postPath, "../data/" . $post_);
            $img_array[] = $post_img;
        }

      } 
     
        $img_array = count($img_array) > 0 ? json_encode($img_array) : null;
      
        if($cat == '10'){
            $status = 1;
        }else{
            $status = 0;
        }
        $query = mysqli_query($db,"update com_posts set cat_id = '$cat', content = '$text', status = $status, img = '$img_array',
        date_edited = '$posted' where p_id = '$postId'"); 
      }
  
  if($query){
      echo 1;
  }else{
      echo $text;
  }
  
  
  
  }


if(isset($_POST['addLearningPost'])){
    
        $cat = 1;
        
        $img = "";
        $userId = mysqli_real_escape_string($db,$_POST['addLearningPost']);
    
        $posted = time();
      
        $text = str_replace("'", "\'", $_POST['post-editor']);
        
        $text = preg_replace("#\[nl\]#","<br>\n", $text);
            
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $text, $match);
        
        foreach($match[0] as $u){
            $link = "<a target='_blank' href=".$u.">".$u."</a>";
            $link = str_replace("'", "\'", $link);
            $text = str_replace($u,$link,$text);
        }
        
    $query = mysqli_query($db,"insert into com_posts (cat_id, content, img, posted_thumb, date_posted, date_edited, posted_user, status) 
      values ('$cat', '$text', '$img', '', '$posted', '$posted', '$userId', '1')");
  
      
  if($query){
      echo 1;
  }else{
      echo '123';
  }
  
}



if (isset($_POST['AddLike'])) {
  
  $post = $_POST['post'];
  
  $toUser = mysqli_fetch_assoc(mysqli_query($db,"select posted_user from com_posts where p_id = '$post'"));
  
  $sel  = mysqli_num_rows(mysqli_query($db,"select l_id from com_likes where  user_id  = '$userId' and post_id = '$post' ")); 
 
  if($sel==0) {
      
   $add = mysqli_query($db,"insert into com_likes (user_id,post_id) values ('$userId', '$post')");
  
  if($userId!=$toUser['posted_user']){
        notification($toUser['posted_user'],"Liked your Post!",$post,$userId);
   }
  
  }
  
  echo 1;
}


if (isset($_POST['delPost'])) {
  $post = $_POST['post'];
  $remove = mysqli_query($db,"delete from com_posts where p_id  = '$post'");
  echo 1;
}


if (isset($_POST['updateCertificatePost'])) {
  $post = $_POST['post'];
  $remove = mysqli_query($db,"update com_posts set status = 1 where p_id  = '$post'");
  echo 1;
}



if (isset($_POST['DelLike'])) {
  $post = $_POST['post'];
  $remove = mysqli_query($db,"delete from com_likes  where user_id  = '$userId' and post_id = '$post'");
  echo 1;
}


if(isset($_POST['AddComment'])){
    
  $post = $_POST['post'];
  
  $post = trim(str_replace("'", "\'", $post));
      
  $img = "";
  $added = time();
  
  $cmt = str_replace("'", "\'", $_POST['AddComment']);
  $toUser = mysqli_fetch_assoc(mysqli_query($db,"select posted_user from com_posts where p_id = '$post'"));

  $add_cmment = mysqli_query($db,"INSERT INTO `com_comments` (`cmt_id`, `user_id`,  `post_id`, `comment`, `cmt_img`, `added`,`status`)
                                  VALUES (NULL, '$userId', '$post', '$cmt', null, '$added','1');");
  if($add_cmment){

     if($userId!=$toUser['posted_user']){
            notification($toUser['posted_user'],"Added comment to your Post!",$post,$userId);
     }
     echo 1;
     
  }else{
      echo mysqli_error($db);
  }

}


if(isset($_POST['AddCommentReply'])){
    
  $postId = $_POST['post'];
  $commentId = $_POST['comment_id'];
  
  $img = "";
  $added = time();
  
  $cmt = str_replace("'", "\'", $_POST['AddCommentReply']);
  
  $toUser = mysqli_fetch_assoc(mysqli_query($db,"select user_id from com_comments where cmt_id = '$commentId'"))['user_id'];

  $add_cmment = mysqli_query($db,"INSERT INTO `com_comments_replies` (`cmt_id`,`user_id`, `comment`, `post_id`, `added`,`status`)
                                  VALUES ('$commentId', '$userId', '$cmt', '$postId', '$added','1');");
  if($add_cmment){

     if($userId!=$toUser){
            notification($toUser,"Added Reply to your comment!",$postId,$userId);
     }
     echo 1;
     
  }else{
      echo mysqli_error($db);
  }

}


if (isset($_POST['delComment'])) {
  $cmt = $_POST['cmt'];
  $remove = mysqli_query($db,"delete from com_comments where cmt_id  = '$cmt'");
  echo 1;
}


if (isset($_POST['delReplyComment'])) {
  $cmt = $_POST['cmt'];
  $remove = mysqli_query($db,"delete from com_comments_replies where r_id  = '$cmt'");
  echo 1;
}


if(isset($_POST['updateComment'])){
    
  $cmt = $_POST['cmt'];
  $text = $_POST['cmtText'];
  $updated = time();
  
  $cmtNew = str_replace("'", "\'", $text);
  $toUser = mysqli_fetch_assoc(mysqli_query($db,"select posted_user from com_posts where p_id = '$post'"));

  $update_cmment = mysqli_query($db," update com_comments set comment = '$cmtNew', added = '$updated' where cmt_id = '$cmt'");
  if($update_cmment){
    //  if($userId!=$toUser['posted_user']){
    //         notification($toUser['posted_user'],"Added comment your Post!",$post,$userId);
    //  }
     echo 1;
     
  }else{
      echo mysqli_error($db);
  }

}





if(isset($_POST['updatePoll'])){
    
  $poll_id = $_POST['updatePoll'];
  $poll_c = $_POST['count_key'];
  
        $data = mysqli_query($db,"select * from com_poll where id = '$poll_id'");
        $poll = mysqli_fetch_assoc($data);
        
        $score = json_decode($poll['vote_count']);
        
        $new_score = [];
        foreach($score as $cid=>$cval){ 
                  
                  if($cid==$poll_c){
                       $cval+=1;
                  }
                  
                  $new_score[$cid] = $cval;
        }
        
  $poll_updated = json_encode($new_score);
  
  $data = mysqli_query($db,"update com_poll set vote_count = '$poll_updated' where id = '$poll_id'");

 

    

}

