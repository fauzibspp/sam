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
    //$jenissoalan = '';
    $v_owner = $_SESSION['userid'];
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
                        
                        db_combo_box("select group_id,group_name from groups","groups",$group,"group_id","group_name","","Kumpulan","","form-control input-sm m-bot15");
                        //echo fnSelect('group_id','group_name','groups',$group,'groupId','form-control input-sm m-bot15','Kumpulan','','','required="required"'); ?>

                        <?php

                        $qry = "SELECT perm_id,perm_key,perm_name from permissions";
                        $rst = db_select($qry);
                        //$rst = mysql_query($qry) or die('Error:'.mysql_error());

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
                            <i class="icon-file"></i> Role Ikut Kumpulan
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

                                                                <th>Kod</th>
                                                                <th>Kumpulan/Modul Disetkan</th>
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
                                                                $total = fnSQLCustom("select count(role_permission_id) as total from roleaccess where role_group_id='".$row['group_id']."'","total");

                                                                ?>
                                                            <tr>

                                                                <td><?php echo $row['group_id']; ?></td>
                                                                <td><?php echo $row['group_name'] .'&nbsp;&nbsp;('.$total.')' ?></td>
                                                                <td>
                                                                    <a href="#dialog-editform" data-id="<?php echo $row['group_id'] ?>" class="btn btn-default btn-xs pinda" data-toggle="modal"><i class="icon-pencil"></i></a>
                                                                    <a href="javascript:void(0)" id="<?php echo $row['group_id'] ?>"  class="btn btn-danger btn-xs padam"><i class="icon-trash"> Clear All</i></a>
                                                                    <a href="javascript:void(0)" id="<?php echo $row['group_id'] ?>"  class="btn btn-info btn-xs role_user"><i class="icon-gears"> Set Role Pengguna</i></a>
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
            var group_id = $(this).data('id');
            var cmd = 'EditDataPermission';
            var url = 'inc/datapermissions.php';
            $.post(url, {group_id: group_id,cmd: cmd,} ,function(data) {
                $(".modal-body").html(data).show();
            });
        });

        $(document).on("click", ".tambah", function () {
            $('#cmd').val('AddDataPermission');
            $("#myModalLabel").html("Tambah Data");
        });



        $('.simpan').click(function(){
            var datastring = $("#form_access").serialize();
            if($('#groupId').val()==''){
                $('.alert').show();
                $('.lblMsg').html('Sila pilih data berikut.');
                $('#groupId').focus();
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
            if($('#groupId').val()==''){
                $('.alert').show();
                $('.lblMsg').html('Sila pilih data berikut.');
                $('#groupId').focus();
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

        $('.role_user').click(function(){
            var datastring = 'groupId='+$(this).attr('id');
            if(y = confirm('Anda pasti untuk teruskan?')){
                if(y){
                    $.ajax({
                        type: 'post',
                        url: 'process.php',
                        data: datastring + '&token='+$('#token').val()+'&cmd=UpdateDataUserRole',
                        cache: false,
                        success: function(html)
                        {
                            alert(html);
                            location.reload();
                        }
                    });
                }else{
                    return false;
                }
            }

        });

        $('.padam').click(function(){
            var datastring = 'groupId='+$(this).attr('id');
            if(y = confirm('Anda pasti untuk teruskan?')){
                if(y){
                    $.ajax({
                        type: 'post',
                        url: 'process.php',
                        data: datastring + '&token='+$('#token').val()+'&cmd=DelDataPermission',
                        cache: false,
                        success: function(html)
                        {
                            alert(html);
                            location.reload();
                        }
                    });
                }else{
                    return false;
                }
            }

        });

        var url = window.location;

        $('ul.sub a[href="'+ url +'"]').parent().addClass('active');
        $('ul.sub a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');


});
    
    
</script>
</body>
</html>
