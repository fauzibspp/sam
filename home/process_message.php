<?php
include_once('../config/functions.php');

if(!isset($_POST['token'])
    || !isset($_SESSION['token'])
    || empty($_POST['token'])
    || $_POST['token'] !== $_SESSION['token']){
    $badtoken = true;
    //echo 'bad'; 
}else{
    $badtoken = false;
    unset($_SESSION['token']);
    $userid = $_SESSION["userid"];
    $groupid = $_SESSION['groupid'];
    $cmd = $_POST['cmd'];
    $namespace = '';
    $ipaddr = $_SERVER['REMOTE_ADDR'];
    $inbox = '/inbox';
	$outbox = '/outbox';

    //content process
    if($cmd=='Compose'){

        if(!$badtoken){
            
            $messageid = create_guid($namespace);
            $addressfrom = trim($_SESSION['userid']);
            $addressto = explode(',',$_POST['email_to']);
            $destination = '../attachments/';
            $subject = $_POST['email_subject'];
            $contents = $_POST['email_message'];
            $senderid = $_SESSION['userid'];		

            //copy setiap mesej yg dihantar
            //check my folder is exist or not if exist then store my attachemnt then copy to receipient
            /*Pengantar*/
            if (!file_exists($destination.$addressfrom.$outbox.'/'.$messageid)) {
                mkdir($destination. "$addressfrom" . "$outbox" . "/"."$messageid", 0777, TRUE);
                $folderpath = $destination.$addressfrom.$outbox.'/'.$messageid.'/';
            } else {
                $folderpath = $destination.$addressfrom.$outbox.'/'.$messageid.'/';
            }

            /*Masukkan semua fail dalam folder pengantar terlebih dahulu*/
            if(!empty($_FILES['files'])){

                for($i=0;$i<count($_POST['file-list']);$i++){
                    $filename = $_FILES['files']['name'][$i];
                    $filenamenew = time();
                    $filesize = $_FILES['files']['size'][$i];
                    $filetype = $_FILES['files']['type'][$i];
                    //CryptFile($folderpath.$filename,$folderpath.$filename,$userid);
                    move_uploaded_file($_FILES['files']['tmp_name'][$i],$folderpath.$filename);

                    //d05_attachment for messages
                    $qry = "INSERT INTO attachments_outbox SET
                    d05_filenamenew = '$filenamenew',
                    d05_filenamecurrent = '$filename',
                    d05_filetype='$filetype',
                    d05_filesize='$filesize',                                            
                    d05_fileuploddte = CURRENT_TIMESTAMP,                                            
                    d05_messageid='$messageid',
                    d05_user_id='$senderid',
                    d05_ipadd='$ipaddr'
                    ";
                    $rst = db_select($qry);
                }//end for file attachment iteration
            }
            //================================
            /**/

            //loop alamat penerima userid alias emailto
            foreach($addressto as $emailto){
                //check if folder exist or not for receipient.
                //if not exist then create dir and swap it. else swap it 
                //format folder <destination> <userid> <inbox> <messageid>
                $emailto = trim($emailto);
                if (!file_exists($destination.$emailto.$inbox.'/'.$messageid)) {				    
                    mkdir($destination. "$emailto" . "$inbox" . "/"."$messageid", 0777, TRUE);
                    $folderpath = $destination.$emailto.$inbox.'/'.$messageid.'/';
                } else {
                    $folderpath = $destination.$emailto.$inbox.'/'.$messageid.'/';
                }

                if(!empty($_FILES['files'])){
                    for($i=0;$i<count($_POST['file-list']);$i++){
                        $filename = $_FILES['files']['name'][$i];
                        $filenamenew = time();
                        $filesize = $_FILES['files']['size'][$i];
                        $filetype = $_FILES['files']['type'][$i];
                        $src = $destination.$addressfrom.$outbox.'/'.$messageid.'/';
                        $dest = $folderpath;
                        recurse_copy($src,$dest);

                        //d05_attachment for messages
                        $qry = "INSERT INTO attachments_inbox SET
                                d05_filenamenew = '$filenamenew',
                                d05_filenamecurrent = '$filename',
                                d05_filetype='$filetype',
                                d05_filesize='$filesize',                                            
                                d05_fileuploddte = CURRENT_TIMESTAMP,                                            
                                d05_messageid='$messageid',
                                d05_user_id='$senderid',
                                d05_ipadd='$ipaddr',
                                d05_user_receipient='$emailto'
                                ";
                        $rst = db_select($qry);

                    }//end for file attachment iteration
                }
                //start input to database message
                if(isset($_POST['file-list'])){
                    $file_list = $_POST['file-list'];
                }else{
                    $file_list = 0;
                }
                if($file_list > 0){
                    $hasattach = 1;
                }else{
                    $hasattach = 0;
                }
                //store into sent message table
                $qry2 = "INSERT INTO email_inbox SET
                                    messageid='$messageid',
                                    sender_id='$senderid',
                                    receiver_id='$emailto',
                                    subject = '$subject',
                                    textbody='$contents',
                                    is_read=0,
                                    has_attachments='$hasattach',
                                    created_at=CURRENT_TIMESTAMP
                                    ";

                $rst2 = db_select($qry2);

            }//end for each

            $qry3 = "INSERT INTO email_outbox SET
                                    messageid='$messageid',
                                    sender_id='$senderid',
                                    receiver_id='$emailto',
                                    subject = '$subject',
                                    textbody='$contents',
                                    is_read=0,
                                    has_attachments='$hasattach',
                                    created_at=CURRENT_TIMESTAMP
                                    ";
            $rst3 = db_select($qry3);


            if(count($rst2) && count($rst3) > 0){

                echo "Proses Berjaya";
            }else{

                echo "Proses Gagal.";
            }
            //print_r($_POST);
            //print_r($_FILES);

        }//bad token end
    }//end if compose

    #=========================
    if($cmd=='Reply'){

        if(!$badtoken){

            $messageid = create_guid($namespace);
            $messageparentid = $_POST['id'];
            $replyto = $_POST['email_to'];
            $subject = $_POST['email_subject'];
            $contents = $_POST['email_message'];
            $senderid = $_SESSION['userid'];
            //start input to database message
            $qry = "INSERT INTO email_inbox SET
                                messageid='$messageid',
                                messageparentid='$messageparentid',
                                sender_id='$senderid',
                                receiver_id='$replyto',
                                subject = '$subject',
                                textbody='$contents',
                                is_read=0,
                                created_at=CURRENT_TIMESTAMP
                                ";
            $qry2 = "INSERT INTO email_outbox SET
                                messageid='$messageid',
                                messageparentid='$messageparentid',
                                sender_id='$senderid',
                                receiver_id='$replyto',
                                subject = '$subject',
                                textbody='$contents',
                                is_read=0,
                                created_at=CURRENT_TIMESTAMP
                                ";
            $rst = db_select($qry);
            $rst2 = db_select($qry2);

            if(count($rst) && count($rst2) > 0){

                echo "Proses Berjaya.";
            }else{

                echo "Proses Gagal.";
            }
            //print_r($_POST);
        }
    }
    #=========================
	
    #=========================
    if($cmd=='InboxForward'){

        if(!$badtoken){


            $messageid = create_guid($namespace);
            $messageparentid = $_POST['id'];           
            $addressto = explode(',',$_POST['email_to']);
            $destination = '../attachments/';
            $subject = $_POST['email_subject'];
            $contents = $_POST['email_message'];
            $addressfrom = $_SESSION['userid'];
            $senderid = $_SESSION['userid'];		
			
			
            /*iteration forward start*/
            foreach($addressto as $emailto){
                //format folder <destination> <userid> <inbox> <messageid>
                $emailto = trim($emailto);

                if (!file_exists($destination.$emailto.$inbox.'/'.$messageid)) {    //asal $messageparentid
                    mkdir($destination. "$emailto" . "$inbox" . "/"."$messageid", 0777, TRUE);    //asal $messageparentid
                    $folderpath = $destination.$emailto.$inbox.'/'.$messageid.'/'; //asal $messageparentid
                } else {
                    $folderpath = $destination.$emailto.$inbox.'/'.$messageid.'/'; //asal $messageparentid
                }

                $src = $destination.$addressfrom.$inbox.'/'.$messageparentid.'/'; //asal $messageparentid
                $dest = $folderpath;

                recurse_copy($src,$dest); //copy drpd folder inbox asal kepada inbox baru
				
				if (!file_exists($destination.$addressfrom.$outbox.'/'.$messageid)) {
                mkdir($destination. "$addressfrom" . "$outbox" . "/"."$messageid", 0777, TRUE);
                $folderpath = $destination.$addressfrom.$outbox.'/'.$messageid.'/';
				} else {
					$folderpath = $destination.$addressfrom.$outbox.'/'.$messageid.'/';
				}
				$dest = $folderpath;
				
				recurse_copy($src,$dest);
				
				

                $qry_msg = "SELECT d05_filenamenew,d05_filenamecurrent,d05_filetype,
                                    d05_filesize,d05_user_id FROM attachments_inbox WHERE
                                    d05_messageid='$messageparentid'";

                $data = db_select($qry_msg);
                //$data = mysql_fetch_assoc($rst_qry);
                $datacount = count($data);
                $filenamenew = '';
                $filename = '';
                $filetype = '';
                $filesize = '';
                if ($datacount > 0 ) {
                    $filenamenew = $data[0]['d05_filenamenew'];
                    $filename = $data[0]['d05_filenamecurrent'];
                    $filetype = $data[0]['d05_filetype'];
                    $filesize = $data[0]['d05_filesize'];
                }

                //d05_attachment for messages
                $qry = "INSERT INTO attachments_inbox SET
                                            d05_filenamenew = '$filenamenew',
                                            d05_filenamecurrent = '$filename',
                                            d05_filetype='$filetype',
                                            d05_filesize='$filesize',                                            
                                            d05_fileuploddte = CURRENT_TIMESTAMP,                                            
                                            d05_messageid='$messageid',
                                            d05_user_id='$senderid',
                                            d05_ipadd='$ipaddr',
                                            d05_user_receipient='$emailto'
                                        ";
                $rst = db_select($qry);

                $qry2 = "INSERT INTO attachments_outbox SET
                                            d05_filenamenew = '$filenamenew',
                                            d05_filenamecurrent = '$filename',
                                            d05_filetype='$filetype',
                                            d05_filesize='$filesize',
                                            d05_fileuploddte = CURRENT_TIMESTAMP,
                                            d05_messageid='$messageid',
                                            d05_user_id='$senderid',
                                            d05_ipadd='$ipaddr'
                                        ";
                $rst2 = db_select($qry2);



                //start input to database message
                if($datacount > 0){
                    $hasattach = 1;
                }else{
                    $hasattach = 0;
                }
                //store into sent message table
                $qry2 = "INSERT INTO email_inbox SET
                                messageid='$messageid',
                                messageparentid='$messageparentid',
                                sender_id='$senderid',
                                receiver_id='$emailto',
                                subject = '$subject',
                                textbody='$contents',
                                is_read=0,
                                has_attachments='$hasattach',
                                created_at=CURRENT_TIMESTAMP
                                ";
                $qry3 = "INSERT INTO email_outbox SET
                                messageid='$messageid',
                                messageparentid='$messageparentid',
                                sender_id='$senderid',
                                receiver_id='$emailto',
                                subject = '$subject',
                                textbody='$contents',
                                is_read=0,
                                has_attachments='$hasattach',
                                created_at=CURRENT_TIMESTAMP
                                ";
                $rst2 = db_select($qry2);
                $rst3 = db_select($qry3);
            }//end for each
            /*iteration forward end*/

            if(count($rst2) && count($rst3) > 0){

                echo "Proses Berjaya.";
            }else{

                echo "Proses Gagal. Sila hubungi pentadbir sistem.";
            }
            //print_r($_POST);
        }
    }
    #========================================================================
	#=========================
    if($cmd=='OutboxForward'){

        if(!$badtoken){


            $messageid = create_guid($namespace);
            $messageparentid = $_POST['id'];           
            $addressto = explode(',',$_POST['email_to']);
            $destination = '../attachments/';
            $subject = $_POST['email_subject'];
            $contents = $_POST['email_message'];
            $addressfrom = $_SESSION['userid'];
            $senderid = $_SESSION['userid'];		
			
			
            /*iteration forward start*/
            foreach($addressto as $emailto){
                //format folder <destination> <userid> <inbox> <messageid>
                $emailto = trim($emailto);

                if (!file_exists($destination.$emailto.$inbox.'/'.$messageid)) {    //asal $messageparentid
                    mkdir($destination. "$emailto" . "$inbox" . "/"."$messageid", 0777, TRUE);    //asal $messageparentid
                    $folderpath = $destination.$emailto.$inbox.'/'.$messageid.'/'; //asal $messageparentid
                } else {
                    $folderpath = $destination.$emailto.$inbox.'/'.$messageid.'/'; //asal $messageparentid
                }

                $src = $destination.$addressfrom.$outbox.'/'.$messageparentid.'/'; //asal $messageparentid
                $dest = $folderpath;

                recurse_copy($src,$dest); //copy drpd folder inbox asal kepada inbox baru
				
				if (!file_exists($destination.$addressfrom.$outbox.'/'.$messageid)) {
                mkdir($destination. "$addressfrom" . "$outbox" . "/"."$messageid", 0777, TRUE);
                $folderpath = $destination.$addressfrom.$outbox.'/'.$messageid.'/';
				} else {
					$folderpath = $destination.$addressfrom.$outbox.'/'.$messageid.'/';
				}
				$dest = $folderpath;
				
				recurse_copy($src,$dest);
				
				

                $qry_msg = "SELECT d05_filenamenew,d05_filenamecurrent,d05_filetype,
                                    d05_filesize,d05_user_id FROM attachments_outbox WHERE
                                    d05_messageid='$messageparentid'";

                $data = db_select($qry_msg);
                //$data = mysql_fetch_assoc($rst_qry);
                $datacount = count($data);
                $filenamenew = '';
                $filename = '';
                $filetype = '';
                $filesize = '';
                if ($datacount> 0 ) {
                    $filenamenew = $data[0]['d05_filenamenew'];
                    $filename = $data[0]['d05_filenamecurrent'];
                    $filetype = $data[0]['d05_filetype'];
                    $filesize = $data[0]['d05_filesize'];
                }

                //d05_attachment for messages
                $qry = "INSERT INTO attachments_inbox SET
                                            d05_filenamenew = '$filenamenew',
                                            d05_filenamecurrent = '$filename',
                                            d05_filetype='$filetype',
                                            d05_filesize='$filesize',                                            
                                            d05_fileuploddte = CURRENT_TIMESTAMP,                                            
                                            d05_messageid='$messageid',
                                            d05_user_id='$senderid',
                                            d05_ipadd='$ipaddr',
                                            d05_user_receipient='$emailto'
                                        ";
                $rst = db_select($qry);
                //start input to database message
                if($datacount > 0){
                    $hasattach = 1;
                }else{
                    $hasattach = 0;
                }
                //store into sent message table
                $qry2 = "INSERT INTO email_inbox SET
                                messageid='$messageid',
                                messageparentid='$messageparentid',
                                sender_id='$senderid',
                                receiver_id='$emailto',
                                subject = '$subject',
                                textbody='$contents',
                                is_read=0,
                                has_attachments='$hasattach',
                                created_at=CURRENT_TIMESTAMP
                                ";
                $qry3 = "INSERT INTO email_outbox SET
                                messageid='$messageid',
                                messageparentid='$messageparentid',
                                sender_id='$senderid',
                                receiver_id='$emailto',
                                subject = '$subject',
                                textbody='$contents',
                                is_read=0,
                                has_attachments='$hasattach',
                                created_at=CURRENT_TIMESTAMP
                                ";
                $rst2 = db_select($qry2);
                $rst3 = db_select($qry3);
            }//end for each
            /*iteration forward end*/

            if(count($rst2) && count($rst3) > 0){

                echo "Proses Berjaya.";
            }else{

                echo "Proses Gagal. Sila hubungi pentadbir sistem.";
            }
            //print_r($_POST);
        }
    }
    #========================================================================

    if($cmd=='DelAllMsgInbox'){ //inbox

        if(!$badtoken){


            $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;
            $rst1 = array();
            $rst2 = array();
            if($countcheck > 0){
                for($i=0;$i<$countcheck;$i++){
                    $messageid = trim($_POST['addCB'][$i]);

                    $dirfoldermsg = "../attachments/".$_SESSION["userid"]."/inbox/".$messageid;
                    delete_directory($dirfoldermsg);
                    $qry = "DELETE FROM attachments_inbox WHERE d05_messageid='$messageid'";
                    $rst1 = db_select($qry);
                    $qry2 = "DELETE FROM email_inbox WHERE messageid='$messageid'";
                    $rst2 = db_select($qry2);

                }
                if(count($rst1) > 0 and count($rst2) > 0){

                    echo "Proses Berjaya.";
                }else{

                    echo "Proses Gagal. Sila hubungi pentadbir sistem.";
                }
            }else{
                echo 'Proses gagal. Sila tandakan sekurang-kurangnya satu mesej';
            }

        }
    }
    //========================


    if($cmd=='DelAllMsgOutbox'){ //outbox

        if(!$badtoken){
            //print_r($_POST);
            $userid = $_SESSION['userid'];
            $rst1 = array();
            $rst2 = array();
            $countcheck = isset($_POST['addCB']) ? count($_POST['addCB']) : 0;
            if($countcheck > 0){
                for($i=0;$i<$countcheck;$i++){
                    $messageid = trim($_POST['addCB'][$i]);
                    $dirfoldermsg = "../attachments/".$_SESSION["userid"]."/outbox/".$messageid;
                    delete_directory($dirfoldermsg);
                    $qry = "DELETE FROM attachments_outbox WHERE d05_messageid='$messageid'";
                    $rst1 = db_select($qry);
                    $qry2 = "DELETE FROM email_outbox WHERE messageid='$messageid'";
                    $rst2 = db_select($qry2);
                }
                if(count($rst2) > 0){

                    echo "Proses Berjaya.";
                }else{

                    echo "Proses Gagal.";
                }
            }else{
                echo 'Proses gagal. Sila tandakan sekurang-kurangnya satu mesej';
            }

        }
    }

    #==================
    //content process

}


?>