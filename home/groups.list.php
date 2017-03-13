<?php include_once('../config/functions.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="../home/img/favicon.png">

    <title><?php echo appname ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->


    <!--alertify css-->
    <link rel="stylesheet" href="css/alertify.core.css" />
    <link rel="stylesheet" href="css/alertify.default.css" id="toggleCSS" />

</head>

<body>

<section id="container" class="">
    <!--header start-->
    <?php include_once("header.php") ?>
    <!--header end-->
    <!--sidebar start-->
    <?php include_once('sidebar.php') ?>
    <!--sidebar end-->
    <!--main content start-->
    <?php
    #initial variable
    if(isset($_SESSION['namajsu'])){ $namajsu = $_SESSION['namajsu'];}else{ $namajsu='';}
    if(isset($_SESSION['skim'])){ $skim = $_SESSION['skim'];}else{ $skim='';}
    if(isset($_SESSION['masa'])){ $masa = $_SESSION['masa'];}else{ $masa='';}
    if(isset($_SESSION['huraian'])){ $huraian = $_SESSION['huraian'];}else{ $huraian='';}

    //$jenissoalan = '';
    $v_owner = $_SESSION['userid'];
    ?>
    
    
    <!-- start modal 1 -->
    <div id="dialog-skim" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade">
        <div class="modal-dialog table-responsive" >
                <div class="modal-content">
                
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 id="myModalLabel">Tambah Data</h4>
                    </div>
                    
                    <div class="modal-body"></div>
                    <div class="modal-footer">
						<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
						<button id="simpan-skim" class="btn btn-success">Simpan</button>
                    </div>
                </div>
        </div>
    </div>
    <!-- end modal 1 -->
    <!-- start modal 2 -->
    <div id="dialog-user" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade">
        <div class="modal-dialog table-responsive" >
            <div class="modal-content">

                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 id="myModalLabel">Senarai Pengguna</h4>
                </div>

                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal 2 -->
    <!-- start modal 3 -->
    <div id="dialog-userlist" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade">
        <div class="modal-dialog table-responsive" >

            <div class="modal-content">

                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 id="myModalLabel">Senarai Pengguna</h4>
                </div>

                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal 3 -->
    
    
    

    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <i class="icon-file"></i> Senarai Kumpulan Pengguna
                        </header>
                        <!--widget start-->
                        
                        

                        
                        <section class="panel">
                            <div class="panel-body">

                                <a href="#dialog-skim" id="0" class="btn tambah sentBtn btn-send" data-toggle="modal">
                                    <i class="icon-plus"></i> Tambah Data</a>
                            
                                <?php
                                $salt = 'm0h2014';
                                $token = sha1(mt_rand(1,1000000) . $salt);
                                $_SESSION['token'] = $token;
                                echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
                                ?>
                                  <article class="media">
                                            <section class="panel">
                                            
                                            
                                            
                                                <!--
                                                <header class="panel-heading">
                                                    Senarai JSU Mengikut Skim
                                                </header>
                                                -->
                                                <div class="media-body">
                                                    <!-- start list media-body-->
													<div class="adv-table">
													
													
							<!--------mula table	-->					
													
							<table  class="display   table-responsive table table-bordered table-striped table-hover" id="example1">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Jumlah Pengguna</th>
                                    <th></th>
								</tr>
							</thead>
							
							<tbody>
								<?php 
								
									//connDB();
									
									$sql = 'SELECT
											group_id,
											group_name,
											group_desc
											FROM
											groups
											WHERE group_id is not null';
									$cnt =1;
									$result = db_select($sql);
                                    foreach ($result as $row){
									
								?>
								<tr>

									<td><?php echo $row['group_name'] ?><br>
                                    <span class="text-muted"><?php echo $row['group_desc'] ?></span>
                                    </td>

                                    <td><?php
                                        $total = fnSQLCustom("SELECT count(*) as totalrecord from groupusers where group_id='".$row['group_id']."'","totalrecord");
                                        if(empty($total)){
                                            echo '0';
                                        }else{
                                            echo $total;
                                        }
                                        ?> Pengguna</td>
									<td>
                                        <a title="Sunting Kumpulan" href="#dialog-skim" id="<?php echo $row['group_id'] ?>" class="btn btn-default btn-xs pinda" data-toggle="modal"><i class="icon-pencil"></i></a>
                                        <a title="Papar senarai pengguna bagi <?php echo $row['group_name'] ?>" href="#dialog-user" id="<?php echo $row['group_id'] ?>" class="btn btn-primary btn-xs view" data-toggle="modal"><i class="icon-eye-open"></i></a>
                                        <a title="Tambah Pengguna" href="#dialog-userlist" id="<?php echo $row['group_id'] ?>" class="btn btn-primary btn-xs viewuserlist" data-toggle="modal"><i class="icon-group"></i></a>
										<a title="Padam Kumpulan <?php echo $row['group_name'] ?>" href="javascript:void(0)" id="<?php echo $row['group_id'] ?>" class="btn btn-danger btn-xs padam"><i class="icon-trash"></i></a>
									</td>
								</tr>
								<?php
									$cnt++;
									}
								?>
							</tbody>
							</table>
							<!--------end table	-->					




													
                                                    </div>
                                                    <!-- end list media-body-->
                                                </div>
                                            </section>
                                        </article>

                            </div>
                        </section>
                        <!--widget end-->


                    </section>

                </div>

            </div><!-- end row 1 -->

            <!-- page end-->
        </section>
    </section>
    <!--main content end-->
    <!--footer start-->
    <?php include_once("footer.php") ?>
    <!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->
<script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.js"></script>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="js/respond.min.js" ></script>
<script src="js/jquery.validate.min.js" ></script>

<!--common script for all pages-->
<script src="js/common-scripts.js"></script>

<!--script for this alertify-->
<script src="js/alertify.min.js"></script>
<script src="js/notifications.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {

		function reset () {
			$("#toggleCSS").attr("href", "css/alertify.default.css");
			alertify.set({
				labels : {
					ok     : "OK",
					cancel : "Cancel"
				},
				delay : 5000,
				buttonReverse : false,
				buttonFocus   : "ok"
			});
		}



        $('#example1').dataTable( {} );

        $('.tambah').click(function(){
            var url = "groups.form.php";
            kod = this.id;
            $(".modal-body").html('<img src="img/loading.gif">');
            $("#myModalLabel").html("Tambah Data");
            $.post(url, {id: kod} ,function(data) {
                $(".modal-body").html(data).show();
            });
        });
		
		$('.pinda').live("click", function(){
			var url = "groups.form.php";
			kod = this.id;
			if(kod != 0) {
				$("#myModalLabel").html("Pinda Data");
			} else {
				$("#myModalLabel").html("Tambah Data");
			}
			$.post(url, {id: kod} ,function(data) {
				$(".modal-body").html(data).show();
			});
		});

        $('.view').click(function(){
           var url = "../inc/datausergroup.php";
           kod = this.id;
            $(".modal-body").html('<img src="img/loading.gif">');
            $.post(url,{id:kod}, function(data){
                $(".modal-body").html(data).show();
            });
        });

        $('.viewuserlist').click(function(){
            var url = "../inc/datauser.php";
            kod = this.id;
            $(".modal-body").html('<img src="img/loading.gif">');
            $.post(url,{id:kod}, function(data){
                $(".modal-body").html(data).show();
            });
        });

		$('.padam').live("click", function(){

			reset();
			
			var url = "groups.input.php";
			kod = this.id;
			v_mode ="del";
			
			alertify.set({ labels: { cancel: "Tidak", ok: "Ya" } });
			alertify.confirm("Apakah anda ingin menghapus data ini?", function (e) {
				if (e) {
					$.post(url, {id: kod, mode: v_mode} ,function(msg) {

                        if(msg==0){
                            alertify.error("Rekod wujud pada 'table -> role access'. Proses Gagal");
                        }
                        if(msg==1){
                            alertify.success("Berjaya padam");
                        }
                        if(msg==2){
                            alertify.error("Gagal padam");
                        }
                        setTimeout(location.reload(),5000);



					});

				} else {
					alertify.error("You've clicked Cancel");
				}
			});
			return false;
		});
		


		$("#simpan-skim").bind("click", function(event) {
			reset();
			
			var url = "groups.input.php";
			var v_kod = $('input:hidden[name=kod]').val();
			var v_nama = $('input:text[name=nama]').val();
			var v_desc = $('input:text[name=desc]').val();
			var v_mode = $('input:hidden[name=mode_kod]').val();
			
			$.post(url, {id: v_kod, nama: v_nama, desc: v_desc, mode: v_mode} ,
			function(data) {
				// sembunyikan modal dialog
				$('#dialog-skim').modal('hide');
				location.reload();
			    
			});
			//alertify.set({ delay: 10000 });
			//alertify.log("Hiding in 10 seconds");
			alertify.success("Kemaskini Berjaya. Terima Kasih.");

		});

        var url = window.location;

        $('ul.sub a[href="'+ url +'"]').parent().addClass('active');
        $('ul.sub a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');
		
});
function jsDeleteData(userid,groupid){
    var url = "process.php";
    $.post(url, {userid: userid, groupid: groupid , cmd: 'DelUserGroup', token: $('#token').val()} ,
        function(data) {
            // sembunyikan modal dialog
            alert(data);
            $('#dialog-user').modal('hide');
            location.reload();

        });
}

function jsJoinGroupUserData(userid,groupid){
    var url = "process.php";
    $.post(url, {userid: userid, groupid: groupid , cmd: 'JoinUserGroup', token: $('#token').val()} ,
        function(data) {
            // sembunyikan modal dialog
            alert(data);
            $('#dialog-userlist').modal('hide');
            location.reload();

        });
}
</script>
</body>
</html>
