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

    $select_databased = $bdd->prepare("SELECT * FROM linkchecked WHERE website = :website");
    $select_databased->bindParam(':website', $url);
    $select_databased->execute();
    $fetch_databases = $select_databased->fetch();
    if($fetch_databases['website'] != "")
    {
        $update = $bdd->prepare("UPDATE linkchecked SET checkeding = '1' WHERE website = :website");
        $update->bindParam(':website', $url);
        $update->execute();
    }
    return true;
}

function insert_uncheck($line)
{
    global $bdd;
    
    $select_link = $bdd->prepare("SELECT * FROM linkchecked WHERE website = :website");
    $select_link->bindParam(':website', $line);
    $select_link->execute();
    $fetch = $select_link->fetch();
    if($fetch['id'] == "")
    {
        $date = date('d-m-Y');
        $insert_link = $bdd->prepare("INSERT INTO linkchecked(website,date) VALUES(:website,:data)");
        $insert_link->bindParam(':website', $line);
        $insert_link->bindParam(':data', $date);
        $insert_link->execute();

    }
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

function GetPayload()
{
    global $bdd;
    
    $select_log = $bdd->prepare("SELECT * FROM payloadcve");
    $select_log->execute();
    while($fetch = $select_log->fetch())
    {
        ?>
              <tr>
                <td><?php echo $fetch['id'];?></td>
                <td><?php echo $fetch['name'];?></td>
                <td><?php echo $fetch['payload']; ?></td>
                <td class="active"><?php echo $fetch['pattern']; ?></td>
                <td><?php echo $fetch['result']; ?></td>
              </tr>
        <?php
    }
}

function GetLink()
{
    global $bdd;
    
    $select_log = $bdd->prepare("SELECT * FROM linkchecked");
    $select_log->execute();
    while($fetch = $select_log->fetch())
    {
        $check = $fetch['checkeding'];
        if($check == '0')
            $check = '<i class="fa fa-times"></i>';
        else
            $check = '<i class="fa fa-check"></i>'
        ?>
              <tr>
                <td><?php echo $fetch['website'];?></td>
                <td><?php echo $check;?></td>
                  <td><a href='index.php?action=deletelink&id=<?php echo $fetch['id']; ?>'>delete</a></td>
              </tr>
        <?php
    }
}

function InsertPayload($name, $payload, $pattern, $result, $type)
{
    global $bdd;
    
    if($name != NULL && $payload != NULL && $pattern != NULL && $result != NULL && $type != "")
    {
        $insert = $bdd->prepare("INSERT INTO payloadcve(name,payload,pattern,result,perform) VALUES(:name, :payload,:pattern, :result, :type)");
        $insert->bindParam(':name', $name);
        $insert->bindParam(':payload', $payload);
        $insert->bindParam(':pattern', $pattern);
        $insert->bindParam(':result', $result);
        $insert->bindParam(':type', $type);
        $insert->execute();
        echo "<div class='alertcve'>Pyscan CVE added !</div>";
    }
    else
        echo "<div class='alertcvered'>Field empty</div>";
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

function countimported()
{
    global $bdd;
    $select = $bdd->prepare("SELECT COUNT(*) FROM linkchecked WHERE checkeding = '0'");
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