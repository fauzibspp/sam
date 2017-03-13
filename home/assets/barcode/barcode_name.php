<?php
require("php-barcode-name.php");
$result = barcode_print($_POST['id'],$_POST['name'],'128',1,'jpg');
//echo $result;
?>
