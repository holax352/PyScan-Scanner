<?php
require('config/config.php');
$count_log = countlog();
$count_vuln = countvuln();
?>
<div class="container">
    <div class="header">
        <div class="menu">
            <ul>
                <li><a href=''>Acceuil</a></li>
                <li><a href=''>Pyscan log ( <?php echo $count_log; ?> )</a></li>
                <li><a href=''>Show V-DB ( <?php echo $count_vuln; ?> )</a></li>
                <li class="right"><a href='?action=logout'>Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="body">
        <div class="firstinfo">
        
        </div>
    </div>
</div>
<div class="footer">&copy; graniet PyScan</div>