<?php
header('Content-Type: application/json');
include_once('../config/functions.php');
$rows = array();
$userid = $_SESSION['userid'];

$sql = "SELECT class_pertemuan.nama_pertemuan as isu_pertemuan, count(pertemuan.class_pertemuan) as total
    FROM pertemuan LEFT JOIN class_pertemuan ON pertemuan.class_pertemuan = class_pertemuan.id";

if($_SESSION['groupname']=='AHO'){
    $where .= " WHERE year(pertemuan.tarikh_pertemuan) = year(current_timestamp) AND pertemuan.userid='".$_SESSION['userid']."'";
}


$result = db_select($sql.$where);
if (count($result) > 0) {

    foreach ($result as $row){

        $data = array($row['isu_pertemuan'],$row['total']);
        array_push($rows,$data);


    }


}

echo json_encode($rows,JSON_NUMERIC_CHECK);
?>