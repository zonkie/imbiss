
<?php require_once('__connect.php'); ?>

    <?php
    if (!empty($_POST) && $_POST['action'] == 'pay_order') {
        $sQuery = "INSERT INTO paid (user_name, paid,date) VALUES ('" . $_POST['paid_name'] . "','" . ($_POST['paid_value'] * 100) . "',now() )";
        if (mysql_query($sQuery)) {
            echo "<div class='success'>" . $_POST['paid_name'] . " hat " . $_POST['paid_value'] . "&euro; Bezahlt!</div>";
        } else {
            echo "<div class='warn'>" . mysql_error() . "</div>";
        }
    }
    ?>
    <?php
    $query = mysql_query("SELECT * FROM products");
    while ($row = mysql_fetch_array($query)) {
        $aShopProducts[$row['id']]['shop'] = $row['shop'];
        $aShopProducts[$row['id']]['title'] = $row['title'];
        $aShopProducts[$row['id']]['price'] = $row['price'];
    }

    $sQuery = "SELECT * FROM orders WHERE date='" . date('Y-m-d') . "';";
    $query = mysql_query($sQuery);
    while ($row = mysql_fetch_array($query)) {
        $aOrders[$row['user_name']][] = $row['product_id'];
    }

    $sQuery = "SELECT * FROM paid WHERE date='" . date('Y-m-d') . "';";
    $query = mysql_query($sQuery);
    $aPaid = array();
    $nTotalPaid = 0;
    while ($row = mysql_fetch_array($query)) {
        $aPaid[$row['user_name']] = $row['paid'];
        $nTotalPaid += $row['paid'];
    }
    ?>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
        <link type="text/css" rel="stylesheet" href="styles.css" />
    </head>
    <body>
        <table style="vertical-align:top; border-collapse: border-collapse;">
                <?php
                foreach ($aOrders AS $sUsername => $aProducts):
                    $userPrice = 0;
                    ?>
                                <tr style="vertical-align:top; border: 1px solid #333; border-collapse: border-collapse;">
                                    <td style="vertical-align:top; border-top: 1px solid #333; border-collapse: border-collapse;">
                            <?php echo $sUsername; ?>
                                    </td>
                                    <td style="vertical-align:top; border-top: 1px solid #333; border-collapse: border-collapse;">
                                        <ul>

                                <?php
                                foreach ($aProducts AS $nProductId) {
                                    echo "<li>" . $aShopProducts[$nProductId]['title'] . "</li>";
                                    $userPrice += $aShopProducts[$nProductId]['price'];
                                }
                                ?>
                                        </ul>
                                    </td>
                                    <td style="vertical-align:top; border-top: 1px solid #333; border-collapse: border-collapse;">
                                    Preis: <?php echo number_format($userPrice / 100, 2, ',', '.'); ?>
                                        
                            <?php
                            if (isset($aPaid) && !empty($aPaid[$sUsername])):
                                ?>
                                            <br /> <div class="success">Bezahlt: <?php echo number_format($aPaid[$sUsername]/ 100, 2, ',', '.'); ?>&euro;</div>
                                <?php
                            else:
                                ?>
                                        <form name="pay" action="" method="post">
                                            <input type="hidden" name="action" value="pay_order">
                                            <input type="hidden" name="paid_name" value="<?php echo $sUsername; ?>">
                                            <input type="text" name="paid_value" placeholder="0.00">
                                            <input type="submit" value="bezahlt">
                                        </form>
                            <?php
                            endif;
                            ?>
                                    </td>
                                </tr>
                    <?php
                endforeach;
                ?>
        </table>

        <table style="border: 1px solid #000; border-collapse: collapse;">
            <?php
            $sCountQuery = "SELECT product_id AS product_id, count(product_id) AS menge FROM orders WHERE date='" . date('Y-m-d') . "' GROUP BY product_id;";
            $countQuery = mysql_query($sCountQuery);
            $price = 0;
            while ($rowCount = mysql_fetch_array($countQuery)) {
                ?>
                                <tr style="border: 1px solid #000; border-collapse: collapse;">
                                    <td style = "vertical-align:top;border: 1px solid #000; border-collapse: collapse;">
                        <?php
                        echo $aShopProducts[$rowCount['product_id']]['title'];
                        ?>
                                    </td>
                                    <td style = "vertical-align:top;border: 1px solid #000; border-collapse: collapse; padding:5px;">
                        <?php
                        echo $rowCount['menge'];
                        ?>
                                    </td>
                                </tr>
                    <?php
                    $price += $aShopProducts[$rowCount['product_id']]['price'] * $rowCount['menge'];
                }
                ?>
            <tr style="border: 1px solid #000; border-collapse: collapse;">
                <td colspan="2" style="border: 1px solid #000; border-collapse: collapse; padding: 5px;">
                    <?php
                    if($nTotalPaid >= $price ) {
                       echo "<div class='success'>";
                    } else {
                       echo "<div class='warn'>";
                    }
                    echo "Gesamt: ". number_format($price / 100, 2, ',', '.');
                    ?> &euro;<br />
                    <?php
                    echo "Bezahlt: ". number_format($nTotalPaid / 100, 2, ',', '.');
                    ?> &euro;<br />
                    </div>
                </td>
            </tr>    
        </table>
        <a href="index.php<?php if ($_GET['test'] == 1) {echo "?test=1";} ?>">Zur&uuml;ck</a>
    </body>
</html>
