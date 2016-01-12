<?php
require_once('../config/config.php');

$select = $bdd->prepare("SELECT * FROM linkchecked WHERE checkeding = '0'");
$select->execute();
while($fetch = $select->fetch())
{
    if($fetch['website'] != '')
    {
        $payload = $fetch['website'];
        echo $payload;
        echo "::::";
    }
    else
        echo "0";
    }
?>