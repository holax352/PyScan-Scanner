<?php
require('config/config.php');
?>
<div class="container">
    <div class="header">
        <?php
        require_once('includes/menu.php');
        ?>
    </div>
    <div class="body">
        <div class="firstinfo">
        <h1 class="titre"> Import log file <small>( .pyscan )</small></h1>
            <form action="index.php" method="post" class="import">
                <input type="file" name="file" />
                <input type="submit" name="import" value="import file" />
            </form>
        </div>
    </div>
</div>
<div class="footer">&copy; graniet PyScan</div>