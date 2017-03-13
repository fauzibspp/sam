<?php include_once('../config/functions.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

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
    //$jenissoalan = '';
    $v_owner = $_SESSION['userid'];
    ?>


    <!-- start modal 1 -->
    <div id="dialog-form" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade">
        <div class="modal-dialog table-responsive" >
            <div class="modal-content">
                <form name="form_module" id="form1" class="form-horizontal" role="form">
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
                        <input type="hidden" name="id" id="id" value=""/>
                        <input type="hidden" name="cmd" id="cmd" value=""/>
                        <input type="text" name="scheme_code" id="scheme_code" value="" class="form-control text-primary" placeholder="Kod Jawatan" maxlength="50" /></br>

                        <input type="text" name="scheme_name" id="scheme_name" value="" class="form-control text-primary" placeholder="Nama Jawatan" /></br>
                        <input type="text" name="scheme_gred" id="scheme_gred" value="" class="form-control text-primary" placeholder="Gred" maxlength="50" /></br>

                        <input type="text" name="scheme_reference" id="scheme_reference" value="" class="form-control text-primary" placeholder="No.Rujukan" />

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
                            <i class="icon-file"></i> Senarai Jawatan
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
                                                        <th>Kod Jawatan</th>
                                                        <th>Nama Jawatan</th>
                                                        <th>Gred</th>
                                                        <th>No.Rujukan</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php

                                                    //connDB();

                                                    $sql = 'SELECT
                                                    scheme_id as id,
                                                    scheme_name,
                                                    scheme_gred,
                                                    scheme_code,
                                                    scheme_reference
                                                    FROM
                                                    scheme
                                                    WHERE scheme_id is not null';
                                                    $cnt =1;
                                                    $result = db_select($sql);
                                                    foreach ($result as $row){

                                                        ?>
                                                        <tr>

                                                            <td><?php echo $row['scheme_code'] ?></td>
                                                            <td><?php echo $row['scheme_name'] ?></td>
                                                            <td><?php echo $row['scheme_gred'] ?></td>
                                                            <td><?php echo $row['scheme_reference'] ?></td>

                                                            <td>
                                                                <a href="#dialog-form" onclick="jsEditData('<?php echo $row['id'] ?>','<?php echo $row['scheme_name']  ?>','<?php echo $row['scheme_gred']  ?>','<?php echo $row['scheme_code']  ?>','<?php echo $row['scheme_reference']  ?>')"  class="btn btn-default btn-xs pinda" data-toggle="modal"><i class="icon-pencil"></i></a>
                                                                <a href="javascript:void(0)" onclick="jsDelData('<?php echo $row['id'] ?>')" id="<?php echo $row['id'] ?>"  class="btn btn-danger btn-xs padam"><i class="icon-trash"></i></a>
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

<!--<script src="js/jquery.js"></script>-->
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

<!--script for this notification-->
<script src="js/notifications.js"></script>

<script type="text/javascript">
    $(document).ready(function(e) {

        $('#example1').dataTable( {} );

        $('.alert').hide();

        $(document).on("click", ".tambah", function () {
            $('#cmd').val('AddDataSkim');
            $("#myModalLabel").html("Tambah Data");
        });

        $('.simpan').click(function(){
            var datastring = $("#form1").serialize();
            if($('#scheme_name').val()==''){
                $('.alert').show();
                $('.lblMsg').html('Sila isikan data berikut.');
                $('#scheme_name').focus();
                return false;
            }else{
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val(),
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

    function jsEditData(p1,p2,p3,p4,p5){
        $(".modal-body #id").val( p1 );
        $(".modal-body #scheme_name").val( p2 );
        $(".modal-body #scheme_gred").val( p3 );
        $(".modal-body #scheme_code").val( p4 );
        $(".modal-body #scheme_reference").val( p5 );
        $('#cmd').val('EditDataSkim');
        $("#myModalLabel").html("Pinda Data");
    }
    function jsDelData(id){

        var datastring = 'id='+id;
        if(y = confirm('Anda pasti untuk teruskan?')){
            if(y){
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val()+'&cmd=DelDataSkim',
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


    }

</script>
</body>
</html>
