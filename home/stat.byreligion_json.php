<?php
header('Content-Type: application/json');
include_once('../config/functions.php');
$rows = array();
$userid = $_SESSION['userid'];

$sql = "SELECT
        c74_ugama.c74_desc_ugama AS religion_name, COUNT(*) AS total
    FROM
        m01_induk
            
        LEFT JOIN c74_ugama
            ON (m01_induk.m01_kod_agama = c74_ugama.c74_kod_ugama)";

if($_SESSION['groupname']=='AHO'){
    $where .= " WHERE m01_induk.m01_userid='".$_SESSION['userid']."'";
}

$groupby = " GROUP BY c74_ugama.c74_desc_ugama";

$result = db_select($sql.$where.$groupby);
if (count($result) > 0) {

    foreach ($result as $row){

        $data = array($row['religion_name'],$row['total']);
        array_push($rows,$data);


    }


}

echo json_encode($rows,JSON_NUMERIC_CHECK);
?>