<?php
require('config/config.php');
updatelog();
?>
<div class="container">
    <div class="header">
    <div class="header">
        <?php
        require_once('includes/menu.php');
        ?>
    </div>
    </div>
    <div class="body">
        <h1 class="titre">Total : <?php echo $count_log; ?></h1>
        <div class="firstinfo">
            <div class="search">
                <form action="index.php" method="get">
                    <input type="hidden" name="action" value="search" />
                    <input type="text" name="site" name="domain" />
                    <input type="submit" name="search" value="search now" />
                </form>
            </div>
            <table>
              <tr>
                <th>#id</th>
                <th>date</th>
                <th>Domain</th>
                <th>Lien</th>
                <th>Type</th>
                <th>Source</th>
              </tr>
                <?php
                $domain = $_GET['site'];
                GetSearchVuln($domain);
                ?>
            </table>
        </div>
    </div>
</div>
<div class="footer">&copy; graniet PyScan</div>