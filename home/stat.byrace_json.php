<?php
header('Content-Type: application/json');
include_once('../config/functions.php');
$rows = array();
$userid = $_SESSION['userid'];
$sql = "SELECT
        c30_keturunan.c30_desc_keturunan AS race_name, COUNT(*) AS total
    FROM
       m01_induk
        LEFT JOIN c30_keturunan
            ON (m01_induk.m01_kod_keturunan = c30_keturunan.c30_kod_keturunan)";

if($_SESSION['groupname']=='AHO'){
    $where .= " WHERE m01_induk.m01_userid='".$_SESSION['userid']."'";
}

$groupby = " GROUP BY c30_keturunan.c30_desc_keturunan";



$result = db_select($sql.$where.$groupby);
if (count($result) > 0) {

    foreach ($result as $row){

        $data = array($row['race_name'],$row['total']);
        array_push($rows,$data);


    }


}

echo json_encode($rows,JSON_NUMERIC_CHECK);
?>