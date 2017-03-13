<?php
require("php-barcode-serial.php");
$result = barcode_print($_POST['id'],'128',1,'jpg');
//echo $result;
?>
