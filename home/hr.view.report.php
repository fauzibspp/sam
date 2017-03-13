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

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/css/bootstrap-timepicker.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->



    <style type="text/css">
        /* padding-bottom and top for image */
        .mfp-no-margins img.mfp-img {
            padding: 0;
        }
        /* position of shadow behind the image */
        .mfp-no-margins .mfp-figure:after {
            top: 0;
            bottom: 0;
        }
        /* padding for main container */
        .mfp-no-margins .mfp-container {
            padding: 0;
        }


        /*

        for zoom animation
        uncomment this part if you haven't added this code anywhere else

        */


        .mfp-with-zoom .mfp-container,
        .mfp-with-zoom.mfp-bg {
            opacity: 0;
            -webkit-backface-visibility: hidden;
            -webkit-transition: all 0.3s ease-out;
            -moz-transition: all 0.3s ease-out;
            -o-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
        }

        .mfp-with-zoom.mfp-ready .mfp-container {
                opacity: 1;
        }
        .mfp-with-zoom.mfp-ready.mfp-bg {
                opacity: 0.8;
        }

        .mfp-with-zoom.mfp-removing .mfp-container,
        .mfp-with-zoom.mfp-removing.mfp-bg {
            opacity: 0;
        }


    </style>

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
$source = '';
$category = '';
$v_owner = $_SESSION['userid'];
?>

