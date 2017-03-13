<?php
session_start();
define('APP_NAME',"SAM");
define('APP_WARNING','Amaran!!!');
$servername = 'localhost';
$aliasname = '/';
define('hostname','localhost');
define('dbname','spkbt');
define('dbuser','root');
define('dbpwd','root');
define('dbport',8889);

//remote config

define('useridremote','root');
define('userpwremote','root');
define('dbremote','kadpengenalan');

function connDB(){
    if (!@mysql_connect(hostname.':'.dbport,dbuser,dbpwd)){ //local
        die('connection error' . mysql_errno() . ':' . mysql_error());
    }
    else {
        mysql_select_db(dbname);//server local
    }

}
function connDB2(){
    if (!@mysql_connect(hostname.':'.dbport,useridremote,userpwremote)){ //local
        die('connection error' . mysql_errno() . ':' . mysql_error());
    }
    else {
        mysql_select_db(dbremote );//server local
    }

}

function fnSQLCustomWithWhileLoop($script="",$fldname){
    connDB();
   // echo $script;
    $rst = mysql_query($script) or die('Error:'.mysql_error());
    $data = '';
    if(mysql_num_rows($rst) > 0){

        while($row = mysql_fetch_assoc($rst)){
            $data .= '<li>'.$row[$fldname].'</li>';
        }
        return '<ul>'.$data.'</ul>';
    }
    mysql_free_result($rst);
}
function fnSQLCustom($script="",$fldname){
    connDB();
    //echo $script;
    $rst = mysql_query($script);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data[$fldname];
    }
    mysql_free_result($rst);
}
function fnSQLCustomRow($script="",$fldname){
    connDB();
    //echo $script;
    $rst = mysql_query($script);
    //$data = mysql_fetch_assoc($rst);
    return mysql_num_rows($rst);
    mysql_free_result($rst);
}
function fnLogEvent($log_event=NULL,$userid=NULL){
    connDB();
    $ip = $_SERVER['REMOTE_ADDR'];
    $qinsert = "INSERT INTO log_activity SET log_event='$log_event',
    log_created = current_timestamp, log_status='unseen',
    log_userid = '$userid',log_ipaddr = '$ip'";
    mysql_query($qinsert) or die('Error:'. mysql_error());
}
function fnTimeAgo($date)
{
    date_default_timezone_set("Asia/Kuala_Lumpur");
    //echo date("Y-m-d H:i:s");

    if(empty($date)) {
        return "No date provided";
    }

    $periods         = array("saat", "minit", "jam", "hari", "minggu", "bulan", "tahun", "dekad");
    $lengths         = array("60","60","24","7","4.35","12","10");

    $now             = time();
    $unix_date       = strtotime($date);

    // check validity of date
    if(empty($unix_date)) {
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {
        $difference     = $now - $unix_date;
        $tense         = "lalu";

    } else {
        $difference     = $unix_date - $now;
        $tense         = "";
    }

    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if($difference != 1) {
        $periods[$j].= "";
    }

    return "$difference $periods[$j] {$tense}";
}
function fnSaveNotification($actor_id,$question_id=null,$notice_receipient=null,$status = null,$msg = null,$scheme_id = null){
    //$question_id == $report_id
    //$scheme_id == $group_id
    connDB();
    $qinsert = "INSERT INTO notifications SET notice_actor_id='$actor_id',
    notice_questions_id='$question_id',notice_typeid='$notice_receipient',
    notice_status='$status',notice_msg='$msg',notice_scheme_id='$scheme_id',
    notice_created=CURRENT_TIMESTAMP";
    mysql_query($qinsert) or die('Error:'. mysql_error());
}



function fnGetIndex($tablename,$fieldname){
    connDB();
    $select = "select max($fieldname) as maxid from $tablename";
    $rst = mysql_query($select);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data['maxid']+1;
    }else{
        return 1;
    }
    mysql_free_result($rst);
}
function fnGetRecord($id,$tablename,$fieldname,$where) {
    connDB();
    $select = "select $fieldname from $tablename where $where='$id'";
    $rst = mysql_query($select);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data[$fieldname];
    }
    mysql_free_result($rst);
}
function fnGetRecord1Param($fldwhere1,$fieldname,$tablename,$param1) {
    connDB();
    $select = "select $fieldname from $tablename where $fldwhere1='$param1'";
    $rst = mysql_query($select);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data[$fieldname];
    }
    //mysql_close();
}
function fnGetRecord2Param($fldwhere1,$fldwhere2,$fieldname,$tablename,$where1,$where2) {
    connDB();
    $select = "select $fieldname from $tablename where $fldwhere1='$where1' and $fldwhere2='$where2'";
    $rst = mysql_query($select);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data[$fieldname];
    }
   mysql_free_result($rst);
}
function fnGetProfile($userid) {
    connDB();
    $select = "SELECT
    userprofile.user_name as username,
    groups.group_name as groupname
    FROM
    a01_groups
    LEFT JOIN groupusers ON groups.group_id = groupusers.group_id
    LEFT JOIN userprofile ON userprofile.user_id = groupusers.user_id
    WHERE a03_userprofile.a03_user_id='$userid'
    ";
    $rst = mysql_query($select);
    $data = mysql_fetch_assoc($rst);
    $datafound = '';
    if (mysql_num_rows($rst) > 0 ) {
        $datafound = $data['groupname'].'&nbsp;'.$data['username'].'&nbsp;<br/><span style="font-size:x-small">('.$data['kumpulan'].')</span>';
    }
    return $datafound;
    //mysql_close();
}
function fnCheckExistingRecord1Param($id,$tablename,$fieldname) {
    connDB();
    $select = "select $fieldname from $tablename where $fieldname='$id'";
    $rst = mysql_query($select);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return 1;
    }
    else{
        return 0;

    }
    mysql_free_result($rst);
}
function fnCheckExistingRecord2Param($param1,$param2,$tablename,$fieldname1,$fieldname2){
    connDB();
    $qry = "SELECT $fieldname1 FROM $tablename where $fieldname1='$param1' and $fieldname2='$param2'";
    $rst = mysql_query($qry);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return 1;
    }else{
        return 0;
    }
    mysql_free_result($rst);
}
function fnCheckExistingRecord2OrParam($param1,$param2,$tablename,$fieldname1,$fieldname2){
    connDB();
    echo $qry = "SELECT $fieldname1 FROM $tablename where $fieldname1='$param1' Or $fieldname2='$param2'";
    $rst = mysql_query($qry);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return 1;
    }else{
        return 0;
    }
    mysql_free_result($rst);
}
function fnCheckExistingRecord3Param($param1,$param2,$param3,$tablename,$fieldname1,$fieldname2,$fieldname3){
    connDB();
    $qry = "SELECT $fieldname1 FROM $tablename where $fieldname1='$param1' and $fieldname2='$param2' and $fieldname3='$param3'";
    $rst = mysql_query($qry);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return 1;
    }else{
        return 0;
    }
    mysql_free_result($rst);
}
function CryptFile($InFileName,$OutFileName,$password){
//check the file if exists
    if (file_exists($InFileName)){

//get file content as string
        $InFile = file_get_contents($InFileName);

// get string length
        $StrLen = strlen($InFile);

// get string char by char
        for ($i = 0; $i < $StrLen ; $i++){
//current char
            $chr = substr($InFile,$i,1);

//get password char by char
            $modulus = $i % strlen($password);
            $passwordchr = substr($password,$modulus, 1);

//encryption algorithm
            $OutFile .= chr(ord($chr)+ord($passwordchr));
        }

        $OutFile = base64_encode($OutFile);

//write to a new file
        if($newfile = fopen($OutFileName, "w")){
            file_put_contents($OutFileName,$OutFile);
            fclose($newfile);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function DecryptFile($InFileName,$OutFileName,$password){
$OutFile = "";
//check the file if exists
    if (file_exists($InFileName)){
//get file content as string
        $InFile = file_get_contents($InFileName);

        $InFile = base64_decode($InFile);
// get string length
        $StrLen = strlen($InFile);

// get string char by char
        for ($i = 0; $i < $StrLen ; $i++){
//current char
            $chr = substr($InFile,$i,1);

//get password char by char
            $modulus = $i % strlen($password);
            $passwordchr = substr($password,$modulus, 1);

//encryption algorithm
            $OutFile .= chr(ord($chr)-ord($passwordchr));
        }

//write to a new file
        if($newfile = fopen($OutFileName, "w")){
            file_put_contents($OutFileName,$OutFile);
            fclose($newfile);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
#======
function fnComboBox($fld1,$fld2,$tblName,$value,$objName,$class,$objDesc)
{
    connDB();
    $qry = "SELECT $fld1,$fld2 FROM $tblName";
    $cond = " ORDER BY $fld2 asc";
    //echo $qry.$cond;
    $results = mysql_query($qry.$cond);
    echo "<select id='$objName' name='$objName' class='$class'>";
    echo "<option value='' selected>--$objDesc--</option>";
    while($row = mysql_fetch_array($results))
    {
        $id = $row[$fld1];
        $desc = $row[$fld2];

        if($id==$value)
        {
            echo "<option value=\"$id\" selected>$desc</option>";
        }
        else
        {
            echo "<option value=\"$id\">$desc</option>";
        }
    }
    echo"</select>";

}
function fnComboBox1($fld1,$fld2,$tblName,$value,$objName,$class,$objDesc)
{
    connDB();
    $qry = "SELECT $fld1,$fld2 FROM $tblName";
    $cond = " ORDER BY $fld2 asc";
    //echo $qry.$cond;
    $results = mysql_query($qry.$cond);
    echo "<select id='$objName' name='$objName' class='$class'>";
    echo "<option value='' selected>--$objDesc--</option>";
    while($row = mysql_fetch_array($results))
    {
        $id = $row[$fld1];
        $desc = $row[$fld2];

        if($id==$value)
        {
            echo "<option value=\"$id\" selected>$desc</option>";
        }
        else
        {
            echo "<option value=\"$id\">$desc</option>";
        }
    }
    echo"</select>";

}
#====================================================================================
function fnComboBox2($fld1,$fld2,$tblName,$value,$objName,$class,$objDesc,$onchange)
{
    connDB();
    $qry = "SELECT $fld1,$fld2 FROM $tblName";
    $cond = " ORDER BY $fld2 asc";
    //echo $qry.$cond;
    $results = mysql_query($qry.$cond);
    echo "<select id='$objName' name='$objName' class='$class' onchange='$onchange'>";
    echo "<option value='' selected>--$objDesc--</option>";
    while($row = mysql_fetch_array($results))
    {
        $id = $row[$fld1];
        $desc = $row[$fld2];

        if($id==$value)
        {
            echo "<option value=\"$id\" selected>$desc</option>";
        }
        else
        {
            echo "<option value=\"$id\">$desc</option>";
        }
    }
    echo"</select>";

}
#====================================================================================
function fnComboBox3($fld1,$fld2,$tblName,$value,$objName,$class,$objDesc,$where = NULL)
{
    connDB();
    $qry = "SELECT $fld1,$fld2 FROM $tblName $where";
    $cond = " ORDER BY $fld2 asc";
    //echo $qry.$cond;
    $results = mysql_query($qry.$cond);
    echo "<select id='$objName' name='$objName' class='$class'>";
    echo "<option value='' selected>--$objDesc--</option>";
    while($row = mysql_fetch_array($results))
    {
        $id = $row[$fld1];
        $desc = $row[$fld2];

        if($id==$value)
        {
            echo "<option value=\"$id\" selected>$desc</option>";
        }
        else
        {
            echo "<option value=\"$id\">$desc</option>";
        }
    }
    echo"</select>";

}
function fnComboBox4($fld1,$fld2,$tblName,$value,$objName,$class,$objDesc,$where = NULL)
{
    connDB();
    $qry = "SELECT $fld1,$fld2 FROM $tblName $where";
    $cond = " ORDER BY $fld1 asc";
    //echo $qry.$cond.$value;
    $results = mysql_query($qry.$cond);
    echo "<select id='$objName' name='$objName' class='$class'>
    onchange='jsSelectObj(this.options[selectedIndex].value)'>";
    echo "<option value='' selected>--$objDesc--</option>";
    while($row = mysql_fetch_array($results))
    {
        $id = $row[$fld1];
        $desc = $row[$fld2];

        if($id==$value)
        {
            echo "<option value=\"$id\" selected>$desc</option>";
        }
        else
        {
            echo "<option value=\"$id\">$desc</option>";
        }
    }
    echo"</select>";

}
#====================================================================================
function fnComboBox5($fld1,$fld2,$fld3,$tblName,$value,$objName,$class,$objDesc,$where = NULL)
{
    connDB();
    $qry = "SELECT $fld1,$fld2,$fld3 FROM $tblName $where";
    $cond = " ORDER BY $fld3 asc";
    //echo $qry.$cond;
    $results = mysql_query($qry.$cond);
    echo "<select id='$objName' name='$objName' class='$class'>";
    echo "<option value='' selected>--$objDesc--</option>";
    while($row = mysql_fetch_assoc($results))
    {
        $id = $row[$fld1];
        $desc = $row[$fld2];
        $desc2 = $row[$fld3];
        if($id==$value)
        {
            echo "<option value=\"$id\" selected>$desc ($desc2)</option>";
        }
        else
        {
            echo "<option value=\"$id\">$desc ($desc2)</option>";
        }
    }
    echo"</select>";

}
function fnComboBox6($fld1,$fld2,$tblName,$value,$objName,$class,$objDesc,$where = NULL,$order = NULL)
{
    connDB();
    $qry = "SELECT $fld1,$fld2 FROM $tblName $where";
    $cond = " $order";
    //echo $qry.$cond;
    $results = mysql_query($qry.$cond);
    echo "<select id='$objName' name='$objName' class='$class'>";
    echo "<option value='' selected>--$objDesc--</option>";
    while($row = mysql_fetch_array($results))
    {
        $id = $row[$fld1];
        $desc = $row[$fld2];

        if($id==$value)
        {
            echo "<option value=\"$id\" selected>$desc</option>";
        }
        else
        {
            echo "<option value=\"$id\">$desc</option>";
        }
    }
    echo"</select>";

}
/*
 * @fnSelect
 * @
 */
function fnSelect($fld1,$fld2,$tblName,$value,$objName,$class,$objDesc,$where = NULL,$order = NULL,$validate='')
{
    connDB();
    $qry = "SELECT $fld1,$fld2 FROM $tblName $where";
    $cond = " $order";
    //echo $qry.$cond.$value;
    $results = mysql_query($qry.$cond) or die('Error:'.mysql_error().' Script:'.$qry);
    //echo "<select id='$objName' name='$objName' class='$class' $validate>";

    if($objDesc != ""){
        echo "<select id='$objName' name='$objName' class='$class' $validate>";
        echo "<option value='' selected>--$objDesc--</option>";
    }else{
        echo "<select id='$objName' name='$objName.[]' class='$class' $validate>";

    }

    while($row = mysql_fetch_array($results))
    {
        $id = $row[$fld1];
        $desc = $row[$fld2];

        if($id==$value)
        {
            echo "<option value=\"$id\" selected>$desc</option>";
        }
        else
        {
            echo "<option value=\"$id\">$desc</option>";
        }
    }
    echo"</select>";

}


function random_id($prefix,$length){

    $random = $prefix.substr(number_format(time() * rand(),0,'',''),0,(int)$length);

    return $random;
}
function fnSumRecordItem1($param1,$tablename,$where,$fieldsum,$param2){
    connDB();
    $qry = "SELECT SUM($fieldsum) as totalrecord FROM $tablename where $where='$param1' $param2";

    $rst = mysql_query($qry) or die('MySQL Error: '.mysql_error());
    $data = mysql_fetch_array($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data['totalrecord'];
    }
    mysql_free_result($rst);

}

function fnCheckCountRecordItem1($param1,$tablename,$where,$fieldcount){
    connDB();
    $qry = "SELECT count($fieldcount) as totalrecord FROM $tablename where $where='$param1'";
    $rst = mysql_query($qry) or die('MySQL Error: '.mysql_error());
    $data = mysql_fetch_array($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data['totalrecord'];
    }
    mysql_free_result($rst);

}
function fnCheckCountRecordItem2($param1,$param2,$tablename,$where1,$where2,$fieldcount){
    connDB();
    $qry = "SELECT count($fieldcount) as totalrecord FROM $tablename where $where1='$param1' and $where2='$param2'";
    $rst = mysql_query($qry) or die('MySQL Error: '.mysql_error());
    $data = mysql_fetch_array($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data['totalrecord'];
    }
    mysql_free_result($rst);

}
function delete_directory($dirname) {
//version 5.1 above
    $dir_handle = '';
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}


function fnModuleAccessByGroup($groupid,$moduleid){
    connDB();
    $sql = "SELECT role_id FROM roleaccess
    WHERE role_group_id='$groupid' AND role_permission_id='$moduleid'";
    $rst = mysql_query($sql) or die('Error:'.$sql);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return true;
    }else{
        return false;
    }
    mysql_free_result($rst);
}
function fnModuleAccessByUser($userid,$moduleid){
    connDB();
    $sql = "SELECT role_id FROM roleaccess_user
    WHERE role_user_id='$userid' AND role_permission_id='$moduleid'";
    $rst = mysql_query($sql) or die('Error:'.$sql);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return true;
    }else{
        return false;
    }
    mysql_free_result($rst);
}
function encryptLink($var1,$var2,$var3,$val1,$val2,$val3,$pageLanding)
{
    $keySalt = "MoH2014";  // change it

    $qryStr = $var1.$val1.$var2.$val2.$var3.$val3;  //making query string

    $query = base64_encode(urlencode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($keySalt), $qryStr, MCRYPT_MODE_CBC, md5(md5($keySalt)))));    //this line of code encrypt the query string

    $link = $pageLanding.$query;

    return $link;

}
function fnGetRecordSum($jsu_id){
    $qry = "SELECT SUM(jsu_cognitive_obj_total) as A,SUM(jsu_cognitive_essei_total) as B FROM jsu_master_details WHERE jsu_id = '$jsu_id'";
    $rst = mysql_query($qry) or die('Error:'.mysql_error().' Script:'.$qry);
    $data = mysql_fetch_array($rst);
    if (mysql_num_rows($rst) > 0 ) {
        $obj_total = isset($data['A']) ? $data['A'] : 0;
        $essei_total  = isset($data['B']) ? $data['B'] : 0;
        $TotalQuestionSum = (int)$obj_total + (int)$essei_total;
    }
    return $TotalQuestionSum;
}

function fnGetRecordCustom2($qry_script,$field_name){
    $qry = $qry_script;
    $rst = mysql_query($qry) or die('Error:'.mysql_error());
    $row = mysql_fetch_assoc($rst);
    if(mysql_num_rows($rst) > 0){
        return $row[$field_name];
    }
    mysql_free_result($rst);
}


/*
 * http://salman-w.blogspot.com/2012/08/php-adjacency-list-hierarchy-tree-traversal.html
 * Recursive top-down tree traversal example:
 * Indent and print child nodes
 */
function display_child_nodes($parent_id, $level)
{
    global $data, $index;
    $parent_id = $parent_id === NULL ? "NULL" AND 0 : $parent_id;
    if (isset($index[$parent_id])) {
        echo '<ul>';
        foreach ($index[$parent_id] as $id) {

            echo '<li>'.str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $level) . $data[$id]["name"] . ' <i>(<span class="text-primary">Oleh:</span> <span class="text-info">'.$data[$id]["owner"].'</span>)</i>';
            //echo '<li>'.str_repeat("", $level) . $data[$id]["name"] . ' <i>(Oleh: '.$data[$id]["owner"].')</i>';
            echo '<a title="Padam" href="javascript:void(0)" id="'.$id.'" data-name="'.$data[$id]["name"].'" class="topic_class">&nbsp;<i class="icon-trash"></i></a>&nbsp;';
            //echo '<a title="Sunting" href="javascript:void(0)" id="'.$id.'" class="topic_edit">&nbsp;<i class="icon-edit"></i></a></li>';

            echo '<a title="Sunting" href="#myEditTopic" id="topic_edit" data-toggle="modal" class="topic_edit" data-id="'.$id.'" data-name="'.$data[$id]["name"].'" data-remote-target="#myEditTopic .modal-body"><i class="icon-edit"></i></a></li>';
            display_child_nodes($id, $level + 1);
        }
        echo '<ul>';
    }
}
/*
 * Recursive bottom-up tree traversal example:
 * Delete child nodes
 */
function delete_child_nodes($parent_id,$table_name,$field_where)
{
    global $data, $index;
    $parent_id = $parent_id === NULL ? "NULL" : $parent_id;
    if (isset($index[$parent_id])) {
        foreach ($index[$parent_id] as $id) {
            delete_child_nodes($id);
            echo "DELETE FROM $table_name WHERE $field_where = " . $data[$id]["id"] . "\n";
        }
    }
}
#============================

$ipaddr = $_SERVER["REMOTE_ADDR"];
$ua = $_SERVER["HTTP_USER_AGENT"];
/* ==== Detect the OS ==== */

// ---- Mobile ----

// Android
$android = strpos($ua, 'Android') ? true : false;

// BlackBerry
$blackberry = strpos($ua, 'BlackBerry') ? true : false;

// iPhone
$iphone = strpos($ua, 'iPhone') ? true : false;

// Palm
$palm = strpos($ua, 'Palm') ? true : false;

// ---- Desktop ----

// Linux
$linux = strpos($ua, 'Linux') ? true : false;

// Macintosh
$mac = strpos($ua, 'Macintosh') ? true : false;

// Windows
$win = strpos($ua, 'Windows') ? true : false;

/* ============================ */


/* ==== Detect the UA ==== */

// Chrome
$chrome = strpos($ua, 'Chrome') ? true : false; // Google Chrome

// Firefox
$firefox = strpos($ua, 'Firefox') ? true : false; // All Firefox
$firefox_2 = strpos($ua, 'Firefox/2.0') ? true : false; // Firefox 2
$firefox_3 = strpos($ua, 'Firefox/3.0') ? true : false; // Firefox 3
$firefox_3_6 = strpos($ua, 'Firefox/3.6') ? true : false; // Firefox 3.6
$firefox_4_0 = strpos($ua, 'Firefox/4.0') ? true : false; // Firefox 4.0
$firefox_5_0 = strpos($ua, 'Firefox/5.0') ? true : false; // Firefox 5.0
$firefox_6_0 = strpos($ua, 'Firefox/6.0') ? true : false; // Firefox 6.0
$firefox_7_0 = strpos($ua, 'Firefox/7.0') ? true : false; // Firefox 7.0
$firefox_8_0 = strpos($ua, 'Firefox/8.0') ? true : false; // Firefox 8.0
$firefox_9_0 = strpos($ua, 'Firefox/9.0') ? true : false; // Firefox 9.0
$firefox_10_0 = strpos($ua, 'Firefox/10.0') ? true : false; // Firefox 10.0

// Internet Exlporer
$msie = strpos($ua, 'MSIE') ? true : false; // All Internet Explorer
$msie_7 = strpos($ua, 'MSIE 7.0') ? true : false; // Internet Explorer 7
$msie_8 = strpos($ua, 'MSIE 8.0') ? true : false; // Internet Explorer 8
$msie_9 = strpos($ua, 'MSIE 9.0') ? true : false; // Internet Explorer 9

// Opera
$opera = preg_match("/\bOpera\b/i", $ua); // All Opera


// Safari
$safari = strpos($ua, 'Safari') ? true : false; // All Safari
$safari_2 = strpos($ua, 'Safari/419') ? true : false; // Safari 2
$safari_3 = strpos($ua, 'Safari/525') ? true : false; // Safari 3
$safari_3_1 = strpos($ua, 'Safari/528') ? true : false; // Safari 3.1
$safari_4 = strpos($ua, 'Safari/531') ? true : false; // Safari 4
$version = '';
/* ============================ */


if ($ua) {

    // ---- Test if using a Handheld Device ----
    if ($android) { // Android
        $os = 'Android';
    }
    if ($blackberry) { // Blackbery
        $os = 'Blackbery';
    }
    if ($iphone) { // iPhone
        $os = 'iPhone';
    }
    if ($palm) { // Palm
        $os = 'Palm';
    }

    if ($linux) { // Linux Desktop
        $os = 'Linux';
    }

    if ($mac) { // Macintosh Desktop
        $os = 'Macintosh';
    }

    if ($win) { // Windows Desktop
        $os = 'Windows';
    }

    // ---- Test if Firefox ----
    if ($firefox) {
        $browser = 'Firefox';

        // Test Versions
        if ($firefox_2) { // Firefox 2
            $version = 'Version 2';
        }
        elseif ($firefox_3) { // Firefox 3
            $version = 'Version 3';
        }
        elseif ($firefox_3_6) { // Firefox 3.6
            $version = 'Version 3.6';
        }
        elseif ($firefox_4_0) { // Firefox 4.0
            $version = 'Version 4.0';
        }
        elseif ($firefox_5_0) { // Firefox 5.0
            $version = 'Version 5.0';
        }
        elseif ($firefox_6_0) { // Firefox 6.0
            $version = 'Version 6.0';
        }
        elseif ($firefox_7_0) { // Firefox 7.0
            $version = 'Version 7.0';
        }
        elseif ($firefox_8_0) { // Firefox 8.0
            $version = 'Version 8.0';
        }
        elseif ($firefox_9_0) { // Firefox 9.0
            $version = 'Version 9.0';
        }
        elseif ($firefox_10_0) { // Firefox 10.0
            $version = 'Version 10.0';
        }
        else { // A version not listed
            $version = 'Unknown';
        }
    }

    // ---- Test if Safari or Chrome ----
    elseif ( ($safari || $chrome) && !$iphone) {
        $browser = 'Safari or Chrome';

        if ($safari && !$chrome) { // Test if Safari and not Chrome
            $browser = 'Safari';

            // Test if Safari Mac or Safari Windows
            if ($mac && $safari) { // Safari Mac
                $browser = 'Safari on a Mac';
            }
            if ($win && $safari) { // Safari Windows
                $browser = 'Safari on Windows';
            }

            // Test Versions
            if ($safari_2) { // Safari 2
                $version = 'Version 2';
            }
            elseif ($safari_3) { // Safari 3
                $version = 'Version 3';
            }
            elseif ($safari_4) { // Safari 4
                $version = 'Version 4';
            }
            else {
                $version = 'Unknown';
            }
        }

        elseif ($chrome) { // Test if Chrome
            $browser = 'Chrome';
        }
    }

    // ---- Test if iPhone with Safari 3.1 ----
    elseif ($iphone && $safari_3_1) {
        $browser = 'Safari 3.1';
    }

    // ---- Test if Internet Explorer ----
    elseif ($msie) {
        $browser = 'Internet Explorer';

        // Test Versions
        if ($msie_7) { // Internet Explorer 7
            $version = 'Version 7';
        }
        elseif ($msie_8) { // Internet Explorer 8
            $version = 'Version 8';
        }
        elseif ($msie_9) { // Internet Explorer 9
            $version = 'Version 9';
        }
        else {
            $version =  'Unknown';
        }
    }

    // ---- Test if Opera ----
    elseif ($opera) {
        $browser= 'Opera';
    }

    // ---- If none of the above ----
    else {
        $browser =  'Uknown Browser';
    }
}
#============================
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' dan ';
    $separator   = ', ';
    $negative    = 'negatif ';
    $decimal     = ' perpuluhan ';
    $dictionary  = array(
        0                   => 'kosong',
        1                   => 'satu',
        2                   => 'dua',
        3                   => 'tiga',
        4                   => 'empat',
        5                   => 'lima',
        6                   => 'enam',
        7                   => 'tujuh',
        8                   => 'lapan',
        9                   => 'sembilan',
        10                  => 'sepuluh',
        11                  => 'sebelas',
        12                  => 'dua belas',
        13                  => 'tiga belas',
        14                  => 'empat belas',
        15                  => 'lima belas',
        16                  => 'enam belas',
        17                  => 'tujuh belas',
        18                  => 'lapan belas',
        19                  => 'sembilan belas',
        20                  => 'dua puluh',
        30                  => 'tiga puluh',
        40                  => 'empat puluh',
        50                  => 'lima puluh',
        60                  => 'enam puluh',
        70                  => 'tujuh puluh',
        80                  => 'lapan puluh',
        90                  => 'sembilan puluh',
        100                 => 'ratus',
        1000                => 'ribu',
        1000000             => 'juta',
        1000000000          => 'bilion',
        1000000000000       => 'trilion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

function fnCheckCountRecordScript($aliasField,$SQLScript){
    connDB();
    $qry = $SQLScript;
    $rst = mysql_query($qry) or die('MySQL Error: '.mysql_error());
    $data = mysql_fetch_array($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data[$aliasField];
    }
    mysql_free_result($rst);

}

function fnGetRecord3Param($fldwhere1,$fldwhere2,$fldwhere3,$fieldname,$tablename,$var1,$var2,$var3) {
    connDB();
    $select = "select $fieldname from $tablename where $fldwhere1='$var1' and $fldwhere2='$var2' and $fldwhere3='$var3'";
    $rst = mysql_query($select);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data[$fieldname];
    }
    mysql_free_result($rst);
}
/* server timezone */
define('CONST_SERVER_TIMEZONE', 'Asia/Kuala_Lumpur');

/* server dateformat */
define('CONST_SERVER_DATEFORMAT', 'Y-m-d H:i:s');
/**
 * Converts current time for given timezone (considering DST)
 *  to 14-digit UTC timestamp (YYYYMMDDHHMMSS)
 *
 * DateTime requires PHP >= 5.2
 *
 * @param $str_user_timezone
 * @param string $str_server_timezone
 * @param string $str_server_dateformat
 * @return string
 */
function now($str_user_timezone,
             $str_server_timezone = CONST_SERVER_TIMEZONE,
             $str_server_dateformat = CONST_SERVER_DATEFORMAT) {

    // set timezone to user timezone
    date_default_timezone_set($str_user_timezone);

    $date = new DateTime('now');
    $date->setTimezone(new DateTimeZone($str_server_timezone));
    $str_server_now = $date->format($str_server_dateformat);

    // return timezone to server default
    date_default_timezone_set($str_server_timezone);

    return $str_server_now;
}
function fnSendEmail($content,$email_from,$email_fromname,$email_subject,$email_to,$email_to_name){

    include_once('/home/codelnet/public_html/phpmailer/PHPMailer_5.2.0/class.phpmailer.php');
    $mail = new PHPMailer();

    $mail->IsSMTP();                                      // set mailer to use SMTP
    $mail->Host = "localhost";  // specify main and backup server

    $mail->From = $email_from;
    $mail->FromName = $email_fromname;
    $mail->AddAddress($email_to, $email_to_name);
    $mail->AddReplyTo("info@code-amal.net", "Information");

    $mail->WordWrap = 50;                                 // set word wrap to 50 characters
    $mail->IsHTML(true);                                  // set email format to HTML

    $mail->Subject = $email_subject;
    $mail->Body    = $content;
    $mail->AltBody = "This is the body in plain text for non-HTML mail clients";

    if(!$mail->Send())
    {
        echo "Message could not be sent. <p>";
        echo "Mailer Error: " . $mail->ErrorInfo;
        exit;
    }

    echo "Message has been sent";
}

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}
function fnVisitor($ip = null,$country,$country_code,$state,$city,$address){
    connDB();
    $insert = "INSERT INTO visitor SET
    ipaddr = '$ip',
    country = '$country',
    country_code = '$country_code',
    state = '$state',
    city = '$city',
    address = '$address',
    timevisit = current_timestamp
    ";
    mysql_query($insert) or die('Error:'.mysql_error());
}
function create_guid($namespace = '') {

    static $guid = '';
    $uid = uniqid("", true);
    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['SERVER_ADDR'];
    $data .= $_SERVER['SERVER_PORT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
    $guid = '{' .
        substr($hash,  0,  8) .
        '-' .
        substr($hash,  8,  4) .
        '-' .
        substr($hash, 12,  4) .
        '-' .
        substr($hash, 16,  4) .
        '-' .
        substr($hash, 20, 12) .
        '}';
    return $guid;
}
/**
 * Custom base64 encoding. Replace unsafe url chars
 *
 * @param string $val
 * @return string
 */
function base64_url_encode($val) {

    return strtr(base64_encode($val), '+/=', '-_,');

}

        /**
         * Custom base64 decode. Replace custom url safe values with normal
         * base64 characters before decoding.
         *
         * @param string $val
         * @return string
         */
function base64_url_decode($val) {

    return base64_decode(strtr($val, '-_,', '+/='));

}

function new_id($fldname,$tblname) {
    #  global $num;
    #  return 'A' . sprintf("%03d", $num++);
    connDB();
    $qry = "SELECT MAX($fldname) as newid FROM $tblname";
    $rst = mysql_query($qry) or die('Error:'.$qry);
    $data = mysql_fetch_assoc($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data['newid']+1;
    }else{
        return 1;
    }

    mysql_free_result($rst);
}

function detectFileMimeType($filename='')
{
    $filename = escapeshellcmd($filename);
    $command = "file -b --mime-type -m /usr/share/misc/magic {$filename}";

    $mimeType = shell_exec($command);

    return trim($mimeType);
}
function getimgsize($url, $referer = '')
{
    $headers = array(
        'Range: bytes=0-32768'
    );

    /* Hint: you could extract the referer from the url */
    if (!empty($referer)) array_push($headers, 'Referer: '.$referer);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);

    $image = imagecreatefromstring($data);

    $return = array(imagesx($image), imagesy($image));

    imagedestroy($image);

    return $return;
}
// Function for resizing jpg, gif, or png image files
function ak_img_resize($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if (($w / $h) > $scale_ratio) {
        $w = $h * $scale_ratio;
    } else {
        $h = $w / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){
        $img = imagecreatefromgif($target);
    } else if($ext =="png"){
        $img = imagecreatefrompng($target);
    } else {
        $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 80);

}

