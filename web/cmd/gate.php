<?php
require_once('../panel/config/config.php');
if(isset($_GET['url']) && $_GET['url'] != NULL && isset($_GET['d']) && $_GET['d'] != NULL)
{
    $date = date('d-m-Y');
    $domain = $_GET['d'];
    $url = $_GET['url'];
    $file = fopen("../log/".$date.'history.pyscan', 'a+');
    fwrite($file, "[$date]:::".$url."\n");
    fclose($file);
    
    insertlog($domain, $url, $date);
    echo "ok";
}
?>