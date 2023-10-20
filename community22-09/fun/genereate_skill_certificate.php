<?php

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

$user = $_GET['user'];
$test = $_GET['test'];

$current_date = date('d M Y');

$file = "certificate-" . $user . "-" . $test . ".jpeg";

if (file_exists("../certificates/" . $file) == 1)
    unlink("../certificates/" . $file);

$url = "https://comunity.jobaajlearnings.com/";

$u = mysqli_fetch_array(mysqli_query($db,"select full_name from users where id = '$user'"));
$name = $u['full_name'];

$course = mysqli_fetch_assoc(mysqli_query($db, "select title from TestCat where testId = '$test'"));

header('content-type:image/jpeg');
$font = "../data/font/DancingScript-Regular.ttf";
$font2 = "../data/font/Poppins-Medium.ttf";

$image = imagecreatefromjpeg("../data/certificate/cer.jpeg");

$color = imagecolorallocate($image, 19, 1, 12);

$courseName = $course['title'];

$details = " has successfully completed " . $courseName . " from Jobaaj Learnings";

$name_list = explode(" ",$name);
$elemCount = count($name_list);
$i=0;
$name = "";

foreach($name_list as $n){
    
    $name.=" ".$n;
    if($i>1)
        break;

    $i++;
}

$name = ucwords(strtolower($name));

$changeByLen = 205;

if(strlen($name)<7)
    $changeByLen = 0;

if(strlen($name)<=10)
    $changeByLen = 50;

if (strlen($name) > 13) {
    $changeByLen = 150;

    $fontSize = 120;
}
else { 
    $changeByLen = 75;
    $fontSize = 130;
}

$name = wordwrap($name, 70, "\n");

$details = wordwrap($details, 45, "\n");

// imagettftextcenter($image,200,900,1350,$color,$font,$name);

$pos = ImageTTFCenter($image, $name, $font, $fontSize);
imagettftextcenter($image, $fontSize, $pos[0]-$changeByLen, 750, $color, $font, $name);
imagettftextcenter($image, 20, 700, 850, $color, $font2, $details);

function ImageTTFCenter($image, $text, $font, $size, $angle = 45)
{
    $xi = imagesx($image);
    $yi = imagesy($image);

    $box = imagettfbbox($size, $angle, $font, $text);

    $xr = abs(max($box[2], $box[4]));
    $yr = abs(max($box[5], $box[7]));

    $x = intval(($xi - $xr) / 2);
    $y = intval(($yi + $yr) / 2);

    return array($x, $y);
}

function imagettftextcenter($image, $size, $x, $y, $color, $fontfile, $text)
{

    // Get height of single line
    $rect = imagettfbbox($size, 0, $fontfile, "Tq");
    $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
    $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));
    $h1 = $maxY - $minY;

    // Get height of two lines
    $rect = imagettfbbox($size, 0, $fontfile, "Tq\nTq");
    $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
    $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));
    $h2 = $maxY - $minY;

    // amount of padding that should be between each line
    $vpadding = $h2 - $h1 - $h1;

    // calculate the dimensions of the text itself
    $frect = imagettfbbox($size, 0, $fontfile, $text);
    $minX = min(array($frect[0], $frect[2], $frect[4], $frect[6]));
    $maxX = max(array($frect[0], $frect[2], $frect[4], $frect[6]));
    $text_width = $maxX - $minX;

    $text = explode("\n", $text);
    foreach ($text as $txt) {
        $rect = imagettfbbox($size, 0, $fontfile, $txt);
        $minX = min(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $maxX = max(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));

        $width = $maxX - $minX;
        $height = $maxY - $minY;

        $_x = $x + (($text_width - $width) / 2);

        imagettftext($image, $size, 0, $_x, $y, $color, $fontfile, $txt);
        $y += ($height + $vpadding);
    }

    return $rect;
}

$fontD = "../data/font/n-regular.otf";
$url = "https://community.jobaajlearnings.com/" . $file;
$certificate_url = "https://comunity.jobaajlearnings.com/certificateqr/" . $file;
imagettftext($image, 30, 0, 490, 1050, $color, $font, $current_date);
$QR = imagecreatefromstring(file_get_contents("https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl=" . urlencode($certificate_url)));
imagecopyresampled($image, $QR, 920, 1190, 0, 0, 170, 170, 120, 120);

// imagejpeg($image);
imagejpeg($image, "../certificates/$file");

imagedestroy($image);




