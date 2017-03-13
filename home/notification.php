<?php
/**
 * Created by PhpStorm.
 * User: fauzi
 * Date: 9/14/14
 * Time: 2:22 PM
 */
include_once('../config/functions.php');
$scheme_id =  isset($_SESSION['schemaid']) ? $_SESSION['schemaid'] : 0;
if(isset($_SESSION['groupid'])){
    if($_SESSION['groupid']==1){//pentadbir
        $qry = "SELECT COUNT(*) AS total FROM notifications WHERE FIND_IN_SET(notice_typeid,'1') AND notice_status='unseen'";
    }else{
        $qry = "";
    }
    if(!empty($qry)){
        $rst = db_select($qry);
        echo $rst[0]['total'];
    }

}