##### Resize and Crop Image ######
function setting_image_default_size($image_name,$destination_folder,$thumb_prefix,$image_res,$image_type,$max_image_size,$image_width,$image_height,$jpeg_quality){
    //Get file extension and name to construct new file name
    $image_info = pathinfo($image_name);
    $image_extension = strtolower($image_info["extension"]); //image extension
    $image_name_only = strtolower($image_info["filename"]);//file name only, no extension

    //create a random name for new image (Eg: fileName_293749.jpg) ;
    $new_file_name = $image_name_only. '_' .  rand(0, 9999999999) . '.' . $image_extension;

    //folder path to save resized images and thumbnails
    $thumb_save_folder 	= $destination_folder . $thumb_prefix . $new_file_name;
    $image_save_folder 	= $destination_folder . $new_file_name;

    //call normal_resize_image() function to proportionally resize image
    if(normal_resize_image($image_res, $image_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality))
    {
        //call crop_image_square() function to create square thumbnails
        if(!crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality))
        {
            die('Error Creating thumbnail');
        }

        /* We have succesfully resized and created thumbnail image
        We can now output image to user's browser or store information in the database*/

    }

    imagedestroy($image_res); //freeup memory
}


#####  This function will proportionally resize image #####
function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality){

    if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize

    //do not resize if image is smaller than max size
    if($image_width <= $max_size && $image_height <= $max_size){
        if(save_image($source, $destination, $image_type, $quality)){
            return true;
        }
    }

    //Construct a proportional size of new image
    $image_scale	= min($max_size/$image_width, $max_size/$image_height);
    $new_width		= ceil($image_scale * $image_width);
    $new_height		= ceil($image_scale * $image_height);

    $new_canvas		= imagecreatetruecolor( $new_width, $new_height ); //Create a new true color image

    //Copy and resize part of an image with resampling
    if(imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)){
        save_image($new_canvas, $destination, $image_type, $quality); //save resized image
    }

    return true;
}

##### This function corps image to create exact square, no matter what its original size! ######
function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality){
    if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize

    if( $image_width > $image_height )
    {
        $y_offset = 0;
        $x_offset = ($image_width - $image_height) / 2;
        $s_size 	= $image_width - ($x_offset * 2);
    }else{
        $x_offset = 0;
        $y_offset = ($image_height - $image_width) / 2;
        $s_size = $image_height - ($y_offset * 2);
    }
    $new_canvas	= imagecreatetruecolor( $square_size, $square_size); //Create a new true color image

    //Copy and resize part of an image with resampling
    if(imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)){
        save_image($new_canvas, $destination, $image_type, $quality);
    }

    return true;
}

##### Saves image resource to file #####
function save_image($source, $destination, $image_type, $quality){
    switch(strtolower($image_type)){//determine mime type
        case 'image/png':
            imagepng($source, $destination); return true; //save png file
            break;
        case 'image/gif':
            imagegif($source, $destination); return true; //save gif file
            break;
        case 'image/jpeg': case 'image/pjpeg':
        imagejpeg($source, $destination, $quality); return true; //save jpeg file
        break;
        default: return false;
    }
}
?>