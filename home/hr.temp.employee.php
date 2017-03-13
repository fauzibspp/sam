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

    <title><?php echo APP_NAME ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- Custom styles for editor -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/froala_editor.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->



    <style type="text/css">
        h1.heading{padding:0px;margin: 0px 0px 10px 0px;text-align:center;font: 18px Georgia, "Times New Roman", Times, serif;}

        /* width and height of google map */
        #google_map {width: 90%; height: 500px;margin-top:0px;margin-left:auto;margin-right:auto;}

        /* Marker Edit form */
        #marker-div{
            width:500px;
            height:200px;
        }

        .marker-edit label{display:block;margin-bottom: 5px;}
        .marker-edit label span {width: 100px;float: left;}
        .marker-edit label input, .marker-edit label select{height: 24px;}
        .marker-edit label textarea{height: 60px;}
        .marker-edit label input, .marker-edit label select, .marker-edit label textarea {width: 60%;margin:0px;padding-left: 5px;border: 1px solid #DDD;border-radius: 3px;}

        /* Marker Info Window */
        h1.marker-heading{color: #585858;margin: 0px;padding: 0px;font: 18px "Trebuchet MS", Arial;border-bottom: 1px dotted #D8D8D8;}
        div.marker-info-win {max-width: 500px;margin-right: -20px;}
        div.marker-info-win p{padding: 0px;margin: 10px 0px 10px 0;}
        div.marker-inner-win{padding: 5px;}
        button.save-marker, button.remove-marker{border: none;background: rgba(0, 0, 0, 0);color: #00F;padding: 0px;text-decoration: underline;margin-right: 10px;cursor: pointer;

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
    $v_owner = $_SESSION['userid'];
    $unit = "";
    $negara="";
    $kursus = "";
    $pangkat_kelas = "";
    $pangkat = "";
    ?>
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">

                    <section class="panel">
                        <div class="inbox-head">
                            <h3><i class="icon-file-text"></i> Senarai Tindakan</h3>
                        </div>

                        <!-- start tab -->
                        <header class="panel-heading tab-bg-dark-navy-blue">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active">
                                    <a data-toggle="tab" href="#a">
                                        <i class="icon-file"> </i>&nbsp;
                                        <span class="text-danger"><strong>Rekod Pangkat</strong></span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#b">
                                        <i class="icon-file"> </i>&nbsp;
                                        <span class="text-danger"><strong>Rekod Kursus</strong></span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#c">
                                        <i class="icon-file"> </i>&nbsp;
                                        <span class="text-danger"><strong>Rekod Misi</strong></span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#d">
                                        <i class="icon-file"> </i>&nbsp;
                                        <span class="text-danger"><strong>Rekod MKA</strong></span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#e">
                                        <i class="icon-file"> </i>&nbsp;
                                        <span class="text-danger"><strong>Rekod KKA</strong></span>
                                    </a>
                                </li>
                            </ul>
                        </header>
                        <!-- end tab -->
                        <!-- start content tab -->
                        <div class="panel-body">
                            <div class="tab-content">

                                <div id="a" class="tab-pane active">
                                    <header class="panel-heading">

                                        <div class="input-group-btn right">
                                            <button type="button" class="finish btn btn-success" id="btn_a"><i class="icon-save"></i> Simpan</button>
                                        </div>
                                    </header>
                                    <div class="panel-body">
                                    <!-- start content here -->
                                        <div class="form-group">
                                            *Sila isikan maklumat dibawah dan tekan butang Simpan.
                                        </div>
                                        <form id="form" name="form" class="form-inline">

                                            <div class="form-group">
                                                <?php echo fnSelect('c45_kod_pangkat','c45_desc_pangkat','c45_pangkat',$pangkat,'pangkat','form-control input-sm m-bot15','Pangkat','',' ORDER BY c45_susunan ASC') ?>
                                            </div>
                                            <div class="form-group">
                                                <?php echo fnSelect('c45_kod_pangkat_kelas','c45_desc_pangkat_kelas','c45_pangkat_kelas',$pangkat_kelas,'pangkat_kelas','form-control input-sm m-bot15','Pengkelasan','','') ?>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" style="width: 150px" name="mula" id="mula" class="form-control input-sm m-bot15 default-date-picker" placeholder="Mulai" required="required" value="">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="okeransi" id="okeransi" value="" class="form-control input-sm m-bot15" placeholder="Kuasa Kelulusan" />
                                            </div>
                                        </form>
                                        <table class="display table table-bordered table-striped table-hover" id="example">
                                            <thead>
                                            <tr><th></th>
                                                <th>No.Tentera</th>
                                                <th>Pangkat</th>
                                                <th>Nama Penuh</th>
                                                <th>TTP</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql_a = "SELECT
                                                d07_temp.d07_tempid as tempid,
                                                d07_temp.d07_no_tentera as notentera,
                                                d07_temp.d07_kategori as kategori,
                                                c45_pangkat.c45_desc_pangkat as pangkat,
                                                m01_induk.m01_nama_anggota as namapenuh,
                                                date_format(m01_induk.m01_tkh_ttp,'%d.%m.%Y') as ttp
                                                FROM
                                                m01_induk
                                                LEFT JOIN c45_pangkat ON c45_pangkat.c45_kod_pangkat = m01_induk.m01_kod_pangkat
                                                LEFT JOIN d07_temp ON m01_induk.m01_no_tentera = d07_temp.d07_no_tentera
                                                WHERE d07_temp.d07_kategori='01'
                                                order by c45_pangkat.c45_susunan
                                                ";
                                            $rst = mysql_query($sql_a) or die('Error:'.mysql_error());
                                            $rows_a = array();
                                            while($rows = mysql_fetch_assoc($rst)){
                                                $rows_a[] = $rows;
                                            }

                                            ?>
                                            <?php foreach($rows_a as $row_a): ?>
                                            <tr>
                                                <td><div id="checkboxes"><input type="checkbox" id="cbox_a" value="<?php echo $row_a["notentera"] ?>" name="addCB[] class="cb" checked disabled /></td>
                                                <td><?php echo $row_a["notentera"] ?></td>
                                                <td><?php echo $row_a["pangkat"] ?></td>
                                                <td><?php echo $row_a["namapenuh"] ?></td>
                                                <td><?php echo $row_a["ttp"] ?></td>
                                                <td><button type="button" id="cancelBtn" class="btn-group-xs" onclick="jsRemoveTempEmployee('<?php echo $row_a['notentera'] ?>','<?php echo $row_a['tempid'] ?>')"> <i class=" icon-remove"></i> Batalkan</button></td>
                                            </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <!-- end content here -->
                                    </div>
                                </div>
                                <div id="b" class="tab-pane">
                                    <header class="panel-heading">
                                        <div class="input-group-btn right">
                                            <button type="button" class="finish btn btn-success" id="btn_b"><i class="icon-save"></i> Simpan</button>
                                        </div>
                                    </header>
                                    <div class="panel-body">
                                        <!-- start content here -->
                                        <div class="form-group">
                                            *Sila isikan maklumat dibawah dan tekan butang Simpan.
                                        </div>
                                        <form id="form" name="form" class="form-inline">

                                            <div class="form-group">
                                                <?php echo fnSelect('c80_kod_kursus','c80_nama_kursus','c80_kursus',$kursus,'kursus','form-control input-sm m-bot15','Kursus',' WHERE c80_nama_kursus IS NOT NULL') ?>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" style="width: 150px" name="mula_kursus" id="mula_kursus" class="form-control input-sm m-bot15 default-date-picker" placeholder="Mula" required="required" value="">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" style="width: 150px" name="tamat_kursus" id="tamat_kursus" class="form-control input-sm m-bot15 default-date-picker" placeholder="Tamat" required="required" value="">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="tempat" id="tempat" value="" class="form-control input-sm m-bot15" placeholder="Tempat Kursus" />
                                            </div>
                                        </form>
                                        <table class="display table table-bordered table-striped table-hover" id="example">
                                            <thead>
                                            <tr><th></th>
                                                <th>No.Tentera</th>
                                                <th>Pangkat</th>
                                                <th>Nama Penuh</th>
                                                <th>TTP</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql_b = "SELECT
                                                d07_temp.d07_tempid as tempid,
                                                d07_temp.d07_no_tentera as notentera,
                                                d07_temp.d07_kategori as kategori,
                                                c45_pangkat.c45_desc_pangkat as pangkat,
                                                m01_induk.m01_nama_anggota as namapenuh,
                                                date_format(m01_induk.m01_tkh_ttp,'%d.%m.%Y') as ttp
                                                FROM
                                                m01_induk
                                                LEFT JOIN c45_pangkat ON c45_pangkat.c45_kod_pangkat = m01_induk.m01_kod_pangkat
                                                LEFT JOIN d07_temp ON m01_induk.m01_no_tentera = d07_temp.d07_no_tentera
                                                WHERE d07_temp.d07_kategori='02'
                                                order by c45_pangkat.c45_susunan
                                                ";
                                            $rst = mysql_query($sql_b) or die('Error:'.mysql_error());
                                            $rows_b = array();
                                            while($rows = mysql_fetch_assoc($rst)){
                                                $rows_b[] = $rows;
                                            }

                                            ?>
                                            <?php foreach($rows_b as $row_b): ?>
                                                <tr>
                                                    <td><div id="checkboxes"><input type="checkbox" id="cbox_b" value="<?php echo $row_b["notentera"] ?>" name="addCB[] class="cb" checked disabled /></td>
                                                    <td><?php echo $row_b["notentera"] ?></td>
                                                    <td><?php echo $row_b["pangkat"] ?></td>
                                                    <td><?php echo $row_b["namapenuh"] ?></td>
                                                    <td><?php echo $row_b["ttp"] ?></td>
                                                    <td><button type="button" id="cancelBtn" class="btn-group-xs" onclick="jsRemoveTempEmployee('<?php echo $row_b['notentera'] ?>','<?php echo $row_b['tempid'] ?>')"> <i class=" icon-remove"></i> Batalkan</button></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <!-- end content here -->
                                    </div>
                                </div>
                                <div id="c" class="tab-pane">
                                    <header class="panel-heading">
                                        <div class="input-group-btn right">
                                            <button type="button" class="finish btn btn-success" id="btn_c"><i class="icon-save"></i> Simpan</button>
                                        </div>
                                    </header>
                                    <div class="panel-body">
                                        <!-- start content here -->
                                        <div class="form-group">
                                            *Sila isikan maklumat dibawah dan tekan butang Simpan.
                                        </div>
                                        <form id="form" name="form" class="form-inline">
                                            <div class="form-group">
                                                <input type="text" name="misi" id="misi" value="" class="form-control input-sm m-bot15" placeholder="Nama Misi" />
                                            </div>
                                            <div class="form-group">
                                                <input type="text" style="width: 150px" name="mula_misi" id="mula_misi" class="form-control input-sm m-bot15 default-date-picker" placeholder="Mula" required="required" value="">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" style="width: 150px" name="tamat_misi" id="tamat_misi" class="form-control input-sm m-bot15 default-date-picker" placeholder="Tamat" required="required" value="">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="tempat_misi" id="tempat_misi" value="" class="form-control input-sm m-bot15" placeholder="Tempat Misi" />
                                            </div>
                                            <div class="form-group">
                                                <?php echo fnSelect('country_id','short_name','c81_country',$negara,'negara','form-control input-sm m-bot15','Negara',' WHERE short_name IS NOT NULL') ?>
                                            </div>
                                        </form>
                                        <table class="display table table-bordered table-striped table-hover" id="example">
                                            <thead>
                                            <tr><th></th>
                                                <th>No.Tentera</th>
                                                <th>Pangkat</th>
                                                <th>Nama Penuh</th>
                                                <th>TTP</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql_c = "SELECT
                                                d07_temp.d07_tempid as tempid,
                                                d07_temp.d07_no_tentera as notentera,
                                                d07_temp.d07_kategori as kategori,
                                                c45_pangkat.c45_desc_pangkat as pangkat,
                                                m01_induk.m01_nama_anggota as namapenuh,
                                                date_format(m01_induk.m01_tkh_ttp,'%d.%m.%Y') as ttp
                                                FROM
                                                m01_induk
                                                LEFT JOIN c45_pangkat ON c45_pangkat.c45_kod_pangkat = m01_induk.m01_kod_pangkat
                                                LEFT JOIN d07_temp ON m01_induk.m01_no_tentera = d07_temp.d07_no_tentera
                                                WHERE d07_temp.d07_kategori='03'
                                                order by c45_pangkat.c45_susunan
                                                ";
                                            $rst = mysql_query($sql_c) or die('Error:'.mysql_error());
                                            $rows_c = array();
                                            while($rows = mysql_fetch_assoc($rst)){
                                                $rows_c[] = $rows;
                                            }

                                            ?>
                                            <?php foreach($rows_c as $row_c): ?>
                                                <tr>
                                                    <td><div id="checkboxes"><input type="checkbox" id="cbox_c" value="<?php echo $row_c["notentera"] ?>" name="addCB[] class="cb" checked disabled /></td>
                                                    <td><?php echo $row_c["notentera"] ?></td>
                                                    <td><?php echo $row_c["pangkat"] ?></td>
                                                    <td><?php echo $row_c["namapenuh"] ?></td>
                                                    <td><?php echo $row_c["ttp"] ?></td>
                                                    <td><button type="button" id="cancelBtn" class="btn-group-xs" onclick="jsRemoveTempEmployee('<?php echo $row_c['notentera'] ?>','<?php echo $row_c['tempid'] ?>')"> <i class=" icon-remove"></i> Batalkan</button></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <!-- end content here -->
                                    </div>
                                </div>
                                <div id="d" class="tab-pane">
                                    <header class="panel-heading">
                                        <div class="input-group-btn right">
                                            <button type="button" class="finish btn btn-success" id="btn_d"><i class="icon-save"></i> Simpan</button>
                                        </div>
                                    </header>
                                    <div class="panel-body">
                                        <!-- start content here -->
                                        <div class="form-group">
                                            *Sila isikan maklumat dibawah dan tekan butang Simpan.
                                        </div>
                                        <form id="form" name="form" class="form-inline">
                                            <div class="form-group">
                                                <?php echo fnSelect('c76_kod_unit','c76_desc_unit','c76_unit',$unit,'unit_mka','form-control input-sm m-bot15','Daripada Unit',' WHERE c76_desc_unit IS NOT NULL') ?>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="penempatan" id="penempatan" value="" class="form-control input-sm m-bot15" placeholder="Penempatan Tugas" />
                                            </div>
                                            <div class="form-group">
                                                <input type="text" style="width: 150px" name="mula_mka" id="mula_mka" class="form-control input-sm m-bot15 default-date-picker" placeholder="Mula" required="required" value="">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="okeransi_mka" id="okeransi_mka" value="" class="form-control input-sm m-bot15" placeholder="Okeransi" />
                                            </div>

                                        </form>
                                        <table class="display table table-bordered table-striped table-hover" id="example">
                                            <thead>
                                            <tr><th></th>
                                                <th>No.Tentera</th>
                                                <th>Pangkat</th>
                                                <th>Nama Penuh</th>
                                                <th>TTP</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql_d = "SELECT
                                                d07_temp.d07_tempid as tempid,
                                                d07_temp.d07_no_tentera as notentera,
                                                d07_temp.d07_kategori as kategori,
                                                c45_pangkat.c45_desc_pangkat as pangkat,
                                                m01_induk.m01_nama_anggota as namapenuh,
                                                date_format(m01_induk.m01_tkh_ttp,'%d.%m.%Y') as ttp
                                                FROM
                                                m01_induk
                                                LEFT JOIN c45_pangkat ON c45_pangkat.c45_kod_pangkat = m01_induk.m01_kod_pangkat
                                                LEFT JOIN d07_temp ON m01_induk.m01_no_tentera = d07_temp.d07_no_tentera
                                                WHERE d07_temp.d07_kategori='04'
                                                order by c45_pangkat.c45_susunan
                                                ";
                                            $rst = mysql_query($sql_d) or die('Error:'.mysql_error());
                                            $rows_d = array();
                                            while($rows = mysql_fetch_assoc($rst)){
                                                $rows_d[] = $rows;
                                            }

                                            ?>
                                            <?php foreach($rows_d as $row_d): ?>
                                                <tr>
                                                    <td><div id="checkboxes"><input type="checkbox" id="cbox_d" value="<?php echo $row_d["notentera"] ?>" name="addCB[] class="cb" checked disabled /></td>
                                                    <td><?php echo $row_d["notentera"] ?></td>
                                                    <td><?php echo $row_d["pangkat"] ?></td>
                                                    <td><?php echo $row_d["namapenuh"] ?></td>
                                                    <td><?php echo $row_d["ttp"] ?></td>
                                                    <td><button type="button" id="cancelBtn" class="btn-group-xs" onclick="jsRemoveTempEmployee('<?php echo $row_d['notentera'] ?>','<?php echo $row_d['tempid'] ?>')"> <i class=" icon-remove"></i> Batalkan</button></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <!-- end content here -->
                                    </div>
                                </div>
                                <div id="e" class="tab-pane">
                                    <header class="panel-heading">
                                        <div class="input-group-btn right">
                                            <button type="button" class="finish btn btn-success" id="btn_e"><i class="icon-save"></i> Simpan</button>
                                        </div>
                                    </header>
                                    <div class="panel-body">
                                        <!-- start content here -->
                                        <div class="form-group">
                                            *Sila isikan maklumat dibawah dan tekan butang Simpan.
                                        </div>
                                        <form id="form" name="form" class="form-inline">
                                            <div class="form-group">
                                                <?php echo fnSelect('c76_kod_unit','c76_desc_unit','c76_unit',$unit,'unit_kka','form-control input-sm m-bot15','Unit Baru',' WHERE c76_desc_unit IS NOT NULL') ?>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" style="width: 150px" name="mula_kka" id="mula_kka" class="form-control input-sm m-bot15 default-date-picker" placeholder="Mula" required="required" value="">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="okeransi_kka" id="okeransi_kka" value="" class="form-control input-sm m-bot15" placeholder="Okeransi" />
                                            </div>

                                        </form>
                                        <table class="display table table-bordered table-striped table-hover" id="example">
                                            <thead>
                                            <tr><th></th>
                                                <th>No.Tentera</th>
                                                <th>Pangkat</th>
                                                <th>Nama Penuh</th>
                                                <th>TTP</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql_e = "SELECT
                                                d07_temp.d07_tempid as tempid,
                                                d07_temp.d07_no_tentera as notentera,
                                                d07_temp.d07_kategori as kategori,
                                                c45_pangkat.c45_desc_pangkat as pangkat,
                                                m01_induk.m01_nama_anggota as namapenuh,
                                                date_format(m01_induk.m01_tkh_ttp,'%d.%m.%Y') as ttp
                                                FROM
                                                m01_induk
                                                LEFT JOIN c45_pangkat ON c45_pangkat.c45_kod_pangkat = m01_induk.m01_kod_pangkat
                                                LEFT JOIN d07_temp ON m01_induk.m01_no_tentera = d07_temp.d07_no_tentera
                                                WHERE d07_temp.d07_kategori='05'
                                                order by c45_pangkat.c45_susunan
                                                ";
                                            $rst = mysql_query($sql_e) or die('Error:'.mysql_error());
                                            $rows_e = array();
                                            while($rows = mysql_fetch_assoc($rst)){
                                                $rows_e[] = $rows;
                                            }

                                            ?>
                                            <?php foreach($rows_e as $row_e): ?>
                                                <tr>
                                                    <td><div id="checkboxes"><input type="checkbox" id="cbox_e" value="<?php echo $row_e["notentera"] ?>" name="addCB[] class="cb" checked disabled /></td>
                                                    <td><?php echo $row_e["notentera"] ?></td>
                                                    <td><?php echo $row_e["pangkat"] ?></td>
                                                    <td><?php echo $row_e["namapenuh"] ?></td>
                                                    <td><?php echo $row_e["ttp"] ?></td>
                                                    <td><button type="button" id="cancelBtn" class="btn-group-xs" onclick="jsRemoveTempEmployee('<?php echo $row_e['notentera'] ?>','<?php echo $row_e['tempid'] ?>')"> <i class=" icon-remove"></i> Batalkan</button></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <!-- end content here -->
                                    </div>
                                </div>
                            </div>
                        <!-- end content tab -->
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

<!--script for editor -->
<script src="js/froala_editor.min.js"></script>

<!--common script for all pages-->
<script src="js/common-scripts.js"></script>
<!--date picker -->
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--<script src="assets/prettify/run_prettify.js"></script>-->


<!--script for this notification-->
<script src="js/notifications.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {

        $('#example1').dataTable( {} );

        $('.alert').hide();

        /* datepicker */
        window.prettyPrint && prettyPrint();
        $('.default-date-picker').datepicker({
            format: 'dd-mm-yyyy'
        });
        /* datepicker */

        $("#mula_kursus").datepicker({ dateFormat: 'dd-mm-yyyy',onSelect: function(selected){
            $("#tamat_kursus").datepicker("option","minDate",selected);
        }
        });
        $("#tamat_kursus").datepicker({ dateFormat: 'dd-mm-yyyy',onSelect: function(selected){
            $("#mula_kursus").datepicker("option","maxDate",selected);
        }
        });

    /* tab control */
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#myTab a[href="' + hash + '"]').tab('show');

        /*save button*/
    $('#btn_a').click(function(){
        var datacheck = $("#cbox_a:checked").map(function(i,n){
            return $(n).val();
        }).get();

        if($('#pangkat').val()==""){
            alert('Sila pilih pangkat');
            $('#pangkat').focus();
            return false;
        }else if($('#pangkat_kelas').val()==""){
            alert('Sila pilih pengkelasan pangkat');
            $('#pangkat_kelas').focus();
            return false;
        }else if($('#mula').val()==""){
            alert('Sila input tarikh kelulusan pangkat');
            $('#mula').focus();
            return false;
        }else{
            if(datacheck.length > 0){
                if(confirm("Anda pasti untuk teruskan?")){
                    $.post("process.php",{
                            'addCB[]' : datacheck,
                            cmd:'VerifyDataEmployeeRank',
                            mula:$('#mula').val(),
                            pangkat:$('#pangkat').val(),
                            pangkat_kelas:$('#pangkat_kelas').val(),
                            okeransi:$('#okeransi').val(),
                            token:$('#token').val(),
                            type: "results"},
                        function(data){
                            alert(data);
                            location.reload();
                        });
                }else{
                    return false;
                }
            }else{
                alert('Sila masukkan sekurang-kurangnya satu rekod untuk diproses.');
            }

        }
    });
    $('#btn_b').click(function(){
        var datacheck = $("#cbox_b:checked").map(function(i,n){
            return $(n).val();
        }).get();

        if($('#kursus').val()==""){
            alert('Sila pilih nama kursus');
            $('#kursus').focus();
            return false;
        }else if($('#mula_kursus').val()==""){
            alert('Sila input tarikh mula');
            $('#mula_kursus').focus();
            return false;
        }else if($('#tamat_kursus').val()==""){
            alert('Sila input tarikh tamat');
            $('#tamat_kursus').focus();
            return false;
        }else if($('#tempat').val()==""){
            alert('Sila input tempat kursus');
            $('#tempat').focus();
            return false;
        }else{
            if(datacheck.length > 0){
                if(confirm("Anda pasti untuk teruskan?")){
                    $.post("process.php",{
                            'addCB[]' : datacheck,
                            cmd:'VerifyDataEmployeeCourse',
                            kursus:$('#kursus').val(),
                            mula:$('#mula_kursus').val(),
                            tamat:$('#tamat_kursus').val(),
                            tempat:$('#tempat').val(),
                            token:$('#token').val(),
                            type: "results"},
                        function(data){
                            alert(data);
                            location.reload();
                        });
                }else{
                    return false;
                }
            }else{
                alert('Sila masukkan sekurang-kurangnya satu rekod untuk diproses.');
            }

        }
    });

    $('#btn_c').click(function(){
        var datacheck = $("#cbox_c:checked").map(function(i,n){
            return $(n).val();
        }).get();

        if($('#misi').val()==""){
            alert('Sila input nama misi');
            $('#misi').focus();
            return false;
        }else if($('#mula_misi').val()==""){
            alert('Sila input tarikh mula');
            $('#mula_misi').focus();
            return false;
        }else if($('#tamat_misi').val()==""){
            alert('Sila input tarikh tamat');
            $('#tamat_misi').focus();
            return false;
        }else if($('#tempat_misi').val()==""){
            alert('Sila input tempat misi');
            $('#tempat_misi').focus();
            return false;
        }else if($('#negara').val()==""){
            alert('Sila pilih negara misi');
            $('#negara').focus();
            return false;
        }else{
            if(datacheck.length > 0){
                if(confirm("Anda pasti untuk teruskan?")){
                    $.post("process.php",{
                            'addCB[]' : datacheck,
                            cmd:'VerifyDataEmployeeMission',
                            misi:$('#misi').val(),
                            mula:$('#mula_misi').val(),
                            tamat:$('#tamat_misi').val(),
                            tempat:$('#tempat_misi').val(),
                            negara:$('#negara').val(),
                            token:$('#token').val(),
                            type: "results"},
                        function(data){
                            alert(data);
                            location.reload();
                        });
                }else{
                    return false;
                }
            }else{
                alert('Sila masukkan sekurang-kurangnya satu rekod untuk diproses.');
            }

        }
    });

    $('#btn_d').click(function(){
        var datacheck = $("#cbox_d:checked").map(function(i,n){
            return $(n).val();
        }).get();

        if($('#unit_mka').val()==""){
            alert('Sila pilih daripada unit asal');
            $('#unit_mka').focus();
            return false;
        }else if($('#penempatan').val()==""){
            alert('Sila input penempatan tugas');
            $('#penempatan').focus();
            return false;
        }else if($('#mula_mka').val()==""){
            alert('Sila input tarikh MKA');
            $('#mula_mka').focus();
            return false;
        }else if($('#okeransi_mka').val()==""){
            alert('Sila input okeransi MKA');
            $('#okeransi_mka').focus();
            return false;
        }else{
            if(datacheck.length > 0){
                if(confirm("Anda pasti untuk teruskan?")){
                    $.post("process.php",{
                            'addCB[]' : datacheck,
                            cmd:'VerifyDataEmployeeMKA',
                            unit:$('#unit_mka').val(),
                            mula:$('#mula_mka').val(),
                            penempatan:$('#penempatan').val(),
                            okeransi:$('#okeransi_mka').val(),
                            token:$('#token').val(),
                            type: "results"},
                        function(data){
                            alert(data);
                            location.reload();
                        });
                }else{
                    return false;
                }
            }else{
                alert('Sila masukkan sekurang-kurangnya satu rekod untuk diproses.');
            }

        }
    });

    $('#btn_e').click(function(){
        var datacheck = $("#cbox_e:checked").map(function(i,n){
            return $(n).val();
        }).get();

        if($('#unit_kka').val()==""){
            alert('Sila pilih unit baru');
            $('#unit_kka').focus();
            return false;
        }else if($('#mula_kka').val()==""){
            alert('Sila input tarikh KKA');
            $('#mula_kka').focus();
            return false;
        }else if($('#okeransi_kka').val()==""){
            alert('Sila input okeransi KKA');
            $('#okeransi_kka').focus();
            return false;
        }else{
            if(datacheck.length > 0){
                if(confirm("Anda pasti untuk teruskan?")){
                    $.post("process.php",{
                            'addCB[]' : datacheck,
                            cmd:'VerifyDataEmployeeKKA',
                            unit:$('#unit_kka').val(),
                            mula:$('#mula_kka').val(),
                            okeransi:$('#okeransi_kka').val(),
                            token:$('#token').val(),
                            type: "results"},
                        function(data){
                            alert(data);
                            location.reload();
                        });
                }else{
                    return false;
                }
            }else{
                alert('Sila masukkan sekurang-kurangnya satu rekod untuk diproses.');
            }

        }
    });

    var url = window.location;

    $('ul.sub a[href="'+ url +'"]').parent().addClass('active');
    $('ul.sub a').filter(function() {
            return this.href == url;
    }).parent().addClass('active');

});
function jsRemoveTempEmployee(itemid,tempid){
    //alert(tempid)
    if(confirm('Proses ini tidak boleh undur. Anda pasti?')){
        $.post("process.php",{
                notentera: itemid,
                cmd: 'RemoveTempDataEmployee',
                tempid:tempid,
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
