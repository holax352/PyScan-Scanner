<?php
require_once('../config/config.php');
if(isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']))
{
    $id = $_GET['id'];
    $select = $bdd->prepare("SELECT * FROM payloadcve WHERE id = :id");
    $select->bindParam(':id', $id);
    $select->execute();
    $fetch = $select->fetch();
    if($fetch['id'] != '')
    {
        $payload = $fetch['payload'];
        $pattern = $fetch['pattern'];
        $result = $fetch['result'];
        $type = $fetch['perform'];
        $chaine = $payload.":::".$pattern.":::".$result.":::".$type;
        echo $chaine;
    }
    else
        echo "0";
}
else
{
    $select = $bdd->prepare("SELECT * FROM payloadcve");
    $select->execute();
    while($fetch = $select->fetch())
    {
        if($fetch['name'] != '')
        {
            $payload = $fetch['payload'];
            $pattern = $fetch['pattern'];
            $result = $fetch['result'];
            $type = $fetch['perform'];
            $chaine = $payload.":::".$pattern.":::".$result.":::".$type;
            echo $chaine;
            echo "::::";
        }
        else
            echo "0";
    }
}
?>