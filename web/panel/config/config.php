<?php
$bdd = new PDO('mysql:host=localhost;dbname=pyscan', 'root', 'root');

function insertlog($domain, $url, $date)
{
    global $bdd;
    
    $verif = $bdd->prepare("SELECT * FROM logs WHERE lien = :lien");
    $verif->bindParam(':lien', $url);
    $verif->execute();
    $fetch_verif = $verif->fetch();
    if($fetch_verif['id'] != NULL)
        return false;
    
    $date = date('d-m-Y');
    $insert = $bdd->prepare("INSERT INTO logs(date_insert,domain,lien) VALUES(:date, :domain, :lien)");
    $insert->bindParam(':date', $date);
    $insert->bindParam(':domain', $domain);
    $insert->bindParam(':lien', $url);
    $insert->execute();
    return true;
}

function GetSearchVuln($domain)
{
    global $bdd;
    
    $like = "%".$domain."%";
    $select_log = $bdd->prepare("SELECT * FROM vuln_logs WHERE domain LIKE :domain");
    $select_log->bindParam(':domain', $like);
    $select_log->execute();
    while($fetch = $select_log->fetch())
    {
        ?>
              <tr>
                <td><?php echo $fetch['id'];?></td>
                <td><?php echo $fetch['date_insert'];?></td>
                <td><?php echo $fetch['domain']; ?></td>
                <td><?php echo $fetch['lien']; ?></td>
                <td><?php echo $fetch['typeinjection']; ?></td>
                  <td><a href='index.php?action=logs&source=<?php echo $fetch['sourcepage']; ?>'>Source</a></td>
              </tr>
        <?php
    }
}

function GetSearchLog($domain)
{
    global $bdd;
    
    $like = "%".$domain."%";
    $select_log = $bdd->prepare("SELECT * FROM logs WHERE domain LIKE :domain");
    $select_log->bindParam(':domain', $like);
    $select_log->execute();
    while($fetch = $select_log->fetch())
    {
        ?>
              <tr>
                <td><?php echo $fetch['id'];?></td>
                <td><?php echo $fetch['date_insert'];?></td>
                <td><?php echo $fetch['domain']; ?></td>
                <td><?php echo $fetch['lien']; ?></td>
              </tr>
        <?php
    }
}
function GetLog()
{
    global $bdd;
    $select_log = $bdd->prepare("SELECT DISTINCT id,date_insert,domain,lien FROM logs ORDER BY id DESC");
    $select_log->execute();
    while($fetch = $select_log->fetch())
    {
        ?>
              <tr>
                <td><?php echo $fetch['id'];?></td>
                <td><?php echo $fetch['date_insert'];?></td>
                <td><?php echo $fetch['domain']; ?></td>
                <td><?php echo $fetch['lien']; ?></td>
              </tr>
        <?php
    }
}

function GetVuln()
{
    global $bdd;
    $select_log = $bdd->prepare("SELECT * FROM vuln_logs ORDER BY id DESC");
    $select_log->execute();
    while($fetch = $select_log->fetch())
    {
        ?>
              <tr>
                <td><?php echo $fetch['id'];?></td>
                <td><?php echo $fetch['date_insert'];?></td>
                <td><?php echo $fetch['domain']; ?></td>
                <td><?php echo $fetch['lien']; ?></td>
                <td><?php echo $fetch['typeinjection']; ?></td>
                  <td><a href='index.php?action=logs&source=<?php echo $fetch['sourcepage']; ?>'>Source</a></td>
              </tr>
        <?php
    }
}

function insertvuln($domain, $url, $date, $type, $source)
{
    global $bdd;
    
    $verif = $bdd->prepare("SELECT * FROM vuln_logs WHERE lien = :lien");
    $verif->bindParam(':lien', $url);
    $verif->execute();
    $fetch_verif = $verif->fetch();
    if($fetch_verif['id'] != NULL)
        return false;
    
    $date = date('d-m-Y');
    $insert = $bdd->prepare("INSERT INTO vuln_logs(date_insert,domain,lien,typeinjection,sourcepage) VALUES(:date, :domain, :lien,:typeinjection,:source)");
    $insert->bindParam(':date', $date);
    $insert->bindParam(':domain', $domain);
    $insert->bindParam(':lien', $url);
    $insert->bindParam(':typeinjection', $type);
    $insert->bindParam(':source', $source);
    $insert->execute();
    return true;
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

function updatelog()
{
    global $bdd;
    $update = $bdd->prepare("UPDATE logs SET unread = '1' WHERE unread = '0'");
    $update->execute();
}

function updatevuln()
{
    global $bdd;
    $update = $bdd->prepare("UPDATE vuln_logs SET unread = '1' WHERE unread = '0'");
    $update->execute();
}

function countunreadlog()
{
    global $bdd;
    $select = $bdd->prepare("SELECT COUNT(*) FROM logs WHERE unread = '0'");
    $select->execute();
    $fetch = $select->fetch();
    if($fetch['COUNT(*)'] != NULL)
        return $fetch['COUNT(*)'];
}

function countunreadvuln()
{
    global $bdd;
    $select = $bdd->prepare("SELECT COUNT(*) FROM vuln_logs WHERE unread = '0'");
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