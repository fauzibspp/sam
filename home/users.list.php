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
    $group = '';
    $skim  = '';
    $v_owner = $_SESSION['userid'];
    ?>
    
    
    <!-- start modal 1 -->
    <div id="dialog-skim" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade">
        <div class="modal-dialog table-responsive" >
                <div class="modal-content">
                    <form class="form-horizontal" role="form" id="form_profile">

                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 id="myModalLabel">Tambah Data</h4>
                    </div>
                    
                    <div class="modal-body">
                            <div class="alert alert-block alert-danger fade in">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="icon-remove"></i>
                                </button>
                                <strong>Harap Maaf!</strong> <label class="lblMsg"></label>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">ID</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="userid" name="userid" placeholder=" " value="<?php //echo $row['user_name'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Nama</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder=" " value="<?php //echo $row['user_name'] ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Tel (HP)</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="hp_phone" name="hp_phone" placeholder=" " value="<?php //echo $row['user_phone'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Tel (Pej)</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="office_phone" name="office_phone" placeholder=" " value="<?php //echo $row['user_phone_ext'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="email" name="email" placeholder=" " value="<?php //echo $row['user_email']   ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Kumpulan*</label>
                                <div class="col-lg-6">
                                    <?php
                                    db_combo_box("select group_id,group_name from groups","groupId",$group,"group_id","group_name","","","Kumpulan","form-control input-sm m-bot15");
                                    //echo fnSelect('group_id','group_name','groups',$group,'groupId','form-control input-sm m-bot15','Kumpulan','','','required="required"'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-lg-2 control-label">Jawatan*</label>
                                <div class="col-lg-10">
                                    <span id="scheme_list"></span>
                                    <?php
                                    //db_combo_box("select scheme_id, scheme_name from scheme","skimId",$skim,"scheme_id","scheme_name","","","","form-control input-sm m-bot15");
                                    echo fnSelect('scheme_id','schema_name','view_scheme',$skim,'skimId','form-control input-sm m-bot15','','','',' required="required" multiple="multiple"'); ?>


                                </div>
                            </div>

                            <input type="hidden" name="cmd" id="cmd" value=""/>

                    </div>
                    <div class="modal-footer">
						<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
                        <button type="button" class="btn btn-success simpan">Simpan</button>
                    </div>
                    </form>
                </div>
        </div>
    </div>
    <!-- end modal 1 -->
    
    
    

    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <i class="icon-file"></i> Senarai Pengguna
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
                                                <div class="media-body">
                                                    <!-- start list media-body-->
													<div class="adv-table">
													
													
							<!--------mula table	-->					
													
							<table  class="display table table-bordered table-striped table-hover" id="example1">
							<thead>
								<tr>
									<th>Nama Penuh & ID Pengguna</th>
                                    <th>Jawatan & Gred</th>
									<th>Kumpulan</th>
									<th></th>
								</tr>
							</thead>
							
							<tbody>
								<?php 
								
							    //connDB();
                                $sql = "SELECT
                                        userprofile.user_id
                                        , userprofile.user_name AS fullname
                                        , userprofile.user_phone_ext AS office
                                        , department.department_name
                                        , groups.group_id
                                        , groups.group_name
                                        , userprofile.user_phone AS hp
                                        , userprofile.user_email AS email
                                        , userprofile.user_images
                                        , userprofile.user_scheme_id
                                    FROM
                                        userprofile
                                        LEFT JOIN  department
                                            ON (userprofile.user_dept_id=department.department_id )
                                        LEFT JOIN groups
                                            ON (userprofile.user_group_id = groups.group_id )";

									$cnt =1;
									$result = db_select($sql);
                                    foreach ($result as $row){
                                        $scheme_id = $row['user_scheme_id'];
                                        $qry = "SELECT scheme_id,CONCAT(scheme_name,' ',scheme_gred) AS skim FROM scheme WHERE FIND_IN_SET(scheme_id,'$scheme_id')";
                                        $rst = db_select($qry);

								?>
								<tr>

									<td><?php echo $row['fullname'] ?><br><span class="text-muted"><?php echo $row['user_id'] ?></span> </td>

                                    <td><?php
                                        foreach ($rst as $row1){
                                            echo $row1['skim'].'<br/>';
                                        }
                                        ?>
                                        </td>
                                    <td><?php echo $row['group_name']?> </td>
                                    <td>
                                        <a href="#dialog-skim" onclick="jsEditData('<?php echo $row['user_id'] ?>','<?php echo $row['fullname']  ?>','<?php echo $row['hp']  ?>','<?php echo $row['office']  ?>','<?php echo $row['email']  ?>','<?php echo $row['group_id']  ?>','<?php echo addslashes($row['user_scheme_id'])  ?>')"  class="btn btn-default btn-xs pinda" data-toggle="modal"><i class="icon-pencil"></i></a>
										<a href="javascript:void(0)" id="<?php echo $row['user_id'] ?>" onclick="jsDelData('DelDataUser','<?php echo $row['user_id'] ?>','')" class="btn btn-danger btn-xs padam"><i class="icon-trash"></i></a>
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

<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
<script src="js/notifications.js"></script>

<script type="text/javascript">
    $(document).ready(function(e) {


        $('#skimId').multiselect({
            selectAllValue: 'multiselect-all',
            enableCaseInsensitiveFiltering: true,
            enableFiltering: true,
            maxHeight: '300',
            buttonWidth: '235',
            onChange: function(element, checked) {
                var brands = $('#skimId option:selected');
                var selected = [];
                $(brands).each(function(index, brand){
                    selected.push([$(this).val()]);
                });

                console.log(selected);
            }
        });

        $('.tambah').click(function(){
            $(".modal-body .multiselect").show();
            $("#scheme_list").hide();
            $("#form_profile")[0].reset();
            $("#userid").attr("readonly", false);
        });



        $('#example1').dataTable( {} );

        $('.alert').hide();

        $(document).on("click", ".tambah", function () {
            $('#cmd').val('AddDataUser');
            $("#myModalLabel").html("Tambah Data");
        });

        $('.simpan').click(function(){
            var datastring = $("#form_profile").serialize();
            if($('#usename').val()==''){
                $('#username').focus();
                return false;
            }else if($('#fullname').val()==''){
                $('#fullname').focus();
                return false;
            }else if($('#groupId').val()==''){
                $('#groupId').focus();
                return false;
            }else if($('#skimId').val()==''){
                $('#skimId').focus();
                return false;
            }else{
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val(),
                    success: function(html)
                    {
                        alert(html);
                        //location.reload();
                        location.href='users.list.php';
                    }
                });
            }

        });

        var url = window.location;

        $('ul.sub a[href="'+ url +'"]').parent().addClass('active');
        $('ul.sub a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');
    });

    function jsEditData(userid,fullname,hp,office,email,group,scheme){
        $("#scheme_list").show();
        $(".modal-body #userid").val( userid );
        $(".modal-body #userid").attr('readonly', true);
        $(".modal-body #fullname").val( fullname );
        $(".modal-body #hp_phone").val( hp );
        $(".modal-body #office_phone").val( office );
        $(".modal-body #email").val( email );
        $(".modal-body #groupId").val( group );
        $(".modal-body .multiselect").hide();
        $.post("../inc/datascheme.php",{
                userid : userid,
                scheme_id:scheme,
                type: "results"},
            function(data){
                $("#scheme_list").html(data);

            });
        $('#cmd').val('EditDataUser');
        $("#myModalLabel").html("Pinda Data");
    }
    function jsDelData(cmd,id,actiontype){
        if(confirm("Anda pasti untuk teruskan?")){
            $.post("process.php",{
                    userid : id,
                    cmd:cmd,
                    token:$('#token').val(),
                    type: "results"},
                function(data){
                    alert(data);
                    location.reload();
                });
        }else{
            return false;
        }
    }

</script>
</body>
</html>
