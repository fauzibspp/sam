<?php
include_once('../config/functions.php');
$name = date('YmdHis');
$destination = "documents";
$ext  = ".jpg";
$newname=$name.$ext;
$kodsumber = $_GET['kodsumber'];
$dir_owner = $kodsumber;
//Directory initialize
if (!file_exists($destination.'/'.$dir_owner)) {
    mkdir($destination."/"."$dir_owner", 0777, TRUE);
    $output_dir = $destination.'/'.$dir_owner.'/';
} else {
    $output_dir = $destination.'/'.$dir_owner.'/';
}
//Write image file
$file = file_put_contents( $output_dir.$newname, file_get_contents('php://input'),FILE_APPEND | LOCK_EX );

$filename = $name.$ext;
$filesize = filesize($output_dir.$newname);
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$filetype = finfo_file($finfo, $output_dir.$newname);
finfo_close($finfo);
$filecategory = 1;
$fileowner = $kodsumber;
$entry_by = $_SESSION['userid'];
if (!$file) {
    print "ERROR: Failed to write data to $filename, check permissions\n";
    exit();
}else{
    //$sql="Insert into snap_shot(name,images) values('$notentera','$name$ext')";

    $sql="INSERT INTO documents(filename,filesize,filetype,filecategory,fileowner,entry_date,entry_by)
VALUES('$filename','$filesize','$filetype','$filecategory','$fileowner',CURRENT_TIMESTAMP,'$entry_by')";

    db_query($sql);

    //$_SESSION["myvalue"]=$newname;
}

$url = 'http://' . $_SERVER['HTTP_HOST'] .'/'.$aliasname.'/home/' . $output_dir.$filename;
echo "$url\n";
?>
