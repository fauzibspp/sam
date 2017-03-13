<?php
//include_once('config/config.php');
//include_once('lib/Aes.php');
//include_once('lib/AesCtr.php');
include_once('config/functions.php');

$user_id = isset($_POST['userid']) ? $_POST['userid'] : "";
$user_pw = isset($_POST['userpwd']) ? $_POST['userpwd'] : "";
$inputKeySalt = inputKeySalt;
//query statement
$query = "SELECT
        userlogin.user_id,
        userlogin.userpwd,
        groups.group_name,
        groups.group_desc,
        userprofile.user_group_id,
        userprofile.user_scheme_id,
        userprofile.user_email as email,
        userprofile.user_images
        FROM
        userlogin
        LEFT JOIN userprofile ON userprofile.user_id = userlogin.user_id
        LEFT JOIN groups ON groups.group_id = userprofile.user_group_id
        WHERE userlogin.user_id = '$user_id'
        AND userlogin.userpwd=AES_ENCRYPT('$user_pw','$inputKeySalt')
        AND userprofile.user_status='1'";

//check existing record and match
$exist = db_check_data_exist($query);
$ipaddr = db_get_ipaddr();

//compare true or false
if($exist === TRUE){
    $rows = db_select($query);
    foreach ($rows as $row) {
        $_SESSION['userid'] = $row['user_id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['groupid'] = $row['user_group_id'];
        $_SESSION['groupname'] = $row['group_name'];
        $_SESSION['schemaid'] = $row['user_scheme_id'];
        $_SESSION['user_avatar'] = $row['user_images'];
    }
    //update
    $token = session_id();
    $query = "UPDATE userlogin SET token=".db_quote($token).", logintime=CURRENT_TIMESTAMP WHERE user_id=".db_quote($user_id)."";
    db_query($query);
    //track log
    $query = "INSERT INTO userlog
			SET logdesc='LOGIN SUCCESS',
			logtime = CURRENT_TIMESTAMP,
			logby = ".db_quote($user_id).",
			logbrowser = ".db_quote($browser).",
			logbrowserversion = ".db_quote($version).",
			logipaddr = ".db_quote($ipaddr).",
			logos = ".db_quote($os)."";
    db_query($query);
    //redirect to home
    //header('location: home/');
    echo 1;
}else{
    $query = "INSERT INTO userlog
			SET logdesc='LOGIN FAILED',
			logtime = CURRENT_TIMESTAMP,
			logby = ".db_quote($user_id).",
			logbrowser = ".db_quote($browser).",
			logbrowserversion = ".db_quote($version).",
			logipaddr = ".db_quote($ipaddr).",
			logos = ".db_quote($os)."";
    db_query($query);
    echo 2;
    //echo '<script>window.location.assign("index.php");</script>';
}



?>