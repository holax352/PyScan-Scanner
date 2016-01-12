<?php
require_once('config/config.php');
if(isset($_GET['id']) && $_GET['id'] != '')
{
    $id = $_GET['id'];
    $select_link = $bdd->prepare("SELECT * FROM linkchecked WHERE id = :id");
    $select_link->bindParam(':id', $id);
    $select_link->execute();
    $fetch = $select_link->fetch();
    if($fetch['id'] != NULL)
    {
        $delete = $bdd->prepare("DELETE FROM linkchecked WHERE id = :id");
        $delete->bindParam(':id', $id);
        $delete->execute();
    }
}
?>
<script>document.location.href='index.php?action=imported'</script>