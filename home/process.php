<?php
include_once('../config/functions.php');
include_once("assets/aes/aes.php");
//print_r($_POST);
//exit();
$userid = isset($_SESSION["userid"]) ? $_SESSION["userid"] : "";
$groupid = isset($_SESSION['groupid']) ? $_SESSION['groupid'] : "";
$cmd = filter_input(INPUT_POST,'cmd',FILTER_SANITIZE_STRING);
$ip = $_SERVER["REMOTE_ADDR"];

#------------------------------------------------------------------------ok

if($cmd=='EditProfile'){

    $user_name = isset($_POST['username']) ? $_POST['username'] : NULL;
    $user_dept_id = isset($_POST['department']) ? $_POST['department'] : 0;
    //$user_group_id = isset($_POST['groups']) ? $_POST['groups'] : 0;
    $user_phone = isset($_POST['hp_phone']) ? $_POST['hp_phone'] : NULL;
    $user_phone_ext = isset($_POST['office_phone']) ? $_POST['office_phone'] : NULL;
    $user_email = isset($_POST['email']) ? $_POST['email'] : NULL;
    //$user_scheme_id  = isset($_POST['scheme']) ? $_POST['scheme'] : NULL;
    $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : NULL;


    $unit_name = isset($_POST['unit_name']) ? $_POST['unit_name'] : NULL;
    $unit_address = isset($_POST['unit_address']) ? $_POST['unit_address'] : NULL;
    $unit_postcode = isset($_POST['unit_postcode']) ? $_POST['unit_postcode'] : 0;
    $unit_state = isset($_POST['unit_state']) ? $_POST['unit_state'] : NULL;
    $rst = array();
    $qry = "UPDATE userprofile SET
             user_dept_id = '$user_dept_id',
             user_name='$user_name',
             user_phone = '$user_phone',
             user_phone_ext = '$user_phone_ext',
             user_email = '$user_email',
             unit_name = '$unit_name',
             unit_address = '$unit_address',
             unit_postcode = '$unit_postcode',
             unit_state = '$unit_state'
             WHERE user_id='$userid'";
    $rst = db_query($qry);


    if(count($rst) > 0){

        fnLogEvent('Sunting rekod profile bagi '.$user_name,$userid);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }
}
if($cmd=='EditPassword'){

    $curr_pwd = isset($_POST['c-pwd']) ? $_POST['c-pwd'] : NULL;
    $new_pwd = isset($_POST['n-pwd']) ? $_POST['n-pwd'] : NULL;
    $retype_new_pwd = isset($_POST['rt-pwd']) ? $_POST['rt-pwd'] : NULL;
    $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : NULL;

    
    
    $status =1;
    $msg = "";
    //check old password
    //$curr_pwd_db = fnGetRecord($userid,'userlogin','userpwd','user_id');

    $row = db_select("select AES_DECRYPT(userpwd,'sourceappspektrum') as userpwd from userlogin where user_id='$userid'");
    $curr_pwd_db = $row[0]['userpwd'];

    if($curr_pwd_db <> $curr_pwd){
        $msg = "Katalaluan lama tidak sama dalam rekod! Proses Gagal<br>";
        $status=0;
    }
    if ( strlen($new_pwd) < 3 or strlen($new_pwd) > 15 ){
        $msg .= "Katalaluan mesti lebih daripada 3 aksara dan maksima 15 aksara<br>";
        $status =0;
    }
    if($new_pwd <> $retype_new_pwd){
        $msg .= "Kedua-dua katalaluan baru dan lama tidak sama<br>";
        $status = 0;
    }

    if($status != 1){

        echo '<div class="alert alert-block alert-danger fade in">
                                  <button data-dismiss="alert" class="close close-sm" type="button">
                                      <i class="icon-remove"></i>
                                  </button>
                                  <strong>Harap Maaf!</strong>'.$msg.'
                              </div>';

    }else{

        $qry = "UPDATE userlogin SET
             userpwd=AES_ENCRYPT('$new_pwd','sourceappspektrum')
             WHERE user_id='$userid'";
        $rst = db_query($qry);


        if(count($rst) > 0){


            echo '<div class="alert alert-success fade in">
                                  <button data-dismiss="alert" class="close close-sm" type="button">
                                      <i class="icon-remove"></i>
                                  </button>
                                  <strong>Tahniah!</strong> proses berjaya.
                              </div>';
            fnLogEvent($_SESSION['userid'].' tukar katalaluan',$_SESSION['userid']);
        }else{


            echo '<div class="alert alert-block alert-danger fade in">
                                  <button data-dismiss="alert" class="close close-sm" type="button">
                                      <i class="icon-remove"></i>
                                  </button>
                                  <strong>Harap Maaf!</strong>Sila hubungi pentadbir sistem
                              </div>';
        }
    }


}

# Manage System Code
# Lokasi --------------------------
if($cmd=='AddDataLocation'){

    $poskod = isset($_POST['Poskod']) ? $_POST['Poskod'] : NULL;
    $lokasi = isset($_POST['Lokasi']) ? $_POST['Lokasi'] : NULL;
    $negeri = isset($_POST['negeri']) ? $_POST['negeri'] : NULL;


    $qry = "INSERT INTO lokasi SET poskod='$poskod', lokasi_peperiksaan='$lokasi', negeri='$negeri'";
    $rst = db_query($qry);

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' cipta data lokasi',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}
if($cmd=='EditDataLocation'){

    $id = isset($_POST['Id']) ? $_POST['Id'] : NULL;
    $poskod = isset($_POST['Poskod']) ? $_POST['Poskod'] : NULL;
    $lokasi = isset($_POST['Lokasi']) ? $_POST['Lokasi'] : NULL;
    $negeri = isset($_POST['negeri']) ? $_POST['negeri'] : NULL;


    $qry = "UPDATE lokasi SET poskod='$poskod', lokasi_peperiksaan='$lokasi', negeri='$negeri' WHERE id='$id'";
    $rst = db_query($qry);

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' sunting data lokasi',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}


