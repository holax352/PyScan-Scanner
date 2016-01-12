<?php
$count_log = countlog();
$count_vuln = countvuln();
$count_unread_vuln = countunreadvuln();
$count_unread_logs = countunreadlog();
$count_imported = countimported();
?>
        <div class="menu">
            <ul>
                <li><a href='?action=index'>Acceuil</a></li>
                <li><a href='?action=log'>Pyscan log ( <?php echo $count_unread_logs; ?> )</a></li>
                <li><a href='?action=vuln'>Show V-DB ( <?php echo $count_unread_vuln; ?> )</a></li>
                <li><a href='?action=import'>Import link</a></li>
                <li><a href='?action=imported'>Imported link ( <?php echo $count_imported; ?> )</a></li>
                <li class="right"><a href='?action=logout'><i class="fa fa-power-off"></i></a></li>
            </ul>
        </div>