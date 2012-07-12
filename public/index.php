<?php require_once('__connect.php'); ?>
<?php
$query = mysql_query("SELECT * FROM buyer WHERE date = '". date('Y-m-d') ."' LIMIT 1");
$buyer = mysql_fetch_array($query);
?>
<html>
<body>

<?php
if (count($buyer == 0)){
	//erst käufer eintragen
	
} else {
?>
	//Kauf-Formular
<form action="" method="post">
	<h2>Imbiss</h2>
	<?php
	//Fetch Products for Imbiss
	
	$query = mysql_query("SELECT * FROM products"); // 1= Imbiss

	
	while ($row = mysql_fetch_array($query)) {
		echo "<label> <checkbox name='products[]' value='". $row['id'] ."' / >". $row['title'] ." - ". ($row['price']/100) ."&euro;</label><br />";
	}
	?>
	
	<input type="submit" value="beim Imbiss bestellen" />
</form>
<form action="" method="post">
	<h2>Dönermann</h2>
	<?php
	//Fetch Products for Imbiss
	
	$sQuery = mysql_query("SELECT * FROM pruducts WHERE shop=2"); // 2= Döner
	

	while ($row = mysql_fetch_array($sQuery)){
		echo "<label> <checkbox name='products[]' value='". $row['id'] ."' / >". $row['title'] ." - ". ($row['price']/100) ."&euro;</label><br />";
	}
	?>
	
	<input type="submit" value="beim Dönermann bestellen" />
</form>	
<?php
}
?>