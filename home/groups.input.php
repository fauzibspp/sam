<?php
   // error_reporting(E_ERROR | E_WARNING | E_PARSE);
    include_once('../config/config.php');
	connDB();
	$kod 	= isset($_POST['id']) ? $_POST['id'] : 0;
	$nama	= isset($_POST['nama']) ? $_POST['nama'] : NULL;
	$desc	= isset($_POST['desc']) ? $_POST['desc'] : NULL;
	$mode	= isset($_POST['mode']) ? $_POST['mode'] : NULL;
	$userid = $_SESSION['userid'];
	
if($nama!="" && $mode!="") {
	
	
	switch(trim($mode)) {
		case 'add':
		
				$query2 = "SELECT MAX(group_id) FROM groups"; 
				$result = mysql_query($query2) or die(mysql_error());
				while($row = mysql_fetch_array($result)){
					$nextid = $row['MAX(group_id)'];
				}
				$nextid++;   
		
				$sqladd = 'INSERT groups SET
								group_id 		= "'.$nextid.'", 
								group_name		= "'.$nama.'",
								group_desc 	= "'.$desc.'"';
                $rst=	mysql_query($sqladd);
                if($rst > 0){
                    fnLogEvent('Cipta kumpulan pengguna bagi '.$nama,$userid);
                    echo 'Berjaya simpan.';
                }else{
                    echo 'Gagal simpan.';
                }
		break;
		case 'edit':
					$sqlup = 'UPDATE groups SET
							group_name = "'.$nama.'",
							group_desc	= "'.$desc.'"
							WHERE group_id = "'.$kod.'"';

                    $rst = mysql_query($sqlup);
                    if($rst > 0){
                        fnLogEvent('Sunting kumpulan pengguna bagi '.$nama,$userid);
                        echo 'Berjaya sunting.';
                    }else{
                        echo 'Gagal sunting.';
                    }



            break;
	}//end switch	
	
}//end if

if(trim($mode) == 'del'){

	if(fnCheckExistingRecord1Param($kod,'roleaccess','role_group_id') == 0){

        $sqldel = 'DELETE FROM groups WHERE group_id = "'.$kod.'"';
        $rst = mysql_query($sqldel);
        if($rst > 0){
            echo 1;// 'Berjaya padam.';
        }else{
            echo 2; //'Gagal padam.';
        }
    }else{
        echo 0;//'Rekod wujud pada "table -> role access.". Proses Gagal';
    }


}

?>
