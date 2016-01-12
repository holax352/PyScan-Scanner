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
        <h1 class="titre"> Import link</h1>
            <form action="index.php" method="get" class="import">
                <input type="hidden" name="action" value="import" />
                <textarea class="link" name="link" placeholder="http://site.com/index.php?id=1 .. one by line"></textarea>
                <input type="submit" class="importsub" name="import" value="import file" />
            </form>
            <?php
            if(isset($_GET['import']) && $_GET['import'] != NULL)
            {
                $text = trim($_GET['link']);
                $textAr = explode("\n", $text);
                $textAr = array_filter($textAr, 'trim');

                foreach ($textAr as $line)
                {
                    insert_uncheck($line);
                }
                 echo "<div class='alertcve'>process end</div>";
            }
            ?>
        </div>
    </div>
</div>
<div class="footer">&copy; graniet PyScan</div>