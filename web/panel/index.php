<?php session_start();
?>
<html>
    <head>
        <title>Pyscan</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="styles.css" />
    </head>
    <div class="logo"><p class="titrelogo">PyScan scanner</p></div>
<?php
if(!isset($_SESSION['login']) || $_SESSION['login'] == '')
    require_once('page/login/index.php');
elseif(isset($_SESSION['login']) && $_SESSION['login'] != '')
{
    if(!isset($_GET['action']) || $_GET['action'] == "index")
        require_once('page/panel/index.php');
    elseif(isset($_GET['action']) && $_GET['action'] != '')
    {
        $dir = $_GET['action'];
        if(is_dir("page/$dir") && file_exists("page/$dir/index.php"))
            require_once("page/".$dir."/index.php");
        else
            echo "404 NOT FOUND";
    }
}
    ?>
</html>