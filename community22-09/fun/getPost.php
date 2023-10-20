<?php

require '../config.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$cmtBoxI = 0;

function removeSpcl($str)
{
  $str = strtolower($str);
  $str = preg_replace('/[^A-Za-z0-9]/', ' ', $str);
  $str = trim($str);
  $str = str_replace(" ", "-", $str);
  $str = preg_replace('/-+/', '-', $str);
  $str = trim($str, '-');
  return $str;
}

function timeago($datetime, $full = false) {
    
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

$userId = $_SESSION['learner_id'];

if (isset($_POST['getPosts'])) {

  $cat = $_POST['cat_id'];
  $search = $_POST['search'];
  $offset = $_POST['offset'];
  
  if($cat == "10"){
     $query = "select * from com_posts where status = 1 and cat_id = 10 ";
  }
  
  else if($cat == "-1"){
     
        $query = "select * from com_posts where status = 1 and cat_id = -1 ";

  } 
  else if($cat == "0"){
        $query = "select * from com_posts where posted_user = '$userId' and cat_id != 10  ";
  }else if($cat == "-2"){
        $query = "select * from com_posts where status = 1 and cat_id != 10  ";
  }
  else{
        
    $trainer = mysqli_fetch_assoc(mysqli_query($db, "select mentors from com_category where id = '$cat'"));
    $trainers = $trainer['mentors'];
      $max_id_query = "select max(p_id) as max_id from com_posts 
                                        where p_id in ( 
                                            select max(p_id) as id from com_posts
                                               where posted_user in ($trainers) 
                                                    group by posted_user
                                        ) ";
      $trainer_post_id = mysqli_fetch_assoc(mysqli_query($db,$max_id_query));                                
      //This query return only last Post of trainer by Last Posted time.
      $query2 = "select * from com_posts c1 join
                              (
                                 ".$max_id_query."
                              ) c2 on c1.p_id = c2.max_id";
                              
                              
      $result2 = mysqli_query($db, $query2);

     $query = "select * from com_posts where cat_id = '$cat' and status = 1 and p_id != '$trainer_post_id[max_id]' ";

        // if($search != '')
        // $query = "select * from com_posts where content like '%$search%' and status = 1   order by p_id desc ";
    }
    
  if($search != '')
  $query.= " and content like '%$search%' ";


  $query.= " order by p_id desc";
 
  $posts = "";

  $sql = mysqli_query($db, $query);

  $query .= " LIMIT " . $offset . ',' . 10;
  
  $number_of_result = mysqli_num_rows($sql);
  
  $result = mysqli_query($db, $query);
    
    $poll_query = mysqli_query($db,"select * from com_poll where cat_id in ($cat) order by id desc limit 1");
    $selected = "";
    $disable = "";
    if(mysqli_num_rows($poll_query)==0){
              
                $poll = mysqli_fetch_assoc($poll_query);
                $option = json_decode($poll['options']);
                $score = json_decode($poll['vote_count']);
                $arr = [];
                
                foreach($score as $cid=>$cval){ 
                          $arr[] = $cval;     
                    }
                        
                        $sel = -1;
                        $cookie = $_COOKIE['463d773cad30c5b74940d5e586e88a75'];
                        $check_disable = false;
                        if($cookie!=''){
                            
                            $cookie_data = explode(",",$cookie);
                            
                            if($cookie_data[0]==$poll['id']){
                                $check_disable = true;
                                $funRun='';
                                $sel = $cookie_data[1];
                                $sty = "style='display:block';";

                            } else{
                                $funRun = "optionSelected($poll[id],event)"; 
                            }
                        }else{
                            $funRun = "optionSelected($poll[id],event)"; 
                        }
                        
                        $totalVote = 0;
                        foreach($arr as $vote){
                            $totalVote+=$vote;
                        }
                        $i = 0;
                        
                        foreach ($option as $key) {
                           
                          if($sel == $i) { $selected = "checked"; } 
                          else { $selected = ''; 
                          } 
                          
                          $per = round(($arr[$i] / $totalVote) * 100);
                          
                          if($check_disable){
                              if($selected=="checked"){
                                  $disable = "";
                              }else{
                                  if($cookie!='')
                                    $disable = "disabled";
                              }
                          }
                          
                          
                          
                          $options.='<li class="list-group-item">
                                        <div class="radio">
                                            <label>
                                                <input '.$disable.' type="radio" '.$selected.'  value="'.$i.'" onclick="'.$funRun.'" name="option" />
                                                '.$key.'
                                            </label>
                                           <span '.$sty.' class="score score'.$poll['id'].'"> '.$per.'% </span>
                                        </div>
                                    </li>';
                                    
                                    $i++;
                        }
                        
                        
                        
                        // $tick = "<img  src='$url/assets/images/tick.svg' class='tick'>";
                        
                        //       $posts .= '<div class="news-feed news-feed-post">
                        //                             <div class="post-header d-flex justify-content-between align-items-center">
                        //                                 <div class="image">
                        //                                     <a href=""><img src="https://www.jobaajlearnings.com/data/pro/1680779117pro-1.png" class="rounded-circle"/></a>
                        //                                 </div>
                        //                                 <div class="info ms-3">
                        //                                     <span class="name"><a href="javascript:;">Jobaaj Learnings '.$tick.'</a></span>
                        //                                     <span class="small-text">Updated</span>
                        //                                 </div>
                        //                                 <br>
                        //                             </div>
                        //                             <div class="post-body">
                        //                                  <div class="panel panel-primary">
                        //                                 <div class="panel-heading">
                        //                                     <h3 style="font-size: 1.2rem;" class="panel-title">
                        //                                         '.$poll['title'].'
                        //                                     </h3>
                        //                                 </div>
                        //                                 <div class="panel-body">
                        //                                     <ul class="list-group">
                        //                                       '.$options.'
                        //                                     </ul>
                        //                                 </div>
                        //                             </div>
                        //                             </div>
                        //                         </div>';
        }
    
  //posts for Announcements     
  if($cat == "-1") {                            
   
      $homResult = mysqli_query($db, "select * from com_posts where posted_user = 1 and status = 1 and cat_id = -1 order by p_id desc");
      $countPost = mysqli_num_rows($homResult);
      if($countPost > 0) { 
       
        while ($row = mysqli_fetch_assoc($homResult)) {
          
        $time = timeago(date('Y-m-d H:i:s',$row['date_posted']));
    
        $postId = $row['p_id'];
    
        $cat = mysqli_fetch_assoc(mysqli_query($db, "select name from com_category where id='$row[cat_id]'"));
        $user = mysqli_fetch_assoc(mysqli_query($db, "select full_name,metaname,image,verification_code from users where id='$row[posted_user]'"));
        $like = mysqli_fetch_assoc(mysqli_query($db, "select count(*) as c from com_likes where post_id='$postId'"));
        $like_check = mysqli_num_rows(mysqli_query($db, "select l_id from com_likes where post_id='$postId' and user_id = '$userId'"));
        $likeCount = $like['c'];
        
        $likeCount = ($likeCount == 0) ? '' : $likeCount;
        $like_icon = ($like_check == 0) ? 'fa-regular' : 'fa-solid';
        
        $post_img = ($row['img'] != '') ? '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$row['img'].'" class="postImg'.$postId.'" ></div>' : '';
        
         $post_video = '';
         
       if($row['img'] != 'null' && $row['img'] != '') { 
        
          $img_s = json_decode($row['img'],true);
   
            if(is_array($img_s)) {
                    
                    if(count($img_s) > 0) { 
                      $post_img = '<div class="swiper mySwiper" style="z-index:99999999;">
                        <div class="swiper-wrapper swiperWrapper'.$postId.'">';
                        foreach($img_s as $img){
                          $post_img .=' 
                            <div class="swiper-slide">
                             <img onerror="this.style.display=`none`" src="'.$img.'"/>
                            </div>';
                        }
                        
                         $post_img.=' </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                      </div>';
                    }
                   
                 } else{
                    $post_img = '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$row['img'].'" class="postImg'.$postId.'" ></div>';
                }
      }
        else{
          
        }
        
        require('inc_comments.php');
        
        
        if ($row['posted_thumb']!='')
            $post_video = '<div class="vjs"><div class="bg-video" style="background-image:url('.$row['posted_thumb'].');"></div><video  controls muted="muted" ><source src="'.$row['img'].'" type="video/mp4"></video></div>';

       
        $profile = $l_url.'data/pro/'.$user['image'];
       
    
        $profile = "<img onerror='this.style.display=`none`'  src='$profile' onerror=this.onerror=null;this.src='https://community.jobaajlearnings.com/assets/images/avatar.png' class='rounded-circle'>";
            
        $tick = '';
        if($user['verification_code']=='101')
        $tick = "<img src='$url/assets/images/tick.svg' class='tick'>";
        
        if($tick!='') $likeCount = rand(380,400);

        $post_url = $url.'post/'.removeSpcl(substr(strip_tags($row['content']),0,100)).'-'.$row['p_id'];
        
    
        $font = (strlen($row['content']) > 85) ? '.9rem' : '1.5rem';   
         
        if($userId != '')  { 
        $edit = ($userId == $row['posted_user']) ? '<li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="editPost('.$postId.')"><i class="fa-regular fa-edit"></i> Edit post</a></li>' : '';
        $del = ($userId == $row['posted_user']) ? '<li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="delPost('.$postId.')"><i class="fa-solid fa-trash"></i> Delete post</a></li>' : '';
        }
        $posts .= '<div class="news-feed news-feed-post post'.$postId.'">
                                    <div class="post-header d-flex justify-content-between align-items-center">
                                        <div class="image">
                                            <a href="profile/'.$user['metaname'].'">'.$profile.'</a>
                                        </div>
                                        <div class="info ms-3">
                                            <span class="name">
                                            <a href="profile/'.$user['metaname'].'">'.$user['full_name'].'</a>
                                            '.$tick.'
                                            </span><br>
                                            <span class="cat_post">#Announcements</span>
                                            <span class="small-text">'.$time.'</span>
                                        </div>
                                        
                                        <div class="dropdown">
                                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flaticon-menu"></i></button>
                                            <ul class="dropdown-menu" style="">
                                                '.$edit.'
                                                '.$del.'
                                                <li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-link"></i> Share Post</a></li>
                                            </ul>
                                        </div>
                                        
                                    </div>
                                    <div class="post-body">
                                        
                                        <p class="postContent'.$postId.'" style="font-size:'.$font.'">'.$row['content'].'</p>
                                        '.$post_img.'
                                        '.$post_video.'
                                        <span style="display:none" class="postCat'.$postId.'">'.$row['cat_id'].'</span>
                                        <ul class="post-meta-wrap d-flex justify-content-between align-items-center">
                                            <li class="post-react">
                                                <span class="post-like" onclick="likePost('.$postId.')"><i class="'.$like_icon.' fa-thumbs-up heart'.$postId.'"></i><span class="like'.$postId.'">'.$likeCount.' </span> Like </span>
                                            </li>
                                            <li class="post-comment">
                                                <a href="javascript:;"><i class="flaticon-comment"></i><span>'.$countComment.' Comment</span> </a>
                                            </li>
                                            <li class="post-share">
                                                <a href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-share"></i><span>Share</span></a>
                                            </li>
                                            
                                        </ul>
                                        <div class="post-comment-list clist'.$postId.'">
                                           '.$comments.'
                                            <div class="more-comments">
                                                '.$moreComments.'
                                            </div>
                                        </div>
                                        <div class="post-footer">
                                            <div class="form-group">
                                                <textarea name="message" '.$cmtBoxI++.'  data-post= '.$postId.' id="comment'.$postId.'" class="form-control" placeholder="Write a comment..."></textarea>
                                                <label class="post-comment" data-post='.$postId.'>Post</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                  }
      
      }else{
          $posts = 0;
      }
  }
  
  //Normal Posts
  else {   
        
       if($cat != '-2' && $cat != '10') {
         
          $countPost2 = mysqli_num_rows($result2);
          
          if($countPost2 > 0) { 
           
            while ($row = mysqli_fetch_assoc($result2)) {
              
            $time = timeago(date('Y-m-d H:i:s',$row['date_posted']));
        
            $postId = $row['p_id'];
        
            $cat = mysqli_fetch_assoc(mysqli_query($db, "select name from com_category where id='$row[cat_id]'"));
            $user = mysqli_fetch_assoc(mysqli_query($db, "select full_name,metaname,image,verification_code from users where id='$row[posted_user]'"));
            $like = mysqli_fetch_assoc(mysqli_query($db, "select count(*) as c from com_likes where post_id='$postId'"));
            $like_check = mysqli_num_rows(mysqli_query($db, "select l_id from com_likes where post_id='$postId' and user_id = '$userId'"));
            $likeCount = $like['c'];
            
            $likeCount = ($likeCount == 0) ? '' : $likeCount;
            $like_icon = ($like_check == 0) ? 'fa-regular' : 'fa-solid';
            
            
            
            $post_img = ($row['img'] != '') ? '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$row['img'].'" class="postImg'.$postId.'" ></div>' : '';
            $post_video = '';
            if($row['img'] != 'null' && $row['img'] != '') { 
        
            $img_s = json_decode($row['img'],true);
   
            if(is_array($img_s)) {
                    
                    if(count($img_s) > 1) { 
                        
                      $post_img = '<div class="swiper mySwiper " style="z-index:99999999;">
                        <div class="swiper-wrapper swiperWrapper'.$postId.'">';
                        foreach($img_s as $img){
                          $post_img .=' 
                            <div class="swiper-slide">
                             <img onerror="this.style.display=`none`" src="'.$img.'"/>
                            </div>';
                        }
                        
                         $post_img.=' </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                      </div>';
                    }
                    else{
                    $post_img = '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$img_s[0].'" class="postImg'.$postId.'" ></div>';
                     }
                 } else{
                    $post_img = '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$img_s[0].'" class="postImg'.$postId.'" ></div>';
                }
                
            
             if ($row['posted_thumb']!='')
                $post_video = '<div class="vjs"><div class="bg-video" style="background-image:url('.$row['posted_thumb'].');"></div><video  controls muted="muted" ><source src="'.$row['img'].'" type="video/mp4"></video></div>';
                
      }
        else{
          
        }
        
            require('inc_comments.php');
            
            $profile = $l_url.'data/pro/'.$user['image'];
            
            $profile = "<img  src='$profile' onerror=this.onerror=null;this.src='https://community.jobaajlearnings.com/assets/images/avatar.png' class='rounded-circle'>";
            
            $font = (strlen($row['content']) > 85) ? '.9rem' : '1.5rem';   
             
            if($userId != '')    {
            $edit = ($userId == $row['posted_user']) ? '<li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="editPost('.$postId.')"><i class="fa-regular fa-edit"></i> Edit post</a></li>' : '';
            $del = ($userId == $row['posted_user']) ? '<li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="delPost('.$postId.')"><i class="fa-solid fa-trash"></i> Delete post</a></li>' : '';

            $status = $row['status'] == '0' ? '<span class="pending">Pending</span>' : '';
            }
         
            $tick = '';
            if($user['verification_code']=='101')
            $tick = "<img   src='$url/assets/images/tick.svg' class='tick'>";
            
            if($tick!='') $likeCount = rand(380,400);

            
            $post_url = $url.'post/'.removeSpcl(substr(strip_tags($row['content']),0,100)).'-'.$row['p_id'];

            
            $posts .= '<div class="news-feed news-feed-post post'.$postId.'">
                                        <div class="post-header d-flex justify-content-between align-items-center">
                                            <div class="image">
                                                <a href="profile/'.$user['metaname'].'">'.$profile.'</a>
                                            </div>
                                            <div class="info ms-3">
                                                <a href="profile/'.$user['metaname'].'">'.$user['full_name'].'</a>
                                                '.$tick.'
                                                '.$status.'</span><br>
                                                <span class="cat_post">#'.str_replace(" ", "", $cat['name']).' </span>
                                                <span class="small-text">'.$time.'</span>
                                            </div>
                                            
                                            <div class="dropdown">
                                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flaticon-menu"></i></button>
                                                <ul class="dropdown-menu" style="">
                                                    '.$edit.'
                                                    '.$del.'
                                                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-link"></i> Share Post</a></li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                        <div class="post-body">
                                            
                                            <p class="postContent'.$postId.'" style="font-size:'.$font.'">'.$row['content'].'</p>
                                            '.$post_img.'
                                            '.$post_video.'
                                            <span style="display:none" class="postCat'.$postId.'">'.$row['cat_id'].'</span>
                                            <ul class="post-meta-wrap d-flex justify-content-between align-items-center">
                                                <li class="post-react">
                                                    <span class="post-like" onclick="likePost('.$postId.')"><i class="'.$like_icon.' fa-thumbs-up heart'.$postId.'"></i><span class="like'.$postId.'">'.$likeCount.' </span> Like </span>
                                                </li>
                                                <li class="post-comment">
                                                    <a href="javascript:;"><i class="flaticon-comment"></i><span>'.$countComment.' Comment</span> </a>
                                                </li>
                                                <li class="post-share">
                                                    <a href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-share"></i><span>Share</span></a>
                                                </li>
                                                
                                            </ul>
                                            <div class="post-comment-list clist'.$postId.'">
                                              '.$comments.'
                                                <div class="more-comments">
                                                    '.$moreComments.'
                                                </div>
                                            </div>
                                            <div class="post-footer">
                                              <div class="form-group">
                                                <textarea name="message" '.$cmtBoxI++.' data-post= '.$postId.' id="comment'.$postId.'" class="form-control" placeholder="Write a comment..."></textarea>
                                                <label class="post-comment" data-post='.$postId.'>Post</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
          }
          
          }else{
              $posts = '';
          }
          
        }
          
          $countPost = mysqli_num_rows($result);
          
          if($countPost > 0) { 
           
            while ($row = mysqli_fetch_assoc($result)) {
              
            $time = timeago(date('Y-m-d H:i:s',$row['date_posted']));
        
            $postId = $row['p_id'];
        
            $cat = mysqli_fetch_assoc(mysqli_query($db, "select name from com_category where id='$row[cat_id]'"));
            $user = mysqli_fetch_assoc(mysqli_query($db, "select full_name,metaname,image,verification_code from users where id='$row[posted_user]'"));
            $like = mysqli_fetch_assoc(mysqli_query($db, "select count(*) as c from com_likes where post_id='$postId'"));
            $like_check = mysqli_num_rows(mysqli_query($db, "select l_id from com_likes where post_id='$postId' and user_id = '$userId'"));
            $likeCount = $like['c'];
            
            $likeCount = ($likeCount == 0) ? '' : $likeCount;
            $like_icon = ($like_check == 0) ? 'fa-regular' : 'fa-solid';
            
            $post_img = ($row['img'] != '') ? '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$row['img'].'" class="postImg'.$postId.'" ></div>' : '';
            
            $post_video = '';
            if($row['img'] != 'null' && $row['img'] != '') { 
        
            $img_s = json_decode($row['img'],true);
   
            if(is_array($img_s)) {
                    
                    if(count($img_s) > 1) { 
                        
                      $post_img = '<div class="swiper mySwiper " style="z-index:99999999;">
                        <div class="swiper-wrapper swiperWrapper'.$postId.'">';
                        foreach($img_s as $img){
                          $post_img .=' 
                            <div class="swiper-slide">
                             <img onerror="this.style.display=`none`" src="'.$img.'"/>
                            </div>';
                        }
                        
                         $post_img.=' </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                      </div>';
                    }
                    else{
                    $post_img = '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$img_s[0].'" class="postImg'.$postId.'" ></div>';
                     }
                 } else{
                    $post_img = '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$img_s[0].'" class="postImg'.$postId.'" ></div>';
                }
                
            
             if ($row['posted_thumb']!='')
                $post_video = '<div class="vjs"><div class="bg-video" style="background-image:url('.$row['posted_thumb'].');"></div><video  controls muted="muted" ><source src="'.$row['img'].'" type="video/mp4"></video></div>';

      }
        else{
          
        }
            require('inc_comments.php');
           
            $profile = $l_url.'data/pro/'.$user['image'];
            
            $profile = "<img  src='$profile' onerror=this.onerror=null;this.src='https://community.jobaajlearnings.com/assets/images/avatar.png' class='rounded-circle'>";
            
            $font = (strlen($row['content']) > 85) ? '.9rem' : '1.5rem';   
             
            if($userId != '')    {
            $edit = ($userId == $row['posted_user']) ? '<li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="editPost('.$postId.')"><i class="fa-regular fa-edit"></i> Edit post</a></li>' : '';
            $del = ($userId == $row['posted_user']) ? '<li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="delPost('.$postId.')"><i class="fa-solid fa-trash"></i> Delete post</a></li>' : '';

            $status = $row['status'] == '0' ? '<span class="pending">Pending</span>' : '';
            }
         
            
            $tick = '';
            if($user['verification_code']=='101')
            $tick = "<img   src='$url/assets/images/tick.svg' class='tick'>";
            $post_url = $url.'post/'.removeSpcl(substr(strip_tags($row['content']),0,100)).'-'.$row['p_id'];
            
            if($tick!='') $likeCount = rand(380,400);
            
            $posts .= '<div class="news-feed news-feed-post post'.$postId.'">
                                        <div class="post-header d-flex justify-content-between align-items-center">
                                            <div class="image">
                                                <a href="profile/'.$user['metaname'].'">'.$profile.'</a>
                                            </div>
                                            <div class="info ms-3">
                                                <a href="profile/'.$user['metaname'].'">'.$user['full_name'].'</a>
                                                '.$tick.'
                                                '.$status.'</span><br>
                                                <span class="cat_post">#'.str_replace(" ", "", $cat['name']).' </span>
                                                <span class="small-text">'.$time.'</span>
                                            </div>
                                            
                                            <div class="dropdown">
                                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flaticon-menu"></i></button>
                                                <ul class="dropdown-menu" style="">
                                                    '.$edit.'
                                                     '.$del.'
                                                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-link"></i> Share Post</a></li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                        <div class="post-body">
                                            
                                            <p class="postContent'.$postId.'" style="font-size:'.$font.'">'.$row['content'].'</p>
                                            '.$post_img.'
                                            '.$post_video.'
                                            <span style="display:none" class="postCat'.$postId.'">'.$row['cat_id'].'</span>
                                            <ul class="post-meta-wrap d-flex justify-content-between align-items-center">
                                                <li class="post-react">
                                                    <span class="post-like" onclick="likePost('.$postId.')"><i class="'.$like_icon.' fa-thumbs-up heart'.$postId.'"></i><span class="like'.$postId.'">'.$likeCount.' </span> Like </span>
                                                </li>
                                                <li class="post-comment">
                                                    <a href="javascript:;"><i class="flaticon-comment"></i><span>'.$countComment.' Comment</span> </a>
                                                </li>
                                                <li class="post-share">
                                                    <a href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-share"></i><span>Share</span></a>
                                                </li>
                                                
                                            </ul>
                                            <div class="post-comment-list clist'.$postId.'">
                                               '.$comments.'
                                                <div class="more-comments">
                                                    '.$moreComments.'
                                                </div>
                                            </div>
                                            <div class="post-footer">
                                               <div class="form-group">
                                                <textarea name="message" '.$cmtBoxI++.' data-post= '.$postId.' id="comment'.$postId.'" class="form-control" placeholder="Write a comment..."></textarea>
                                                <label class="post-comment" data-post='.$postId.'>Post</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
            
                    
                
          }
          
          }else{
              $posts = 0;
          }
       }
 
  $data = array();
  $data['posts'] = $posts;
  $data['count'] = $countPost;
  $data['query'] = '';

  echo $form = json_encode($data);
}

if (isset($_POST['getPost'])) {

  $post = $_POST['getPost'];
  
  $query = "select * from com_posts where p_id = '$post'";
  $post = "";

  $result = mysqli_query($db, $query);
        
    $row = mysqli_fetch_assoc($result);
    
    $postId = $row['p_id'];
      
    $time = timeago(date('Y-m-d H:i:s',$row['date_posted']));

    $cat = mysqli_fetch_assoc(mysqli_query($db, "select name from com_category where id='$row[cat_id]'"));
    $user = mysqli_fetch_assoc(mysqli_query($db, "select full_name,metaname,image,verification_code from users where id='$row[posted_user]'"));
    
   // $user = mysqli_fetch_assoc(mysqli_query($db, "select full_name,metaname,image,verification_code from users where id='$row[posted_user]'"));
    $like = mysqli_fetch_assoc(mysqli_query($db, "select count(*) as c from com_likes where post_id='$postId'"));
    $like_check = mysqli_num_rows(mysqli_query($db, "select l_id from com_likes where post_id='$postId' and user_id = '$userId'"));
    $likeCount = $like['c'];
    
    $likeCount = ($likeCount == 0) ? '' : $likeCount;
    $like_icon = ($like_check == 0) ? 'fa-regular' : 'fa-solid';
    
    $post_img = ($row['img'] != '') ? '<div class="post-image "><img onerror="this.style.display=`none`" src="'.$row['img'].'" class="postImg'.$postId.'" ></div>' : '';
    
    if($row['img'] != 'null' && $row['img'] != '') { 
        
          $img_s = json_decode($row['img'],true);
   
            if(is_array($img_s)) {
                    
                    if(count($img_s) > 0) { 
                      $post_img = '<div class="swiper mySwiper" style="z-index:99999999;">
                        <div class="swiper-wrapper swiperWrapper'.$postId.'">';
                        foreach($img_s as $img){
                          $post_img .=' 
                            <div class="swiper-slide">
                             <img onerror="this.style.display=`none`" src="'.$img.'"/>
                            </div>';
                        }
                        
                         $post_img.=' </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                      </div>';
                    }
                   
                 } else{
                    $post_img = '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$row['img'].'" class="postImg'.$postId.'" ></div>';
                }
      }
      
    $post_video = '';
    
    
    if ($row['posted_thumb']!='') {
        $post_img = "";
        $post_video = '<div class="vjs"><div class="bg-video" style="background-image:url('.$row['posted_thumb'].');"></div><video  controls muted="muted" ><source src="'.$row['img'].'" type="video/mp4"></video></div>';
    }

        
     require('inc_comments_post.php');
    
    $profile = $l_url.'data/pro/'.$user['image'];
    
    $profile = "<img  src='$profile' onerror=this.onerror=null;this.src='https://community.jobaajlearnings.com/assets/images/avatar.png' class='rounded-circle'>";
    
    $tick = '';
    if($user['verification_code']=='101')
    $tick = "<img   src='$url/assets/images/tick.svg' class='tick'>";
    
    if($tick!='') $likeCount = rand(380,400);

    $post_url = $url.'post/'.removeSpcl(substr(strip_tags($row['content']),0,100)).'-'.$row['p_id'];
    
    $font = (strlen($row['content']) > 100) ? '.9rem' : '1.5rem';   
         
      if($userId != '')    {
            $edit = ($userId == $row['posted_user']) ? '<li><a class="dropdown-item d-flex align-items-center" href="'.$url.'?myPost" onclick="editPost('.$postId.')"><i class="fa-regular fa-edit"></i> Edit post</a></li>' : '';
            $status = $row['status'] == '0' ? '<span class="pending">Pending</span>' : '';
        }
  
  
                             
    $post .= '<div class="news-feed news-feed-post post'.$postId.'">
    
                                <div class="post-header d-flex justify-content-between align-items-center">
                                    <div class="image">
                                        <a href="profile/'.$user['metaname'].'">'.$profile.'</a>
                                        
                                    </div>
                                    <div class="info ms-3">
                                        <span class="name">
                                        
                                        <a href="profile/'.$user['metaname'].'">'.$user['full_name']. $status .'</a> 
                                        '.$tick.'
                                        </span><br/>
                                         <span class="cat_post">#'.str_replace(" ", "", $cat['name']).' </span>
                                        <span class="small-text">'.$time.'</span>
                                    </div>
                                    
                                    <div class="dropdown">
                                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flaticon-menu"></i></button>
                                                <ul class="dropdown-menu" style="">
                                                     '.$edit.'
                                                     '.$del.'
                                                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-link"></i> Share Post</a></li>
                                                </ul>
                                     </div>
                                   
                                </div>

                                <div class="post-body">
                                    <p style="font-size:'.$font.'">'.$row['content'].'</p>
                                    '.$post_img.'
                                    '.$post_video.'
                                    <ul class="post-meta-wrap d-flex justify-content-between align-items-center">
                                        <li class="post-react">
                                            <span class="post-like" onclick="likePost('.$postId.')"><i class="'.$like_icon.' fa-thumbs-up heart'.$postId.'"></i><span class="like'.$postId.'">'.$likeCount.' </span> Like </span>
                                        </li>
                                        <li class="post-comment">
                                            <a href="javascript:;"><i class="flaticon-comment"></i><span>'.$countComment.' Comment</span> </a>
                                        </li>
                                        <li class="post-share">
                                            <a href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-share"></i><span>Share</span></a>
                                        </li>
                                        
                                    </ul>
                                    
                                    <div class="post-comment-list clist'.$postId.'">
                                       '.$comments.'
                                    </div>
                                    <div class="post-footer">
                                       <div class="form-group">
                                                <textarea name="message" '.$cmtBoxI++.' data-post= '.$postId.' id="comment'.$postId.'" class="form-control" placeholder="Write a comment..."></textarea>
                                                <label class="post-comment" data-post='.$postId.'>Post</label>
                                        </div>
                                    </div>
                                </div>
                            </div>';
  

  $data = array();
  $data['post'] = $post;
  $data['title'] = strtok($user['full_name'],' ').'\'s Post';

  echo $form = json_encode($data);
}

if (isset($_POST['editPost'])) {

  $post = $_POST['editPost'];
  
  $query = "select * from com_posts where p_id = '$post'";
  $post = "";

  $result = mysqli_query($db, $query);
  
  $row = mysqli_fetch_assoc($result);
      
  $data = array();
  $data['post'] = $row['content'];
  $data['img'] = $row['img'];
  $data['cat'] = $row['cat_id'];

  echo $form = json_encode($data);
}


if (isset($_GET['myPosts'])) {
    
  if(isset($_GET['profile'])) {
   $user = $_GET['myPosts'];
   $query = "select * from com_posts where posted_user = '$user' and status = 1 order by p_id desc";
  }
  
  
  else 
  $query = "select * from com_posts where posted_user = '$userId' order by p_id desc";

  $posts = "";

  $sql = mysqli_query($db, $query);

  $number_of_result = mysqli_num_rows($sql);
  
  $result = mysqli_query($db, $query);
     
  $countPost = mysqli_num_rows($result);
         
          if($countPost > 0) { 
           
            while ($row = mysqli_fetch_assoc($result)) {
              
            $time = timeago(date('Y-m-d H:i:s',$row['date_posted']));
        
            $postId = $row['p_id'];
        
            $cat = mysqli_fetch_assoc(mysqli_query($db, "select name from com_category where id='$row[cat_id]'"));
            $user = mysqli_fetch_assoc(mysqli_query($db, "select full_name,metaname,image,verification_code from users where id='$row[posted_user]'"));
            $like = mysqli_fetch_assoc(mysqli_query($db, "select count(*) as c from com_likes where post_id='$postId'"));
            $like_check = mysqli_num_rows(mysqli_query($db, "select l_id from com_likes where post_id='$postId' and user_id = '$userId'"));
           
            $likeCount = $like['c'];
            
            $likeCount = ($likeCount == 0) ? '' : $likeCount;
            $like_icon = ($like_check == 0) ? 'fa-regular' : 'fa-solid';
            
            $post_img = ($row['img'] != '') ? '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$row['img'].'" class="postImg'.$postId.'" ></div>' : '';
            
            $post_video = '';
            
            if($row['img'] != 'null' && $row['img'] != '') { 
        
            $img_s = json_decode($row['img'],true);
   
            if(is_array($img_s)) {
                    
                    if(count($img_s) > 1) { 
                        
                      $post_img = '<div class="swiper mySwiper " style="z-index:99999999;">
                        <div class="swiper-wrapper swiperWrapper'.$postId.'">';
                        foreach($img_s as $img){
                          $post_img .=' 
                            <div class="swiper-slide">
                             <img onerror="this.style.display=`none`" src="'.$img.'"/>
                            </div>';
                        }
                        
                         $post_img.=' </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                      </div>';
                    }
                    else{
                    $post_img = '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$img_s[0].'" class="postImg'.$postId.'" ></div>';
                     }
                 } else{
                    $post_img = '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$img_s[0].'" class="postImg'.$postId.'" ></div>';
                }
      }
            else{
              
            }
        
            
            if ($row['posted_thumb']!='')
                $post_video = '<div class="vjs"><div class="bg-video" style="background-image:url('.$row['posted_thumb'].');"></div><video  controls muted="muted" ><source src="'.$row['img'].'" type="video/mp4"></video></div>';
            
           
            require('inc_comments.php');

            $profile = $l_url.'data/pro/'.$user['image'];
           
            $profile = "<img  src='$profile' onerror=this.onerror=null;this.src='https://community.jobaajlearnings.com/assets/images/avatar.png' class='rounded-circle'>";
            
            $font = (strlen($row['content']) > 85) ? '.9rem' : '1.5rem';   
             
            if($userId != '')
            {
            $edit = ($userId == $row['posted_user']) ? '<li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="editPost('.$postId.')"><i class="fa-regular fa-edit"></i> Edit post</a></li>' : '';
            $del = ($userId == $row['posted_user']) ? '<li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="delPost('.$postId.')"><i class="fa-solid fa-trash"></i> Delete post</a></li>' : '';

            $status = $row['status'] == '0' ? '<span class="pending">Pending</span>' : '';
            }
         
            $tick = '';
            if($user['verification_code']=='101')
            $tick = "<img   src='$url/assets/images/tick.svg' class='tick'>";
            
            if($tick!='') $likeCount = rand(380,400);


            $post_url = $url.'post/'.removeSpcl(substr(strip_tags($row['content']),0,100)).'-'.$row['p_id'];
            
            $posts .= '<div class="news-feed news-feed-post post'.$postId.'">
                                        <div class="post-header d-flex justify-content-between align-items-center">
                                            <div class="image">
                                                <a href="profile/'.$user['metaname'].'">'.$profile.'</a>
                                            </div>
                                            <div class="info ms-3">
                                                <span class="name">
                                                 <a href="profile/'.$user['metaname'].'">'.$user['full_name'].'</a>
                                                '.$tick.'
                                                '.$status.'</span><br>
                                                <span class="cat_post">#'.str_replace(" ", "", $cat['name']).' </span>
                                                <span class="small-text">'.$time.'</span>
                                            </div>
                                            
                                            <div class="dropdown">
                                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flaticon-menu"></i></button>
                                                <ul class="dropdown-menu" style="">
                                                     '.$edit.'
                                                     '.$del.'
                                                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-link"></i> Share Post</a></li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                        <div class="post-body">
                                            
                                            <p class="postContent'.$postId.'" style="font-size:'.$font.'">'.$row['content'].'</p>
                                            '.$post_img.'
                                            '.$post_video.'
                                            <span style="display:none" class="postCat'.$postId.'">'.$row['cat_id'].'</span>
                                            <ul class="post-meta-wrap d-flex justify-content-between align-items-center">
                                                <li class="post-react">
                                                    <span class="post-like" onclick="likePost('.$postId.')"><i class="'.$like_icon.' fa-thumbs-up heart'.$postId.'"></i><span class="like'.$postId.'">'.$likeCount.' </span> Like </span>
                                                </li>
                                                <li class="post-comment">
                                                    <a href="javascript:;"><i class="flaticon-comment"></i><span>'.$countComment.' Comment</span> </a>
                                                </li>
                                                <li class="post-share">
                                                    <a href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-share"></i><span>Share</span></a>
                                                </li>
                                                
                                            </ul>
                                            <div class="post-comment-list clist'.$postId.'">
                                              '.$comments.'
                                                <div class="more-comments">
                                                    '.$moreComments.'
                                                </div>
                                            </div>
                                            <div class="post-footer">
                                              <div class="form-group">
                                                <textarea name="message" '.$cmtBoxI++.' data-post= '.$postId.' id="comment'.$postId.'" class="form-control" placeholder="Write a comment..."></textarea>
                                                <label class="post-comment" data-post='.$postId.'>Post</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
          }
          
          }else{
              $posts = '';
          }
 
  $data = array();
  $data['posts'] = $posts;
  $data['count'] = $countPost;
  $data['query'] = '';

  echo $form = json_encode($data);
}


if (isset($_GET['userPosts'])) {
    
   $user = $_GET['userPosts'];
   
   $query = "select * from com_posts where posted_user = '$user' and status = 1 order by p_id desc";
   $posts = "";

   $sql = mysqli_query($db, $query);

   $number_of_result = mysqli_num_rows($sql);
  
   $result = mysqli_query($db, $query);
     
   $countPost = mysqli_num_rows($result);
         
          if($countPost > 0) { 
           
            while ($row = mysqli_fetch_assoc($result)) {
              
            $time = timeago(date('Y-m-d H:i:s',$row['date_posted']));
        
            $postId = $row['p_id'];
        
            $cat = mysqli_fetch_assoc(mysqli_query($db, "select name from com_category where id='$row[cat_id]'"));
            $user = mysqli_fetch_assoc(mysqli_query($db, "select full_name,metaname,image,verification_code from users where id='$row[posted_user]'"));
            $like = mysqli_fetch_assoc(mysqli_query($db, "select count(*) as c from com_likes where post_id='$postId'"));
            $like_check = mysqli_num_rows(mysqli_query($db, "select l_id from com_likes where post_id='$postId' and user_id = '$userId'"));
           
            $likeCount = $like['c'];
            
            $likeCount = ($likeCount == 0) ? '' : $likeCount;
            $like_icon = ($like_check == 0) ? 'fa-regular' : 'fa-solid';
            
            $post_img = ($row['img'] != '') ? '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$row['img'].'" class="postImg'.$postId.'" ></div>' : '';
            
            $post_video = '';
            
            if($row['img'] != 'null' && $row['img'] != '') { 
        
            $img_s = json_decode($row['img'],true);
   
            if(is_array($img_s)) {
                    
                    if(count($img_s) > 1) { 
                        
                      $post_img = '<div class="swiper mySwiper " style="z-index:99999999;">
                        <div class="swiper-wrapper swiperWrapper'.$postId.'">';
                        foreach($img_s as $img){
                          $post_img .=' 
                            <div class="swiper-slide">
                             <img onerror="this.style.display=`none`" src="'.$img.'"/>
                            </div>';
                        }
                        
                         $post_img.=' </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                      </div>';
                    }
                    else{
                    $post_img = '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$img_s[0].'" class="postImg'.$postId.'" ></div>';
                     }
                 } else{
                    $post_img = '<div class="post-image"><img onerror="this.style.display=`none`" src="'.$img_s[0].'" class="postImg'.$postId.'" ></div>';
                }
      }
            else{
              
            }
        
            
            if ($row['posted_thumb']!='')
                $post_video = '<div class="vjs"><div class="bg-video" style="background-image:url('.$row['posted_thumb'].');"></div><video  controls muted="muted" ><source src="'.$row['img'].'" type="video/mp4"></video></div>';
            
            $profile = $l_url.'data/pro/'.$user['image'];
           
            $profile = "<img  src='$profile' onerror=this.onerror=null;this.src='https://community.jobaajlearnings.com/assets/images/avatar.png' class='rounded-circle'>";
            
            $font = (strlen($row['content']) > 85) ? '.9rem' : '1.5rem';   
             
            $tick = '';
            if($user['verification_code']=='101')
            $tick = "<img   src='$url/assets/images/tick.svg' class='tick'>";
            
            if($tick!='') $likeCount = rand(380,400);


            $post_url = $url.'post/'.removeSpcl(substr(strip_tags($row['content']),0,100)).'-'.$row['p_id'];
            
            $posts .= '<div class="news-feed news-feed-post post'.$postId.'">
                                        <div class="post-header d-flex justify-content-between align-items-center">
                                            <div class="info ms-3">
                                                <span class="name">
                                                 <a href="profile/'.$user['metaname'].'">'.$user['full_name'].'</a>
                                                '.$tick.'
                                                '.$status.'</span><br>
                                                <span class="cat_post">#'.str_replace(" ", "", $cat['name']).' </span>
                                                <span class="small-text">'.$time.'</span>
                                            </div>
                                            
                                            <div class="dropdown">
                                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flaticon-menu"></i></button>
                                                <ul class="dropdown-menu" style="">
                                                     '.$edit.'
                                                     '.$del.'
                                                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="showShare(`'.$post_url.'`)"><i class="fa-solid fa-link"></i> Share Post</a></li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                        <div class="post-body">
                                            
                                            <p class="postContent'.$postId.'" style="font-size:'.$font.'">'.$row['content'].'</p>
                                            '.$post_img.'
                                            '.$post_video.'
                                            
                                            <a style="color:#888" href="'.$post_url.'">show more....</a>
                                        </div>
                                    </div>';
          }
          
          }else{
              $posts = '';
          }
 
  $data = array();
  $data['posts'] = $posts;
  $data['count'] = $countPost;
  $data['query'] = '';

  echo $form = json_encode($data);
}
