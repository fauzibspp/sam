<?php
/**
 * Created by PhpStorm.
 * User: fauzi
 * Date: 9/14/14
 * Time: 9:43 PM
 */
include_once('../config/config.php');

connDB();
mysql_query("BEGIN");
if(isset($_SESSION['groupid'])){
    if($_SESSION['groupid']==1){//admin
        $qry = "UPDATE notifications SET notice_status='seen',notice_update=CURRENT_TIMESTAMP WHERE FIND_IN_SET(notice_typeid,'1')";
    }else{
        $qry = "";
    }
    if(!empty($qry)){
        $rst = mysql_query($qry) or die("Error:".mysql_error());

        if($rst > 0){
            mysql_query("COMMIT");
        }else{
            mysql_query("ROLLBACK");
        }

        mysql_free_result($rst);
    }

}