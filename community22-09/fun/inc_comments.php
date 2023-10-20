<?php

        $cmt_query = mysqli_query($db,"select c.comment,c.added,u.full_name,u.verification_code,u.image,c.user_id,c.post_id,c.cmt_id from com_comments as c join users as u on c.user_id = u.id  where post_id = '$postId' and c.status = 1 order by c.cmt_id desc");
        $countComment = mysqli_num_rows($cmt_query);
        $countComment = ($countComment == 0) ? '' : $countComment;
           
            $comments = '';
          
            if($countComment > 0 ){
            $cmt = mysqli_fetch_assoc($cmt_query);
            
            $tick = '';
                  if($cmt['verification_code']=='101')
                  $tick = "<img  src='$url/assets/images/tick.svg' class='tick'>";
                
                if($tick!='') $likeCount = rand(380,400);


                $time2 = timeago(date('Y-m-d H:i:s',$cmt['added']));
    
                $pro = $l_url.'data/pro/'.$cmt['image']; 
                $pro = "<img  src='$pro' onerror=this.onerror=null;this.src='https://community.jobaajlearnings.com/assets/images/avatar.png' class='rounded-circle'>";
                $user_id = $cmt['user_id'];
                $commentor_id = $cmt['user_id'];
                $cmt_opts = '';
                
                $cmtId = $cmt['cmt_id'];
                $updateBox ='';
                
                if($userId == $find_user['posted_user'] && $userId !='') 
                  $cmt_opts = '<i onclick="delCmt('.$cmtId.')" class="fa-solid fa-trash delC"></i>';


                if($commentor_id == $userId && $userId != '') {
                    $cmt_opts = '<i onclick="editCmt('.$cmtId.')" class="fa-regular fa-edit editC"></i> <i onclick="delCmt('.$cmtId.')" class="fa-solid fa-trash delC"></i>';
                    $updateBox = '<p  class="updateBox'.$cmtId.' p2" onclick="updateCmt('.$cmtId.')">Update</p>';
                }
                //find user who posted the post for the same we are reading comments
                $find_user = mysqli_fetch_assoc(mysqli_query($db,"select posted_user from com_posts where p_id = '$cmt[post_id]'"));
                
                
                $comments.='<div class="comment-list cmt'.$cmtId.'">
                                <div class="comment-image">
                                    <a href="javascript:;">'.$pro.'</a>
                                </div>
                                <div class="comment-info">
                                    <h3>
                                        <a href="javascript:;">'.$cmt['full_name'].'</a> '.$tick.$cmt_opts.'
                                    </h3>
                                    <div class="single-comment">
                                    <p class="p1 editBox'.$cmtId.'">'.$cmt['comment'].'</p>
                                    '.$updateBox.'
                                    </div>
                                    <ul class="comment-react">
                                        <li><span>'.$time2.'</span></li>
                                        <li><span class="comment-reply"  data-post='.$postId.' data-comment='.$cmtId.'>Reply</span></li>
                                    </ul>
                                </div>';
                                
                                

 $cmt_reply_query = mysqli_query($db,"select c.comment,c.added,u.full_name,u.verification_code,u.image,c.user_id,c.post_id,c.r_id from com_comments_replies as c join users as u on c.user_id = u.id  where cmt_id = '$cmtId' and c.status = 1 order by c.cmt_id desc");
                                $countCommentReply = mysqli_num_rows($cmt_reply_query);
                                
                                if($countCommentReply > 0) { 
                                    
                                    $r_cmt = mysqli_fetch_assoc($cmt_reply_query);
                                    
                                    $time = timeago(date('Y-m-d H:i:s',$r_cmt['added']));
                                    
                                    $user_id = $r_cmt['user_id'];
                                    $commentor_id = $r_cmt['user_id'];
                                    $cmt_opts = '';
                                    
                                    $tick = '';
                                      if($r_cmt['verification_code']=='101')
                                      $tick = "<img  src='$url/assets/images/tick.svg' class='tick'>";
                                 
                                    
                                    $replyCmtId = $r_cmt['r_id'];
                                    $updateBox ='';
                                    
                                     if($userId == $find_user['posted_user'] && $userId !='') 
                                      $cmt_opts = '<i onclick="delCmt('.$cmtId.')" class="fa-solid fa-trash delC"></i>';
                    
                    
                                    if($commentor_id == $userId && $userId != '') {
                                          $cmt_opts = '<i onclick="delReplyCmt('.$replyCmtId.')" class="fa-solid fa-trash delC"></i>';
                                       // $cmt_opts = '<i onclick="editCmt('.$cmtId.')" class="fa-regular fa-edit editC"></i> <i onclick="delCmt('.$cmtId.')" class="fa-solid fa-trash delC"></i>';
                                       // $updateBox = '<p  class="updateBox'.$cmtId.' p2" onclick="updateCmt('.$cmtId.')">Update</p>';
                                    }
                                    
    
                                    $pro = $l_url.'data/pro/'.$r_cmt['image']; 
                                    $pro = "<img  src='$pro' onerror=this.onerror=null;this.src='https://community.jobaajlearnings.com/assets/images/avatar.png' class='rounded-circle'>";
                               
                                    $comments.='<div class="comment-list  comment-reply cmt-rep'.$replyCmtId.' ms-5 mt-2">  
                                                <div class="comment-image">             
                                                    <a href="javascript:;">'.$pro.'</a>
                                                </div>                             
                                                <div class="comment-info">                           
                                                    <h3>                                     
                                                        <a href="javascript:;">'.$r_cmt['full_name'].'</a> '.$tick.$cmt_opts.'                  
                                                    </h3>                                 
                                                    <p>'.$r_cmt['comment'].'</p>                                 
                                                    <ul class="comment-react">                                 
                                                      <li><span>'.$time.'</span></li>                               
                                                    </ul>                             
                                                </div>                        
                                     </div>';
                                 
                                }
                                 
                            $comments.='</div>';
            }else {
                $comments='';
            }
            
            
    if($countComment > 1){
            $lessCmt = $countComment - 1;
            $post_url = $url.'post/'.removeSpcl(substr(strip_tags($row['content']),0,100)).'-'.$row['p_id'];
            $moreComments = '<a href="'.$post_url.'">'.$lessCmt.' More Comments+</a>';
    
    }else{
        $moreComments ='';
    }
                                    
?>