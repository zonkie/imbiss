<?php require_once('__connect.php');
error_reporting(E_ALL);
 ?>


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
			$sQuery = "SELECT sum(price) AS gesamt FROM products WHERE id IN(".  implode(', ', $_POST['products']) .")";
			$query = mysql_query($sQuery); // 1= Imbiss
			$price = mysql_fetch_array($query);
                        $result = "<div style='background:#cfc;border: 1px dashed #0f0;' >Bestellung eingetragen. Bitte  " . number_format($price['gesamt']/100,2,',','.') ."&euro; an den Einkäer bezahlen!</div>";
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
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
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
        ?>
        <?php
        if ($buyer==false):
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
            <h1>Der gl&uuml;ckliche Eink&auml;ufer lautet heute: <?php echo $buyer['name']; ?></h3>
            <!-- Kauf-Formular -->
            <form action="" method="post">
                <input type = "hidden" name = "action" value = "1">
                <h2>Imbiss</h2>
                <input type = "text" name = "user" placeholder="Dein Name?"><br />
                <?php
                //Fetch Products for Imbiss
                $query = mysql_query("SELECT * FROM products WHERE shop=1"); // 1= Imbiss
                while ($row = mysql_fetch_array($query)) {
                    echo "<label><input type='checkbox' name='products[]' class='check_product' data-price='". $row['price'] ."' value='" . $row['id'] . "' / >" . $row['title'] . " - " . number_format(($row['price'] / 100), 2, ',', '.') . "&euro;</label><br />";
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
