<?php
require('../db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['programEdit'])){
   
    $req = array();
    foreach($_POST['pro'] as $r) {
        if($r!=''){
            $t = str_replace("'","\'",$r['title']);
            $req[$t] = str_replace("'","\'",$r['project']);
        }
    }
    
    $req = json_encode($req);
    
    
    $tools = array();
    foreach($_FILES["tools"]["tmp_name"] as $key=>$tmp_name) {
        
            $file_name=$_FILES["tools"]["name"][$key];
            $file_tmp=$_FILES["tools"]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);

            $filename=basename($file_name,$ext);
            $newFileName=$filename.time().".png";
            move_uploaded_file($file_tmp=$_FILES["tools"]["tmp_name"][$key],"../../data/tools/".$newFileName);
    
    $tools[] = $newFileName;

    }
    $tools = json_encode($tools);
    
    
    $skills = array();
    foreach($_POST['skill'] as $r) {
        if($r!='')
         $skills[$r['title']] = str_replace("'","\'",$r['desc']);
    }
    
    $skills = json_encode($skills);
    
    
        $ed1 = str_replace("'","\'",$_POST['editor1']);
        $ed1 =  preg_replace('/\s+/', ' ', $ed1);
        
        $ed2 = str_replace("'","\'",$_POST['editor2']);
        $ed2 =  preg_replace('/\s+/', ' ', $ed2);
       
        
        $ed3 = str_replace("'","\'",$_POST['editor3']);
        $ed3 =  preg_replace('/\s+/', ' ', $ed3);
        
       
        $ed4 = str_replace("'","\'",$_POST['editor4']);
        $ed4 =  preg_replace('/\s+/', ' ', $ed4);
       
    
    
    $thumb="";
    $thumbPath="";
    if($_FILES['course_thumbnail']['name']!=''){
    $thumb = $_FILES['course_thumbnail']['name'];
    $thumbPath = $_FILES['course_thumbnail']['tmp_name'];
    $thumb = time()."thumb-programe.jpg";
    } else {
        $thumb = $_POST['x_thumb'];
    }
    
     
    $cover="";
    $coverPath="";
    if($_FILES['course_cover']['name']!=''){
    $cover = $_FILES['course_cover']['name'];
    $coverPath = $_FILES['course_cover']['tmp_name'];
    $cover = time()."cover-course.jpg";
    } else {
         $cover = $_POST['x_cover'];
    }
    
    
     
    $doc="";
    $docPath="";
    if($_FILES['course_doc']['name']!=''){
    $doc = $_FILES['course_doc']['name'];
    $docPath = $_FILES['course_doc']['tmp_name'];
    $doc = time()."doc-syllabus.pdf";
    } else {
        $doc = $_POST['x_doc'];
    }
    
    
    $title = str_replace("'","\'",$_POST['title']);
    $short = str_replace("'","\'",$_POST['short']);
    $desc = str_replace("'","\'",$_POST['editor0']); 
    
    $date = time();
    
     $query = mysqli_query($db,"update programmes set  title = '$title', cover = '$cover', overview = '$_POST[course_overview_url]', 
    thumb = '$thumb', short_desc = '$short', what_you_get='', total_hours ='$_POST[hours]', skills='$skills', total_case = '$_POST[case]',
    duration='$_POST[duration]', prog1='$ed1', prog2='$ed2', prog3='$ed3', prog4='$ed4', tools = '$tools', content_cer = '$desc', industry_project = '$req', syllabus ='$doc', price = '$_POST[price]', dis_price = '$_POST[discounted_price]' 
    where id = '$_POST[pro_id]'");
    
   $pid = $_POST['pro_id'];
   
    
    $del = mysqli_query($db,"delete from syllabus_program where prog_id = '$pid'");
  
    
    if($query){
        
        $i=0;
        $sec = "";
        foreach($_POST['course'] as $course){
            $sec = "";
            $j = 0;
            while(sizeof($_POST['item'][$i])!=$j) {
              $sec.= $_POST['item'][$i][$j].",";
              $j++;
            }
            
            $sec = trim($sec,",");
            
          $ss = mysqli_query($db,"INSERT INTO `syllabus_program` (`id`, `course`, `sections`, `prog_id`) VALUES (NULL, '$course', '$sec', '$pid');");
        $i++;    
      
        }
        
        move_uploaded_file($thumbPath, "../../data/thumb/".$thumb);
        move_uploaded_file($docPath, "../../data/syllabus/".$doc);
        move_uploaded_file($coverPath, "../../data/cover/".$cover);
        echo header('Location:../allProgram');

    }else{
        
        echo mysqli_error($db);
    }
    
    
    
    
}
    

