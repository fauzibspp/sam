<?php include_once('../config/config.php') ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title><?php echo APP_NAME ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />

    <!-- Custom styles for editor -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/froala_editor.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <!--upload-->
    <link rel="stylesheet" href="css/uploadfile.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

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
    <!-- start popup modal 1 -->
    <div id="dialog-form" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade">
        <div class="modal-dialog table-responsive" >
            <form name="form_receipient" id="form_receipient" class="form-horizontal" role="form">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 id="myModalLabel">Senarai Pengguna</h4>
                    </div>

                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Tutup</button>
                        <button type="submit" class="btn btn-success simpan">OK</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end popup modal 1 -->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">

                <section class="panel">
                    <div class="inbox-head">
                        <h3><i class="icon-edit-sign"></i> Butir Peribadi</h3>
                    </div>
                    <header class="panel-heading">
                        *Klik butang Kemaskini untuk sunting.
                    </header>


                    <div class="panel-body">
                        <div class="input-group-btn">
                            <button style="float: right" type="button" id="btnUpdate" class="finish btn btn-success form-inline"><i class="icon-pencil"></i> Kemaskini</button>
                        </div>

                        <div id="result"></div>
                        <div id="loading"></div>

                        <!-- start content -->
                        <div class="container-fluid"><!-- container start -->
                        <div class="row-fluid">
                        <div class="span10">
                        <!--Body content-->
                        <?php
                        connDB();
                        $qry = "SELECT
                    m01_induk.m01_no_tentera as notentera,
                    m01_induk.m01_kpbaru_anggota as nokpbaru,
                    c45_pangkat.c45_desc_pangkat as pangkat,
                    m01_induk.m01_nama_anggota as namapenuh,
                    m01_induk.m01_gelaran as gelaran,
                    m01_induk.m01_skim as skim,
                    c76_unit.c76_shortform_unit as unit,
                    c65_taraf_khidmat.c65_desc_taraf_khid as tarafkhidmat,
                    c33_kor.c33_desc_kor as kor,
                    c31_khidmat.c31_desc_khidmat as khidmat,
                    DATE_FORMAT(m01_induk.m01_tkh_tmk,'%d.%m.%Y') as tmk,
                    DATE_FORMAT(m01_induk.m01_tkh_ttp,'%d.%m.%Y') as ttp,
                    m01_induk.m01_kplama as nokplama,
                    DATE_FORMAT(m01_induk.m01_tkh_lahir,'%d.%m.%Y') as tkhlahir,
                    m01_induk.m01_telhp as telhp,
                    m01_induk.m01_telrumah as telrumah,
                    c13_jantina.c13_desc_jantina as jantina,
                    c30_keturunan.c30_desc_keturunan as keturunan,
                    c60_status_kahwin.c60_desc_status_kahwin as tarafkahwin,
                    c74_ugama.c74_desc_ugama as agama,
                    m01_induk.m01_emailrasmi as emailrasmi,
                    m01_induk.m01_emailperibadi as emailperibadi,
                    m01_induk.m01_gambar as gambar,
                    m01_induk.m01_penempatan as penempatan
                    FROM
                    m01_induk
                    LEFT JOIN c13_jantina ON c13_jantina.c13_kod_jantina = m01_induk.m01_kod_jantina
                    LEFT JOIN c30_keturunan ON c30_keturunan.c30_kod_keturunan = m01_induk.m01_kod_keturunan
                    LEFT JOIN c31_khidmat ON c31_khidmat.c31_kod_khidmat = m01_induk.m01_kod_khidmat
                    LEFT JOIN c33_kor ON c33_kor.c33_kod_kor = m01_induk.m01_kod_kor
                    LEFT JOIN c45_pangkat ON c45_pangkat.c45_kod_pangkat = m01_induk.m01_kod_pangkat
                    LEFT JOIN c65_taraf_khidmat ON c65_taraf_khidmat.c65_kod_taraf_khid = m01_induk.m01_kod_taraf_khidmat
                    LEFT JOIN c60_status_kahwin ON c60_status_kahwin.c60_kod_status_kahwin = m01_induk.m01_kod_status_kahwin
                    LEFT JOIN c74_ugama ON c74_ugama.c74_kod_ugama = m01_induk.m01_kod_agama
                    LEFT JOIN c76_unit ON c76_unit.c76_kod_unit = m01_induk.m01_kod_unit
                    WHERE m01_induk.m01_no_tentera = '".$_GET['notentera']."'";
                        //echo $qry;

                        $rst = mysql_query($qry) or die('Error: '.$qry);
                        $row = mysql_fetch_assoc($rst);

                        if(empty($row['gambar'])){
                            $gambar = '../images/user_male.png.jpg';
                        }else{
                            $gambar = '../profile/'.$row['notentera'].'/'.$row['gambar'];
                        }

                        ?>

                        <?php
                        $salt = 'abc123';
                        $token = sha1(mt_rand(1,1000000) . $salt);
                        $_SESSION['token'] = $token;
                        echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
                        ?>

                        <fieldset><legend>Info <?php echo $_GET['notentera'] ?></legend></fieldset>
                        <button type="button" class="btn btn-primary btn-mini" id="editButton" style="float: right;" onclick="jsEdit('<?php echo $_GET['notentera'] ?>')">Kemaskini</button>
                        &nbsp;
                        <button type="button" class="btn btn-primary btn-mini" id="delButton" style="float: right;" onclick="jsDelete('<?php echo $_GET['notentera'] ?>')">Padam</button>
                        &nbsp;
                        <!-- $$$$$$$$$$$$$$$$$$$$ -->
                        <div class="row-fluid" style="margin-left:10px;">
                            <div class="span2">
                                <div class="row-fluid">
                                    <div class="span12" style="text-align: center;">
                                        <img id="profile_image__id_" src="<?php echo $gambar ?>" class="img-polaroid" style="max-width: 140px;max-height: 140px;">

                                    </div>

                                </div>
                            </div>
                            <div class="span9" style="margin-left:50px;">

                                <div class="row-fluid" style="border-top: 1px;">
                                    <div class="span4" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;font-size:13px;">No.Tentera</label>
                                        <label class="control-label" style="width:200px;font-size:13px;font-weight: bold;" id="notentera"><?php echo $_GET['notentera'] ?></label>
                                    </div>
                                    <div class="span4" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">No.KP Baru</label>
                                        <label class="control-label" style="width:200px;font-size:13px;font-weight: bold;" id="nokpbaru"><?php echo $row['nokpbaru'] ?></label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row-fluid" style="margin-left:10px;">

                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Perkhidmatan</span><br/><br/>


                                <div class="row-fluid">

                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Pangkat</label>
                                        <label id="pangkat" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['pangkat'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Nama Penuh</label>
                                        <label id="namapenuh" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['namapenuh'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Gelaran</label>
                                        <label id="gelaran" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['gelaran'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Skim</label>
                                        <label id="skim" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['skim'] ?></label>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row-fluid">
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Unit</label>
                                        <label id="unit" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['unit'] ?></label>
                                    </div>

                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Taraf Khidmat</label>
                                        <label id="tkhidmat" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['tarafkhidmat'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Kor</label>
                                        <label id="kor" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['kor'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Khidmat</label>
                                        <label id="khidmat" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['khidmat'] ?></label>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row-fluid">
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Masuk Khidmat</label>
                                        <label id="tmk" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['tmk'] ?></label>
                                    </div>

                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Tamat Khidmat</label>
                                        <label id="ttp" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['ttp'] ?></label>
                                    </div>

                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Penempatan</label>
                                        <label id="ttp" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['penempatan'] ?></label>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">
                                <hr/>
                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Peribadi</span><br/><br/>
                                <div class="row-fluid">
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">No.KP Lama</label>
                                        <label id="nokplama" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['nokplama'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Tarikh Lahir:</label>
                                        <label id="tlahir" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['tkhlahir'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Tel H/P:</label>
                                        <label id="telhp" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['telhp'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Tel Rumah:</label>
                                        <label id="telrumah" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['telrumah'] ?></label>
                                    </div>

                                </div>
                                <hr/>
                                <div class="row-fluid">
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Jantina</label>
                                        <label id="jantina" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['jantina'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Keturunan</label>
                                        <label id="keturunan" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['keturunan'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Taraf Kahwin</label>
                                        <label id="tarafkahwin" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['tarafkahwin'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Agama</label>
                                        <label id="agama" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['agama'] ?></label>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row-fluid">
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Email Rasmi</label>
                                        <label id="emailrasmi" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['emailrasmi'] ?></label>
                                    </div>
                                    <div class="span3" style="font-size:16px;">
                                        <label class="control-label" style="width:200px;font-size:13px;">Email Peribadi</label>

                                        <label id="emailperibadi" class="control-label" style="width:200px;font-size:13px;font-weight: bold;"><?php echo $row['emailperibadi'] ?></label>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </div>
                        <?php mysql_free_result($rst); ?>
                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Pasangan</span><br/><br/>
                                <div class="row-fluid">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>No.KP</th>
                                            <th>Nama</th>
                                            <th>Tarikh Lahir</th>
                                            <th>Tarikh Kahwin</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $bil=1;
                                        $qry2 = "SELECT
        w04_pasangan.w04_no_kp_pasangan as nokpbarupasangan,
        w04_pasangan.w04_nama_pasangan as namapasangan,
        date_format(w04_pasangan.w04_tkh_lahir,'%d.%m.%Y') as tkhlahirpasangan,
        date_format(w04_pasangan.w04_tkh_kahwin,'%d.%m.%Y') as tkhkahwinpasangan
        FROM
        w04_pasangan WHERE w04_pasangan.w04_no_tentera ='".$_GET['notentera']."'";
                                        $rst2 = mysql_query($qry2) or die('Error:'.$qry2);
                                        while($row2 = mysql_fetch_assoc($rst2)){
                                            if($oddoreven=$bil%2){
                                                $oddoreven = 'odd';
                                            }else{
                                                $oddoreven = 'event';
                                            }
                                            ?>
                                            <tr class="<?php echo $oddoreven ?>">
                                                <td><?php echo $row2['nokpbarupasangan'] ?></td>
                                                <td><?php echo $row2['namapasangan'] ?></td>
                                                <td><?php echo $row2['tkhlahirpasangan'] ?></td>
                                                <td><?php echo $row2['tkhkahwinpasangan'] ?></td>
                                            </tr>

                                            <?php
                                            $bil++;
                                        }
                                        mysql_free_result($rst2);
                                        ?>

                                </div>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        </div>

                        <hr />
                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Anak</span><br/><br/>
                                <div class="row-fluid">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>No.KP</th>
                                            <th>Nama</th>
                                            <th>Jantina</th>
                                            <th>Tarikh Lahir</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $bil=1;
                                        $qry3 = "SELECT
        w01_anak.w01_no_kp_anak as nokpbaruanak,
        w01_anak.w01_nama_anak as namapenuhanak,
        c13_jantina.c13_desc_jantina as jantinaanak,
        DATE_FORMAT(w01_anak.w01_tkh_lahir_anak,'%d.%m.%Y') as tkhlahiranak,
        DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),w01_anak.w01_tkh_lahir_anak)), '%Y')+0 AS umur
        FROM
        w01_anak
        LEFT JOIN c13_jantina ON c13_jantina.c13_kod_jantina = w01_anak.w01_kod_jantina_anak
        WHERE w01_anak.w01_no_tentera='".$_GET['notentera']."'";

                                        $rst3 = mysql_query($qry3) or die('Error:'.$qry3);
                                        while($row3 = mysql_fetch_assoc($rst3)){
                                            if($oddoreven=$bil%2){
                                                $oddoreven = 'odd';
                                            }else{
                                                $oddoreven = 'event';
                                            }
                                            ?>
                                            <tr class="<?php echo $oddoreven ?>">
                                                <td><?php echo $row3['nokpbaruanak'] ?></td>
                                                <td><?php echo $row3['namapenuhanak'] ?></td>
                                                <td><?php echo $row3['jantinaanak'] ?></td>
                                                <td><?php echo $row3['tkhlahiranak'] ?>&nbsp;(<?php echo $row3['umur'] ?> TAHUN)</td>
                                            </tr>
                                            <?php
                                            $bil++;
                                        }
                                        mysql_free_result($rst3);
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Dokumen</span><br/><br/>
                                <div class="row-fluid">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <th>Nama File</th>

                                        </thead>
                                        <tbody>

                                        <?php
                                        $qry4 = "SELECT m01_id,m01_filenamenew,m01_no_tentera,m01_filenamecurrent,m01_filetype
            FROM m01_attachments WHERE  m01_filecategory = 2 AND m01_no_tentera = '".$_GET['notentera']."' order by m01_fileuploddte DESC";

                                        $rst4 = mysql_query($qry4) or die('Error:'.$qry4);
                                        while($row4 = mysql_fetch_assoc($rst4)){
                                            ?>

                                            <tr>
                                                <td>
                                                    <?php echo $row4['m01_filenamecurrent'] ?><a href="../profile/<?php echo $_GET['notentera'].'/'.$row4['m01_filenamenew'] ?>" class="popup-pdf btn btn-mini" style="float: right;">Papar</a>
                                                </td>

                                            </tr>


                                        <?php
                                        }
                                        mysql_free_result($rst4);
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Koleksi Gambar</span><br/><br/>
                                <div class="row-fluid">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <th>Nama File</th>

                                        </thead>
                                        <tbody>

                                        <?php
                                        $qry4 = "SELECT m01_id,m01_filenamenew,m01_no_tentera,m01_filenamecurrent,m01_filetype
            FROM m01_attachments WHERE  m01_filecategory = 1 AND m01_no_tentera = '".$_GET['notentera']."' order by m01_fileuploddte DESC";

                                        $rst4 = mysql_query($qry4) or die('Error:'.$qry4);
                                        while($row4 = mysql_fetch_assoc($rst4)){
                                            ?>

                                            <tr>
                                                <td>
                                                    <?php echo $row4['m01_filenamecurrent'] ?><a href="../profile/<?php echo $_GET['notentera'].'/'.$row4['m01_filenamenew'] ?>" class="image-popup-vertical-fit btn btn-mini" style="float: right;">Papar</a>
                                                </td>
                                            </tr>


                                        <?php
                                        }
                                        mysql_free_result($rst4);
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Pangkat</span><br/><br/>
                                <div class="row-fluid">
                                    <table class="table table-striped table-bordered">
                                        <thead>

                                        <tr>
                                            <th style="width: 20px;text-align: center;"></th>
                                            <th>Kelas Pangkat</th>
                                            <th>Pangkat</th>
                                            <th>Tarikh</th>
                                            <th>Kuasa Kelulusan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        connDB();
                                        $bil=1;
                                        $qry = "SELECT d11p.d11_pkt_id AS pktid,
            c45p.c45_kod_pangkat as kod_pangkat,
            c45pk.c45_desc_pangkat_kelas AS kelas_pkt,
            c45pk.c45_kod_pangkat_kelas as kod_pangkat_kelas,
            c45p.c45_desc_pangkat AS pangkat,
            DATE_FORMAT(d11p.d11_tkh_pemakaian,'%d.%m.%Y') AS tkh_pkt,
            d11p.d11_kuasa_pemakaian AS kuasa_pemakaian
            FROM d11_pangkat AS d11p INNER JOIN c45_pangkat AS c45p ON
            (d11p.d11_pkt_kod = c45p.c45_kod_pangkat)
            LEFT JOIN c45_pangkat_kelas AS c45pk ON
            d11p.d11_pkt_kelas = c45pk.c45_kod_pangkat_kelas
            WHERE d11p.d11_no_tentera = '".$_GET['notentera']."'";

                                        $result = mysql_query($qry) or die('Error Desc:'.$qry);

                                        while($row = mysql_fetch_assoc($result)){

                                            if($oddoreven=$bil%2){
                                                $oddoreven = 'odd';
                                            }else{
                                                $oddoreven = 'event';
                                            }


                                            ?>
                                            <tr class="<?php echo $oddoreven ?>">
                                                <td style="text-align: center;"><?php echo $bil ?>.</td>
                                                <td><?php echo $row['kelas_pkt'] ?></td>
                                                <td><?php echo $row['pangkat'] ?></td>
                                                <td><?php echo $row['tkh_pkt'] ?></td>
                                                <td><?php echo $row['kuasa_pemakaian'] ?></td>


                                            </tr>

                                            <?php
                                            $bil++;
                                        }
                                        mysql_free_result($result);
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Kursus/Latihan</span><br/><br/>
                                <div class="row-fluid">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Nama Kursus</th>
                                            <th>Mulai</th>
                                            <th>Tamat</th>
                                            <th>Tempat</th>
                                            <th>Keputusan</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        connDB();

                                        $bil=1;
                                        $qry = "SELECT
            d07_kursus.d07_kod_id as kodid,
            d07_kursus.d07_kod_kursus as kodkursus,
            DATE_FORMAT(d07_kursus.d07_mulai,'%d.%m.%Y') AS mula,
            DATE_FORMAT(d07_kursus.d07_hingga,'%d.%m.%Y') AS tamat,
            d07_kursus.d07_keputusan as keputusan,
            c80_kursus.c80_nama_kursus as namakursus,
            d07_kursus.d07_tempat as tempat
            FROM
            c80_kursus
            INNER JOIN d07_kursus ON c80_kursus.c80_kod_kursus = d07_kursus.d07_kod_kursus
            WHERE d07_kursus.d07_no_tentera='".$_GET['notentera']."'";

                                        $result = mysql_query($qry) or die('Error Desc:'.$qry);

                                        while($row = mysql_fetch_assoc($result)){

                                            if($oddoreven=$bil%2){
                                                $oddoreven = 'odd';
                                            }else{
                                                $oddoreven = 'event';
                                            }


                                            ?>
                                            <tr class="<?php echo $oddoreven ?>">
                                                <td><?php echo $row['namakursus'] ?></td>
                                                <td><?php echo $row['mula'] ?></td>
                                                <td><?php echo $row['tamat'] ?></td>
                                                <td><?php echo $row['tempat'] ?></td>
                                                <td><?php echo $row['keputusan'] ?></td>
                                            </tr>

                                            <?php
                                            $bil++;
                                        }
                                        mysql_free_result($result);
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr />

                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Misi</span><br/><br/>
                                <div class="row-fluid">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Misi</th>
                                            <th>Mulai</th>
                                            <th>Tamat</th>
                                            <th>Tempat</th>
                                            <th>Negara</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        connDB();

                                        $bil=1;
                                        $qry = "SELECT
            d08_misi.d08_nama_misi AS misi,
            c81_country.short_name AS negara,
            DATE_FORMAT(d08_misi.d08_mulai,'%d.%m.%Y') AS mula,
            DATE_FORMAT(d08_misi.d08_hingga,'%d.%m.%Y') AS tamat,
            d08_misi.d08_tempat AS tempat
            FROM
            d08_misi
            INNER JOIN c81_country ON c81_country.country_id = d08_misi.d08_kod_negara
            WHERE d08_misi.d08_no_tentera = '".$_GET['notentera']."'";

                                        $result = mysql_query($qry) or die('Error Desc:'.$qry);

                                        while($row = mysql_fetch_assoc($result)){

                                            if($oddoreven=$bil%2){
                                                $oddoreven = 'odd';
                                            }else{
                                                $oddoreven = 'event';
                                            }


                                            ?>
                                            <tr class="<?php echo $oddoreven ?>">
                                                <td><?php echo $row['misi'] ?></td>
                                                <td><?php echo $row['mula'] ?></td>
                                                <td><?php echo $row['tamat'] ?></td>
                                                <td><?php echo $row['tempat'] ?></td>
                                                <td><?php echo $row['negara'] ?></td>
                                            </tr>

                                            <?php
                                            $bil++;
                                        }
                                        mysql_free_result($result);
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr />

                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Rekod DKT</span><br/><br/>
                                <div class="row-fluid">
                                    <table class="table table-bordered table-hover list table-condensed table-striped" id="example3">
                                        <thead>

                                        <tr>
                                            <th style="width: 20px;text-align: center;"></th>
                                            <th>Status DKT</th>
                                            <th>Tarikh Pemeriksaan</th>
                                            <th>Publikasi</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        connDB();

                                        $bil=1;
                                        $qry = "SELECT
                            d09_dkt.d09_dkt_id as dktid,
                            d09_dkt.d09_no_tentera as notentera,
                            d09_dkt.d09_dkt_status as tahap,
                            DATE_FORMAT(d09_dkt.d09_tkh_pemeriksaan,'%d.%m.%Y') as mula,
                            d09_dkt.d09_perbah as publikasi
                            FROM
                            d09_dkt
                            WHERE d09_dkt.d09_no_tentera='".$_GET['notentera']."'
                            ORDER BY d09_dkt.d09_tkh_pemeriksaan DESC";

                                        $result = mysql_query($qry) or die('Error Desc:'.$qry);

                                        while($row = mysql_fetch_assoc($result)){

                                            if($oddoreven=$bil%2){
                                                $oddoreven = 'odd';
                                            }else{
                                                $oddoreven = 'event';
                                            }


                                            ?>
                                            <tr class="<?php echo $oddoreven ?>">
                                                <td style="text-align: center;"><?php echo $bil ?>.</td>
                                                <td><?php echo $row['tahap'] ?></td>
                                                <td><?php echo $row['mula'] ?></td>
                                                <td><?php echo $row['publikasi'] ?></td>


                                            </tr>

                                            <?php
                                            $bil++;
                                        }
                                        mysql_free_result($result);
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Rekod BMI</span><br/><br/>
                                <div class="row-fluid">

                                    <table class="table table-bordered table-hover list table-condensed table-striped" id="example3">
                                        <thead>

                                        <tr>
                                            <th style="width: 20px;text-align: center;"></th>
                                            <th>Berat</th>
                                            <th>Tinggi</th>
                                            <th>BMI</th>
                                            <th>Tarikh</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        connDB();

                                        $bil=1;
                                        $qry = "SELECT
                            d09_bmi.d09_bmi_id as bmiid,
                            d09_bmi.d09_no_tentera as notentera,
                            d09_bmi.d09_berat as berat,
                            d09_bmi.d09_tinggi as tinggi,
                            DATE_FORMAT(d09_bmi.d09_tkh_pemeriksaan,'%d.%m.%Y') as mula,
                            d09_bmi.d09_perbah as publikasi
                            FROM
                            d09_bmi
                            WHERE d09_bmi.d09_no_tentera='".$_GET['notentera']."'
                            ORDER BY d09_bmi.d09_tkh_pemeriksaan DESC";

                                        $result = mysql_query($qry) or die('Error Desc:'.$qry);

                                        while($row = mysql_fetch_assoc($result)){

                                            if($oddoreven=$bil%2){
                                                $oddoreven = 'odd';
                                            }else{
                                                $oddoreven = 'event';
                                            }
                                            //Formula BMI = Berat (kg) / [ Tinggi (m) x Tinggi (m) ]
                                            $b = $row['berat'];
                                            $t = $row['tinggi'];
                                            $bmi = $b / ($t * $t);



                                            if(round($bmi) >= 19 && round($bmi) <= 24){
                                                $color = 'blue';
                                            }else if(round($bmi) >= 25 && round($bmi) <= 29){
                                                $color = 'yellow';
                                            }else if(round($bmi) >= 30 && round($bmi) <= 34){
                                                $color = 'green';
                                            }else if(round($bmi) >= 35){
                                                $color = 'orange';
                                            }

                                            //echo $color;
                                            ?>
                                            <tr class="<?php echo $oddoreven ?>">
                                                <td style="text-align: center;"><?php echo $bil ?>.</td>
                                                <td><?php echo $row['berat'] ?></td>
                                                <td><?php echo $row['tinggi'] ?></td>
                                                <td><span class='<?php echo $color ?>'><?php echo number_format((float)$bmi, 2, '.', ''); ?></span></td>
                                                <td><?php echo $row['mula'] ?></td>
                                            </tr>

                                            <?php
                                            $bil++;
                                        }
                                        mysql_free_result($result);
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row-fluid" style="margin-left:10px;margin-top:20px;">
                            <div class="span12">

                                <span class="label label-inverse" style="font-size:16px;background: #405A6A;">Rekod Keluar/Masuk Unit</span><br/><br/>
                                <div class="row-fluid">

                                    <table class="table table-bordered table-hover list table-condensed table-striped" id="example3">
                                        <thead>

                                        <tr>
                                            <th style="width: 20px;text-align: center;"></th>
                                            <th>Mulai</th>
                                            <th>Dari</th>
                                            <th>Ke</th>
                                            <th>Perbah II</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        connDB();

                                        $bil=1;
                                        $qry = "SELECT
                                d10_masukkeluar.d10_dari AS kod_dari,
                                d10_masukkeluar.d10_ke AS kod_ke,
                                DATE_FORMAT(d10_masukkeluar.d10_mulai,'%d.%m.%Y') AS mulai,
                                d10_masukkeluar.d10_perbah AS publikasi,
                                d.c76_shortform_unit AS dari,
                                k.c76_shortform_unit AS ke
                                FROM
                                d10_masukkeluar
                                Left Join c76_unit AS d ON d10_masukkeluar.d10_dari = d.c76_kod_unit
                                Left Join c76_unit AS k ON d10_masukkeluar.d10_ke = k.c76_kod_unit
                                WHERE
                                d10_masukkeluar.d10_no_tentera =  '".$_GET['notentera']."'
                                ORDER BY d10_masukkeluar.d10_mulai ASC";

                                        $result = mysql_query($qry) or die('Error Desc:'.$qry);

                                        while($row = mysql_fetch_assoc($result)){

                                            if($oddoreven=$bil%2){
                                                $oddoreven = 'odd';
                                            }else{
                                                $oddoreven = 'event';
                                            }


                                            //echo $color;
                                            ?>
                                            <tr class="<?php echo $oddoreven ?>">
                                                <td style="text-align: center;"><?php echo $bil ?>.</td>
                                                <td><?php echo $row['mulai'] ?></td>
                                                <td><?php echo $row['dari'] ?></td>
                                                <td><?php echo $row['ke'] ?></td>
                                                <td><?php echo $row['publikasi'] ?></td>
                                            </tr>

                                            <?php
                                            $bil++;
                                        }
                                        mysql_free_result($result);
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr />


                        <!-- $$$$$$$$$$$$$$$$$$$$ -->
                        <!--Body content-->
                        </div>
                        </div>
                        <!-- end content -->

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

<!--<script src="js/jquery.js"></script>-->
<script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.js"></script>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/jquery.form.js" type="text/javascript"></script>
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
<script src="assets/tiles/js/jquery.magnific-popup.min.js"></script>

<!-- upload multiple -->
<script src="assets/multifile/jquery.multiFile.js"></script>

<script type="text/javascript">
    $(document).ready(function(e) {

        $("#more-multifile").multiFile();



        //open dialog box

        $("#email_to").click(function(){
            $("#dialog-form").modal('show');
            var url = 'inc/data_contact_list.php';
            $.post(url, {} ,function(data) {
                $("#dialog-form .modal-body").html(data).show();
            });
        });

        var url = window.location;

        $('ul.sub a[href="'+ url +'"]').parent().addClass('active');
        $('ul.sub a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');

        //magnific popup
        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: {
                verticalFit: true
            }

        });

    });

    function jsDelData(id,filename){

        var datastring = 'id='+id+'&filename='+filename;
        if(y = confirm('Anda pasti untuk teruskan?')){
            if(y){
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring +'&cmd=DelDataUploadFile',
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
    function jsVerifyData(id,publish){

        var datastring = 'id='+id+'&publish='+publish;
        if(y = confirm('Anda pasti untuk teruskan?')){
            if(y){
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring +'&cmd=VerifyDataUploadFile',
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
