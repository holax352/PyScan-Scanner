<?php
require_once('../panel/config/config.php');
if(isset($_GET['url']) && $_GET['url'] != NULL)
{
    $date = date('d-m-Y');
    $domain = $_GET['d'];
    $url = $_GET['url'];
    $type = $_GET['t'];
    $source = $_GET['s'];
    $file = fopen("../log/".$date.'history.pyscan', 'a+');
    fwrite($file, "[$date]:::".$url."\n");
    fclose($file);
    
    insertvuln($domain, $url, $date, $type, $source);
}
?>