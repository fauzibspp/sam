<?php
include_once("../config/functions.php");
/**
 * Created by PhpStorm.
 * User: fauzi
 * Date: 9/16/14
 * Time: 12:11 PM
 */
if($_POST)
{
    $items_per_group =2;
    //sanitize post value
    $group_number = filter_var($_POST["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
    //throw HTTP error if group number is not valid
    if(!is_numeric($group_number)){
        header('HTTP/1.1 500 Invalid number!');
        exit();
    }

    //get current starting point of records
    $position = ($group_number * $items_per_group);
    $userid = $_SESSION['userid'];
    $hariini = fnSQLCustom('SELECT DATE_FORMAT(CURDATE(),"%d-%m-%Y")  AS hariini','hariini');
    $q = "SELECT DATE_FORMAT(log_created,'%r') AS masa,log_event FROM log_activity WHERE log_status='seen' AND log_userid='$userid' AND DATE_FORMAT(log_created,'%d-%m-%Y')='$hariini' order by log_created desc";
    $rst = db_select($q);
    if($rst){
        $i=0;
        foreach ($rst as $row){
            if($i%2 == 0)
            {
                $class1 = 'activity terques';
                $class2 = 'icon-bell';
                echo '<div class="'.$class1.'">
                                              <span>
                                                  <i class="'.$class2.'"></i>
                                              </span>
                                              <div class="activity-desk">
                                                  <div class="panel">
                                                      <div class="panel-body">
                                                          <div class="arrow"></div>
                                                          <i class=" icon-time"></i>
                                                          <h4>'.$row['masa'].'</h4>
                                                          <p>'.$row['log_event'].'</p>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>';
            }
            else
            {
                $class1 = 'activity alt purple';
                $class2 = 'icon-rocket';
                echo '<div class="'.$class1.'">
                                              <span>
                                                  <i class="'.$class2.'"></i>
                                              </span>
                                              <div class="activity-desk">
                                                  <div class="panel">
                                                      <div class="panel-body">
                                                          <div class="arrow"></div>
                                                          <i class=" icon-time"></i>
                                                          <h4>'.$row['masa'].'</h4>
                                                          <p>'.$row['log_event'].'</p>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>';
            }
            $i++;
        }
    }
    
}
