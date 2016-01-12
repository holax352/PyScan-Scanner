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
            <h1 class="titre"><i class="fa fa-check"></i> Welcome to PyScan</h1>
            <p class="introduction">
                PyScan is a simple web vulnerability scanner you can start scan with python script : <br />
                <br />
                - <b>python PyScan.py -u "http://site.com" --all </b>(All payload scan)<br />
                - <b>python PyScan.py -u "http://site.com/index.php?id=1" -s -p [ID PAYLOAD]</b> (Single scan with payload ID)<br />
                - <b>python PyScan.py --database </b> ( Scan all link on database )<br />
            </p>
        </div>
        
        <div class="CVE">
            <h1 class="titre"><i class="fa fa-pencil"></i> Make Pyscan payload </h1>
            <form action="#" method="post">
                <input class="making" type="text" name="name" placeholder="CVE NAME" />
                <input class="making" type="text" name="payload" placeholder="Payload : ex id=" />
                <input class="making" type="text" name="pattern" placeholder="Pattern : ex  '" />
                <input class="making" type="text" name="result" placeholder="Text result" />
                <select class="selectcve" name="type">
                    <option value="result">Result based</option>
                    <option value="time">Time based</option>
                    <option value="compare">Compare based</option>
                </select>
                <input class="sendcve" type="submit" name="envoyer" value="make a CVE" />
            </form>
            <?php
            if(isset($_POST['envoyer']))
            {
                $name = $_POST['name'];
                $payload = $_POST['payload'];
                $pattern = $_POST['pattern'];
                $result = $_POST['result'];
                $type = $_POST['type'];
                InsertPayload($name, $payload, $pattern, $result, $type);
            }
            ?>
        </div>
        
        <div class="CVE">
            <h1 class="titre"><i class="fa fa-list"></i> Payload</h1>
            <table>
              <tr>
                <th>#id</th>
                <th>Name</th>
                <th>Payload</th>
                <th>Pattern</th>
                <th>Result</th>
              </tr>
                <?php
                GetPayload();
                ?>
            </table>
        </div>
    </div>
</div>
<div class="footer"><i class="fa fa-copyright"></i> graniet PyScan</div>