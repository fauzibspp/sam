<?php
include_once('config/functions.php');
//connDB();
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : "";
$ipaddr = $_SERVER["REMOTE_ADDR"];
if($userid != ""){
    $qryupdate = "UPDATE userlogin SET token='', logofftime=CURRENT_TIMESTAMP WHERE user_id='$userid'";
    db_query($qryupdate);
    session_destroy();
}else{
    session_destroy();
}
echo '<script>location.href="/'.$aliasname.'/"</script>';
?>