if(isset($_POST['programAdd'])){
    
    
    $what_get = array();
    foreach($_POST['what'] as $w) {
        if($w!=''){
            $t = str_replace("'","\'",$w['title']);
            $what_get[$t] = str_replace("'","\'",$w['text']);
        }
    }
    
    $what_get = json_encode($what_get);
    
    
    $course_for = array();
    foreach($_POST['course'] as $w) {
        if($w!=''){
            $t = str_replace("'","\'",$w['title']);
            $course_for[$t] = str_replace("'","\'",$w['text']);
        }
    }
    
    $course_for = json_encode($course_for);
    
    
     $req = array();
    foreach($_POST['pro'] as $r) {
        if($r!=''){
            $t = str_replace("'","\'",$r['title']);
            $req[$t] = str_replace("'","\'",$r['project']);
        }
    }
    
    $req = json_encode($req);
    
    
    
    $tools = array();
    foreach($_FILES["tools"]["tmp_name"] as $key=>$tmp_name) {
        
            $file_name=$_FILES["tools"]["name"][$key];
            $file_tmp=$_FILES["tools"]["tmp_name"][$key];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);

            $filename=basename($file_name,$ext);
            $newFileName=$filename.time().".png";
            move_uploaded_file($file_tmp=$_FILES["tools"]["tmp_name"][$key],"../../data/tools/".$newFileName);
    
    $tools[] = $newFileName;
    
    }
    $tools = json_encode($tools);
    
    
    
    $skills = array();
    foreach($_POST['skill'] as $r) {
        if($r!='')
         $skills[$r['title']] = str_replace("'","\'",$r['desc']);
         
    }
    
    $skills = json_encode($skills);
    
    
        $ed1 = str_replace("'","\'",$_POST['editor1']);
        $ed1 =  preg_replace('/\s+/', ' ', $ed1);
        
        $ed2 = str_replace("'","\'",$_POST['editor2']);
        $ed2 =  preg_replace('/\s+/', ' ', $ed2);
       
        
        $ed3 = str_replace("'","\'",$_POST['editor3']);
        $ed3 =  preg_replace('/\s+/', ' ', $ed3);
        
       
        $ed4 = str_replace("'","\'",$_POST['editor4']);
        $ed4 =  preg_replace('/\s+/', ' ', $ed4);
        
        
    
    
    $thumb="";
    $thumbPath="";
    if($_FILES['course_thumbnail']['name']!=''){
    $thumb = $_FILES['course_thumbnail']['name'];
    $thumbPath = $_FILES['course_thumbnail']['tmp_name'];
    $thumb = time()."thumb-programe.jpg";
    }
    
     
    $cover="";
    $coverPath="";
    if($_FILES['course_cover']['name']!=''){
    $cover = $_FILES['course_cover']['name'];
    $coverPath = $_FILES['course_cover']['tmp_name'];
    $cover = time()."cover-course.jpg";
    }
    
    
    
    
     
    $doc="";
    $docPath="";
    if($_FILES['course_doc']['name']!=''){
    $doc = $_FILES['course_doc']['name'];
    $docPath = $_FILES['course_doc']['tmp_name'];
    $doc = time()."doc-syllabus.pdf";
    }
    
    
    $title = str_replace("'","\'",$_POST['title']);
    $short = str_replace("'","\'",$_POST['short']);
    $desc = str_replace("'","\'",$_POST['editor1']); 
    
    $date = time();
  
   $query = mysqli_query($db,"INSERT INTO `programmes` (`id`, `title`, `cover`, `overview`, `thumb`, `short_desc`, `what_you_get`, `course_for`, `total_hours`, `skills`, `total_case`, `duration`, `prog1`, `prog2`, `prog3`, `prog4`, `tools`, `content_cer`, `industry_project`, `date_added`, `pro_type`, `syllabus`, `price`, `dis_price`, `status`)
    VALUES (NULL, '$title', '$cover',  '$_POST[course_overview_url]', '$thumb', '$short', '$what_get', '$course_for', '$_POST[hours]', '$skills', '$_POST[case]', '$_POST[duration]', '$ed1', '$ed2', '$ed3', '$ed4', '$tools', '$desc', '$req', '$date', 'programe', '$doc',
    '$_POST[price]', '$_POST[discounted_price]', '1');");
    
     $pro_id = mysqli_fetch_array(mysqli_query($db,"select * from programmes order by id desc limit 0,1"));
      $pid = $pro_id['id'];
    
    
    if($query){
        
        move_uploaded_file($thumbPath, "../../data/thumb/".$thumb);
        move_uploaded_file($docPath, "../../data/syllabus/".$doc);
        move_uploaded_file($coverPath, "../../data/cover/".$cover);
        echo header('Location:../allProgram');

    }else{
        
        echo mysqli_error($db);
    }
    
    
    
    
    
    
}



