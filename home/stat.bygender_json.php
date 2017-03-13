<?php
header('Content-Type: application/json');
include_once('../config/functions.php');
$rows = array();
$userid = $_SESSION['userid'];

$sql = "SELECT
        c13_jantina.c13_desc_jantina AS gender_name, COUNT(*) AS total
    FROM
       m01_induk
        LEFT JOIN c13_jantina
            ON (m01_induk.m01_kod_jantina = c13_jantina.c13_kod_jantina)";

if($_SESSION['groupname']=='AHO'){
    $where .= " WHERE m01_induk.m01_userid='".$_SESSION['userid']."'";
}

$groupby = " GROUP BY c13_jantina.c13_desc_jantina";

$result = db_select($sql.$where.$groupby);
if (count($result) > 0) {

    foreach ($result as $row){

        $data = array($row['gender_name'],$row['total']);
        array_push($rows,$data);


    }


}

echo json_encode($rows,JSON_NUMERIC_CHECK);
?>