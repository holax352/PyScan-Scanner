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
        
        <div class="imported">
            <h1 class="titre"><i class="fa fa-link"></i> Imported link</h1>
            <table>
              <tr>
                <th>Website</th>
                <th>Checked</th>
                <th>Delete</th>
              </tr>
                <?php
                GetLink();
                ?>
            </table>
        </div>
    </div>
</div>
<div class="footer"><i class="fa fa-copyright"></i> graniet PyScan</div>