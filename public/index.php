<?php
require_once('__connect.php');
error_reporting(E_ALL);
?>


<?php
if (isset($_POST) && !empty($_POST['action'])) {
    switch ($_POST['action']) {
        case "insert_buyer"; // Eink&auml;ufer eintragen
            $sQueryInsertBuyer = "INSERT INTO buyer VALUES ('" . $_POST['buyer'] . "',now(), '". date('Y-m-d H:i',strtotime(date('Y-m-d'). $_POST['deadline'])) ."');";
            echo $sQueryInsertBuyer;
            if (mysql_query($sQueryInsertBuyer)) {
                $result = "<div class='success'>K&auml;ufer eingetragen!</div>";
            } else {
                $result = "<div class='error'>Das hat nicht geklappt...</div>" . mysql_error();
                ;
            }
            break;

        case "1"; // Imbiss bestellung
            if ($_POST['user'] != '' && isset($_POST['products']) && count($_POST['products']) != 0) {
                foreach ($_POST['products'] AS $nProductId) {
                    if (mysql_query("INSERT INTO orders VALUES (null, now(), '" . $nProductId . "','" . $_POST['user'] . "');")) {
                        $geklappt = true;
                    } else {
                        $geklappt = false;
                        return;
                    }
                    if ($geklappt == true) {
                        $sQuery = "SELECT sum(price) AS gesamt FROM products WHERE id IN(" . implode(', ', $_POST['products']) . ")";
                        $query = mysql_query($sQuery); // 1= Imbiss
                        $price = mysql_fetch_array($query);
                        $result = "<div class='success'>Bestellung eingetragen. Bitte  <div class='warn'>" . number_format($price['gesamt'] / 100, 2, ',', '.') . "&euro;</div> an den Eink&auml;ufer bezahlen!</div>";
                    } else {
                        $result = "<div class='error'>Och n&ouml;&ouml;&ouml;&ouml;.... das hat nicht geklappt.</div>";
                    }
                }
            } elseif ($_POST['user'] == '') {
                $result = "<div class='warn'>Ald&auml; hackts oder w&auml;s? Gib'n Namen ein du Knackwuast! Sonst kein Mittach f&uuml;r dich!</div>";
            } elseif (isset($_POST['products']) && count($_POST['products']) == 0) {
                $result = "<div class='warn'>Ald&auml; hackts oder w&auml;s? W&auml;hl doch ma was aaauuuus ey! Oder haste kein' Hung&auml;?</div>";
            }

            break;

        case "2"; // D&ouml;ner Bestellung

            break;
    }
}
?>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
        <link type="text/css" rel="stylesheet" href="styles.css" />
    </head>
    <body>
        <h1>Bestellscript</h1>
        Achtung, Vorserienmodell ;)
        <?php
        if (!empty($result)) {
            echo $result;
        }
        ?>

        <?php
        $sQuery = "SELECT * FROM buyer WHERE date = '" . date('Y-m-d') . "' LIMIT 1";
        $query = mysql_query($sQuery);
        $buyer = mysql_fetch_array($query);
        $in_timewindow = (time() <= strtotime($buyer['deadline']) ) ? true : false;
        ?>
        <?php
        if ($buyer == false && empty($in_timewindow)):
            //erst k&auml;ufer eintragen
            ?>
            <form action = "" method = "post">
                <h2>Wer geht los?</h2>
                <input type = "hidden" name = "action" value = "insert_buyer" />
                <input type="text" name="buyer" placeholder="Wer geht los?" />
                <input type="text" name="deadline" placeholder="Deadline? z.B. 12:30" />
                <input type = "submit" value = "beim Imbiss bestellen" />
            </form>
            <?php
        elseif ($in_timewindow == false):
            ?>
        <div class="error">Zu sp&auml;t...</div>
            <?php
        else :
            ?>
            <h1>Der gl&uuml;ckliche Eink&auml;ufer lautet heute: <?php echo $buyer['name']; ?></h3>
            <!-- Kauf-Formular -->
            <form action="" method="post">
                <input type = "hidden" name = "action" value = "1">
                <h2>Imbiss</h2>
                <input type = "text" name = "user" placeholder="Dein Name?"><br />
                <?php
                //Fetch Products for Imbiss
                $query = mysql_query("SELECT * FROM products WHERE shop=1 ORDER BY type_id"); // 1= Imbiss
                while ($row = mysql_fetch_array($query)) {
                    $aProducts[$row['type_id']][] = $row;
                }
                echo "<h3>Hauptgerichte</h3>";
                foreach($aProducts[1] AS $row){
                    echo "<label><input type='checkbox' name='products[]' class='check_product' data-price='" . $row['price'] . "' value='" . $row['id'] . "' / >" . $row['title'] . " - " . number_format(($row['price'] / 100), 2, ',', '.') . "&euro;</label><br />";
                }
                
                echo "<h3>Beilagen</h3>";
                foreach($aProducts[2] AS $row){
                    echo "<label><input type='checkbox' name='products[]' class='check_product' data-price='" . $row['price'] . "' value='" . $row['id'] . "' / >" . $row['title'] . " - " . number_format(($row['price'] / 100), 2, ',', '.') . "&euro;</label><br />";
                }
                ?>
                <input type="submit" value="beim Imbiss bestellen" />
            </form>
            <!--
                        <form action="" method="post">
                            <input type = "hidden" name = "action" value = "2">
                            <h2>D&ouml;nermann</h2>
                            <input type = "text" name = "user" placeholder="Dein Name?"><br />
            <?php
            //Fetch Products for Imbiss
            $sQuery = mysql_query("SELECT * FROM pruducts WHERE shop=2 ORDER BY type_id"); // 2= D�ner
            while ($row = mysql_fetch_array($sQuery)) {
                echo "<label> <checkbox name='products[]' value='" . $row['id'] . "' />" . $row['title'] . " - " . number_format(($row['price'] / 100), 2, ',', '.') . "&euro;</label><br />";
            }
            ?>
                            <input type="submit" value="beim D&oouml;nermann bestellen" />
                        </form>	
            -->
        <?php
        endif;
        ?>



        <a href="list_order.php<?php if ($_GET['test'] == 1) {echo "?test=1";} ?>">Zur Bestell&uuml;bersicht</a>
