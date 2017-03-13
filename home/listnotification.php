<?php
/**
 * Created by PhpStorm.
 * User: fauzi
 * Date: 9/14/14
 * Time: 4:52 PM
 */
include_once('../config/functions.php');

$scheme_id =  $_SESSION['schemaid'];
if(isset($_SESSION['groupid'])){
    if($_SESSION['groupid']==1){//pentadbir
        $qry = "SELECT notice_msg as msg,DATE_FORMAT(notice_created,'%Y-%m-%d %H:%i') as timedte FROM notifications WHERE FIND_IN_SET(notice_typeid,'1') AND notice_status='unseen' ORDER BY notice_created DESC LIMIT 0,5";
    }else{
        $qry = "";
    }
    if(!empty($qry)){
        //$rst = mysql_query($qry) or die("Error:".mysql_error());
        $rst = db_select($qry);
        foreach ($rst as $row){


            echo '<li>
                              <a href="#">
                                  <span class="label label-warning"><i class="icon-bell"></i></span>
            '.$row['msg'].'
                                  <br><span class="small italic" style="float:right">[ '.fnTimeAgo($row['timedte']).' ]</span>
                              </a>
                          </li>';
        }


    }


}

?>