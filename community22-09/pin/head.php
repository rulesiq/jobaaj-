<?php require('config.php');

function timeago($datetime, $full = false)
{

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


if ($user['image'] != '')
    $profile = $l_url . 'data/pro/' . $user['image'];
else
    $profile = $l_url . '/assets/images/avatar.png';


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MVJFH5TQ');
    </script>
    <!-- End Google Tag Manager -->



    <!-- Links of CSS files -->
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/animate.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/remixicon.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/simplebar.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/metismenu.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $url; ?>assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <meta name="robots" content="index,follow">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <?php
    if (isset($_GET['post'])) {

        $slug = explode("-", $_GET['post']);

        $postId = end($slug);

        $postD = mysqli_fetch_assoc(mysqli_query($db, "select 
                                                                u.full_name,
                                                                c.content,
                                                                c.posted_thumb,
                                                                c.status,
                                                                c.posted_user,
                                                                c.img
                                                                from com_posts c 
                                                                join users u 
                                                                on u.id = c.posted_user 
                                                                where c.p_id = '$postId'"));

        $status = $postD['status'];
        $postExist = true;
        if (!isset($_GET['admin'])) {

            if ($user['id'] != '') {

                if ($user['id'] != $postD['posted_user']) {

                    if ($status != '1') {
                        echo "<script>location.href='/';</script>";
                    }
                }
            } else {
                if ($status != '1') {
                    $postExist = false;
                    //echo "<script>alert('dd');location.href='/';</script>";
                }
            }
        }

        $content = ucfirst(substr(strip_tags($postD['content']), 0, 200)) . "....";
        $ogTitle = ucfirst(substr(strip_tags($postD['content']), 0, 100)) . "....";
        $title = $postD['full_name'] . " on Community : " . ucfirst($ogTitle);

        $p_img = $postD['img'];
        $post_img = ($p_img != '') ? $p_img : 'https://community.jobaajlearnings.com/assets/images/og.jpeg';

        if ($p_img != 'null' && $p_img != '') {

            $img_s = json_decode($p_img, true);

            if (is_array($img_s)) {

                if (count($img_s) > 0)
                    $post_img = $img_s[0];
            }
        }

        if (str_contains($post_img, 'vid')) {
            $post_img = $postD['posted_thumb'];
        }

    ?>

        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $content; ?>">
        <meta name="keywords" content="<?php echo "Community Jobaajlearnings,Jobaaj,Jobaajelarnings"; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- STYLES -->

        <?php $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
        <!-- OG Type -->
        <meta property="og:title" content="<?php $title; ?>" />
        <meta property="og:description" content="<?php echo $content; ?>" />
        <meta property="og:image" content="<?php echo $post_img; ?>" />
        <meta property="og:url" content="<?php echo $actual_link; ?>" />
        <meta property="og:type" content="Article" />
        <meta name="description" content="<?php echo $content; ?>">
        <meta name="author" content="Jobaaj Learnings Community">
        <link rel="canonical" href="<?php echo $actual_link; ?>" />

    <?php } else if (isset($_GET['user']) && $_SESSION['learner_id'] != '' && $_SESSION['learner_id'] == $_GET['user']) {

        $userId = mysqli_real_escape_string($db, $_GET['user']);
        $find_user = mysqli_query($db, "select * from users where metaname = '$userId'");
        if (mysqli_num_rows($find_user) > 0) {
            $user = mysqli_fetch_assoc($find_user);
        } else {
            echo "<script>location.href='/'</script>";
        }

    ?>

     <title><?php echo ucfirst($user['full_name']); ?> - Jobaaj Learnings | Upskill every second - Login or Signup </title>

    <?php  } else if (isset($_GET['user'])) {

        $userId = mysqli_real_escape_string($db, $_GET['user']);
        $find_user = mysqli_query($db, "select * from users where metaname = '$userId'");
        if (mysqli_num_rows($find_user) > 0) {
            $user_pro = mysqli_fetch_assoc($find_user);
        } else {
            echo "<script>location.href='/'</script>";
        }

    ?>

        <title><?php echo ucfirst($user_pro['full_name']); ?> - Jobaaj Learnings | Upskill every second - Login or Signup </title>


    <?php } else {

    ?>

        <title>Community - Jobaaj Learnings | Upskill every second - Login or Signup </title>


        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo "1 lakh+ active members | Upskilling individuals at every step. Building a learning community, for Accessing and Sharing Knowledge and Insights."; ?>">
        <meta name="keywords" content="<?php echo "Community Jobaajlearnings,Jobaaj,Jobaajelarnings"; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <?php $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
        <!-- OG Type -->
        <meta property="og:title" content="Community - Jobaaj Learnings | Upskill every second " />
        <meta property="og:description" content="<?php echo "1 lakh+ active members | Upskilling individuals at every step. Building a learning community, for Accessing and Sharing Knowledge and Insights."; ?>" />
        <meta property="og:image" content="<?php echo $url . "assets/images/community.jpeg"; ?>" />
        <meta property="og:url" content="<?php echo $actual_link; ?>" />
        <meta property="og:type" content="Article" />
        <meta name="description" content="<?php echo ""; ?>">
        <meta name="author" content="Jobaaj Learnings Community">
        <link rel="canonical" href="<?php echo $actual_link; ?>" />


    <?php } ?>

    <link rel="apple-touch-icon" sizes="180x180" href="https://cdn.nishtyainfotech.com/learnings/assets/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://cdn.nishtyainfotech.com/learnings/assets/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://cdn.nishtyainfotech.com/learnings/assets/favicon.png">
    <link rel="manifest" href="https://cdn.nishtyainfotech.com/learnings/assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="https://cdn.nishtyainfotech.com/learnings/assets/favicon/safari-pinned-tab.svg" color="#6366f1">
    <link rel="shortcut icon" href="https://cdn.nishtyainfotech.com/learnings/assets/favicon.png">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MVJFH5TQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <style>
        .tranding {
            box-shadow: 0 8px 10px 0 rgba(183, 192, 206, 0.1);
            background: #ffffff40;
        }

        .tranding a {
            font-size: 1rem;
            font-weight: 600;
            color: #4050b5
        }

        .tranding .cat {
            font-size: .7rem;
            font-weight: 500;
        }

        .tranding .view {
            font-size: .6rem;
            font-weight: 500;
        }

        .right-sidebar-area {
            z-index: 11111111111111;
            background: white;
        }

        .content-page-box-area {
            margin-top: 2rem;
        }

        .post-like {
            cursor: pointer;
        }

        .post-like i {
            font-size: 1.2rem !important;
        }

        .go-top {
            z-index: 111111;
        }

        .icon {
            width: .8rem;
        }

        .news-feed-area .news-feed-post .post-body .post-comment-list .comment-list .comment-image img {
            max-width: 2.5rem;
        }

        .comment-info a {
            font-size: .8rem;
        }

        .nav-item label {
            margin: 1rem 0px;
            display: flex;
        }

        .nav-item label input {
            margin-right: 10px;
        }

        .nav-item label .icon {
            margin-right: 4px;
        }

        .sidemenu-nav .nav-item {
            margin-bottom: 19px;
        }

        .news-feed-area .news-feed-form form .button-group button {
            background-color: transparent;
            border: none;
            font-size: 13px !important;
        }

        .news-feed-area .news-feed-form form .button-group i {
            color: #1CCD16;
            font-size: 17px !important;
        }

        .comment-reply {
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
        }

        .reply-box {
            margin-left: 6rem;
            margin-top: -1rem;
        }

        .post-comment {
            cursor: pointer;
        }

        .news-feed-area .news-feed-post .post-body .post-comment-list .comment-list .comment-info .comment-react {
            padding: 0;
            margin-bottom: 0;
            margin-top: 0px !important;
        }

        .comment-react li {
            margin-top: .5rem !important;
        }

        .news-feed-area .news-feed-post .post-body .post-comment-list .comment-list .comment-info {
            margin-left: 60px;
            padding: 0.6rem !important;
            border-radius: 0.5rem;
            border-top-left-radius: 0rem;
            background-color: #dddddd;
        }

        .main-content-wrapper .navbar-area {
            z-index: 999999990;
        }

        .react-now img {
            width: 1rem;
        }

        .news-feed-area .news-feed-post .post-header .info {
            width: 612px;
        }

        .swiper-button-next,
        .swiper-button-prev {
            background: #000000a3;
            border-radius: 5rem;
            width: 1.7rem !important;
            height: 1.7rem !important;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-family: swiper-icons;

            color: #fff;
            width: 0.6rem;
            font-size: .9rem !important;

        }

        .swiper-button-next:after {
            width: 0.4rem;
        }

        .main-content-wrapper .navbar-area .main-navbar .navbar .others-options .option-item .notifications-nav-item .notifications-btn span {
            position: absolute;
            top: -2px;
            right: -5px;
            display: block;
            width: 9px;
            height: 9px;

        }


        .news-feed-area .news-feed-post .post-header .info .small-text {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: var(--paragraph-color);
            margin-top: 1px;
        }

        .post-cat {
            background: #666666;
            color: #fff;
            margin-top: .2rem;
            font-size: .7rem;
            border-radius: 0.5rem;
            padding: 0rem 0.2rem;
        }

        .post-elements {
            display: flex;
            padding-right: 20px;
            justify-content: space-evenly;

        }

        .post-elements i {
            width: 1.4rem;
            margin: 5px 10px;
            height: 1.3rem;
            font-size: 1.2rem;
        }

        .post-elements .fa-image {
            color: #1CCD16;
        }


        .post-elements .fa-file-image {
            color: #FF3E3E;
        }


        .post-elements .fa-award {
            color: #3644D9;
        }

        .sidemenu-area .sidemenu-body .sidemenu-nav .nav-item .nav-link .icon {
            -webkit-transition: var(--transition);
            transition: var(--transition);
            display: inline-block;
            height: 14px;
            width: 21px;
            line-height: 10px;
            background-color: #F4F7FC;
            color: var(--black-color);
            font-size: 18px;
            text-align: center;
            border-radius: 8px;
            position: absolute;
            left: 0;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }


        .sidemenu-area {
            position: static;
        }

        .loader {
            border: 2px solid #777;
            border-radius: 50%;
            border-top: 2px solid #444;
            width: 50px;
            height: 50px;
            -webkit-animation: spin 1s linear infinite;
            /* Safari */
            animation: spin 1s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        .editC,
        .delC {
            font-size: .7rem;
            margin-left: .4rem;
            cursor: pointer;
        }

        .fa-ellipsis:hover {
            background-color: #9999995c;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .news-feed-area .news-feed-post .post-body .post-comment-list .comment-list .comment-info .comment-react {
            padding: 0;
            margin-bottom: 0;
            margin-top: 6px;
        }


        .news-feed-area .news-feed-post .post-body .post-comment-list .comment-list .comment-info span {
            color: var(--paragraph-color);
            display: inline-block;
            margin-top: -7px;
            margin-bottom: 0px;
            font-size: 10px;
            font-weight: 600;
        }


        #showPost,
        #showCategory,
        #showUpdate,
        #showLogin,
        #showShare {
            z-index: 1111111111;
            background-color: #ffffffd6;
            /*-webkit-filter: blur(4px);*/
            /*-moz-filter: blur(4px);*/
            /*-o-filter: blur(4px);*/
            /*-ms-filter: blur(4px);*/
            /*filter: blur(4px);*/
            /*filter: url("https://gist.githubusercontent.com/amitabhaghosh197/b7865b409e835b5a43b5/raw/1a255b551091924971e7dee8935fd38a7fdf7311/blur".svg#blur);*/
            /*filter:progid:DXImageTransform.Microsoft.Blur(PixelRadius='4');*/
        }

        .news-feed-area .news-feed-post .post-body .post-footer .form-group {
            position: relative;
            padding-left: 0px;
        }

        .news-feed-area .news-feed-post .post-body p {
            margin-bottom: 20px;
            color: #424242;
        }

        .modal-dialog {
            top: 16%;
        }

        #showDialog .modal-dialog {
            top: 8%;
        }

        .modal-title {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .post-name {
            display: block;
            color: #222;
            font-weight: 600;
        }

        .main-content-wrapper .navbar-area .main-navbar .navbar {
            width: 95%;
        }

        .news-feed-area .news-feed-form form .form-group .form-control {
            background-color: #F4F7FC;
            border: 1px solid #F4F7FC;
            padding: 10px 15px !important;
            font-size: 15px !important;
        }

        textarea {
            resize: none;
        }

        .rounded-circle {
            height: 50px;
            width: 50px;
            max-width: 50px !important;
        }

        .nav-link-active .icon {
            color: #fff !important;
        }

        .nav-link-active .menu-title {
            color: #3644d9;
        }

        .main-content-wrapper {
            -webkit-transition: var(--transition);
            transition: var(--transition);
            overflow: hidden;
            background-color: #f3f2ef;
            min-height: 100vh;
            padding-top: 100px;
            padding-left: 175px;
            padding-right: 135px;
            padding-bottom: 50px;
        }

        .main-content-wrapper .navbar-area .main-navbar .navbar .search-box {
            position: relative;
            width: 430px;
            margin-left: 8.5rem !important;
        }
        }

        .post-editor {
            font-size: 1.2rem;
            height: 8rem;

            padding: 0px;
            border: none;
        }

        .img-box {
            display: none;
        }

        .img-upload {
            width: 100%;
            height: 13rem;
            border-radius: 1rem;
            margin: 13px 0px;
            top: 17%;
            align-items: center;
            background: #f4f4f480;
            flex-direction: column;
            justify-content: center;
            display: flex;

        }

        .img-selected {
            width: 100%;
            height: auto;
            border-radius: .3rem;
            top: 17%;
            align-items: center;
            background: #f4f4f480;
            flex-direction: column;
            justify-content: center;
            display: flex;

        }

        .post-loader {
            width: 100%;
            height: 21rem;
            margin: 0 auto;
            top: 17%;
            display: none;
            align-items: center;
            background: #f4f4f480;
            flex-direction: column;
            position: absolute;
            justify-content: center;
        }

        .post-image {
            text-align: center;
        }

        .news-feed-area .news-feed-post .post-header .image a img {
            max-width: 53px;
        }

        .simplebar-content {
            padding: 40px 15px !important;
        }

        .react-list li a img {

            width: 1.4rem;

        }

        #img-preview {
            margin: 10px 0px;
            display: flex;
            flex-wrap: wrap;
            height: 15rem;
            justify-content: space-around;
            flex-direction: row;
        }

        .news-feed-area .news-feed-post .post-body .post-footer .form-group .form-control {
            background-color: #F4F7FC;
            border: 0px solid #F4F7FC;
            padding: 9px 17px;
            color: var(--paragraph-color);
            height: 40px;
            font-size: 13px;
        }

        .news-feed-area .news-feed-post .post-body .post-footer .footer-image a img {
            max-width: 45px;
        }



        :focus {
            box-shadow: none !important;
        }

        *[data-focus] {
            box-shadow: none !important;
        }





        .main-content-wrapper .navbar-area .main-navbar .navbar .search-box .input-search {
            height: 41px;
            border-radius: 8px;
            background-color: #969696 !important;
        }

        .modal-body {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }

        .sidemenu-area .sidemenu-body {
            max-height: calc(100% - 40px);
        }

        .sidemenu-area .sidemenu-body {
            max-height: calc(100% -100px);
        }


        .main-content-wrapper .navbar-area .main-navbar {
            padding: 10px;
        }

        .main-content-wrapper .navbar-area .main-navbar .navbar .search-box .input-search {
            height: 41px;

        }

        .main-content-wrapper .main-responsive-nav .main-responsive-menu {
            position: absolute;
            right: 50px;
            top: 12px;
        }

        .sidemenu-area .sidemenu-body .sidemenu-nav .nav-item {
            margin-bottom: 19px;
        }


        .sidemenu-body .sidemenu-nav .nav-item:hover .nav-link .icon {
            background-color: transparent !important;
        }

        .sidemenu-area .sidemenu-body {
            max-height: 350px !important;
        }

        .main-content-wrapper .navbar-area .main-navbar .navbar .others-options .option-item .profile-nav-item .dropdown-bs-toggle::before {
            display: none !important;
        }

        #arrowBtn {
            height: 35px;
            width: 35px;
            margin-left: 10px;
            border-radius: 25px;
            padding: 5px;
        }

        .right-size2 {
            right: 1px !important;
        }

        .sidemenu-area .sidemenu-body {
            max-height: calc(100% - 0px);
        }

        .main-content-wrapper .main-responsive-nav .main-responsive-menu .responsive-burger-menu span {
            background: #222;
        }

        .right-sidebar-area {
            position: fixed;
            right: 0px;
            top: 1rem;
            height: 100%;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
            width: 300px;
            max-height: calc(100% - 0px);

        }


        .right-size {
            right: -300px !important;
        }


        .name {
            color: #222 !important;
        }

        .main-navbar {
            background-color: #fff;
        }

        .navbar-area .main-navbar .navbar .search-box button {
            position: absolute;
            right: 0;
            top: -2px !important;
        }

        .main-content-wrapper .main-responsive-nav .main-responsive-menu {
            position: absolute;
            right: 15px;
            top: 12px;
        }

        .loginPopup {
            max-width: 30%;
            top: 20%;
        }

        .shareDialog {
            max-width: 386px;
            top: 20%;
        }

        .fw-bold {
            font-weight: 600 !important;
        }

        .main-content-wrapper .navbar-area .main-navbar .navbar .others-options .option-item .profile-nav-item .menu-profile img {
            width: 35px;
            height: 35px;
            display: inline-block;
            margin-right: 8px;
        }



        .input-search {
            font-size: .9rem !important;

            background-color: #555555 !important;
            padding: 2px 6px 5px 18px !important;
        }

        .main-content-wrapper .navbar-area .main-navbar .navbar .others-options .option-item .notifications-nav-item .notifications-btn i {
            color: #7d7d7d;
            font-size: 25px;
        }

        .sidemenu-area {
            top: 3rem;
        }

        .dot-menu {
            display: none;
        }

        .search-mobile {
            display: none;
        }

        .search-mobile ::placeholder {
            color: #fff;
        }

        .search-mobile .input-search {
            display: block;
            width: 170px;

            border: none;
            border-radius: 50px;
            background-color: #2E3AB8;
            -webkit-transition: var(--transition);
            transition: var(--transition);
            color: var(--white-color);
            font-size: var(--font-size);
            font-weight: 400;
            padding: 0 0 0 16px;
            -webkit-box-shadow: none;
            box-shadow: none;
            outline: 0;
            font-size: .8rem;
            height: 35px;
            border-radius: 8px;
            background-color: #969696 !important;
        }

        .search-mobile button {
            position: absolute;
            right: 94px;

            top: 1.5px;
            height: 50px;
            background-color: transparent;
            border: none;
            color: var(--white-color);
            border-radius: 5px;
            font-size: 18px;
            padding: 0 20px;
        }

        .main-content-wrapper .main-responsive-nav {
            display: block;
        }

        .news-feed-area .news-feed-post .post-body .post-comment-list .comment-list .comment-info {
            padding-left: 61px;
        }

        .side_home {
            display: block;
        }

        .postDialog {
            max-width: 50% !important;
        }

        @media only screen and (max-width: 767px) {
            .main-content-wrapper {
                padding-top: 0px;
                padding-left: 5px;
                padding-right: 5px;
            }


            .postDialog {
                max-width: 100% !important;
            }


            .side_home {
                display: none;
            }

            .news-feed-area .news-feed-post .post-body .post-meta-wrap {
                margin-top: 25px;
                padding: 6px;
                border-top: 1px solid #eeeeee;
                border-bottom: 1px solid #eeeeee;
                margin-bottom: 0;
            }



            .news-feed-area .news-feed-post .post-body .post-meta-wrap .post-react {
                width: 81px !important;
            }


            .sidemenu-area {
                display: block !important;
            }

            .sidemenu-area {
                position: fixed;
            }


            .loginPopup {
                max-width: 100%;
                top: 20%;
            }

            .shareDialog {
                max-width: 370px;
                top: 8%;
            }

            .main-content-wrapper .navbar-area .main-navbar {
                display: none;
            }

            .news-feed-area .news-feed-form form .button-group.d-flex {
                display: flex !important;
            }

            .sidemenu-area {
                display: none;
            }

            .search-mobile {
                padding-top: 10px;
                background: #fff;
                display: flex;
                position: fixed;
                z-index: 111111111;
            }

            .main-content-wrapper .main-responsive-nav {}

            .news-feed-area .news-feed-form form .button-group li button {
                font-size: 12px;
                padding-left: 25px !important;
            }

            .notifications-body .simplebar-content {
                padding-top: 1rem !important;
            }

            .profile-notify {
                height: 40px !important;
                width: 40px !important;
                max-width: 40px !important;
            }
    </style>

    <style>
        .single-comment {
            display: flex;
            justify-content: space-between;
        }

        .news-feed-area .news-feed-post .post-body .post-comment-list .comment-list .comment-info span {
            font-size: 9px;
        }

        .single-comment .p1 {
            flex: 1;
            padding-left: .1rem;
            margin-right: 1rem;
        }


        .single-comment .p2 {
            font-size: .7rem !important;
            font-weight: 600;
            max-width: 2rem;
            line-height: 23px;
            display: none;
            cursor: pointer;
        }

        .pimg {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-family: swiper-icons;
            font-size: 27px;
        }

        .post-footer .form-group input {
            padding-right: 3.5rem !important;
        }

        .post-comment {
            font-weight: 600;
            font-size: .8rem;
        }

        .news-feed-area .news-feed-post .post-header .dropdown .dropdown-menu.show {
            z-index: 111111111111;
        }

        .myPostUrl {
            height: 1rem;
            font-size: .7rem;
            line-height: 1rem;
            color: #222;
        }

        .btn-icon {
            height: 2.6rem;
            width: 2.6rem;
            margin-bottom: 0.5rem;
            color: #fff;
            padding: 6px;
        }

        [contenteditable] {}


        .btn-icon i {
            font-size: 1.4rem;
            line-height: 1.7rem;
        }

        .btn-icon:hover i {
            color: #fff;
        }


        .news-feed-area .news-feed-form form .form-group .form-control {
            background-color: #F4F7FC;
            border: 1px solid #F4F7FC;
            padding: 13px 18px;
            color: var(--paragraph-color);
            font-size: 13px;
        }

        .nopost {}

        .simplebar-content {
            padding: 15px 15px !important;
        }

        .sidemenu-area .sidemenu-body .sidemenu-nav .nav-item .nav-link .icon:before {
            background-color: #fff !important;
        }

        .cat_post {
            color: #3F51B5;
            font-weight: 600;
            font-size: .8rem;
        }

        .form-outline input {
            border: none;
            border-radius: 0px !important;
            padding: 0px;
            padding-bottom: 0.3rem;
            border-bottom: 1px solid #888;
        }

        .list-group-item {
            position: relative;
            display: block;
            padding: 0.5rem 0rem !important;
            margin-bottom: 1.3rem !important;
            color: #212529;
            border: none;
            border-radius: 0px;
            text-decoration: none;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, .125) !important;
        }

        .score {
            font-weight: 600;
            float: right;
            display: none;
        }

        .pending {
            color: #fff;
            font-size: .7rem;
            font-weight: 500;
            margin-left: 1rem;
            background: #3f51b5;
            padding: 0.1rem 0.7rem;
            border-radius: 1rem;

        }

        .panel-title {
            margin-top: 20px !important;
            margin-bottom: 20px !important;
            font-size: 1.5rem;
        }

        .post-body a {
            color: #3644d9;
        }

        .img-choosen {
            display: none;
            margin-bottom: 2.4rem;
        }

        .closeImg {
            font-size: 1.5rem;
            float: right;
            position: relative;
            top: 10px;
            background: #fff;
            border-radius: 1rem;
        }

        .radio input[type='radio'] {
            margin-right: 0.3rem;
        }

        .panel-body {
            margin-left: .8rem;
        }

        .post-strip {
            margin-bottom: 10px;
            width: 100%;
            border: 1px solid #555;
            justify-content: space-between;
            padding: .3rem 1rem;
            border-radius: .4rem;
            height: 2.6rem;
            display: flex
        }

        .modal-footer {
            border: none;
        }


        /*Emoji Styles*/

        .emojionearea,
        .emojionearea.form-control {
            border: none;
        }

        .emojionearea-editor {
            font-size: 1.2rem !important;
            padding: 6px 20px 6px 2px !important;
        }

        .emojionearea-editor:focus {
            box-shadow: none !important;
        }

        .emojionearea-editor:focus {
            border: 0;
            outline: none !important;
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }

        .emojionearea.form-control.post-editor {
            -webkit-box-shadow: none;
            box-shadow: none;
            position: static !important;
            -moz-box-shadow: none;
        }

        .emojionearea.focused {
            border: 0;
            outline: none !important;
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;

        }

        .swiper {
            width: 100%;
            height: 100%;
            /*max-height:400px;*/
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            max-height: 350px;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            max-height: 350px;
            height: 100%;
            object-fit: contain;
        }

        /*Emoji Styles*/

        .emojionearea,
        .emojionearea.form-control {
            border: none;
        }

        .emojionearea-editor {
            font-size: 1.2rem !important;
            padding: 6px 20px 6px 2px !important;
        }

        .emojionearea-editor:focus {
            box-shadow: none !important;
        }

        .emojionearea-editor:focus {
            border: 0;
            outline: none !important;
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }

        .emojionearea.form-control.post-editor {
            -webkit-box-shadow: none;
            box-shadow: none;
            position: static !important;
            -moz-box-shadow: none;
        }

        .emojionearea.focused {
            border: 0;
            outline: none !important;
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;

        }

        .swiper {
            width: 100%;
            height: 100%;
            max-height: 400px;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            max-height: 350px;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            max-height: 350px;
            height: 100%;
            object-fit: contain;
        }


        .modal {
            z-index: 111111111 !important
        }

        .closeShare {
            margin-right: 15px;
            margin-top: 10px;
        }

        .vjs {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--black, #000);
            color: var(--white, #fff);
            overflow: hidden;
            height: 30rem;
            max-width: 100%;
            padding-top: 0;
            position: relative;
            /* Added position: relative */
        }

        video {
            position: absolute;
            /* Added position: absolute */
            width: 100%;
            height: 30rem;
            top: 0;
            z-index: 111;
            left: 0;
        }

        .bg-video {
            position: absolute;
            /* Added position: absolute */
            filter: blur(20px);
            opacity: .6;
            background-position: 50% 50%;
            background-size: cover;
            background-repeat: no-repeat;
            transform: scale(1.1);
            width: 100%;
            height: 100%;
            top: 0;
            z-index: 110;
            /* Lower z-index than video to make it appear behind */
        }

        .menu_sidebar .nav-item:hover {
            background-color: #70b5f933;
        }

        .metisMenu .nav-item .icon i {
            font-size: 1rem;
            margin-right: .2rem;
            color: #555;
        }

        .nav-item-active {
            background-color: #70b5f933;

        }

        .nav-mobile-bar {
            display: flex;
            position: fixed;
            background: #fff;
            z-index: 111111;
        }

        nav-mobile-bar
    </style>


    <div class="search-box search-mobile">
        <img onclick="location.href='/'" src="https://www.jobaaj.com//assets/svg/logos/jobaaj.png" style="width:20%;margin-top: -14px;width:22%;cursor:pointer" alt="image">

        <input type="text" id="search_input" class="input-search" placeholder="Search Topic...">
        <img src="<?php echo $profile; ?>" id="arrowBtn" onclick="rightOpen()" onerror=this.onerror=null;this.src='<?php echo $url; ?>assets/images/avatar.png' class="rounded-circle userAvatar" alt="image">


        <a href="<?php echo $url; ?>notify" style="padding-top:5px;"><i style="    margin-left:3px;
    color: #7d7d7d;
    font-size: 23px;" class="flaticon-bell"></i></a>
    </div>


    <!-- Start Main Content Wrapper Area -->
    <div class="main-content-wrapper d-flex flex-column">




        <!-- Start Navbar Area -->


        <div class="navbar-area">
            <div class="main-responsive-nav">
                <div class="main-responsive-menu">
                    <div class="responsive-burger-menu d-lg-none d-block">
                        <span class="top-bar"></span>
                        <span class="middle-bar"></span>
                        <span class="bottom-bar"></span>
                    </div>
                </div>
            </div>


            <div class="main-responsive-nav">
                <div onclick="openNav();" class="main-responsive-menu">
                    <div class="responsive-burger-menu d-lg-none d-block">
                        <span class="top-bar"></span>
                        <span class="middle-bar"></span>
                        <span class="bottom-bar"></span>
                    </div>
                </div>
            </div>



            <div class="main-navbar">
                <nav class="navbar navbar-expand-lg navbar-light">

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <div class="search-box m-auto">
                            <form style="display:flex" onsubmit="return false" method="">
                                <img onclick="location.href='/'" src="https://cdn.nishtyainfotech.com/learnings/assets/img/d-logo.png" style="width:32%;cursor:pointer" alt="image">
                                <input type="text" id="search_input2" class="input-search" placeholder="Search Topic...">
                                <button type="button" onclick="searchTopic()"><i class="ri-search-line"></i></button>
                            </form>
                        </div>


                        <div class="others-options d-flex align-items-center">



                            <div class="option-item">
                                <div class="dropdown notifications-nav-item">
                                    <a href="#" class="dropdown-bs-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div class="notifications-btn">
                                            <i class="flaticon-bell"></i>
                                            <span>&nbsp;</span>
                                        </div>
                                    </a>

                                    <div class="dropdown-menu">
                                        <div class="notifications-header d-flex justify-content-between align-items-center">
                                            <h3>Notifications</h3>
                                        </div>
                                        <div class="notifications-body" style="margin-top: -10px;" data-simplebar>

                                            <?php




                                            $sel = mysqli_query($db, "SELECT c.*,u.full_name,u.image,u.verification_code FROM com_notify c join users u on u.id = c.fromUser where (toUser = '$user[id]' or toUser = '0') order by nid desc limit 0,5");
                                            if (mysqli_num_rows($sel) > 0) {

                                                while ($not = mysqli_fetch_assoc($sel)) {

                                                    $post_url = $url . "/post/" . $not['post'];

                                                    if ($not['image'] != '')
                                                        $profileNotify = $l_url . 'data/pro/' . $not['image'];
                                                    else
                                                        $profileNotify = $l_url . '/assets/images/avatar.png';

                                                    $tick = '';
                                                    if ($not['verification_code'] == '101')
                                                        $tick = "<img src='$url/assets/images/tick.svg' class='tick'>";

                                                    $post_url = $url . "post/" . $not['post'];

                                            ?>
                                                    <div class="item d-flex justify-content-between align-items-center" style="cursor:pointer;" onclick="location.href='<?php echo $post_url; ?>'">
                                                        <div class="figure">
                                                            <a href="javascript:;">
                                                                <img src="<?php echo  $profileNotify; ?>" onerror="this.onerror=null;this.src='https://community.jobaajlearnings.com/assets/images/avatar.png'" class="rounded-circle profile-notify" alt="image">

                                                            </a>
                                                        </div>
                                                        <div class="text">
                                                            <h4><a href="javascript:;"><?php echo $not['full_name'] . $tick; ?></a></h4>
                                                            <div onclick="location.href='<?php echo $post_url; ?>'">
                                                                <span><?php echo $not['msg']; ?></span>
                                                                <span class="main-color"><?php echo  timeago(date('Y-m-d H:i:s', $not['date_added'])); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>
                                                <div class="view-all-notifications-btn">
                                                    <a href="notify" class="default-btn">View All Notifications</a>
                                                </div>

                                            <?php } else {  ?>

                                                <div class="view-all-notifications-btn">
                                                    No Updates!
                                                </div>

                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="option-item">
                                <div class="dropdown profile-nav-item">

                                    <a class="dropdown-bs-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div class="menu-profile">
                                            <img src="<?php echo $profile; ?>" onerror=this.onerror=null;this.src='<?php echo $url; ?>assets/images/avatar.png' class="rounded-circle userAvatar" alt="image">
                                            <span class="name"><?php echo "Hey! " . strtok($user['full_name'], ' '); ?></span>
                                            <span class="status-online"></span>
                                        </div>
                                    </a>

                                    <div class="dropdown-menu">
                                        <?php if ($user['id'] != '') { ?>
                                            <div class="profile-header">
                                                <h3><?php echo $user['full_name']; ?></h3>
                                                <a href="<?php echo $url;?>/profile/<?php echo $user['metaname']; ?>"><?php echo "@".$user['metaname']; ?></a>
                                            </div>
                                            <ul class="profile-body">
                                                <li><i class="flaticon-comment"></i> <a href="<?php echo $url; ?>#myPosts" target="_blank">My Posts</a></li>
                                                <li><i class="flaticon-user"></i> <a href="<?php echo $url; ?>profile/<?php echo $user['metaname']; ?>">Edit Profile</a></li>
                                                <li><i class="flaticon-logout"></i> <a href="<?php echo $url; ?>logout">Logout</a></li>
                                            </ul>

                                        <?php } else { ?>
                                            <ul class="profile-body">
                                                <li><i class="flaticon-logout"></i> <a href="javascript:;" onclick=" loginNow();">Login</a></li>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </nav>
            </div>

            <div class="others-option-for-responsive">
                <div class="container">
                    <div class="dot-menu">
                        <div class="inner">
                            <div class="circle circle-one"></div>
                            <div class="circle circle-two"></div>
                            <div class="circle circle-three"></div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="option-inner">
                            <div class="others-options d-flex align-items-center">
                                <div class="option-item">
                                    <a href="index.html" class="home-btn"><i class="flaticon-home"></i></a>
                                </div>
                                <div class="option-item">
                                    <div class="dropdown friend-requests-nav-item">
                                        <a href="#" class="dropdown-bs-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <div class="friend-requests-btn">
                                                <i class="flaticon-user"></i>
                                                <span>3</span>
                                            </div>
                                        </a>

                                        <div class="dropdown-menu">
                                            <div class="friend-requests-header d-flex justify-content-between align-items-center">
                                                <h3>Friend Requests</h3>
                                                <i class="flaticon-menu"></i>
                                            </div>

                                            <div class="friend-requests-body">
                                                <div class="item d-flex align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-2.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>

                                                    <div class="content d-flex justify-content-between align-items-center">
                                                        <div class="text">
                                                            <h4><a href="#">Sandra Cross</a></h4>
                                                            <span>26 Friends</span>
                                                        </div>
                                                        <div class="btn-box d-flex align-items-center">
                                                            <button class="delete-btn d-inline-block me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" type="button"><i class="ri-close-line"></i></button>

                                                            <button class="confirm-btn d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirm" type="button"><i class="ri-check-line"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item d-flex align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-3.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>

                                                    <div class="content d-flex justify-content-between align-items-center">
                                                        <div class="text">
                                                            <h4><a href="#">Kenneth Crowe</a></h4>
                                                            <span>53 Friends</span>
                                                        </div>
                                                        <div class="btn-box d-flex align-items-center">
                                                            <button class="delete-btn d-inline-block me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" type="button"><i class="ri-close-line"></i></button>

                                                            <button class="confirm-btn d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirm" type="button"><i class="ri-check-line"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item d-flex align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-4.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>

                                                    <div class="content d-flex justify-content-between align-items-center">
                                                        <div class="text">
                                                            <h4><a href="#">Andrea Harwell</a></h4>
                                                            <span>99 Friends</span>
                                                        </div>
                                                        <div class="btn-box d-flex align-items-center">
                                                            <button class="delete-btn d-inline-block me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" type="button"><i class="ri-close-line"></i></button>

                                                            <button class="confirm-btn d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirm" type="button"><i class="ri-check-line"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item d-flex align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-5.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>

                                                    <div class="content d-flex justify-content-between align-items-center">
                                                        <div class="text">
                                                            <h4><a href="#">John Lago</a></h4>
                                                            <span>18 Friends</span>
                                                        </div>
                                                        <div class="btn-box d-flex align-items-center">
                                                            <button class="delete-btn d-inline-block me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" type="button"><i class="ri-close-line"></i></button>

                                                            <button class="confirm-btn d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirm" type="button"><i class="ri-check-line"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="view-all-requests-btn">
                                                    <a href="friends.html" class="default-btn">View All Requests</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-item">
                                    <div class="dropdown messages-nav-item">
                                        <a href="#" class="dropdown-bs-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <div class="messages-btn">
                                                <i class="flaticon-email"></i>
                                                <span>2</span>
                                            </div>
                                        </a>

                                        <div class="dropdown-menu">
                                            <div class="messages-header d-flex justify-content-between align-items-center">
                                                <h3>Messages</h3>
                                                <i class="flaticon-menu"></i>
                                            </div>
                                            <div class="messages-search-box">
                                                <form>
                                                    <input type="text" class="input-search" placeholder="Search Message...">
                                                    <button type="submit"><i class="ri-search-line"></i></button>
                                                </form>
                                            </div>
                                            <div class="messages-body">
                                                <div class="item d-flex justify-content-between align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-11.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h4><a href="#">James Vanwin</a></h4>
                                                        <span>Hello Dear I Want Talk To You</span>
                                                    </div>
                                                </div>
                                                <div class="item d-flex justify-content-between align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-12.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h4><a href="#">Harry Lopez</a></h4>
                                                        <span>Hi. I Am looking For UI Designer</span>
                                                    </div>
                                                </div>
                                                <div class="item d-flex justify-content-between align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-13.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h4><a href="#">Matthew Smith</a></h4>
                                                        <span>Thanks For Connecting!</span>
                                                    </div>
                                                </div>
                                                <div class="item d-flex justify-content-between align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-14.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h4><a href="#">Russe Smith</a></h4>
                                                        <span>Thanks For Connecting!</span>
                                                    </div>
                                                </div>
                                                <div class="view-all-messages-btn">
                                                    <a href="messages.html" class="default-btn">View All Messages</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-item">
                                    <div class="dropdown notifications-nav-item">
                                        <a href="#" class="dropdown-bs-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <div class="notifications-btn">
                                                <i class="flaticon-bell"></i>
                                                <span>1</span>
                                            </div>
                                        </a>

                                        <div class="dropdown-menu">
                                            <div class="notifications-header d-flex justify-content-between align-items-center">
                                                <h3>Notifications</h3>
                                                <i class="flaticon-menu"></i>
                                            </div>
                                            <div class="notifications-body">
                                                <div class="item d-flex justify-content-between align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-11.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h4><a href="#">James Vanwin</a></h4>
                                                        <span>Posted A Comment On Your Status</span>
                                                        <span class="main-color">20 Minites Ago</span>
                                                    </div>
                                                </div>
                                                <div class="item d-flex justify-content-between align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-12.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h4><a href="#">Harry Lopez</a></h4>
                                                        <span>Sent You A Friend Request</span>
                                                        <span class="main-color">2 Days Ago</span>
                                                    </div>
                                                </div>
                                                <div class="item d-flex justify-content-between align-items-center">
                                                    <div class="figure">
                                                        <a href="#"><img src="<?php echo $url; ?>assets/images/user/user-13.jpg" class="rounded-circle" alt="image"></a>
                                                    </div>
                                                    <div class="text">
                                                        <h4><a href="#">Matthew Smith</a></h4>
                                                        <span>Add A Photo In Design Group</span>
                                                        <span class="main-color">3 Days Ago</span>
                                                    </div>
                                                </div>
                                                <div class="view-all-notifications-btn">
                                                    <a href="notifications.html" class="default-btn">View All Notifications</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-item">
                                    <div class="dropdown language-option">
                                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon-global"></i>
                                            <span class="lang-name"></span>
                                        </button>
                                        <div class="dropdown-menu language-dropdown-menu">
                                            <a class="dropdown-item" href="#">
                                                <img src="<?php echo $url; ?>assets/images/uk.png" alt="flag">
                                                Eng
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <img src="<?php echo $url; ?>assets/images/china.png" alt="flag">
                                                简体中文
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <img src="<?php echo $url; ?>assets/images/uae.png" alt="flag">
                                                العربيّة
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-item">
                                    <div class="dropdown profile-nav-item" style="    ">
                                        <a href="#" class="dropdown-bs-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <div class="menu-profile" style="margin-right: -45px;">
                                                <img src="<?php echo $url; ?>assets/images/user/user-1.jpg" class="rounded-circle" alt="image">
                                                <span class="name">Matthew</span>
                                                <span class="status-online"></span>
                                            </div>
                                        </a>

                                        <div class="dropdown-menu">
                                            <div class="profile-header">
                                                <h3>Matthew Turner</h3>
                                                <a href="mailto:matthew507@gmail.com">matthew507@gmail.com</a>
                                            </div>
                                            <ul class="profile-body">
                                                <li><i class="flaticon-user"></i> <a href="my-profile.html">My Profile</a></li>
                                                <li><i class="flaticon-settings"></i> <a href="setting.html">Setting</a></li>
                                                <li><i class="flaticon-privacy"></i> <a href="privacy.html">Privacy</a></li>
                                                <li><i class="flaticon-information"></i> <a href="help-and-support.html">Help & Support</a></li>
                                                <li><i class="flaticon-logout"></i> <a href="index.html">Logout</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-item">
                                    <div class="search-box">
                                        <form>
                                            <input type="text" class="input-search" placeholder="Search...">
                                            <button type="submit"><i class="ri-search-line"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- End Navbar Area -->