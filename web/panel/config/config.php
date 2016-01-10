<?php
$bdd = new PDO('mysql:host=localhost;dbname=pyscan', 'root', 'root');

function insertlog($domain, $url, $date)
{
    global $bdd;
    $date = date('d-m-Y');
    $insert = $bdd->prepare("INSERT INTO logs(date_insert,domain,lien) VALUES(:date, :domain, :lien)");
    $insert->bindParam(':date', $date);
    $insert->bindParam(':domain', $domain);
    $insert->bindParam(':lien', $url);
    $insert->execute();
}

function insertvuln($domain, $url, $date, $type, $source)
{
    global $bdd;
    $date = date('d-m-Y');
    $insert = $bdd->prepare("INSERT INTO vuln_logs(date_insert,domain,lien,typeinjection,sourcepage) VALUES(:date, :domain, :lien,:typeinjection,:source)");
    $insert->bindParam(':date', $date);
    $insert->bindParam(':domain', $domain);
    $insert->bindParam(':lien', $url);
    $insert->bindParam(':typeinjection', $type);
    $insert->bindParam(':source', $source);
    $insert->execute();
}

function countlog()
{
    global $bdd;
    $select = $bdd->prepare("SELECT COUNT(*) FROM logs");
    $select->execute();
    $fetch = $select->fetch();
    if($fetch['COUNT(*)'] != NULL)
        return $fetch['COUNT(*)'];
}

function countvuln()
{
    global $bdd;
    $select = $bdd->prepare("SELECT COUNT(*) FROM vuln_logs");
    $select->execute();
    $fetch = $select->fetch();
    if($fetch['COUNT(*)'] != NULL)
        return $fetch['COUNT(*)'];
}
?>