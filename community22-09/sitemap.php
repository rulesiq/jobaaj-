<?php
    require('config.php');
     $lastmod = date("Y-m-d");
     
  
    header("Content-Type:application/xml; charset=utf-8");
    echo '<!--?xml version="1.0" encoding="UTF-8"?-->'.PHP_EOL;
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemalocation="http://www.sitemaps.org/schemas/sitemap/0.9
           http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'.PHP_EOL; 
    echo '<url>' . PHP_EOL;
    echo '<loc>'.$url.'</loc>' . PHP_EOL;
    echo '<lastmod>'.date('Y-m-d').'</lastmod>';
    echo '<changefreq>daily</changefreq>' . PHP_EOL;
    echo '</url>' . PHP_EOL;
    echo '</urlset>'.PHP_EOL;
?>