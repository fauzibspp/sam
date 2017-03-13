<?php
header('Content-Type: application/json');
include_once('../config/functions.php');

$query = "SELECT month(tarikh_pertemuan) as bulan, pegawai_pengendali as aho, count(pegawai_pengendali) as visit 
from pertemuan where pegawai_pengendali <> 'admin'";

$groupby = " GROUP BY pegawai_pengendali";

if($_SESSION['groupname']=='AHO'){
    $where .= " AND userid='".$_SESSION['userid']."'";
}

$rows = db_select($query.$where.$groupby);
$dataArr =  array();
foreach ($rows as $row){
    if($dataArr[$row['aho']]==null)
        $dataArr[$row['aho']] = array(0,0,0,0,0,0,0,0,0,0,0,0);

    $dataArr[$row['aho']][$row['bulan']-1] = $row['visit'];
}
//print_r($dataArr);
$chartData =  [array(
    "name" => "Month",
    "data" => ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
)];
while ($d = current($dataArr)){
    $cd = array();
    $cd['name'] = key($dataArr);
    $cd['data'] = $d;

    array_push($chartData,$cd);
    next($dataArr);

}

print json_encode($chartData, JSON_NUMERIC_CHECK);