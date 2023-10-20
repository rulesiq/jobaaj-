

<?php

require_once('../db.php');

$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.countrystatecity.in/v1/states",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 10,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
     CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
     "X-CSCAPI-KEY:NWRsQ3RyRzlwbmM4MkZ5Ujl6bnVKWEhvUU5oVkJHSGJsa2dqVHZ4Yw=="
    ),

  ));
 $sr = curl_exec($curl);
 curl_close($curl);
 $response = json_decode($sr,true);
    
      foreach ($response as $key => $v) {
        mysqli_query($db,"INSERT INTO `states` (`id`, `name`, `code`, `country_id`) VALUES (NULL, '$v[name]', '$v[iso2]', '$v[country_code]');");
    }

?>



<?php

if(isset($_POST['countryId']))
{
$cid = $_POST['countryId']; 

$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.countrystatecity.in/v1/countries/$cid/states",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 10,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
     CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
     "X-CSCAPI-KEY:NWRsQ3RyRzlwbmM4MkZ5Ujl6bnVKWEhvUU5oVkJHSGJsa2dqVHZ4Yw=="
    ),
));
 $sr = curl_exec($curl);
 curl_close($curl);
 $response = json_decode($sr,true);
 $data = '<option value="">Select State</option>';
 foreach ($response as $key => $v) {
        
        $data.='<option value="'. $v['iso2'].'">'.$v['name'].'</option>';
 }
 echo $data;
    
}




if(isset($_POST['stateId']))
{
        $cid = $_POST['countryF']; 
        $sid = $_POST['stateId']; 
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.countrystatecity.in/v1/countries/$cid/states/$sid/cities",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "X-CSCAPI-KEY:NWRsQ3RyRzlwbmM4MkZ5Ujl6bnVKWEhvUU5oVkJHSGJsa2dqVHZ4Yw=="
        ),
        ));
        $sr = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($sr,true);
        $data = '<option value="">Select City</option>';
        foreach ($response as $key => $v) {
        
        $data.='<option value="'. $v['iso2'].'">'.$v['name'].'</option>';
        }
        echo $data;

}


?>