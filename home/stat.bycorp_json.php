<?php
header('Content-Type: application/json');
include_once('../config/functions.php');
$rows = array();
$userid = $_SESSION['userid'];


$sql = "SELECT
        c33_kor.c33_desc_kor AS corp_name,COUNT(*) AS total
    FROM
        m01_induk
        LEFT JOIN c33_kor
            ON (m01_induk.m01_kod_kor = c33_kor.c33_kod_kor)";

if($_SESSION['groupname']=='AHO'){
    $where .= " WHERE m01_induk.m01_userid='".$_SESSION['userid']."'";
}

$groupby = " GROUP BY c33_kor.c33_desc_kor";

$result = db_select($sql.$where.$groupby);
if (count($result) > 0) {
    foreach ($result as $row) {

        $data = array($row['corp_name'],$row['total']);
        array_push($rows,$data);


    }


}

echo json_encode($rows,JSON_NUMERIC_CHECK);
?>