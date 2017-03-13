<?php
#development
session_start();
define("host",'localhost:8889');
define("user",'root');
define("pass",'root');
define("dbname",'spkbt');
//define("port", '8889');
define("appname","SAM");
define("appver","v1");
define("aliasname","/");

define("inputKeySalt","sourceappspektrum");
define("blockSize","256");

#production
//
//define("host",'adams.disd.org');
//define("user",'dbadmin');
//define("pass",'P@ssw0rd');
//define("dbname",'adams');
//define("port", '3306');
//define("appname","ADAMS");
//define("appver","v3");
//define("aliasname","");
//define("protocol",'http://'.host);

function db_date(){
    $query = "select current_date";
    $row = db_select($query);
    $current_date = $row[0]['current_date'];
    return $current_date;
}
/*
 * db_connect   : connection to database
 * desc         : return value a boolean true or false
 */
function db_connect() {

    // Define connection as a static variable, to avoid connecting more than once
    static $connection;

    // Try and connect to the database, if a connection has not been established yet
    if(!isset($connection)) {
        $connection = mysqli_connect(host,user,pass,dbname);
    }

    // If connection was not successful, handle the error
    if($connection === false) {
        // Handle error - notify administrator, log to a file, show an error screen, etc.
        return mysqli_connect_error();
    }
    return $connection;
}
/*
 * db_query : UDF used for tasking Insert, Update and Delete
 * desc     : return value a boolean true or false
 */
function db_query($query) {
    // Connect to the database
    $connection = db_connect();

    // Query the database
    $result = mysqli_query($connection,$query) or die('Error db_query:'.mysqli_error($connection));

	//return true or false is failed
    return $result; 
}
/*
 * db_error : UDF used for handle error debug
 * desc     : return a string value of error detection
 */
function db_error() {
    $connection = db_connect();
    return mysqli_error($connection);
}
/*
 * db_select    : UDF used for task reading table from database.
 * Return       : This UDF return array value.  Used looping function to output the value in variable array
 */
function db_select($query) {
    $rows = array();
    $result = db_query($query);

    // If query failed, return `false`
    if($result === false) {
        return false;
    }

    // If query was successful, retrieve all the rows into an array
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function db_select_opt($query,$fldname) {
    $rows = array();
    $result = db_query($query);

    // If query failed, return `false`
    if($result === false) {
        return false;
    }

    // If query was successful, retrieve all the rows into an array
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[$row[$fldname]][] = $row;
    }
    return $rows;
}

/*
 * db_quote     : This UDF used for escape a string during store data to database
 * desc         : db_quote(your_variable)
 */
function db_quote($value) {
    $connection = db_connect();
    return "'" . mysqli_real_escape_string($connection,$value) . "'";
}
/*
 * db_check_data_exist  :   This UDF used for checking data existing in target table
 * desc                 :   Return value as true or false
 */
function db_check_data_exist($query){
    // Connect to the database
    $connection = db_connect();
	
    // Query the database
    $result = mysqli_query($connection,$query) or die('Error Data Exist:'.mysqli_error($connection));
	
    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }

}
/*
 * db_combo_box :   This UDF print object as dropdown box
 */
function db_combo_box($query,$obj="",$param,$fld1="",$fld2="",$required="",$default_option="",$default_value=0,$class_obj=""){
//echo $param;
    //echo $query;
    //echo $param;
    $rows = db_select($query);
    echo "<select id='".$obj."' name='".$obj."' class='".$class_obj."' $required>";
    echo "<option value='".$default_value."' selected>".$default_option."</option>";
    foreach($rows as $row){
        if($param==$row[$fld1]){
            echo "<option value='".$row[$fld1]."' selected>".$row[$fld2]."</option>";
        }else{
            echo "<option value='".$row[$fld1]."'>".$row[$fld2]."</option>";
        }

    }
    echo '</select>';
}
function db_selection_box($id = 0, $sublev = 0,$iso=''){
    $query = "select id,category_name as var_name from report_category where parent_id='$id'";
    $rows = db_select($query);

    foreach($rows as $row){
        $ss = '';
        if($sublev !==0){
            for($i=0;$i<=$sublev*10;$i++){
                $ss.='&nbsp;';
            }
            $ss.='|';
            for($i=0;$i<=$sublev;$i++){
                $ss.='-';
            }
            $ss.='&nbsp;';
        }
        $sel_s = '';
        if(isset($sublev))
        {
            if($row['id']==$sublev)
            {
                $sel_s = ' selected';
            }
        } elseif (isset($id)) {
            if($row['id']==$id)
            {
                $sel_s = ' selected';
            }
        } else {
            $sel_s = '';
        }

        echo "<option value=".$row['id'].$sel_s.">".$ss.$row['var_name']."</option>\r\n";
        db_selection_box($row['id'],$sublev+1,$iso);
    }
}
/*
function db_selection_box($id = 0, $sublev = 0,$iso=''){
    $query = "select id,organization_name from organization where parent_id='$id' and country_id='$iso'";
    $rows = db_select($query);

    foreach($rows as $row){
        $ss = '';
        if($sublev !==0){
            for($i=0;$i<=$sublev*10;$i++){
                $ss.='&nbsp;';
            }
            $ss.='|';
            for($i=0;$i<=$sublev;$i++){
                $ss.='-';
            }
                $ss.='&nbsp;';
        }
        $sel_s = '';
        if(isset($sublev))
        {
            if($row['id']==$sublev)
            {
                $sel_s = ' selected';
            }
        } elseif (isset($id)) {
            if($row['id']==$id)
            {
                $sel_s = ' selected';
            }
        } else {
            $sel_s = '';
        }

        echo "<option value=".$row['id'].$sel_s.">".$ss.$row['organization_name']."</option>\r\n";
        db_selection_box($row['id'],$sublev+1,$iso);
    }
}
*/