# Skim --------------------------
if($cmd=='AddDataSkim'){
    
    $scheme_name = isset($_POST['scheme_name']) ? $_POST['scheme_name'] : NULL;
    $scheme_gred = isset($_POST['scheme_gred']) ? $_POST['scheme_gred'] : NULL;
    $scheme_code = isset($_POST['scheme_code']) ? $_POST['scheme_code'] : NULL;
    $scheme_reference = isset($_POST['scheme_reference']) ? $_POST['scheme_reference'] : NULL;
    

    $qry = "INSERT INTO scheme SET
    scheme_name='$scheme_name',
    scheme_gred='$scheme_gred',
    scheme_code='$scheme_code',
    scheme_reference='$scheme_reference'
    ";
    $rst = db_query($qry);

    if(count($rst) > 0){
        
        fnLogEvent($_SESSION['userid'].' cipta data skim',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{
        
        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}

if($cmd=='EditDataSkim'){
    
    $id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $scheme_name = isset($_POST['scheme_name']) ? $_POST['scheme_name'] : NULL;
    $scheme_gred = isset($_POST['scheme_gred']) ? $_POST['scheme_gred'] : NULL;
    $scheme_code = isset($_POST['scheme_code']) ? $_POST['scheme_code'] : NULL;
    $scheme_reference = isset($_POST['scheme_reference']) ? $_POST['scheme_reference'] : NULL;

    
    $qry = "UPDATE scheme SET
    scheme_name='$scheme_name',
    scheme_gred='$scheme_gred',
    scheme_code='$scheme_code',
    scheme_reference='$scheme_reference'
    WHERE scheme_id= '$id'
    ";
    $rst = db_query($qry);

    if(count($rst) > 0){
        
        fnLogEvent($_SESSION['userid'].' sunting data skim',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{
        
        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}
if($cmd=='DelDataSkim'){
    
    $id = isset($_POST['id']) ? $_POST['id'] : NULL;

    //if(fnCheckExistingRecord1Param($id,'permohonan','user_scheme_id')==0){
    
    $qry = "DELETE FROM scheme WHERE scheme_id='$id'";
    $rst = db_query($qry);

    if(count($rst) > 0){
        
        fnLogEvent($_SESSION['userid'].' padam data skim',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{
        
        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }
    //}else{
    //    echo 'Data wujud pada table permohonan. Gagal proses';
    //}
}
# Module --------------------------
if($cmd=='AddDataModule'){
    
    $perm_key = isset($_POST['permKey']) ? $_POST['permKey'] : NULL;
    $perm_name = isset($_POST['permName']) ? $_POST['permName'] : NULL;
    

    $qry = "INSERT INTO permissions SET perm_key='$perm_key', perm_name='$perm_name'";
    $rst = db_query($qry);

    if(count($rst) > 0){
        
        fnLogEvent($_SESSION['userid'].' cipta data modul',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{
        
        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}

if($cmd=='EditDataModule'){
    
    $perm_id = isset($_POST['permId']) ? $_POST['permId'] : NULL;
    $perm_key = isset($_POST['permKey']) ? $_POST['permKey'] : NULL;
    $perm_name = isset($_POST['permName']) ? $_POST['permName'] : NULL;
    

    $qry = "UPDATE permissions SET perm_key='$perm_key', perm_name='$perm_name' WHERE perm_id='$perm_id'";
    $rst = db_query($qry);

    if(count($rst) > 0){
        
        fnLogEvent($_SESSION['userid'].' sunting data modul',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{
        
        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}
if($cmd=='DelDataModule'){
    
    $perm_id = isset($_POST['permId']) ? $_POST['permId'] : NULL;

    $exist = db_check_data_exist("select role_permission_id from roleaccess where role_permission_id='$perm_id'");
    
    if($exist===TRUE){
        
        $qry = "DELETE FROM permissions WHERE perm_id='$perm_id'";
        $rst = db_query($qry);

        if($rst > 0){
            
            fnLogEvent($_SESSION['userid'].' padam data modul',$_SESSION['userid']);
            echo "Proses Berjaya.";
        }else{
            
            echo "Proses Gagal. Sila hubungi pentadbir sistem.";
        }
    }else{
        echo 'Data wujud pada table roleaccess. Gagal proses';
    }
}

if($cmd=='MultiDelDataModule'){
    
    $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;
    $result_success=0;
    $result_failed=0;
    $result_exist=0;
    for($i=0; $i < $countcheck; $i++){
        $perm_id = trim($_POST['addCB'][$i]);

        $exist = db_check_data_exist("select role_permission_id from roleaccess where role_permission_id='$perm_id'");

        if($exist===TRUE){
            
            $qry = "DELETE FROM permissions WHERE perm_id='$perm_id'";
            $rst = db_query($qry);

            if($rst > 0){
                
                fnLogEvent($_SESSION['userid'].' padam data modul',$_SESSION['userid']);
                $result_success++;
            }else{
                
                $result_failed++;
            }
        }else{
            $result_exist++;
        }
    }//end for


    echo 'Berjaya : '.$result_success.'\n';
    echo 'Gagal   : '.$result_failed.'\n';
    echo 'Wujud   : '.$result_exist;



}
# Permissions --------------------------
if($cmd=='AddDataPermission'){
    
    $group_id = isset($_POST['groupId']) ? $_POST['groupId'] : 0;
    $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;

    for($i=0; $i < $countcheck; $i++){
        $id = trim($_POST['addCB'][$i]);
        $qry = "INSERT INTO roleaccess SET role_group_id='$group_id',
            role_permission_id='$id'";
        $rst = db_query($qry);
    }

    if(count($rst) > 0){
        
        fnLogEvent($_SESSION['userid'].' cipta data capaian',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{
        
        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}

if($cmd=='EditDataPermission'){
    
    $group_id = isset($_POST['groupId']) ? $_POST['groupId'] : 0;
    $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;

    $qdel = "DELETE FROM roleaccess WHERE role_group_id='$group_id'";
    $rst = db_query($qdel);

    for($i=0; $i < $countcheck; $i++){
        $id = trim($_POST['addCB'][$i]);
        $qry = "INSERT INTO roleaccess SET role_group_id='$group_id',
            role_permission_id='$id'";
        $rst = db_query($qry);
    }

    if(count($rst) > 0){
        
        fnLogEvent($_SESSION['userid'].' sunting data capaian kumpulan',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{
        
        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}

if($cmd=='UpdateDataUserRole'){
    
    $group_id = isset($_POST['groupId']) ? $_POST['groupId'] : 0;

    $qry_user = "SELECT user_id,user_group_id from userprofile where user_group_id='$group_id'";
    $rst_user = db_select($qry_user);
    $rst_insert_perm = 0;
    foreach ($rst_user as $row_user){
        $group_id = $row_user['user_group_id'];
        $qry_role = "SELECT role_permission_id FROM roleaccess WHERE role_group_id='$group_id'";
        $rst_perm = db_select($qry_role);
        #if re-click
        $qry_del_perm = "DELETE FROM roleaccess_user WHERE role_user_id='".$row_user['user_id']."'";
        $rst_del_perm = db_query($qry_del_perm);
        foreach ($rst_perm as $row_perm){
            $user_id = $row_user['user_id'];
            $role_id = $row_perm['role_permission_id'];

            $exist = db_check_data_exist("SELECT role_permission_id from roleaccess_user where role_user_id='$user_id' and role_permission_id='$role_id'");
            if($exist===FALSE){
                $qry_insert_perm = "INSERT INTO roleaccess_user SET role_user_id='$user_id',role_permission_id='$role_id'";
                $rst_insert_perm = db_query($qry_insert_perm);
            }
        }
    }

    if(count($rst_insert_perm) > 0){

        fnLogEvent($_SESSION['userid'].' set data capaian pengguna',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}

if($cmd=='DelDataPermission'){

    $group_id = isset($_POST['groupId']) ? $_POST['groupId'] : 0;

    $qdel = "DELETE FROM roleaccess WHERE role_group_id='$group_id'";
    $rst = db_query($qdel);

    if($rst > 0){

        fnLogEvent($_SESSION['userid'].' padam data capaian kumpulan',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}

if($cmd=='AddDataPermissionUser'){

    $user_id = isset($_POST['userId']) ? $_POST['userId'] : 0;
    $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;

    for($i=0; $i < $countcheck; $i++){
        $id = trim($_POST['addCB'][$i]);
        $qry = "INSERT INTO roleaccess_user SET role_user_id='$user_id',
            role_permission_id='$id'";
        $rst = db_query($qry);
    }

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' cipta data capaian pengguna',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}
if($cmd=='EditDataPermissionUser'){

    $user_id = isset($_POST['userId']) ? $_POST['userId'] : 0;
    $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;

    $qdel = "DELETE FROM roleaccess_user WHERE role_user_id='$user_id'";
    $rst = db_query($qdel);

    for($i=0; $i < $countcheck; $i++){
        $id = trim($_POST['addCB'][$i]);
        $qry = "INSERT INTO roleaccess_user SET role_user_id='$user_id',
            role_permission_id='$id'";
        $rst = db_query($qry);
    }

    if($rst > 0){

        fnLogEvent($_SESSION['userid'].' sunting data capaian pengguna',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}

if($cmd=='DelDataPermissionUser'){

    $user_id = isset($_POST['userId']) ? $_POST['userId'] : 0;

    $qdel = "DELETE FROM roleaccess_user WHERE role_user_id='$user_id'";
    $rst = db_query($qdel);

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' padam data capaian pengguna',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}

# Profile --------------------------
if($cmd=='AddDataUser'){



    $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : 0;
    $hp_phone = isset($_POST['hp_phone']) ? $_POST['hp_phone'] : 0;
    $office_phone = isset($_POST['office_phone']) ? $_POST['office_phone'] : 0;
    $email = isset($_POST['email']) ? $_POST['email'] : 0;
    $group_id = isset($_POST['groupId']) ? $_POST['groupId'] : 0;
    $skim_id = isset($_POST['skimId_']) ? $_POST['skimId_'] : 0;
    $skim_id_with_comma_list = implode(",", (array)$skim_id);

    //$aes = new AES($userid, inputKey, blockSize);
    //$enc = $aes->encrypt();
    $default_pwd = $userid;
    $inputKeySalt = inputKeySalt;
    $exist = db_check_data_exist("select user_id from userprofile where user_id='$userid'");
    if($exist===FALSE){
        $qry = "INSERT INTO userprofile
            SET user_id = '$userid',user_name='$fullname',user_phone='$hp_phone',
            user_phone_ext='$office_phone',user_email='$email',user_group_id='$group_id',
            user_scheme_id='$skim_id_with_comma_list',user_status=1";
        $rst = db_query($qry);
        if(count($rst) > 0){


            $qry_add_user = "INSERT INTO userlogin SET user_id='$userid',userpwd=AES_ENCRYPT('$default_pwd','$inputKeySalt')";
            db_query($qry_add_user);

            fnLogEvent($_SESSION['userid'].' cipta data pengguna '.$fullname,$_SESSION['userid']);
            echo "Proses Berjaya.";
        }else{

            echo "Proses Gagal. Sila hubungi pentadbir sistem.";
        }
    }else{
        echo "Harap Maaf! Rekod telah wujud. Proses gagal.";
    }
}

if($cmd=='EditDataUser'){

    $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : 0;
    $hp_phone = isset($_POST['hp_phone']) ? $_POST['hp_phone'] : 0;
    $office_phone = isset($_POST['office_phone']) ? $_POST['office_phone'] : 0;
    $email = isset($_POST['email']) ? $_POST['email'] : 0;
    $group_id = isset($_POST['groupId']) ? $_POST['groupId'] : 0;
    $skim_id = isset($_POST['skim']) ? $_POST['skim'] : 0;
    $skim_id_with_comma_list = @implode(",", $skim_id);




    $qry = "UPDATE userprofile
            SET user_name='$fullname',user_phone='$hp_phone',
            user_phone_ext='$office_phone',user_email='$email',user_group_id='$group_id',
            user_scheme_id='$skim_id_with_comma_list' WHERE user_id = '$userid'";
    $rst = db_query($qry);
    if(count($rst) > 0){

        $exist = db_check_data_exist("select user_id from groupusers where user_id='$userid'");
        if($exist===FALSE){
            $qry = "INSERT INTO groupusers SET user_id='$userid', group_id='$group_id'";
            db_query($qry);
        }


        fnLogEvent($_SESSION['userid'].' sunting data pengguna '.$fullname,$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }
}

if($cmd=='DelDataUser'){

    $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

    $exist = db_check_data_exist("select user_id from groupusers where user_id='$userid'");
    if($exist===FALSE){

        $qry = "DELETE FROM userprofile WHERE user_id = '$userid'";
        $rst = db_query($qry);
        if(count($rst) > 0){

            $qry = "DELETE FROM userlogin WHERE user_id='$userid'";
            db_query($qry);
            fnLogEvent($_SESSION['userid'].' padam data pengguna '.$userid,$_SESSION['userid']);
            echo "Proses Berjaya.";
        }else{

            echo "Proses Gagal. Sila hubungi pentadbir sistem.";
        }
    }else{
        echo "Harap Maaf! Sila semak rekod pada modul kumpulan.";
    }
}

#--------------------------
if($cmd=='DelUserGroup'){

    $user_id = isset($_POST['userid']) ? $_POST['userid'] : 0;
    $group_id = isset($_POST['groupid']) ? $_POST['groupid'] : 0;


    $qry = "DELETE FROM groupusers WHERE user_id = '$user_id'";
    $rst = db_query($qry);
    if(count($rst) > 0){

        $qry = "UPDATE userprofile SET user_group_id='0' WHERE user_id='$user_id'";
        db_query($qry);
        fnLogEvent($_SESSION['userid'].' padam data pengguna dalam kumpulan',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }
}

if($cmd=='JoinUserGroup'){

    $user_id = isset($_POST['userid']) ? $_POST['userid'] : 0;
    $group_id = isset($_POST['groupid']) ? $_POST['groupid'] : 0;
    $group_name = fnGetRecord1Param('group_id','group_name','groups',$group_id);


    $qry = "INSERT INTO groupusers SET user_id = '$user_id', group_id='$group_id'";
    $rst = db_query($qry);
    if($rst > 0){

        $qry = "UPDATE userprofile SET user_group_id='$group_id' WHERE user_id='$user_id'";
        db_query($qry);
        fnLogEvent($_SESSION['userid'].' pindahkan data pengguna ke dalam kumpulan '.$group_name,$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }
}


if($cmd=='ResetLogActivity'){

    $qry = "UPDATE log_activity SET log_status='seen' WHERE log_userid='$userid'";
    $rst = db_query($qry);
    if(count($rst) > 0){
        echo "Proses berjaya";
    }else{
        echo "Proses gagal";
    }
}

if($cmd=='DeleteActivityLog'){

    $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;

    for($i=0; $i < $countcheck; $i++){
        $id = trim($_POST['addCB'][$i]);

        $qry = "DELETE FROM log_activity WHERE log_id='$id'";
        $rst = db_query($qry);
    }

    if(count($rst) > 0){

        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }
}
if($cmd=='DeleteNoticeLog'){

    $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;

    for($i=0; $i < $countcheck; $i++){
        $id = trim($_POST['addCB'][$i]);

        $qry = "DELETE FROM notifications WHERE notice_id='$id'";
        $rst = db_query($qry);
    }

    if(count($rst) > 0){

        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }
}


# Department --------------------------
if($cmd=='AddDataDepartment'){

    $departName = isset($_POST['departName']) ? $_POST['departName'] : NULL;
    $departPath = isset($_POST['departPath']) ? $_POST['departPath'] : NULL;


    $qry = "INSERT INTO department SET department_name='$departName', department_path='$departPath'";
    $rst = db_query($qry);

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' cipta data jabatan',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}
if($cmd=='EditDataDepartment'){

    $departid = isset($_POST['departId']) ? $_POST['departId'] : NULL;
    $departName = isset($_POST['departName']) ? $_POST['departName'] : NULL;
    $departPath = isset($_POST['departPath']) ? $_POST['departPath'] : NULL;
    mysql_query("BEGIN"); //Start Transaction

    $qry = "UPDATE department SET department_name='$departName', department_path='$departPath' WHERE department_id='$departid'";
    $rst = db_query($qry);

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' sunting data jabatan',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}
if($cmd=='DelDataDepartment'){

    $departid = isset($_POST['departId']) ? $_POST['departId'] : NULL;

    $exist = db_check_data_exist("select user_dept_id from userprofile where user_dept_id='$departid'");
    if($exist===FALSE){



        $qry = "DELETE FROM department WHERE department_id='$departid'";
        $rst = db_query($qry);

        if(count($rst) > 0){

            fnLogEvent($_SESSION['userid'].' padam data jabatan',$_SESSION['userid']);
            echo "Proses Berjaya.";
        }else{

            echo "Proses Gagal. Sila hubungi pentadbir sistem.";
        }
    }else{
        echo 'Data wujud pada table userprofile. Gagal proses';
    }
}
# Status --------------------------
if($cmd=='AddDataStatus'){

    $statusName = isset($_POST['statusName']) ? $_POST['statusName'] : NULL;


    $qry = "INSERT INTO status SET status_name='$statusName'";
    $rst = db_query($qry);

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' cipta data status',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}
if($cmd=='EditDataStatus'){

    $departid = isset($_POST['statusId']) ? $_POST['statusId'] : NULL;
    $statusName = isset($_POST['statusName']) ? $_POST['statusName'] : NULL;


    $qry = "UPDATE status SET status_name='$statusName' WHERE status_id='$departid'";
    $rst = db_query($qry);
    if($rst > 0){

        fnLogEvent($_SESSION['userid'].' sunting data status',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}


/*
 * UploadFile is process to store data attachment and store file in directory
 */
if($cmd=='UploadFile'){
    //print_r($_POST);
    $output_dir = "../files/";
    $subject = isset($_POST['subject']) ? $_POST['subject'] : 0;
    $category = isset($_POST['file_category']) ? $_POST['file_category'] : 0;
    $subcategory = isset($_POST['file_subcategory']) ? $_POST['file_subcategory'] : 0;
    $author = isset($_POST['author']) ? $_POST['author'] : "";
    $source = isset($_POST['file_source']) ? $_POST['file_source'] : 0;
    $remark = isset($_POST['remark']) ? $_POST['remark'] : 0;
    $fileName="";

    if(isset($_FILES["myfile"]))
    {
        $ret = array();

        $error =$_FILES["myfile"]["error"];
        {

            if(!is_array($_FILES["myfile"]['name'])) //single file
            {
                $RandomNum   = time();

                $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name']));
                $ImageType      = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.
                $ImageSize      = $_FILES['myfile']['size'];

                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt       = str_replace('.','',$ImageExt);
                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName   = $ImageName.'.'.$ImageExt;

                $exist = db_check_data_exist("select attach_filename from attachments where attach_filename='$NewImageName'");
                if($exist===FALSE){
                    $ret[$NewImageName]= $output_dir.$NewImageName;
                    move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$NewImageName );

                    $qry = "INSERT INTO attachments SET
                    attach_filename = '$NewImageName',attach_filesize='$ImageSize',
                    attach_filetype = '$ImageType',attach_category = '$category',
                    attach_subcategory = '$subcategory',attach_source = '$source',
                    attach_subject = '$subject',attach_author = '$author',
                    attach_remark = '$remark',attach_display = 1,
                    entry_date=CURRENT_TIMESTAMP,entry_by='$userid';
                    ";

                    db_query($qry);
                }

            }
            else
            {
                $fileCount = count($_FILES["myfile"]['name']);
                for($i=0; $i < $fileCount; $i++)
                {
                    $RandomNum   = time();

                    $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name'][$i]));
                    $ImageType      = $_FILES['myfile']['type'][$i]; //"image/png", image/jpeg etc.
                    $ImageSize      = $_FILES['myfile']['size'][$i];

                    $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                    $ImageExt       = str_replace('.','',$ImageExt);
                    $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                    //$NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

                    $NewImageName   = $ImageName.'.'.$ImageExt;
                    $exist = db_check_data_exist("select attach_filename from attachments where attach_filename='$NewImageName'");
                    if($exist===FALSE){

                        $ret[$NewImageName]= $output_dir.$NewImageName;
                        move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$NewImageName );

                        $qry = "INSERT INTO attachments SET
                    attach_filename = '$NewImageName',attach_filesize='$ImageSize',
                    attach_filetype = '$ImageType',attach_category = '$category',
                    attach_subject = '$subject',
                    attach_display = 1,
                    entry_date=CURRENT_TIMESTAMP,entry_by='$userid';
                    ";
                        db_query($qry);
                    }

                }
            }
        }
        echo json_encode($ret);

    }
}


if($cmd=='RemoveListedEmployee'){

    $nokelompok = $_POST['nokelompok'];
    $tblname = $_POST['tblname'];
    $fieldname = $_POST['fieldname'];

    $qry = "DELETE FROM $tblname WHERE $fieldname = '$nokelompok'";

    $rst = db_query($qry);

    if(count($rst) > 0){

        echo 'Proses berjaya';
    }else{

        echo 'Padam gagal. Sila hubungi pentadbir sistem.';
    }

}

/*
 * AddDataPeribadi
 */
if($cmd=='AddDataPeribadi'){
    //print_r($_POST);
    //exit();
    $pegawai_pengendali = filter_input(INPUT_POST,'pegawai_pengendali',FILTER_SANITIZE_STRING);
    $kod_sumber = filter_input(INPUT_POST,'kod_sumber',FILTER_SANITIZE_STRING);
    $notentera = filter_input(INPUT_POST,'notentera',FILTER_SANITIZE_STRING);
    $nokpbaru  = filter_input(INPUT_POST,'nokpbaru',FILTER_SANITIZE_STRING);
    $pkt = filter_input(INPUT_POST,'pkt',FILTER_SANITIZE_STRING);
    $namapenuh = filter_input(INPUT_POST,'namapenuh',FILTER_SANITIZE_STRING);
    $namapenuh = strtoupper($namapenuh);
    $gelaran = filter_input(INPUT_POST,'gelaran',FILTER_SANITIZE_STRING);
    $khidmat = filter_input(INPUT_POST,'khidmat',FILTER_SANITIZE_STRING);
    $kor = filter_input(INPUT_POST,'kor',FILTER_SANITIZE_STRING);
    $unit = filter_input(INPUT_POST,'unit',FILTER_SANITIZE_STRING);
    $jawatan = filter_input(INPUT_POST,'jawatan',FILTER_SANITIZE_STRING);
    $penempatan = filter_input(INPUT_POST,'penempatan',FILTER_SANITIZE_STRING);
    $tmk = filter_input(INPUT_POST,'tmk',FILTER_SANITIZE_STRING);

    if(!empty($tmk)){
        $tmk = date('Y-m-d',  strtotime($tmk));
    }else{
        $tmk = "\N";
    }
    
    
    $ttp = filter_input(INPUT_POST,'ttp',FILTER_SANITIZE_STRING);
    if(!empty($ttp)){
        $ttp = date('Y-m-d',  strtotime($ttp));
    }else{
        $ttp = "\N";
    }
    

    $telpej = filter_input(INPUT_POST,'telpej',FILTER_SANITIZE_STRING);
    $telrumah = filter_input(INPUT_POST,'telrumah',FILTER_SANITIZE_STRING);
    $telhp = filter_input(INPUT_POST,'telhp',FILTER_SANITIZE_STRING);
    $nokplama = filter_input(INPUT_POST,'nokplama',FILTER_SANITIZE_STRING);
   
    $tlahir = filter_input(INPUT_POST,'tlahir',FILTER_SANITIZE_STRING);
    if(!empty($tlahir)){
        $tlahir = date('Y-m-d',  strtotime($tlahir));
    }else{
        $tlahir = "\N";
    }
    
    $jantina = filter_input(INPUT_POST,'jantina',FILTER_SANITIZE_STRING);
    $keturunan = filter_input(INPUT_POST,'keturunan',FILTER_SANITIZE_STRING);
    if(!empty($tkahwin)){
        $tkahwin = date('Y-m-d',  strtotime($tkahwin));
    }else{
        $tkahwin = "\N";
    }
    $agama = filter_input(INPUT_POST,'agama',FILTER_SANITIZE_STRING);
    $emailrasmi = filter_input(INPUT_POST,'emailrasmi',FILTER_SANITIZE_STRING);
    $emailperibadi = filter_input(INPUT_POST,'emailperibadi',FILTER_SANITIZE_STRING);
    $status_khidmat = filter_input(INPUT_POST,'status_khidmat', FILTER_SANITIZE_STRING);
    if($status_khidmat==""){
        $status_khidmat=0;
    }
    $latarbelakang= filter_input(INPUT_POST,'latarbelakang', FILTER_SANITIZE_STRING);
    $potensi= filter_input(INPUT_POST,'potensi', FILTER_SANITIZE_STRING);
    $keperluan= filter_input(INPUT_POST,'keperluan', FILTER_SANITIZE_STRING);
    $rancangan_hadapan= filter_input(INPUT_POST,'rancangan_hadapan', FILTER_SANITIZE_STRING);
    $hal_lain= filter_input(INPUT_POST,'hal_lain', FILTER_SANITIZE_STRING);

    $exist = db_check_data_exist("select m01_kodsumber from m01_induk where m01_kodsumber='$kod_sumber'");
    if($exist===FALSE){
         $qry = "INSERT INTO m01_induk SET
            m01_kodsumber = '$kod_sumber',
            m01_no_tentera = '$notentera',
            m01_kpbaru_anggota = '$nokpbaru',
            m01_kod_pangkat = '$pkt',
            m01_nama_anggota = '$namapenuh',
            m01_gelaran = '$gelaran',
            m01_kod_khidmat = '$khidmat',
            m01_kod_kor = '$kor',
            m01_kod_unit = '$unit',
            m01_kod_jawatan = '$jawatan',
            m01_penempatan = '$penempatan',
            m01_tkh_tmk = $tmk,
            m01_tkh_ttp = $ttp,
            m01_telpejabat = '$telpej',
            m01_telrumah = '$telrumah',
            m01_telhp = '$telhp',
            m01_kplama = '$nokplama',
            m01_tkh_lahir = $tlahir,
            m01_kod_jantina = '$jantina',
            m01_kod_keturunan = '$keturunan',
            m01_kod_status_kahwin= '$tkahwin',
            m01_kod_agama = '$agama',
            m01_emailrasmi = '$emailrasmi',
            m01_emailperibadi = '$emailperibadi',
            m01_status_khidmat = $status_khidmat,
            m01_ipadd = '$ipaddr',
            m01_userid='$userid',
            m01_latarbelakang = '$latarbelakang',
            m01_potensi = '$potensi',
            m01_keperluan = '$keperluan',
            m01_rancangan_hadapan = '$rancangan_hadapan',
            m01_hal_lain = '$hal_lain',
            m01_pegawai_pengendali = '$pegawai_pengendali',
            m01_dteentry = CURRENT_DATE
            ";

        $rst = db_query($qry);

        if(count($rst) > 0){

            echo 'Daftar berjaya';
        }else{

            echo 'Daftar gagal. Sila hubungi pentadbir sistem.';
        }
    }else{
        echo 'Rekod telah wujud. Proses gagal';
    }


}
/*
 * EditDataPeribadi
 */
if($cmd=='EditDataPeribadi'){
     //print_r($_POST);
    $pegawai_pengendali = filter_input(INPUT_POST,'pegawai_pengendali',FILTER_SANITIZE_STRING);
    $kod_sumber = filter_input(INPUT_POST,'kod_sumber',FILTER_SANITIZE_STRING);
    $notentera = filter_input(INPUT_POST,'notentera',FILTER_SANITIZE_STRING);
    $nokpbaru  = filter_input(INPUT_POST,'nokpbaru',FILTER_SANITIZE_STRING);
    $pkt = filter_input(INPUT_POST,'pkt',FILTER_SANITIZE_STRING);
    $namapenuh = filter_input(INPUT_POST,'namapenuh',FILTER_SANITIZE_STRING);
    $gelaran = filter_input(INPUT_POST,'gelaran',FILTER_SANITIZE_STRING);
    $skim = filter_input(INPUT_POST,'skim',FILTER_SANITIZE_STRING);
    $unit = filter_input(INPUT_POST,'unit',FILTER_SANITIZE_STRING);
    $tkhidmat =filter_input(INPUT_POST,'tkhidmat',FILTER_SANITIZE_STRING);
    $kor = filter_input(INPUT_POST,'kor',FILTER_SANITIZE_STRING);
    $khidmat = filter_input(INPUT_POST,'khidmat',FILTER_SANITIZE_STRING);
    $tmk = filter_input(INPUT_POST,'tmk',FILTER_SANITIZE_STRING);
    if(!empty($tmk)){
        $tmk = date('Y-m-d',  strtotime($tmk));
    }else{
        $tmk = "\N";
    }
    

    $ttp = filter_input(INPUT_POST,'ttp',FILTER_SANITIZE_STRING);
    if(!empty($ttp)){
        $ttp = date('Y-m-d',  strtotime($ttp));
    }else{
        $ttp = "\N";
    }
    $penempatan = filter_input(INPUT_POST,'penempatan',FILTER_SANITIZE_STRING);
    $nokplama = filter_input(INPUT_POST,'nokplama',FILTER_SANITIZE_STRING);
    $tlahir = filter_input(INPUT_POST,'tlahir',FILTER_SANITIZE_STRING);

    if(!empty($tlahir)){
        $tlahir = date('Y-m-d',  strtotime($tlahir));
    }else{
        $tlahir = "\N";
    }
    $telhp = filter_input(INPUT_POST,'telhp',FILTER_SANITIZE_STRING);
    $telrumah = filter_input(INPUT_POST,'telrumah',FILTER_SANITIZE_STRING);
    $telpej = filter_input(INPUT_POST,'telpej',FILTER_SANITIZE_STRING);
    $jantina = filter_input(INPUT_POST,'jantina',FILTER_SANITIZE_STRING);
    $keturunan = filter_input(INPUT_POST,'keturunan',FILTER_SANITIZE_STRING);
    $tkahwin = filter_input(INPUT_POST,'tkahwin',FILTER_SANITIZE_STRING);
    
    if(!empty($tkahwin)){
        $tkahwin = date('Y-m-d',  strtotime($tkahwin));
    }else{
        $tkahwin = "\N";
    }
    $agama = filter_input(INPUT_POST,'agama',FILTER_SANITIZE_STRING);
    $emailrasmi = filter_input(INPUT_POST,'emailrasmi',FILTER_SANITIZE_STRING);
    $emailperibadi = filter_input(INPUT_POST,'emailperibadi',FILTER_SANITIZE_STRING);
    $status_khidmat = filter_input(INPUT_POST,'status_khidmat', FILTER_SANITIZE_STRING);
    $jawatan = filter_input(INPUT_POST,'jawatan', FILTER_SANITIZE_STRING);
    $latarbelakang= filter_input(INPUT_POST,'latarbelakang', FILTER_SANITIZE_STRING);
    $potensi= filter_input(INPUT_POST,'potensi', FILTER_SANITIZE_STRING);
    $keperluan= filter_input(INPUT_POST,'keperluan', FILTER_SANITIZE_STRING);
    $rancangan_hadapan= filter_input(INPUT_POST,'rancangan_hadapan', FILTER_SANITIZE_STRING);
    $hal_lain= filter_input(INPUT_POST,'hal_lain', FILTER_SANITIZE_STRING);

     $qry = "UPDATE m01_induk SET
            m01_no_tentera = '$notentera',
            m01_kpbaru_anggota = '$nokpbaru',
            m01_kod_pangkat = '$pkt',
            m01_nama_anggota = '$namapenuh',
            m01_gelaran = '$gelaran',
            m01_kod_khidmat = '$khidmat',
            m01_kod_kor = '$kor',
            m01_kod_unit = '$unit',
            m01_kod_jawatan = '$jawatan',
            m01_penempatan = '$penempatan',
            m01_tkh_tmk = $tmk,
            m01_tkh_ttp = $ttp,
            m01_telpejabat = '$telpej',
            m01_telrumah = '$telrumah',
            m01_telhp = '$telhp',
            m01_kplama = '$nokplama',
            m01_tkh_lahir = $tlahir,
            m01_kod_jantina = '$jantina',
            m01_kod_keturunan = '$keturunan',
            m01_kod_status_kahwin= '$tkahwin',
            m01_kod_agama = '$agama',
            m01_emailrasmi = '$emailrasmi',
            m01_emailperibadi = '$emailperibadi',
            m01_status_khidmat = '$status_khidmat',
            m01_ipadd = '$ipaddr',
            m01_userid='$userid',
            m01_latarbelakang = '$latarbelakang',
            m01_potensi = '$potensi',
            m01_keperluan = '$keperluan',
            m01_rancangan_hadapan = '$rancangan_hadapan',
            m01_hal_lain = '$hal_lain',
            m01_pegawai_pengendali = '$pegawai_pengendali',
            m01_dteupdate = CURRENT_DATE
            WHERE m01_kodsumber = '$kod_sumber'
            ";

//echo $qry;
    $rst = db_query($qry);

    if(count($rst) > 0){

        $exist = db_check_data_exist("select c77_penempatandesc from c77_penempatan where c77_penempatandesc='$penempatan'");
        if($exist===FALSE){
        
            $qinsert = "INSERT INTO c77_penempatan SET c77_penempatandesc='$penempatan'";
            db_query($qinsert);
        }
        echo 'Kemaskini berjaya';
    }else{
        
        echo 'Kemaskini gagal. Sila hubungi pentadbir sistem.';
    }
    
}
if($cmd=='DelMultiDataEmployee'){
    

    $exe_count = 0;
    $exe_count_reject = 0;
    $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;
    for($i=0;$i<$countcheck;$i++){
        $kod_sumber = trim($_POST['addCB'][$i]);

        $qry = "DELETE FROM m01_induk WHERE m01_kodsumber='$kod_sumber'";


        $rst =  db_query($qry);

        if(count($rst) > 0){
            
            $exe_count++;
        }else{
            $exe_count_reject++;
        }
    }

    if($exe_count > 0){
        echo $exe_count.' Rekod Proses berjaya.';
        if($exe_count_reject > 0){
            echo '  '.$exe_count_reject. ' rekod tidak dapat diproses.';
        }
    }else{
       
        echo 'Proses gagal. Sila hubungi pentadbir sistem.';
    }
   
}

//Delete multiple table using inner join
if($cmd=='DelDataPeribadiCascade'){
    //print_r($_POST);

    $kod_sumber = filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING);

    $qry = "delete m01_induk, w04_pasangan, w01_anak 
    from m01_induk 
    left join w04_pasangan on w04_pasangan.w04_kodsumber = m01_induk.m01_kodsumber 
    left join w01_anak on w01_anak.w01_kodsumber = m01_induk.m01_kodsumber
    where m01_induk.m01_kodsumber = '$kod_sumber'";


    $rst = db_query($qry);

    if(count($rst) > 0){
        echo "Berjaya padam rekod $kod_sumber";
    }else{
        echo "Gagal padam rekod $kod_sumber";
    }
}

/*
 * AddDataWaris
 */
if($cmd=='AddDataWaris'){
    $kod_sumber = filter_input(INPUT_POST,'kod_sumber',FILTER_SANITIZE_STRING);
    $nokpbaruanggota = filter_input(INPUT_POST,'nokpbaruanggota',FILTER_SANITIZE_STRING);
    $notentera = filter_input(INPUT_POST,'notentera',FILTER_SANITIZE_STRING);
    $nokpbaru = isset($_POST['nokpbaru']) ? $_POST['nokpbaru'] : "";
    $nama_pasangan = filter_input(INPUT_POST,'nama_pasangan',FILTER_SANITIZE_STRING);
    $keturunan = filter_input(INPUT_POST,'keturunan',FILTER_SANITIZE_STRING);
    $pertalian = filter_input(INPUT_POST,'pertalian',FILTER_SANITIZE_STRING);
    $agama = filter_input(INPUT_POST,'agama',FILTER_SANITIZE_STRING);
    $tkhkahwin = filter_input(INPUT_POST,'tkhkahwin',FILTER_SANITIZE_STRING);
    $tkhkahwin = date('Y-m-d',  strtotime($tkhkahwin));
    $tlahir = filter_input(INPUT_POST,'tkhlahir',FILTER_SANITIZE_STRING);
    $tlahir = date('Y-m-d',  strtotime($tlahir));
    $tempatkahwin = filter_input(INPUT_POST,'tempatkahwin',FILTER_SANITIZE_STRING);
    $ipaddr = $_SERVER["REMOTE_ADDR"];
    $pekerjaan = filter_input(INPUT_POST,'pekerjaan',FILTER_SANITIZE_STRING);
    $akademik = filter_input(INPUT_POST,'akademik',FILTER_SANITIZE_STRING);
    $hobi = filter_input(INPUT_POST,'hobi',FILTER_SANITIZE_STRING);

    

    $qry = "INSERT INTO w04_pasangan SET
            w04_kodsumber = '$kod_sumber',
            w04_nokpbaru_anggota = '$nokpbaruanggota',
            w04_no_tentera = '$notentera',
            w04_no_kp_pasangan = '$nokpbaru',
            w04_nama_pasangan = '$nama_pasangan',
            w04_kod_keturunan_pasangan = '$keturunan',
            w04_kod_pertalian = '$pertalian',
            w04_kod_ugama_pasangan = '$agama',
            w04_tkh_kahwin = '$tkhkahwin',
            w04_tkh_lahir = '$tlahir',
            w04_tempat_kahwin = '$tempatkahwin',
            w04_ipadd = '$ipaddr',
            w04_pekerjaan = '$pekerjaan',
            w04_akademik = '$akademik',
            w04_hobi = '$hobi',
            w04_userid='$userid'";

    $rst = db_query($qry);

    if(count($rst) > 0){
        
        echo 'Proses berjaya';
    }else{
        
        echo 'Daftar gagal. Sila hubungi pentadbir sistem.';
    }
    
}
/*
 * EditDataWaris - mengemaskini maklumat waris
 */
if($cmd=='EditDataWaris'){
    $kod_sumber = filter_input(INPUT_POST,'kod_sumber',FILTER_SANITIZE_STRING);
    $pekerjaan = filter_input(INPUT_POST,'pekerjaan',FILTER_SANITIZE_STRING);
    $akademik = filter_input(INPUT_POST,'akademik',FILTER_SANITIZE_STRING);
    $hobi = filter_input(INPUT_POST,'hobi',FILTER_SANITIZE_STRING);
    $notentera = filter_input(INPUT_POST,'notentera',FILTER_SANITIZE_STRING);
    $nokpbaru = isset($_POST['nokpbaru']) ? $_POST['nokpbaru'] : "";
    $nama_pasangan = filter_input(INPUT_POST,'nama_pasangan',FILTER_SANITIZE_STRING);
    $keturunan = filter_input(INPUT_POST,'keturunan',FILTER_SANITIZE_STRING);
    $pertalian = filter_input(INPUT_POST,'pertalian',FILTER_SANITIZE_STRING);
    $agama = filter_input(INPUT_POST,'agama',FILTER_SANITIZE_STRING);
    $tkhkahwin = filter_input(INPUT_POST,'tkhkahwin',FILTER_SANITIZE_STRING);
    $tkhkahwin = date('Y-m-d',  strtotime($tkhkahwin));
    $tlahir = filter_input(INPUT_POST,'tkhlahir',FILTER_SANITIZE_STRING);
    $tlahir = date('Y-m-d',  strtotime($tlahir));
    $tempatkahwin = filter_input(INPUT_POST,'tempatkahwin',FILTER_SANITIZE_STRING);
    $ipaddr = $_SERVER["REMOTE_ADDR"];
    
    $qry = "UPDATE w04_pasangan SET
            w04_kodsumber = '$kod_sumber',
            w04_no_tentera = '$notentera',
            w04_nama_pasangan = '$nama_pasangan',
            w04_kod_keturunan_pasangan = '$keturunan',
            w04_kod_pertalian = '$pertalian',
            w04_kod_ugama_pasangan = '$agama',
            w04_tkh_kahwin = '$tkhkahwin',
            w04_tkh_lahir = '$tlahir',
            w04_tempat_kahwin = '$tempatkahwin',
            w04_pekerjaan = '$pekerjaan',
            w04_akademik = '$akademik',
            w04_hobi = '$hobi',
            w04_ipadd = '$ipaddr',
            w04_userid='$userid' WHERE w04_no_kp_pasangan = '$nokpbaru'";

    $rst = db_query($qry);

    if(count($rst) > 0){
        
        echo 'Proses berjaya';
    }else{
        
        echo 'Daftar gagal. Sila hubungi pentadbir sistem.';
    }
    
}

/*
 * AddDataANAK
 */
if($cmd=='AddDataAnak'){
    //print_r($_POST);
    $kod_sumber = filter_input(INPUT_POST,'kod_sumber',FILTER_SANITIZE_STRING);
    $nokpbaruanggota = filter_input(INPUT_POST,'nokpbaruanggota',FILTER_SANITIZE_STRING);
    $notentera = filter_input(INPUT_POST,'notentera',FILTER_SANITIZE_STRING);
    $nokpbaru = isset($_POST['nokpbaru']) ? $_POST['nokpbaru'] : "";
    $nama_anak = filter_input(INPUT_POST,'nama_anak',FILTER_SANITIZE_STRING);

    $tlahir = filter_input(INPUT_POST,'tkhlahir',FILTER_SANITIZE_STRING);
    $tlahir = date('Y-m-d',  strtotime($tlahir));
    $jantina = filter_input(INPUT_POST,'jantina',FILTER_SANITIZE_STRING);
    $ipaddr = $_SERVER["REMOTE_ADDR"];

    $qry = "INSERT INTO w01_anak SET
            w01_kodsumber = '$kod_sumber',
            w01_no_tentera = '$notentera',
            w01_nama_anak = '$nama_anak',
            w01_tkh_lahir_anak = '$tlahir',
            w01_kod_jantina_anak = '$jantina',
            w01_ipadd = '$ipaddr',
            w01_userid='$userid',
            w01_no_kp_anak = '$nokpbaru',
            w01_nokpbaru_anggota = '$nokpbaruanggota'";

    $rst = db_query($qry);

    if(count($rst) > 0){

        echo 'Proses berjaya';
    }else{

        echo 'Daftar gagal. Sila hubungi pentadbir sistem.';
    }

}
/*
 * EditDataAnak - mengemaskini maklumat anak
 */
if($cmd=='EditDataAnak'){
    $kod_sumber = filter_input(INPUT_POST,'kod_sumber',FILTER_SANITIZE_STRING);
    $nokpbaruanggota = filter_input(INPUT_POST,'nokpbaruanggota',FILTER_SANITIZE_STRING);
    $notentera = filter_input(INPUT_POST,'notentera',FILTER_SANITIZE_STRING);
    $nokpbaru = isset($_POST['nokpbaru']) ? $_POST['nokpbaru'] : "";
    $nama_anak = filter_input(INPUT_POST,'nama_anak',FILTER_SANITIZE_STRING);
    $tlahir = filter_input(INPUT_POST,'tkhlahir',FILTER_SANITIZE_STRING);
    $tlahir = date('Y-m-d',  strtotime($tlahir));
    $jantina = filter_input(INPUT_POST,'jantina',FILTER_SANITIZE_STRING);
    $ipaddr = $_SERVER["REMOTE_ADDR"];

    $qry = "UPDATE w01_anak SET
            w01_kodsumber = '$kod_sumber,
            w01_no_tentera = '$notentera',
            w01_nokpbaru_anggota = '$nokpbaruanggota',
            w01_nama_anak = '$nama_anak',
            w01_tkh_lahir_anak = '$tlahir',
            w01_kod_jantina_anak = '$jantina',
            w01_ipadd = '$ipaddr',
            w01_userid='$userid' WHERE w01_no_kp_anak = '$nokpbaru'";

    $rst = db_query($qry);

    if(count($rst) > 0){

        echo 'Proses berjaya';
    }else{

        echo 'Daftar gagal. Sila hubungi pentadbir sistem.';
    }

}

/*
 * DelDataRecord - perkhidmatan / waris / anak / dokumen / gambar
 */
if($cmd=='DelDataRecord'){
    
    $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING);
    $tablename = filter_input(INPUT_POST,'tablename',FILTER_SANITIZE_STRING);
    $fieldwhere = filter_input(INPUT_POST,'fieldwhere',FILTER_SANITIZE_STRING);
    $filename = isset($_POST['filename']) ? $_POST['filename'] : "";
    $fileowner = isset($_POST['fileowner']) ? $_POST['fileowner'] : "";
    
    $qry = "DELETE FROM $tablename WHERE $fieldwhere='$id'";
    $rst = db_query($qry);
    if(count($rst) > 0){
        if(!empty($filename)){
            $filename = '../documents/'.$fileowner.'/'.$filename;
            if (file_exists($filename)) {
                @unlink($filename);
            }
        }
        echo 'Proses berjaya';
    }else{
        
        echo 'Padam gagal. Sila hubungi pentadbir sistem.';
    }
    
}
if($cmd=='SetImageDefault'){
    

    $filename = isset($_POST['filename']) ? $_POST['filename'] : "";
    $fileowner = isset($_POST['fileowner']) ? $_POST['fileowner'] : "";

    $qry = "UPDATE m01_induk SET m01_gambar = '$filename' WHERE m01_kodsumber = '$fileowner'";
    $rst = db_query($qry);

    if(count($rst) > 0){
        echo 'Proses berjaya';
    }else{
        
        echo 'Proses gagal. Sila hubungi pentadbir sistem.';
    }
}
/*
 * AddDataRpt
 */

if($cmd=='AddDataRpt'){
//    echo '<pre>';
//    print_r($_POST);
//    print_r($_SESSION);
    //exit();
    //$kod_sumber = isset($_POST['kod_sumber']) ? $_POST['kod_sumber'] : 'Nil'; //A0001
    $kod_sumber = filter_input(INPUT_POST,'kod_sumber',FILTER_SANITIZE_STRING);
    $nokpbaru_sumber = isset($_POST['nokpbaru_sumber']) ? $_POST['nokpbaru_sumber'] : '000000-00-0000';
    $tarikh_laporan = isset($_POST['tarikh_laporan']) ? $_POST['tarikh_laporan'] : '0000-00-00';
    $tarikh_laporan = date('Y-m-d',  strtotime($tarikh_laporan));
    $pegawai_pengendali = isset($_POST['pegawai_pengendali']) ? $_POST['pegawai_pengendali'] : 'Nil';
    $nama_samaran = isset($_POST['nama_samaran']) ? $_POST['nama_samaran'] : 'Nil';
    $perkara = isset($_POST['perkara']) ? $_POST['perkara'] : 'Nil';
    $tempat_pertemuan = isset($_POST['tempat_pertemuan']) ? $_POST['tempat_pertemuan'] : 'Nil';
    $tarikh_pertemuan = isset($_POST['tarikh_pertemuan']) ? $_POST['tarikh_pertemuan'] : '0000-00-00';
    $tarikh_pertemuan = date('Y-m-d',  strtotime($tarikh_pertemuan));
    $masa_pertemuan = isset($_POST['masa_pertemuan']) ? $_POST['masa_pertemuan'] : '00:00';
    $class_maklumat = isset($_POST['class_maklumat']) ? $_POST['class_maklumat'] : 'Nil';
    $class_perlindungan = isset($_POST['class_perlindungan']) ? $_POST['class_perlindungan'] : 'Nil';
    $masalah_keselamatan = isset($_POST['masalah_keselamatan']) ? $_POST['masalah_keselamatan'] : 'Nil';
    $tempat_baru = isset($_POST['tempat_baru']) ? $_POST['tempat_baru'] : 'Nil';
    $tarikh_baru = isset($_POST['tarikh_baru']) ? $_POST['tarikh_baru'] : '0000-00-00';
    $tarikh_baru = date('Y-m-d',  strtotime($tarikh_baru));
    $masa_utama = isset($_POST['masa_utama']) ? $_POST['masa_utama'] : '00:00';
    $masa_varian = isset($_POST['masa_varian']) ? $_POST['masa_varian'] : '00:00';
    $hal_operasi = isset($_POST['hal_operasi']) ? $_POST['hal_operasi'] : 'Nil';
    $keperluan_semasa = isset($_POST['keperluan_semasa']) ? $_POST['keperluan_semasa'] : 'Nil';
    $hal_pentadbiran = isset($_POST['hal_pentadbiran']) ? $_POST['hal_pentadbiran'] : 'Nil';
    $hal_peribadi = isset($_POST['hal_peribadi']) ? $_POST['hal_peribadi'] : 'Nil';
    $penilaian = isset($_POST['penilaian']) ? $_POST['penilaian'] : 'Nil';
    $komen = isset($_POST['komen']) ? $_POST['komen'] : 'Nil';
    $userid = $_SESSION['userid'];
    $class_pertemuan = isset($_POST['class_pertemuan']) ? $_POST['class_pertemuan'] : '0';

    
    $qry = "insert into pertemuan set kod_sumber='$kod_sumber',
    nokpbaru_sumber = '$nokpbaru_sumber', 
    tarikh_laporan = '$tarikh_laporan',
    nama_samaran = '$nama_samaran',perkara='$perkara',
    tempat_pertemuan = '$tempat_pertemuan',tarikh_pertemuan='$tarikh_pertemuan',
    masa_pertemuan = '$masa_pertemuan',class_maklumat = '$class_maklumat',
    class_perlindungan = '$class_perlindungan',
    masalah_keselamatan = '$masalah_keselamatan',tempat_baru='$tempat_baru',
    tarikh_baru = '$tarikh_baru', masa_utama = '$masa_utama', masa_varian='$masa_varian',
    hal_operasi = '$hal_operasi', keperluan_semasa = '$keperluan_semasa',hal_pentadbiran = '$hal_pentadbiran',
    hal_peribadi = '$hal_peribadi', penilaian= '$penilaian', komen ='$komen',
    entry_date = CURRENT_TIMESTAMP, userid='$userid', pegawai_pengendali = '$pegawai_pengendali',
    class_pertemuan = '$class_pertemuan'
    ";

    $rst = db_query($qry);

    if(count($rst) > 0){
        echo 'Proses berjaya';
    }else{
        
        echo 'Proses gagal. Sila hubungi pentadbir sistem.';
    }
    
    
}
/*
 * EditDataRpt
 */

if($cmd=='EditDataRpt'){
    //echo '<pre>';
    //print_r($_POST);
//    print_r($_SESSION);
    //exit();
    $id = isset($_POST['id']) ? $_POST['id'] : '0';
    //$kod_sumber = isset($_POST['kod_sumber']) ? $_POST['kod_sumber'] : 'Nil'; //A0001
    $kod_sumber = filter_input(INPUT_POST,'kod_sumber',FILTER_SANITIZE_STRING);
    $nokpbaru_sumber = isset($_POST['nokpbaru_sumber']) ? $_POST['nokpbaru_sumber'] : '000000-00-0000';
    $tarikh_laporan = isset($_POST['tarikh_laporan']) ? $_POST['tarikh_laporan'] : '0000-00-00';
    $tarikh_laporan = date('Y-m-d',  strtotime($tarikh_laporan));
    $pegawai_pengendali = isset($_POST['pegawai_pengendali']) ? $_POST['pegawai_pengendali'] : 'Nil';
    $nama_samaran = isset($_POST['nama_samaran']) ? $_POST['nama_samaran'] : 'Nil';
    $perkara = isset($_POST['perkara']) ? $_POST['perkara'] : 'Nil';
    $tempat_pertemuan = isset($_POST['tempat_pertemuan']) ? $_POST['tempat_pertemuan'] : 'Nil';
    $tarikh_pertemuan = isset($_POST['tarikh_pertemuan']) ? $_POST['tarikh_pertemuan'] : '0000-00-00';
    $tarikh_pertemuan = date('Y-m-d',  strtotime($tarikh_pertemuan));
    $masa_pertemuan = isset($_POST['masa_pertemuan']) ? $_POST['masa_pertemuan'] : '00:00';
    $class_maklumat = isset($_POST['class_maklumat']) ? $_POST['class_maklumat'] : 'Nil';
    $class_perlindungan = isset($_POST['class_perlindungan']) ? $_POST['class_perlindungan'] : 'Nil';
    $masalah_keselamatan = isset($_POST['masalah_keselamatan']) ? $_POST['masalah_keselamatan'] : 'Nil';
    $tempat_baru = isset($_POST['tempat_baru']) ? $_POST['tempat_baru'] : 'Nil';
    $tarikh_baru = isset($_POST['tarikh_baru']) ? $_POST['tarikh_baru'] : '0000-00-00';
    $tarikh_baru = date('Y-m-d',  strtotime($tarikh_baru));
    $masa_utama = isset($_POST['masa_utama']) ? $_POST['masa_utama'] : '00:00';
    $masa_varian = isset($_POST['masa_varian']) ? $_POST['masa_varian'] : '00:00';
    $hal_operasi = isset($_POST['hal_operasi']) ? $_POST['hal_operasi'] : 'Nil';
    $keperluan_semasa = isset($_POST['keperluan_semasa']) ? $_POST['keperluan_semasa'] : 'Nil';
    $hal_pentadbiran = isset($_POST['hal_pentadbiran']) ? $_POST['hal_pentadbiran'] : 'Nil';
    $hal_peribadi = isset($_POST['hal_peribadi']) ? $_POST['hal_peribadi'] : 'Nil';
    $penilaian = isset($_POST['penilaian']) ? $_POST['penilaian'] : 'Nil';
    $komen = isset($_POST['komen']) ? $_POST['komen'] : 'Nil';
    $userid = $_SESSION['userid'];
    $class_pertemuan = isset($_POST['class_pertemuan']) ? $_POST['class_pertemuan'] : '0';


    $qry = "UPDATE pertemuan set kod_sumber='$kod_sumber',
    nokpbaru_sumber = '$nokpbaru_sumber', 
    tarikh_laporan = '$tarikh_laporan',
    nama_samaran = '$nama_samaran',perkara='$perkara',
    tempat_pertemuan = '$tempat_pertemuan',tarikh_pertemuan='$tarikh_pertemuan',
    masa_pertemuan = '$masa_pertemuan',class_maklumat = '$class_maklumat',
    class_perlindungan = '$class_perlindungan',
    masalah_keselamatan = '$masalah_keselamatan',tempat_baru='$tempat_baru',
    tarikh_baru = '$tarikh_baru', masa_utama = '$masa_utama', masa_varian='$masa_varian',
    hal_operasi = '$hal_operasi', keperluan_semasa = '$keperluan_semasa',hal_pentadbiran = '$hal_pentadbiran',
    hal_peribadi = '$hal_peribadi', penilaian= '$penilaian', komen ='$komen',
    entry_date = CURRENT_TIMESTAMP, userid='$userid', pegawai_pengendali = '$pegawai_pengendali',
    class_pertemuan = '$class_pertemuan'
    WHERE id='$id'
    ";

    $rst = db_query($qry);

    if(count($rst) > 0){
        echo 'Proses berjaya';
    }else{

        echo 'Proses gagal. Sila hubungi pentadbir sistem.';
    }


}
/*
 * AddDataDoc - Upload dokumen personal
 */
if($cmd=='AddDataDoc'){
    //print_r($_POST);
    $destination = "documents/";
    $category = isset($_POST['file_category']) ? $_POST['file_category'] : 0;
    $dir_owner = isset($_POST['dir_owner']) ? $_POST['dir_owner'] : 0;
    $fileName="";

    if (!file_exists($destination.'/'.$dir_owner)) {
        mkdir($destination."/"."$dir_owner", 0777, TRUE);
        $output_dir = $destination.'/'.$dir_owner.'/';
    } else {
        $output_dir = $destination.'/'.$dir_owner.'/';
    }

    if(isset($_FILES["myfile"]))
    {
        $ret = array();

        $error =$_FILES["myfile"]["error"];
        {

            if(!is_array($_FILES["myfile"]['name'])) //single file
            {
                $RandomNum   = time();

                $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name']));
                $ImageType      = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.
                $ImageSize      = $_FILES['myfile']['size'];

                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt       = str_replace('.','',$ImageExt);
                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName   = $ImageName.'.'.$ImageExt;

                $exist = db_check_data_exist("select filename from documents where filename='$NewImageName'");
                if($exist===FALSE){

                    $ret[$NewImageName]= $output_dir.$NewImageName;
                    move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$NewImageName );
                    if($category==1){//gambar
                        $target_file = $output_dir.$NewImageName;
                        $resized_file = $output_dir.$NewImageName;
                        $wmax = 240;
                        $hmax = 250;
                        ak_img_resize($target_file, $resized_file, $wmax, $hmax, $ImageExt);
                    }


                    $qry = "INSERT INTO documents SET
                    filename = '$NewImageName',filesize='$ImageSize',
                    filetype = '$ImageType',filecategory = '$category',
                    fileowner = '$dir_owner',
                    entry_date=CURRENT_TIMESTAMP,entry_by='$userid'";
                    //$ret[$NewImageName]=$qry;

                    db_query($qry);
                }

            } else {

                $fileCount = count($_FILES["myfile"]['name']);
                for($i=0; $i < $fileCount; $i++)
                {
                    $RandomNum   = time();

                    $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name'][$i]));
                    $ImageType      = $_FILES['myfile']['type'][$i]; //"image/png", image/jpeg etc.
                    $ImageSize      = $_FILES['myfile']['size'][$i];

                    $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                    $ImageExt       = str_replace('.','',$ImageExt);
                    $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                    //$NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

                    $NewImageName   = $ImageName.'.'.$ImageExt;
                    $exist = db_check_data_exist("select filename from documents where filename='$NewImageName'");
                    if($exist===FALSE){

                        $ret[$NewImageName]= $output_dir.$NewImageName;
                        move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$NewImageName );

                        if($category==1){//gambar
                            $target_file = $output_dir.$NewImageName;
                            $resized_file = $output_dir.$NewImageName;
                            $wmax = 240;
                            $hmax = 250;
                            ak_img_resize($target_file, $resized_file, $wmax, $hmax, $ImageExt);
                        }

                        $qry = "INSERT INTO documents SET
                        filename = '$NewImageName',filesize='$ImageSize',
                        filetype = '$ImageType',filecategory = '$category',
                        fileowner = '$dir_owner',
                        entry_date=CURRENT_TIMESTAMP,entry_by='$userid'";
                        db_query($qry);
                    }//end if

                }//end loop
            }
        }
        echo json_encode($ret);

    }
}


if($cmd=='AddDataIsu'){


    $_name = isset($_POST['IsuName']) ? $_POST['IsuName'] : NULL;


    $qry = "INSERT INTO class_pertemuan SET nama_pertemuan='$_name'";
    $rst = db_query($qry);

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' cipta data isu',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}

if($cmd=='EditDataIsu'){

    $_id = isset($_POST['Id']) ? $_POST['Id'] : NULL;

    $_name = isset($_POST['IsuName']) ? $_POST['IsuName'] : NULL;


    $qry = "UPDATE class_pertemuan SET nama_pertemuan='$_name' WHERE id='$_id'";
    $rst = db_query($qry);

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' sunting data isu',$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}
if($cmd=='DelDataIsu'){
//print_r($_POST);
    $_id = isset($_POST['Id']) ? $_POST['Id'] : NULL;

    $exist = db_check_data_exist("select class_pertemuan from pertemuan where class_pertemuan='$_id'");

    if($exist===FALSE){

        $qry = "DELETE FROM class_pertemuan WHERE id='$_id'";
        $rst = db_query($qry);

        if(count($rst) > 0){

            fnLogEvent($_SESSION['userid'].' padam data isu',$_SESSION['userid']);
            echo "Proses Berjaya.";
        }else{

            echo "Proses Gagal. Sila hubungi pentadbir sistem.";
        }
    }else{
        echo 'Data wujud pada table pertemuan. Gagal proses';
    }
}

if($cmd=='MultiDelDataIsu'){

    $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;
    $result_success=0;
    $result_failed=0;
    $result_exist=0;
    for($i=0; $i < $countcheck; $i++){
        $_id = trim($_POST['addCB'][$i]);

        $exist = db_check_data_exist("select class_pertemuan from pertemuan where class_pertemuan='$_id'");

        if($exist===FALSE){

            $qry = "DELETE FROM class_pertemuan WHERE id='$_id'";
            $rst = db_query($qry);

            if(count($rst) > 0){

                fnLogEvent($_SESSION['userid'].' padam data isu',$_SESSION['userid']);
                $result_success++;
            }else{

                $result_failed++;
            }
        }else{
            $result_exist++;
        }
    }//end for


    echo 'Berjaya : '.$result_success.'\n';
    echo 'Gagal   : '.$result_failed.'\n';
    echo 'Wujud   : '.$result_exist;



}

//===========
if($cmd=='AddDataDictionary'){

    $_id = isset($_POST['Id']) ? $_POST['Id'] : NULL;
    $_name = isset($_POST['Desc']) ? $_POST['Desc'] : NULL;
    $tblname = isset($_POST['tbl']) ? $_POST['tbl'] : NULL;

    switch($tblname){
        case "c45_pangkat":
            $fld1 = "c45_kod_pangkat";
            $fld2 = "c45_desc_pangkat";
            $model = " pangkat";
            break;
        case "c33_kor":
            $fld1 = "c33_kod_kor";
            $fld2 = "c33_desc_kor";
            $model = " perkhidmatan/kor/rej";
            break;
        case "c76_unit":
            $fld1 = "c76_kod_unit";
            $fld2 = "c76_desc_unit";
            $model = " kementerian/pasukan/jabatan";
            break;
    }

    $qry = "INSERT INTO $tblname SET $fld1 = '$_id', $fld2='$_name'";
    $rst = db_query($qry);

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' cipta data '.$model,$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}

if($cmd=='EditDataDictionary'){

    $_id = isset($_POST['Id']) ? $_POST['Id'] : NULL;

    $_name = isset($_POST['Desc']) ? $_POST['Desc'] : NULL;

    $tblname = isset($_POST['tbl']) ? $_POST['tbl'] : NULL;

    switch($tblname){
        case "c45_pangkat":
            $fld1 = "c45_kod_pangkat";
            $fld2 = "c45_desc_pangkat";
            $model = " pangkat";
            break;
        case "c33_kor":
            $fld1 = "c33_kod_kor";
            $fld2 = "c33_desc_kor";
            $model = " perkhidmatan/kor/rej";
            break;
        case "c76_unit":
            $fld1 = "c76_kod_unit";
            $fld2 = "c76_desc_unit";
            $model = " kementerian/pasukan/jabatan";
            break;
    }

    $qry = "UPDATE $tblname SET $fld2='$_name' WHERE $fld1='$_id'";
    $rst = db_query($qry);

    if(count($rst) > 0){

        fnLogEvent($_SESSION['userid'].' sunting data '.$model,$_SESSION['userid']);
        echo "Proses Berjaya.";
    }else{

        echo "Proses Gagal. Sila hubungi pentadbir sistem.";
    }

}
if($cmd=='DelDataDictionary'){
//print_r($_POST);
    $_id = isset($_POST['Id']) ? $_POST['Id'] : NULL;
    $tblname = isset($_POST['tbl']) ? $_POST['tbl'] : NULL;
    switch($tblname){
        case "c45_pangkat":
            $fld1 = "c45_kod_pangkat";
            $fld2 = "c45_desc_pangkat";
            $model = " pangkat";
            $chk_fld = "m01_kod_pangkat";
            break;
        case "c33_kor":
            $fld1 = "c33_kod_kor";
            $fld2 = "c33_desc_kor";
            $model = " perkhidmatan/kor/rej";
            $chk_fld = "m01_kod_kor";
            break;
        case "c76_unit":
            $fld1 = "c76_kod_unit";
            $fld2 = "c76_desc_unit";
            $model = " kementerian/pasukan/jabatan";
            $chk_fld = "m01_kod_unit";
            break;
    }


    $exist = db_check_data_exist("select $chk_fld from m01_induk where $chk_fld='$_id'");

    if($exist===FALSE){

        $qry = "DELETE FROM $tblname WHERE $fld1='$_id'";
        $rst = db_query($qry);

        if(count($rst) > 0){

            fnLogEvent($_SESSION['userid'].' padam data '.$model,$_SESSION['userid']);
            echo "Proses Berjaya.";
        }else{

            echo "Proses Gagal. Sila hubungi pentadbir sistem.";
        }
    }else{
        echo 'Data wujud pada table pertemuan. Gagal proses';
    }
}

if($cmd=='MultiDelDataDictionary'){

    $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;
    $result_success=0;
    $result_failed=0;
    $result_exist=0;

    $tblname = isset($_POST['tbl']) ? $_POST['tbl'] : NULL;
    switch($tblname){
        case "c45_pangkat":
            $fld1 = "c45_kod_pangkat";
            $fld2 = "c45_desc_pangkat";
            $model = " pangkat";
            $chk_fld = "m01_kod_pangkat";
            break;
        case "c33_kor":
            $fld1 = "c33_kod_kor";
            $fld2 = "c33_desc_kor";
            $model = " perkhidmatan/kor/rej";
            $chk_fld = "m01_kod_kor";
            break;
        case "c76_unit":
            $fld1 = "c76_kod_unit";
            $fld2 = "c76_desc_unit";
            $model = " kementerian/pasukan/jabatan";
            $chk_fld = "m01_kod_unit";
            break;
    }

    for($i=0; $i < $countcheck; $i++){
        $_id = trim($_POST['addCB'][$i]);

        $exist = db_check_data_exist("select $chk_fld from m01_induk where $chk_fld='$_id'");

        if($exist===FALSE){

            $qry = "DELETE FROM $tblname WHERE $fld1='$_id'";
            $rst = db_query($qry);

            if(count($rst) > 0){

                fnLogEvent($_SESSION['userid'].' padam data '.$model,$_SESSION['userid']);
                $result_success++;
            }else{

                $result_failed++;
            }
        }else{
            $result_exist++;
        }
    }//end for


    echo 'Berjaya : '.$result_success.'\n';
    echo 'Gagal   : '.$result_failed.'\n';
    echo 'Wujud   : '.$result_exist;



}