<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <?php
            if(isset($_GET['id'])){
                $qry = "SELECT pertemuan.id, 
            pertemuan.kod_sumber, 
            pertemuan.nama_samaran, 
            pertemuan.perkara, 
            pertemuan.tempat_pertemuan, 
            pertemuan.tarikh_pertemuan, 
            pertemuan.masa_pertemuan, 
            pertemuan.class_maklumat, 
            pertemuan.class_perlindungan,
            pertemuan.masalah_keselamatan, 
            pertemuan.tempat_baru, 
            pertemuan.tarikh_baru, 
            pertemuan.masa_utama, 
            pertemuan.masa_varian, 
            pertemuan.hal_operasi, 
            pertemuan.tarikh_laporan, 
            pertemuan.komen, 
            pertemuan.penilaian, 
            pertemuan.hal_peribadi, 
            pertemuan.keperluan_semasa, 
            pertemuan.hal_pentadbiran,
            pertemuan.pegawai_pengendali,
            pertemuan.class_pertemuan
        FROM pertemuan WHERE pertemuan.id='".$_GET['id']."'";
                $rst = db_select($qry);
                //echo $rst[0]['class_maklumat'];
            }else{

                echo '<div class="row text-danger"><h3>Capaian Disekat!!.</h3></div>';
                echo '<div class="row text-primary"><a class="btn btn-primary" href="hr.view.employee.php?kodsumber='.$_GET['kodsumber'].'&notentera='.$_GET['notentera'].'&nokpbaru='.$_GET['nokpbaru'].'">Kembali</a></div>';
            }

        ?>

        <div class="row">
            <div class="col-lg-12">

                <section class="panel">
                    <div class="inbox-head">
                        <h3><i class="icon-file-text-alt"></i> Laporan Pertemuan</h3>
                        <div style="float: right"><button id="btnback" class="btn btn-default"><i class="icon-backward"></i> Kembali</button></div>
                    </div>

                    <div class="panel-body">
                        <form name="form_report" id="form_report" method="post" action="process.php" class="form-horizontal">
                            <div id="result"></div>
                            <div id="loading"></div>
                            <input type="hidden" id="cmd" name="cmd" value="EditDataRpt" />
                            <input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] ?>" />
                            <input type="hidden" id="nokpbaru_sumber" name="nokpbaru_sumber" value="<?php echo $_GET['nokpbaru'] ?>" />

                            <div class="row">
                                <div class="col-md-12">
                                    <button style="float: right" type="submit" class="btn btn-primary" name="btnSave" id="btnSave"><i class="icon-save"></i> Kemaskini</button>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <span><i class="icon-anchor"></i> Kod Sumber</span>:
                                        <input type="text" class="form-control" id="kod_sumber" name="kod_sumber" value="<?php echo $rst[0]['kod_sumber'] ?>" required="required">
                                    </div>

                                    <div class="col-md-2">
                                        <span><i class="icon-apple"></i> @/Nama Samaran</span>:
                                        <input type="text" class="form-control" id="nama_samaran" name="nama_samaran" value="<?php echo $rst[0]['nama_samaran'] ?>">
                                    </div>

                                    <div class="col-md-2">
                                        <span><i class="icon-user"></i> AHO</span>:
                                        <input type="text" class="form-control" id="pegawai_pengendali" name="pegawai_pengendali" value="<?php echo $rst[0]['pegawai_pengendali'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <span><i class="icon-calendar"></i> Tarikh Laporan</span>:
                                        <input type="text" class="form-control default-date-picker" id="tarikh_laporan" name="tarikh_laporan" value="<?php echo $rst[0]['tarikh_laporan'] ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <span><i class="icon-pencil"></i> Perkara </span>:
                                        <input type="text" class="form-control" id="perkara" name="perkara" value="<?php echo $rst[0]['perkara'] ?>">
                                    </div>

                                </div>

                            </div>
                            <p></p>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <span><i class="icon-pinterest"></i> Tempat Pertemuan</span>:
                                        <input type="text" class="form-control" id="tempat_pertemuan" name="tempat_pertemuan" value="<?php echo $rst[0]['tempat_pertemuan'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <span><i class="icon-bullseye"></i> Isu Pertemuan</span>:
                                        <?php
                                        $class_pertemuan = $rst[0]['class_pertemuan'];
                                        db_combo_box("select id, nama_pertemuan from class_pertemuan","class_pertemuan","$class_pertemuan","id","nama_pertemuan","","--Sila Pilih--","","form-control");
                                        ?>
                                    </div>
                                    <div class="col-md-3">
                                        <span><i class="icon-calendar"></i> Tarikh Pertemuan</span>:
                                        <input type="text" class="form-control default-date-picker" id="tarikh_pertemuan" name="tarikh_pertemuan" value="<?php echo $rst[0]['tarikh_pertemuan'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <span><i class="icon-time"></i> Masa Pertemuan</span>:
                                        <input type="text" class="form-control default-time-picker" id="masa_pertemuan" name="masa_pertemuan" value="<?php echo $rst[0]['masa_pertemuan'] ?>">
                                    </div>
                                </div>
                            </div>
                            <p></p>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="col-md-4">

                                        <span><i class="icon-puzzle-piece"></i> Cover Digunakan </span>:

                                        <select name="class_perlindungan" id="class_perlindungan" class="form-control">
                                            <option value="" selected>--Sila Pilih--</option>
                                            <option value="Sumber/Agen" <?php if($rst[0]['class_perlindungan']=='Sumber/Agen') { echo "selected";} ?>>Sumber/Agen</option>
                                            <option value="AHO" <?php if($rst[0]['class_perlindungan']=='AHO') { echo "selected";} ?>>AHO</option>
                                            <option value="Kedua-Duanya" <?php if($rst[0]['class_perlindungan']=='Kedua-Duanya') { echo "selected";} ?>>Kedua-Duanya</option>
                                        </select>

                                    </div>

                                    <div class="col-md-8">
                                        <span><i class="icon-lock"></i> Masalah Keselamatan </span>:
                                        <textarea class="form-control" id="masalah_keselamatan" name="masalah_keselamatan" cols="2" rows="2"><?php echo $rst[0]['masalah_keselamatan'] ?></textarea>
                                    </div>


                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <span><i class="icon-pinterest"></i> Tempat Pertemuan Akan Datang </span>:
                                        <input type="text" class="form-control" id="tempat_baru" name="tempat_baru" value="<?php echo $rst[0]['tempat_baru'] ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <span><i class="icon-calendar"></i> Tarikh Akan Datang</span>:
                                        <input type="text" class="form-control default-date-picker" id="tarikh_baru" name="tarikh_baru" value="<?php echo $rst[0]['tarikh_baru'] ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-5">
                                            <span><i class="icon-time"></i> Utama</span>:
                                            <input type="text" class="form-control default-time-picker" id="masa_utama" name="masa_utama" value="<?php echo $rst[0]['masa_utama'] ?>" placeholder="00:00" data-mask="00:00">
                                        </div>
                                        <div class="col-md-5">
                                            <span><i class="icon-time"></i> Varian</span>:
                                            <input type="text" class="form-control default-time-picker" id="masa_varian" name="masa_varian" value="<?php echo $rst[0]['masa_varian'] ?>" placeholder="00:00" data-mask="00:00">
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <span><i class="icon-inbox"></i> Maklumat Perisikan Diterima </span>:
                                        <select name="class_maklumat" id="class_maklumat" class="form-control">
                                            <option value="" selected>--Sila Pilih--</option>
                                            <option value="Lengkap" <?php if($rst[0]['class_maklumat']=='Lengkap') { echo "selected";} ?>>Laporan Lengkap</option>
                                            <option value="Tidak" <?php if($rst[0]['class_maklumat']=='Tidak') { echo "selected";} ?>>Laporan Tidak Lengkap</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <span><i class="icon-rocket"></i> Hal-hal Operasi</span>:
                                        <input type="text" class="form-control" id="hal_operasi" name="hal_operasi" value="<?php echo $rst[0]['hal_operasi'] ?>">
                                    </div>
                                </div>

                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <span><i class="icon-edit"></i> Keperluan Semasa </span>:
                                        <textarea class="form-control" id="keperluan_semasa" name="keperluan_semasa" cols="2" rows="2"><?php echo $rst[0]['keperluan_semasa'] ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <span><i class="icon-edit"></i> Keperluan Yang Belum Dipenuhi</span>:
                                        <textarea class="form-control" id="masalah_keselamatan" name="masalah_keselamatan" cols="2" rows="2"><?php echo $rst[0]['masalah_keselamatan'] ?></textarea>
                                    </div>
                                </div>

                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <span><i class="icon-edit"></i> Hal Pentadbiran </span>:
                                        <textarea class="form-control" id="hal_pentadbiran" name="hal_pentadbiran" cols="2" rows="2"><?php echo $rst[0]['hal_pentadbiran'] ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <span><i class="icon-edit"></i> Hal Peribadi</span>:
                                        <textarea class="form-control" id="hal_peribadi" name="hal_peribadi" cols="2" rows="2"><?php echo $rst[0]['hal_peribadi'] ?></textarea>
                                    </div>
                                </div>

                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <span><i class="icon-edit"></i> Penilaian </span>:
                                        <textarea class="form-control" id="penilaian" name="penilaian" cols="2" rows="2"><?php echo $rst[0]['penilaian'] ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <span><i class="icon-edit"></i> Komen/Cadangan</span>:
                                        <textarea class="form-control" id="komen" name="komen" cols="2" rows="2"><?php echo $rst[0]['komen'] ?></textarea>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </section>

            </div>
        </div>
        <!-- end row 1 -->

        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<?php include_once("footer.php") ?>
