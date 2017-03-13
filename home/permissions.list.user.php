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
    $group=$_SESSION['groupid'];
    //$user_id="";
    //$jenissoalan = '';

    $user_id = $_SESSION['userid'];
    ?>
    
    
    <!-- start modal 1 -->
    <div id="dialog-form" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade">
            <div class="modal-dialog table-responsive" >
                <div class="modal-content">
                    <form name="form_access" id="form_access" class="form-horizontal" role="form">
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
                        <input type="hidden" name="permissionId" id="permissionId" value=""/>
                        <input type="hidden" name="cmd" id="cmd" value=""/>
                        <?php

                        db_combo_box("select user_id, user_name from userprofile where user_status=1","userId",$user_id,"user_id","user_name","required='required'","Pengguna","","form-control input-sm m-bot15")
                        ?>

                        <?php

                        $qry = "SELECT perm_id,perm_key,perm_name from permissions";
                        $rst = db_select($qry);


                        echo '<div class="checkboxes">';
                        $i=1;
                        foreach ($rst as $rows){

                            echo '<label class="label_check" for="checkbox-0'.$i.'">';

                                echo '<input name="addCB[]" id="addCB" value="'.$rows['perm_id'].'" type="checkbox" /> '.$rows['perm_name'];

                            echo '</label>';
                        $i++;
                        }
                        echo '</div>';

                        ?>

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
    <!-- start modal 2 -->
    <div id="dialog-editform" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade">
        <div class="modal-dialog table-responsive" >
            <form name="form_perm" id="form_perm" class="form-horizontal" role="form">
            <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 id="myModalLabel">Pinda Data</h4>
                    </div>

                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
                        <button type="button" class="btn btn-success simpan2">Simpan</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <!-- end modal 2 -->




    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <i class="icon-file"></i> Role Ikut Pengguna
                        </header>
                        <!--widget start-->
                        <section class="panel">
                            <div class="panel-body">
                                <a href="#dialog-form" id="0" class="btn tambah sentBtn btn-send" data-toggle="modal">
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

                                                                <th>Id Pengguna/Kumpulan</th>
                                                                <th>Pengguna/Modul Disetkan</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php



                                                            $sql = 'SELECT
                                                                    userprofile.user_id
                                                                    , userprofile.user_name
                                                                    , groups.group_desc
                                                                FROM
                                                                    groups
                                                                    LEFT JOIN userprofile
                                                                        ON (groups.group_id = userprofile.user_group_id)';
                                                            $cnt =1;
                                                            $rst = db_select($sql);
                                                            foreach ($rst as $row){
                                                                $total = fnSQLCustom("select count(role_permission_id) as total from roleaccess_user where role_user_id='".$row['user_id']."'","total");
                                                                ?>
                                                            <tr>

                                                                <td>
                                                                    <?php echo $row['user_id']; ?>
                                                                    <div class="text-muted"><?php echo $row['group_desc'] ?></div>

                                                                </td>
                                                                <td><?php echo $row['user_name'] .'&nbsp;&nbsp;('.$total.')' ?></td>
                                                                <td>
                                                                    <a href="#dialog-editform" data-id="<?php echo $row['user_id'] ?>" class="btn btn-default btn-xs pinda" data-toggle="modal"><i class="icon-pencil"></i></a>
                                                                    <a href="javascript:void(0)" id="<?php echo $row['user_id'] ?>" onclick="jsDelData('DelDataPermissionUser','<?php echo $row['user_id'] ?>','')"  class="btn btn-danger btn-xs"><i class="icon-trash"> Clear Role</i></a>
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

        $('#example1').dataTable( {} );

        $('.alert').hide();

        $(document).on("click", ".pinda", function () {
            var user_id = $(this).data('id');
            var cmd = 'EditDataPermissionUser';
            var url = '../inc/datapermissionsuser.php';
            $.post(url, {user_id: user_id,cmd: cmd,} ,function(data) {
                $(".modal-body").html(data).show();
            });
        });

        $(document).on("click", ".tambah", function () {
            $('#cmd').val('AddDataPermissionUser');
            $("#myModalLabel").html("Tambah Data");
        });



        $('.simpan').click(function(){
            var datastring = $("#form_access").serialize();
            if($('#userId').val()==''){
                $('.alert').show();
                $('.lblMsg').html('Sila pilih data berikut.');
                $('#userId').focus();
                return false;
            }else{
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val(),
                    cache: false,
                    success: function(html)
                    {
                        alert(html);
                        location.reload();
                    }
                });
            }
        });

        $('.simpan2').click(function(){
            var datastring = $("#form_perm").serialize();
            if($('#userId').val()==''){
                $('.alert').show();
                $('.lblMsg').html('Sila pilih data berikut.');
                $('#userId').focus();
                return false;
            }else{
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val(),
                    cache: false,
                    success: function(html)
                    {
                        alert(html);
                        location.reload();
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
function jsDelData(cmd,userid,actionType){
    if(confirm("Anda pasti untuk teruskan?")){
        $.post("process.php",{
                userId : userid,
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
