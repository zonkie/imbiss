<?php require_once('__connect.php'); ?>


<?php
if (isset($_POST) && !empty($_POST['action'])) {
    switch ($_POST['action']) {
        case "insert_buyer"; // Einkäufer eintragen
            if (mysql_query("INSERT INTO buyer VALUES ('" . $_POST['buyer'] . "',now());")) {
                $result = "K&auml;ufer eingetragen!";
            } else {
                $result = "Das hat nicht geklappt..." . mysql_error();
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
                        $result = "Bestellung eingetragen: " . implode(', ', $_POST['products']);
                    } else {
                        $result = "Och n&ouml;&ouml;&ouml;&ouml;.... das hat nicht geklappt.";
                    }
                }
            } elseif ($_POST['user'] == '') {
                $result = "Ald&auml; hackts oder w&auml;s? Gib'n Namen ein du Knackwuast! Sonst kein Mittach f&uuml;r dich!";
            } elseif (isset($_POST['products']) && count($_POST['products']) == 0) {
                $result = "Ald&auml; hackts oder w&auml;s? W&auml;hl doch ma was aaauuuus ey! Oder haste kein' Hung&auml;?";
            }

            break;

        case "2"; // Döner Bestellung

            break;
    }
}
?>
<html>
    <body>
        <?php
        if (!empty($result)) {
            echo $result;
        }
        ?>

        <?php
        $sQuery = "SELECT * FROM buyer WHERE date = '" . date('Y-m-d') . "' LIMIT 1";
        $query = mysql_query($sQuery);
        $buyer = mysql_fetch_array($query);
        ?>
        <?php
        if (count($buyer) == 0):
            //erst käufer eintragen
            ?>
            <form action = "" method = "post">
                <h2>Wer geht los?</h2>
                <input type = "hidden" name = "action" value = "insert_buyer">
                <input type="text" name="buyer" placeholder="Wer geht los?">
                <input type = "submit" value = "beim Imbiss bestellen" />
            </form>
            <?php
        else :
            ?>
            <h1>Der gl&uuml;ckliche Eink&auml;fer lautet heute: <?php echo $buyer['name']; ?></h3>
            <!-- Kauf-Formular -->
            <form action="" method="post">
                <input type = "hidden" name = "action" value = "1">
                <h2>Imbiss</h2>
                <input type = "text" name = "user" placeholder="lauten wie, dein Name?"><br />
                <?php
                //Fetch Products for Imbiss
                $query = mysql_query("SELECT * FROM products WHERE shop=1"); // 1= Imbiss
                while ($row = mysql_fetch_array($query)) {
                    echo "<label><input type='checkbox' name='products[]' value='" . $row['id'] . "' / >" . $row['title'] . " - " . number_format(($row['price'] / 100), 2, ',', '.') . "&euro;</label><br />";
                }
                ?>
                <input type="submit" value="beim Imbiss bestellen" />
            </form>
<!--
            <form action="" method="post">
                <input type = "hidden" name = "action" value = "2">
                <h2>D&ouml;nermann</h2>
                <input type = "text" name = "user" placeholder="lauten wie, dein Name?"><br />
                <?php
                //Fetch Products for Imbiss
                $sQuery = mysql_query("SELECT * FROM pruducts WHERE shop=2"); // 2= D�ner
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



<a href="list_order.php">Zur Bestell&uuml;bersicht</a>