<!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->

<!--<script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.js"></script>-->
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
<!--<script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>-->
<script src="js/respond.min.js" ></script>
<script src="js/jquery.validate.min.js" ></script>

<!--common script for all pages-->
<script src="js/common-scripts.js"></script>

<!--script for this notification-->
<script src="js/notifications.js"></script>

<!--date picker -->
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#btnback').click(function(){
            location.href='hr.view.employee.php?kodsumber=<?php echo $_GET['kodsumber'] ?>&notentera=<?php echo $_GET['notentera'] ?>&nokpbaru=<?php echo $_GET['nokpbaru'] ?>';
        });



        $('#form_report').on('submit', function(e){

            var ok = confirm('Anda pasti untuk teruskan?');
            if(ok){
                e.preventDefault();
                $("#loading").html('<img src="img/progressbar.gif">');
                $(this).ajaxSubmit({
                    target: '#result',
                    success: function(response){
                        $("#loading").html('');
                        $('#result').fadeOut(1000);
                        alert(response);
                        location.reload();
                    }
                });
            }else{
                return false;
            }


        });


        window.prettyPrint && prettyPrint();
        $('.default-date-picker').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('.default-time-picker').timepicker({
            autoclose: true,
            minuteStep: 1,
            showSeconds: false,
            showMeridian: true
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
