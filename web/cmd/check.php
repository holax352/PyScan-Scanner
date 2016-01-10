<?php
$date = date('d-m-Y');
$url = file_get_contents("$date"."history.pyscan");
$match = $_GET['url'];
if(stristr($url, $match))
    echo "1";
else
    echo "0";
?>