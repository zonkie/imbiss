
<?php require_once('__connect.php'); ?>


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
?>
<html>
    <body>
        <table style="vertical-align:top;">
<?php
foreach ($aOrders AS $sUsername => $aProducts):
    ?>
                <tr>
                    <td style="vertical-align:top;">
    <?php echo $sUsername; ?>
                    </td>
                    <td style="vertical-align:top;">
                        <ul>

    <?php
    foreach ($aProducts AS $nProductId) {
        echo "<li>" . $aShopProducts[$nProductId]['title'] . "</li>";
    }
    ?>
                        </ul>
                    </td>
                </tr>
    <?php
endforeach;
?>
        </table>

        <table>
<?php
$sCountQuery = "SELECT product_id AS product_id, count(product_id) AS menge FROM orders WHERE date='" . date('Y-m-d') . "' GROUP BY product_id;";
$countQuery = mysql_query($sCountQuery);
$price=0;
while ($rowCount = mysql_fetch_array($countQuery)) {
    ?>
                <tr>
                    <td style = "vertical-align:top;">
    <?php
    echo $aShopProducts[$rowCount['product_id']]['title'];
    ?>
                    </td>
                    <td style = "vertical-align:top;">
    <?php
    echo $rowCount['menge'];
    ?>
                    </td>
                </tr>
    <?php
    $price += $aShopProducts[$rowCount['product_id']]['price'] * $rowCount['menge'];
}
?>
                <tr>
                    <td colspan="2">
                           <?php
    echo number_format($price/100,2,',','.');
    ?> &euro;
                    </td>
                </tr>    
        </table>
        <a href="index.php">Zur&uuml;ck</a>
    </body>
</html>