if(isset($_POST['updateSyllabus'])){
    
    $pid = $_POST['pid'];
    
    $del = mysqli_query($db,"delete from syllabus_program where prog_id = '$pid'");

    $i=0;
        $sec = "";
        foreach($_POST['course'] as $course){
            $sec = "";
            $j = 0;
            while(sizeof($_POST['item'][$i])!=$j) {
              $sec.= $_POST['item'][$i][$j].",";
              $j++;
            }
            
            $sec = trim($sec,",");
            
          $ss = mysqli_query($db,"INSERT INTO `syllabus_program` (`id`, `course`, `sections`, `prog_id`) VALUES (NULL, '$course', '$sec', '$pid');");
        $i++;    
      
        }
        
         echo "<script>location.href='../changeSyllabus?edit_id=$pid';</script>";
    
}




if(isset($_POST['addCourse'])){
    
    $add = mysqli_query($db,"INSERT INTO `section` (`id`, `title`, `course_id`, `order`) VALUES (NULL, '$_POST[addSection]', '$_POST[c_id]', '0');");
    
    if($add) {
        echo 1;
    }
    else  { echo 0; }
    
}



if(isset($_POST['addQuiz'])){
    
    $cid = $_POST['c_id'];
    $date = time();
    $add = mysqli_query($db,"INSERT INTO `lesson` (`id`, `title`, `duration`, `course_id`, `section_id`, `video_type`, `video_url`, `date_added`, `lesson_type`, `attachment`, `summary`, `is_free`, `order`)
                        VALUES (NULL, '$_POST[addQuiz]', '0', '$cid', '$_POST[s_id]', '', '', '$date', 'quiz', '', '$_POST[summary]', '0', '0');");
   
    if($add) {
        echo 1;
    }
    else  { echo mysqli_error($db); }
    
}



if(isset($_POST['addLesson'])){
    
    
    if(isset($_FILES['source']))
        {
            $thumb = $_FILES['source']['name'];
            $thumbpath = $_FILES['source']['tmp_name'];
            
            $rand = rand(100,999);
            $thumb = $rand.$thumb;
        }
        
    $type= $_POST['lesson_type'];
    
        if($type=='youtube' || $type=='vimeo'){
           $url = $_POST['video_url'];
        }else if($type=='iframe'){
             $url = $_POST['iframe_url']; 
        }
            
    $cid = $_POST['course_id'];
    $date = time();
    $add = mysqli_query($db,"INSERT INTO `lesson` (`id`, `title`, `duration`, `course_id`, `section_id`, `video_type`, `video_url`, `date_added`, `lesson_type`, `attachment`, `summary`, `is_free`, `order`)
                        VALUES (NULL, '$_POST[title]', '$_POST[duration]', '$cid', '$_POST[section_id]', '$type', '$url', '$date', '$_POST[lesson_type]', '$thumb', '$_POST[editor2]', '0', '0');");
    
    if($add) {
        move_uploaded_file($thumbpath, "../../data/lesson/".$thumb);
        echo "<script>location.href='../editCourse?edit_id=$cid';</script>";
    }
    else  { echo 0; }
    
}

if(isset($_FILES['imgfile']['name'])){
    $c_date = date("Y-m-d H:i:s");
    
    $url = "https://stories.jobaaj.com/files/manage/assets/images/";
  
    $pro = $_FILES['imgfile']['name'];
    $proU = $url.$_FILES['imgfile']['name'];
  
    $proPath = $_FILES['imgfile']['tmp_name'];
  
    // echo $pro;
  
    if($pro != ''){
      $q = mysqli_query($db, "INSERT INTO `upload_images`(`id`,`name`,`upload_at`) VALUES(NULL,'$proU','$c_date')");
      if($q){
        if(move_uploaded_file($proPath, "../assets/images/".$pro)){
          echo 1;
        }
        else{
          echo 2;
        }
      }else{
        echo 3;
      }
    }else{
      echo 4;
    }
  }
  
  if(isset($_POST['deleteimg'])){
    $imgid = $_POST['imgid'];
    $q = mysqli_query($db, "DELETE FROM `upload_images` WHERE `id`='$imgid'");
    if($q){
      echo 1;
    }else{
      echo 2;
    }
  }