/*
 * db_combo_box :   This UDF to track user event activity
 */
function db_event_log($log_event="",$userid="",$ipaddr=""){
    $query = "INSERT INTO log_activity SET log_event='$log_event',
    log_created = current_timestamp, log_status='unseen',
    log_userid = '$userid',log_ipaddr = '$ipaddr'";
    db_query($query);
}

/*
 * capture thumnail image from video file
 */
function db_snap_image_video($frameset=0,$filename="",$iso=""){

    //$ffmpeg = "E:\\project_2014\\bspp\d.analisis\dev2\\ffmpeg\\bin\\ffmpeg";
    $ffmpeg = 'ffmpeg';
    $videofile = __DIR__."/files/$iso/$filename";
    $imagefile = __DIR__."/files/$iso/$filename".".jpg";
    $output = "../files/$iso/$filename".".jpg";
    $size = "279x222";
    $cmd = "$ffmpeg -i $videofile -an -ss $frameset -s $size $imagefile";

    if(!shell_exec($cmd)){
        $img = '<img src="'.$output.'" >';
    }else{
        $img =  "Failed created image.";
    }
    return $img;
}

function fnGetIndex($tablename,$fieldname){

    $query = "select max($fieldname) as maxid from $tablename";
    $rst = db_select($query);
    //print_r($rst);

    if ($rst[0]['maxid'] > 0 ) {
        return $rst[0]['maxid']+1;
    }else{
        return 1;
    }

}
function fnModuleAccessByGroup($groupid,$moduleid){

    $query = "SELECT role_id FROM roleaccess
    WHERE role_group_id='$groupid' AND role_permission_id='$moduleid'";
    $rst = db_select($query);

    if ($rst[0]['role_id'] > 0 ) {
        return true;
    }else{
        return false;
    }

}
function fnModuleAccessByUser($userid,$moduleid){

    $query = "SELECT role_id FROM roleaccess_user
    WHERE role_user_id='$userid' AND role_permission_id='$moduleid'";
    $rst = db_select($query);

    if ($rst[0]['role_id'] > 0 ) {
        return true;
    }else{
        return false;
    }

}
function fnLogEvent($log_event=NULL,$userid=NULL){
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $qinsert = "INSERT INTO log_activity SET log_event='$log_event',
    log_created = current_timestamp, log_status='unseen',
    log_userid = '$userid',log_ipaddr = '$ip'";
    db_query($qinsert);
}
function fnSQLCustomWithWhileLoop($script="",$fldname){

    // echo $script;
    $rst = db_select($script);//mysql_query($script) or die('Error:'.mysql_error());
    $data = '';
    if(count($rst) > 0){

        foreach ($rst as $row){


            $data .= '<li>' . $row[$fldname] . '</li>';
        }
        return '<ul>'.$data.'</ul>';
    }
   
}
function fnSQLCustom($script="",$fldname){
//echo $script;
    $rst = db_select($script);

    if ($rst[0][$fldname] > 0 ) {
        return $rst[0][$fldname];
    }
    
}
function fnCheckCountRecordScript($aliasField,$SQLScript){
    
    $rst = db_select($SQLScript);
    $data = mysql_fetch_array($rst);
    if (mysql_num_rows($rst) > 0 ) {
        return $data[$aliasField];
    }
    mysql_free_result($rst);

}

function fnMonthConvert($bulan)
{
    switch($bulan){
        case 1:
            return 'Jan';
            break;
        case 2:
            return 'Feb';
            break;
        case 3:
            return 'Mac';
            break;
        case 4:
            return 'Apr';
            break;
        case 5:
            return 'Mei';
            break;
        case 6:
            return 'Jun';
            break;
        case 7:
            return 'Jul';
            break;
        case 8:
            return 'Ogos';
            break;
        case 9:
            return 'Sep';
            break;
        case 10:
            return 'Okt';
            break;
        case 11:
            return 'Nov';
            break;
        case 12:
            return 'Dis';
            break;
    }
}

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
function db_get_ipaddr()
{
    foreach (array('HTTP_CLIENT_IP',
                 'HTTP_X_FORWARDED_FOR',
                 'HTTP_X_FORWARDED',
                 'HTTP_X_CLUSTER_CLIENT_IP',
                 'HTTP_FORWARDED_FOR',
                 'HTTP_FORWARDED',
                 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $IPaddress){
                $IPaddress = trim($IPaddress); // Just to be safe

                if (filter_var($IPaddress,
                        FILTER_VALIDATE_IP,
                        FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
                    !== false) {

                    return $IPaddress;
                }
            }
        }
    }
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}
function recurse_copy($src,$dst) {
    $dir = opendir($src);
    //@mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
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
function fnSelect($fld1,$fld2,$tblName,$value,$objName,$class,$objDesc,$where = NULL,$order = NULL,$validate='')
{

    $qry = "SELECT $fld1,$fld2 FROM $tblName $where";
    $cond = " $order";
    //echo $qry.$cond.$value;
    $results = db_select($qry);
    //echo "<select id='$objName' name='$objName' class='$class' $validate>";

    if($objDesc != ""){
        echo "<select id='$objName' name='$objName' class='$class' $validate>";
        echo "<option value='' selected>--$objDesc--</option>";
    }else{
        echo "<select id='$objName' name='$objName.[]' class='$class' $validate>";

    }
    foreach ($results as $row)
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