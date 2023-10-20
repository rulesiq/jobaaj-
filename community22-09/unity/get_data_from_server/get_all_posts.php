<?php
require_once('../db.php');
// require_once('../config-db.php');


// SQL server connection information
$sql_details = $search_db;

$table = <<<EOT
(  
   select p.p_id id,p.cat_id,c.name as category,p.date_posted,p.status,SUBSTRING(p.content, 1, 50) content,
   u.full_name name,u.id as user_id 
    from com_posts p 
    join users u 
   on u.id = p.posted_user 
   join com_category c on p.cat_id = c.id
   

) join_table
EOT;

$whereResult = null;

if(isset($_GET['where_condition']) && !empty($_GET['where_condition'])) {
    $whereAll = $_GET['where_condition'];
}else{
    $whereAll = null;
    
}

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(

    array('db' => 'id', 'dt' => 1,
    
    'formatter' => function($cell, $row){

            $returnValue =  "<input class='id_check' type='checkbox' name='checkboxPost' data-id='$row[id]'>";
            
            return $returnValue;
        }
    ),
    array('db' => 'id', 'dt' => 0),
    
    array('db' => 'content', 'dt' => 2,
     
    'formatter' => function($cell, $row){

            $returnValue =  '<a href="https://community.jobaajlearnings.com/post/'.$row['id'].'/admin';
            $returnValue .= '" target="_blank">'.$row['content'].'</a>';
            
            return $returnValue;
        }
    ),
    
    array('db' => 'name', 'dt' => 3),
    array('db' => 'status', 'dt' => 4,
    'formatter' => function($cell, $row){
            
            if($row['status'] == 1) 
            return  "<span data-id='$row[id]' data-st='0' class='btn btn-success status-change'>Active</span>";
            else
            return  "<span data-id='$row[id]' data-st='1' class='btn btn-danger status-change'>Pending</span>";

            
        }
    ),
    
    array('db' => 'date_posted', 'dt' => 5,
       'formatter' =>function($cell,$row){
              return  date('D, h:i:a d-m',$row['date_posted']);
         }
    ),
    array('db' => 'category', 'dt' => 6),
    
    array('db' => 'id', 'dt' => 7,
        'formatter' => function($cell, $row){

            $returnValue =  '<a href="post-notify?post='.$row['content'].'&post_id='.$row['id'].'"';
            $returnValue .= '" target="_blank">Notify</a>';
            
            return $returnValue;
        }
        
    ),
    
    array('db' => 'id', 'dt' => 8),
    array('db' => 'id', 'dt' => 9)
);





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
require('ssp.class.php');

echo json_encode(
    // SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult, $whereAll)
);
