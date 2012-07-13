<?php
if ($_GET['test'] == 1) {
mysql_connect('localhost','imbiss_test','sWLt2hzAGCJZWyMz','imbiss_test') or die(mysql_error());
mysql_select_db("imbiss_test") or die("M&Ouml;P". mysql_error());
echo "<div class='warn'>TEST DATENBANK!</div>";
} else {
//mysql_connect('10.4.16.26','www','JgOIE42g1a2aG','imbiss') or die(mysql_error());
mysql_connect('localhost','imbiss','hHBWvzD5qLLDKG2s','imbiss') or die(mysql_error());
mysql_select_db("imbiss") or die("M&Ouml;P");
}



?>

