<!DOCTYPE html>
<html lang="en">
    <head>
        
         <?php  


        include('db.php');

        if(!isset($_SESSION['user']))
        {
            echo "<script>location.href='index';</script>";
        }

        ?>
        <meta charset="utf-8" />
        <title>Jobaaj  - Dashboard</title>
        
       
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://www.jobaaj.com//assets/img/jobaaj-favicon.ico">

    <!-- plugin css -->
    <link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet preload" as="style" type="text/css" />
    <link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet preload" as="style" type="text/css" />
    <link href="assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet preload" as="style" type="text/css" />
    <link href="assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet preload" as="style" type="text/css" />


    <!-- plugins -->
    <link href="assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet preload" as="style" type="text/css" />

    <!-- select picker -->
    <link href="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet preload" as="style" />
    <link href="assets/libs/select2/select2.min.css" rel="stylesheet preload" as="style" type="text/css" />
    <link href="assets/libs/multiselect/multi-select.css" rel="stylesheet preload" as="style" type="text/css" />

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet preload" as="style" type="text/css" />

    <!-- <link href="assets/css/bootstrap-dark.min.css" rel="stylesheet preload" as="style" type="text/css" />
    <link href="assets/css/app-dark.min.css" rel="stylesheet preload" as="style" type="text/css" /> -->

    <link href="assets/css/bootstrap.min.css" rel="stylesheet preload" as="style" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet preload" as="style" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

  <style>
        /* width */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #7e8ce9;
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #5369f8;
        }

        .btn-padding {
            padding: 0.2rem;
            /* padding-bottom: 0.2rem; */
        }

        div.dataTables_wrapper div.dataTables_processing {
            top: 5%;
            left: 50%;
            border: 1px solid red;
            color: red;
            transform: translateX(-50%);
            margin: 0;
        }

        .counting {
            font-size: 11px !important;
            background: #fff;
            color: #000;
            display: inline;
            padding: 0.2em 0.3em 0.1em 0.3em;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.2rem;
            border: 1px solid transparent;
        }

        .btn-filter {
            cursor: default !important;
            border-radius: 40px !important;
            background-color: #188758 !important;
        }

        .btn-filter i {
            cursor: pointer;
        }
    </style>
    
    
    </head>

