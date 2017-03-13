<?php include_once('../config/config.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title><?php APP_NAME ?></title>

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
$skim = '';
$siri = '';
$masa_mula = '';
$masa_tamat = '';
$v_owner = $_SESSION['userid'];
connDB();
$searchvalue = isset($_GET['searchvalue']) ? $_GET['searchvalue'] : "";

?>
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <div class="inbox-head">
                        <h3><i class="icon-user"></i> Senarai Cetak & Disahkan</h3>
                    </div>


                    <!--widget start-->

                    <section class="panel">
                        <div class="panel-body">




                            <article class="media">
                                <section class="panel">


                                    <div class="media-body">
                                        <!-- start list media-body-->
                                        <div class="adv-table">


                                            <!--------mula table	-->

                                            <table class="display table table-bordered table-striped table-hover" id="example1">
                                                <thead>
                                                <tr>
                                                    <th style="width: 10px">Bil</th>
                                                    <th>No.Tentera</th>
                                                    <th>Pangkat</th>
                                                    <th>Nama Penuh</th>
                                                    <th>No.KP Baru</th>
                                                    <th>Tarikh Disahkan</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $sql = "";
                                                $userid = $_SESSION['userid'];



                                                         $sql = "SELECT @num := @num +1 bil
                                                            , d13_print_card.d13_notentera AS notentera
                                                            , c45_pangkat.c45_desc_pangkat AS pangkat
                                                            , m01_induk.m01_nama_anggota AS namapenuh
                                                            , m01_induk.m01_kpbaru_anggota AS nokpbaru
                                                            , DATE_FORMAT(m01_induk.m01_tkh_ttp,'%d %M %Y') AS ttp
                                                            , d13_print_card.d13_verify_date as tkh_sah
                                                        FROM
                                                            d13_print_card
                                                            INNER JOIN m01_induk
                                                                ON (d13_print_card.d13_notentera = m01_induk.m01_no_tentera)
                                                            INNER JOIN c45_pangkat
                                                                ON (m01_induk.m01_kod_pangkat = c45_pangkat.c45_kod_pangkat)
                                                                ,(SELECT @num :=0) d
                                                                WHERE d13_print_card.d13_verify_by = '$userid'";


                                                    //echo $sql;
                                                    $result = mysql_query($sql) or die('Error 1:'.mysql_error());
                                                    $rows_induk = array();
                                                    while($row = mysql_fetch_assoc($result)){
                                                        $rows_induk[] = $row;
                                                    }

                                                    ?>

                                                    <?php foreach($rows_induk as $row_induk): ?>
                                                        <tr>
                                                            <td><?php echo $row_induk['bil'] ?>.</td>
                                                            <td><a title="Klik untuk terperinci" href="hr.view.employee.php?notentera=<?php echo $row_induk['notentera'] ?>"><?php echo $row_induk['notentera'] ?></a></td>
                                                            <td><?php echo $row_induk['pangkat'] ?></td>
                                                            <td><a title="Klik untuk terperinci" href="hr.view.employee.php?notentera=<?php echo $row_induk['notentera'] ?>"><?php echo $row_induk['namapenuh'] ?></a>
                                                            <br>TTP: <span class="text-info"><?php echo $row_induk['ttp'] ?></span>
                                                            </td>
                                                            <td><?php echo $row_induk['nokpbaru'] ?></td>
                                                            <td><?php echo $row_induk['tkh_sah'] ?></td>

                                                        </tr>
                                                    <?php endforeach; ?>


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

<!--plug in -->
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="assets/prettify/run_prettify.js"></script>
<script src="assets/bootstrap-dialog/js/bootstrap-dialog.js"></script>
<!--input mask-->
<script src="js/inputmask.js" type="text/javascript"></script>

<!--script for this notification-->
<script src="js/notifications.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {

    $('#filterby').on('change', function() {
        //alert( this.value ); // or $(this).val()

        if(this.value == '2'){
            $('#searchvalue').removeClass('hidden');
        }else{
            $('#searchvalue').addClass('hidden');
        }

    });



    /* datepicker */
    window.prettyPrint && prettyPrint();
    $('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy',
        beforeShow: function() {$('#ui-datepicker-div').maxZIndex(); }
    });
    /* datepicker */

    $('#example1').dataTable( {} );
/*
    $('#btnSearch').click(function(){
        if($('#filterby').val()==""){
            alert('Sila pilih kriteria');
            $('#filterby').focus();
            return false;
        }else if($('#searchvalue').val()==""){
            alert('Sila input carian');
            $('#searchvalue').focus();
            return false;
        }else{
            startFilter(this.value);
        }
    });

    $('input#searchvalue').keypress(function(e) {

        if (e.which == '13') {
            e.preventDefault();
            if($('#searchvalue').val()==""){
                alert('Sila input carian');
                $('#searchvalue').focus();
                return false;
            }else{
                startFilter(this.value);
            }


        }
    });
*/
    function startFilter(searchvalue){

        if($("#filterby").val()==""){
            alert('Sila pilih kriteria terlebih dahulu.');
            $("#filterby").focus();
            return false;
        }else{
            $('#search').submit();
        }
    }


    var url = window.location;

    $('ul.sub a[href="'+ url +'"]').parent().addClass('active');
    $('ul.sub a').filter(function() {
        return this.href == url;
    }).parent().addClass('active');
});

</script>
</body>
</html>
