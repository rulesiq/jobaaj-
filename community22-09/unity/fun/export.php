<?php

require_once('../db.php');

if(isset($_GET['programmes'])) {
//Set variable to false for heading
$heading = false;

$exportType = '';
 
// Excel file name for download 
$fileName = "programming-leads" . date('Y-m-d') . ".xls"; 
 
 $fields = array('Program', 'Name', 'Email Id', 'Mobile','Date'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database  

$users =  str_replace(',,', ',', $_GET['users']);
$to = strtotime(date($_GET['toDate']));
$from = strtotime(date($_GET['fromDate']));

$i=1;
$sql=mysqli_query($db,"select * from programLeads order by id desc");
if(isset($_GET['toDate'])) {
    $sql=mysqli_query($db,"select * from programLeads where date_added between '$from' AND '$to'");
}

//$sql = mysqli_query($db,"SELECT * FROM `job_user` where id in ($users) order by id");
    // Output each row of the data 
    while($row = mysqli_fetch_array($sql)){ 
    $u = mysqli_fetch_array(mysqli_query($db,"select * from programmes where id = '$row[prog_id]'")); 
    $p = $u['title'];
    
    $date = date('d M Y',$row['date_added']);

    $lineData = array($p, $row['name'], $row['email'], $row['mobile'],$date); 
        
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit();

}


if(isset($_GET['subscription'])) {
    //Set variable to false for heading
    $heading = false;
    
    $exportType = '';
     
    // Excel file name for download 
    $fileName = "subscription-leads" . date('Y-m-d') . ".xls"; 
     
     $fields = array('email','Date'); 
     
    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n"; 
     
    // Fetch records from database  
    
    $users =  str_replace(',,', ',', $_GET['users']);
    $to = strtotime(date($_GET['toDate']));
    $from = strtotime(date($_GET['fromDate']));
    
    $i=1;
    $sql=mysqli_query($db,"select * from subscribe_list order by id desc");
    if(isset($_GET['toDate'])) {
        $sql=mysqli_query($db,"select * from subscribe_list where date_added between '$from' AND '$to'");
    }
    
    //$sql = mysqli_query($db,"SELECT * FROM `job_user` where id in ($users) order by id");
        // Output each row of the data 
        while($row = mysqli_fetch_array($sql)){ 
        $u = mysqli_fetch_array(mysqli_query($db,"select * from subscribe_list where id = '$row[id]'")); 
        // $p = $u['title'];
        
        $date = date('d M Y',$row['date_added']);
    
        $lineData = array($row['email'],$date); 
            
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        } 
     
    // Headers for download 
    header("Content-Type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment; filename=\"$fileName\""); 
     
    // Render excel data 
    echo $excelData; 
     
    exit();
    
 }
    if(isset($_GET['contact'])) {
        //Set variable to false for heading
        $heading = false;
        
        $exportType = '';
         
        // Excel file name for download 
        $fileName = "contactus-leads" . date('Y-m-d') . ".xls"; 
         
         $fields = array('fullname','phone','email','identity','textmessage','Date'); 
         
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 
         
        // Fetch records from database  
        
        $to = date("Y-m-d", strtotime($_GET['toDate']));
        $from = date("Y-m-d", strtotime($_GET['fromDate']));
        
        $i=1;
        $sql=mysqli_query($db,"select * from contactus order by id desc");
        if(isset($_GET['toDate'])) {
            $sql=mysqli_query($db,"select * from contactus where created_at between '$from' AND '$to'");
        }
        
        //$sql = mysqli_query($db,"SELECT * FROM `job_user` where id in ($users) order by id");
            // Output each row of the data 
            while($row = mysqli_fetch_array($sql)){ 
            $u = mysqli_fetch_array(mysqli_query($db,"select * from contactus where id = '$row[id]'")); 
            // $p = $u['title'];
            
            $date = $row['created_at'];
        
            $lineData = array($row['fullname'],$row['phone'],$row['email'],$row['identity'],$row['textmessage'],$date); 
                
                array_walk($lineData, 'filterData'); 
                $excelData .= implode("\t", array_values($lineData)) . "\n"; 
            } 
         
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
         
        // Render excel data 
        echo $excelData; 
         
        exit();
        
        }
        if(isset($_GET['workshop'])) {
            //Set variable to false for heading
            $heading = false;
            
            $exportType = '';
             
            // Excel file name for download 
            $fileName = "workshop-leads" . date('Y-m-d') . ".xls"; 
             
             $fields = array('fullname','phone','email','workshop_name','Date'); 
             
            // Display column names as first row 
            $excelData = implode("\t", array_values($fields)) . "\n"; 
             
            // Fetch records from database  
            
            $to = date("Y-m-d", strtotime($_GET['toDate']));
            $from = date("Y-m-d", strtotime($_GET['fromDate']));
            
            $i=1;
            $sql=mysqli_query($db,"select * from goworkshops order by id desc");
            if(isset($_GET['toDate'])) {
                $sql=mysqli_query($db,"select * from goworkshops where created_at between '$from' AND '$to'");
            }
            
            //$sql = mysqli_query($db,"SELECT * FROM `job_user` where id in ($users) order by id");
                // Output each row of the data 
                while($row = mysqli_fetch_array($sql)){ 
                $u = mysqli_fetch_array(mysqli_query($db,"select * from goworkshops where id = '$row[id]'")); 
                // $p = $u['title'];
                
                $date = $row['created_at'];
            
                $lineData = array($row['name'],$row['phone'],$row['email'],$row['workshop_name'],$date); 
                    
                    array_walk($lineData, 'filterData'); 
                    $excelData .= implode("\t", array_values($lineData)) . "\n"; 
                } 
             
            // Headers for download 
            header("Content-Type: application/vnd.ms-excel"); 
            header("Content-Disposition: attachment; filename=\"$fileName\""); 
             
            // Render excel data 
            echo $excelData; 
             
            exit();
            
            }
        if(isset($_GET['financial'])) {
            //Set variable to false for heading
            $heading = false;
            
            $exportType = '';
             
            // Excel file name for download 
            $fileName = "financialaid-leads" . date('Y-m-d') . ".xls"; 
             
             $fields = array('fullname','phone','email','edu_back','annualincome','employstatus','canafford','coursename','whyapplying','careergoal','lowinterest','Date'); 
             
            // Display column names as first row 
            $excelData = implode("\t", array_values($fields)) . "\n"; 
             
            // Fetch records from database  
            
            $to = strtotime(date($_GET['toDate']));
            $from = strtotime(date($_GET['fromDate']));
            
            $i=1;
            $sql=mysqli_query($db,"select * from financialaid order by id desc");
            if(isset($_GET['toDate'])) {
                $sql=mysqli_query($db,"select * from financialaid where date_added between '$from' AND '$to'");
            }
            
            //$sql = mysqli_query($db,"SELECT * FROM `job_user` where id in ($users) order by id");
                // Output each row of the data 
                while($row = mysqli_fetch_array($sql)){ 
                $u = mysqli_fetch_array(mysqli_query($db,"select * from financialaid where id = '$row[id]'")); 
                // $p = $u['title'];
                
                $date = date('d M Y',$row['date_added']);

            
                $lineData = array($row['fullname'],$row['phone'],$row['email'],$row['edu_back'],$row['annualincome'],$row['employstatus'],$row['canafford'],$row['coursename'],$row['whyapplying'],$row['careergoal'],$row['lowinterest'],$date); 
                    
                    array_walk($lineData, 'filterData'); 
                    $excelData .= implode("\t", array_values($lineData)) . "\n"; 
                } 
             
            // Headers for download 
            header("Content-Type: application/vnd.ms-excel"); 
            header("Content-Disposition: attachment; filename=\"$fileName\""); 
             
            // Render excel data 
            echo $excelData; 
             
            exit();
            
            }
?>