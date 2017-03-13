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

    <title><?php appname ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        @media screen and (min-width: 768px) {

            #dialog-form .modal-dialog  {width:900px;}

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
    $skim = '';
    $siri = '';
    $masa_mula = '';
    $masa_tamat = '';
    $v_owner = $_SESSION['userid'];
    //connDB();
    $searchvalue = isset($_GET['searchvalue']) ? $_GET['searchvalue'] : "";
    ?>


    <!-- start modal 1 -->

    <div id="dialog-form" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog table-responsive" >
            <div class="modal-content">
                <form name="form_peribadi" id="form_peribadi" class="form-vertical" role="form">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 id="myModalLabel">Tambah Data</h4>
                    </div>

                    <div class="modal-body">
                    <!-- content -->

                            <div id="progress_peribadi"></div>
                            <div class="panel-body">

                                <input type="hidden" id="cmd" name="cmd" value="" />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <span><i class="icon-credit-card"></i> Kod Sumber </span>:
                                            <input type="text" class="form-control" id="kod_sumber" name="kod_sumber" value="" required="required" maxlength="10" placeholder="A0000-0000" style="text-transform:uppercase">
                                        </div>
                                        <div class="col-md-3">
                                            <span><i class="icon-credit-card"></i> No.Tentera </span>:
                                            <input type="text" class="form-control" id="notentera" name="notentera" value="" required="">
                                        </div>
                                        <div class="col-md-3">
                                            <span><i class="icon-credit-card"></i> No.KP Baru</span>:
                                            <input type="text" class="form-control" id="nokpbaru" name="nokpbaru" value="" data-mask="999999-99-9999" placeholder="000000-00-0000" required="required">
                                        </div>
                                        <div class="col-md-3">
                                            <span>Pangkat </span>:
                                            <?php
                                            db_combo_box("select c45_kod_pangkat,c45_desc_pangkat from c45_pangkat where c45_desc_pangkat IS NOT NULL","pkt","","c45_kod_pangkat","c45_desc_pangkat","","Pangkat","","form-control");
                                             ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <span>Nama Penuh </span>:
                                            <input type="text" class="form-control" id="namapenuh" name="namapenuh" value="" required="" style="text-transform: uppercase">
                                        </div>
                                        <div class="col-md-4">
                                            <span>Nama Gelaran </span>:
                                            <input type="text" class="form-control" id="gelaran" name="gelaran" value="" required="">
                                        </div>
                                        <div class="col-md-4">
                                            <span>Khidmat </span>:
                                            <?php
                                            db_combo_box("select c31_kod_khidmat,c31_desc_khidmat from c31_khidmat WHERE c31_desc_khidmat IS NOT NULL","khidmat","","c31_kod_khidmat","c31_desc_khidmat","","","","form-control");
                                             ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <span>Perkhidmatan/Kor/Rej </span>:
                                            <?php
                                            db_combo_box("select c33_kod_kor, c33_desc_kor from c33_kor WHERE c33_desc_kor IS NOT NULL","kor","","c33_kod_kor","c33_desc_kor","","","","form-control");
                                             ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Pasukan/Jabatan </span>:
                                            <?php
                                            db_combo_box("select c76_kod_unit, c76_desc_unit from c76_unit WHERE c76_desc_unit IS NOT NULL","unit","","c76_kod_unit","c76_desc_unit","","","","form-control");
                                           ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Jawatan </span>:
                                            <input type="text" class="form-control" id="jawatan" name="jawatan" value="" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <span><i class="icon-map-marker"></i> Penempatan </span>:
                                            <input type="text" class="form-control" id="penempatan" name="penempatan" value="" required="">
                                        </div>
                                        <div class="col-md-4">
                                            <span><i class="icon-calendar"></i> TMT </span>:
                                            <input type="text" class="form-control default-date-picker" id="tmk" name="tmk" value="" required="">
                                        </div>
                                        <div class="col-md-4">
                                            <span><i class="icon-calendar"></i> TTP </span>:
                                            <input type="text" class="form-control default-date-picker" id="ttp" name="ttp" value="" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <span><i class="icon-mobile-phone"></i> Telefon Pejabat </span>:
                                            <input type="text" class="form-control" id="telpej" name="telpej" value="" required="">
                                        </div>
                                        <div class="col-md-4">
                                            <span><i class="icon-mobile-phone"></i> Telefon Rumah </span>:
                                            <input type="text" class="form-control" id="telrumah" name="telrumah" value="" required="">
                                        </div>
                                        <div class="col-md-4">
                                            <span><i class="icon-mobile-phone"></i> Telefon Bimbit </span>:
                                            <input type="text" class="form-control" id="telhp" name="telhp" value="" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <span><i class="icon-credit-card"></i> No.KP Lama </span>:
                                            <input type="text" class="form-control" id="nokplama" name="nokplama" value="" required="">
                                        </div>
                                        <div class="col-md-4">
                                            <span><i class="icon-calendar"></i> Tarikh Lahir </span>:
                                            <input type="text" class="form-control default-date-picker" id="tlahir" name="tlahir" value="" required="">
                                        </div>
                                        <div class="col-md-4">
                                            <span>Jantina </span>:
                                            <?php
                                            db_combo_box("select c13_kod_jantina, c13_desc_jantina from c13_jantina WHERE c13_desc_jantina IS NOT NULL","jantina","","c13_kod_jantina","c13_desc_jantina","","","","form-control");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">


                                        <div class="col-md-4">
                                            <span>Bangsa </span>:
                                            <?php
                                            db_combo_box("select c30_kod_keturunan, c30_desc_keturunan from c30_keturunan WHERE c30_desc_keturunan IS NOT NULL","keturunan","","c30_kod_keturunan","c30_desc_keturunan","","","","form-control");
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Taraf Kahwin </span>:
                                            <?php
                                            db_combo_box("select c60_kod_status_kahwin, c60_desc_status_kahwin from c60_status_kahwin WHERE c60_desc_status_kahwin IS NOT NULL","tkahwin","","c60_kod_status_kahwin","c60_desc_status_kahwin","","","","form-control");
                                           ?>
                                        </div>
                                        <div class="col-md-4">
                                            <span>Agama </span>:
                                            <?php
                                            db_combo_box("select c74_kod_ugama, c74_desc_ugama from c74_ugama WHERE c74_desc_ugama IS NOT NULL","agama","","c74_kod_ugama","c74_desc_ugama","","","","form-control");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="col-md-4">
                                            <span><i class="icon-envelope"></i> Email Rasmi </span>:
                                            <input type="text" class="form-control" id="emailrasmi" name="emailrasmi" value="" required="">
                                        </div>
                                        <div class="col-md-4">
                                            <span><i class="icon-envelope"></i> Email Peribadi </span>:
                                            <input type="text" class="form-control" id="emailperibadi" name="emailperibadi"  value="" required="">
                                        </div>
                                        <div class="col-md-4">
                                            <span>Status </span>:
                                            <?php
                                            db_combo_box("select c01_kod_status_khidmat, c01_desc_status_khidmat from c01_status_khidmat WHERE c01_desc_status_khidmat IS NOT NULL","status_khidmat","","c01_kod_status_khidmat","c01_desc_status_khidmat","","","","form-control");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <span><i class="icon-user-md"></i> Pegawai Pengendali (AHO) </span>:
                                            <?php db_combo_box("select user_id, user_name from userprofile WHERE user_id <> 'admin'","pegawai_pengendali","","user_id","user_name","","--Sila Pilih--","","form-control");?>
                                            </div>
                                        </div>
                                </div>


                            </div>

                        </form>
                    <!-- content -->
                    </div>
                    <div class="modal-footer">
                        <button class="btn btnCancel btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
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
                        <div class="inbox-head">
                            <h3><i class="icon-search"></i> Carian Induk</h3>
                        </div>
                        <header class="panel-heading">
                            *Sila isikan maklumat dibawah dan tekan butang yang disediakan.
                        </header>

                        <!--widget start-->

                        <section class="panel">
                            <div class="panel-body">


                                <?php
                                $salt = 'm0h2014';
                                $token = sha1(mt_rand(1,1000000) . $salt);
                                $_SESSION['token'] = $token;
                                echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
                                $filterby = isset($_GET['filterby']) ? $_GET['filterby'] : 0;
                                //$searchvalue = "";

                                ?>
                                <article class="media">
                                    <section class="panel">
                                        <form id="search" name="search" method="GET" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-inline">
                                            <div class="form-group">
                                                <div class="btn-group">
                                                    <a href="#dialog-form" id="0" class="btn tambah sentBtn btn-send" data-toggle="modal">
                                                        <i class="icon-plus"></i> Tambah Data</a>

                                                </div>
                                                <div class="btn-group">
                                                <select id="filterby" name="filterby" class="form-control">
                                                    <option value="" selected=""></option>

                                                    <option value="5" <?php if($filterby==5){ echo 'selected';} ?> >Semua</option>
                                                    <option value="4" <?php if($filterby==4){ echo 'selected';} ?> >Kod Sumber</option>
                                                    <option value="1" <?php if($filterby==1){ echo 'selected';} ?> >No.KP Baru</option>
                                                    <option value="2" <?php if($filterby==2){ echo 'selected';} ?> >No.Tentera</option>
                                                    <option value="3" <?php if($filterby==3){ echo 'selected';} ?> >Nama</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="searchvalue" id="searchvalue" placeholder="Carian"  class="form-control" value="<?php echo $searchvalue ?>" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" name="btnSearch" id="btnSearch" class="btn btn-primary"><i class="icon-search"> </i> Cari </button>
                                            </div>


                                            <p>*Pilih kriteria dan input carian. Kemudian tekan butang Enter/Return atau butang Cari.</p>

                                        </form>

                                        <div class="media-body">
                                            <!-- start list media-body-->
                                            <div class="adv-table">


                                                <!--------mula table	-->

                                                <table class="display table table-bordered table-striped table-hover" id="example">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 10px">Bil<!--<input type="checkbox" onclick="toggleChecked(this.checked)" id="checkAll" />--> </th>
                                                        <th>Kod Sumber</th>

                                                        <th>Nama Penuh</th>
                                                        <th>No.KP Baru</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php

                                                    if(empty($filterby) && empty($searchvalue)){
                                                        echo "<tr><td></td><td></td><td></td><td></td><td></td></tr>";
                                                    }else if(!empty($filterby)){


                                                   // if(!empty($searchvalue))
                                                    //{
                                                        if($filterby == 1){
                                                            $sql = "SELECT m01_induk.m01_kodsumber, m01_induk.m01_no_tentera AS notentera, 
                                                                m01_induk.m01_kpbaru_anggota as nokpbaru, 
                                                                m01_induk.m01_nama_anggota as namapenuh, 
                                                                c45_pangkat.c45_desc_pangkat as pangkat
                                                            FROM m01_induk LEFT JOIN c45_pangkat ON 
                                                            m01_induk.m01_kod_pangkat = c45_pangkat.c45_kod_pangkat 
                                                            WHERE m01_induk.m01_kpbaru_anggota LIKE '$searchvalue%'";

                                                            $orderby = "ORDER by m01_induk.m01_kpbaru_anggota";

                                                        }

                                                        if($filterby == 2){
                                                            $sql = "SELECT m01_induk.m01_kodsumber, m01_induk.m01_no_tentera as notentera, 
                                                                m01_induk.m01_kpbaru_anggota as nokpbaru, 
                                                                m01_induk.m01_nama_anggota as namapenuh, 
                                                                c45_pangkat.c45_desc_pangkat as pangkat
                                                            FROM m01_induk LEFT JOIN c45_pangkat ON 
                                                            m01_induk.m01_kod_pangkat = c45_pangkat.c45_kod_pangkat 
                                                            WHERE m01_induk.m01_no_tentera LIKE '$searchvalue%'";

                                                            $orderby = " ORDER by m01_induk.m01_no_tentera";

                                                        }

                                                        if($filterby == 3){
                                                            $sql = "SELECT m01_induk.m01_kodsumber, m01_induk.m01_no_tentera as notentera, 
                                                                m01_induk.m01_kpbaru_anggota as nokpbaru, 
                                                                m01_induk.m01_nama_anggota as namapenuh, 
                                                                c45_pangkat.c45_desc_pangkat as pangkat
                                                            FROM m01_induk LEFT JOIN c45_pangkat ON 
                                                            m01_induk.m01_kod_pangkat = c45_pangkat.c45_kod_pangkat 
                                                            WHERE m01_induk.m01_nama_anggota LIKE '$searchvalue%'";

                                                            $orderby = " ORDER by m01_induk.m01_nama_anggota";


                                                        }

                                                        if($filterby == 4){
                                                            $sql = "SELECT m01_induk.m01_kodsumber, m01_induk.m01_no_tentera as notentera, 
                                                                m01_induk.m01_kpbaru_anggota as nokpbaru, 
                                                                m01_induk.m01_nama_anggota as namapenuh, 
                                                                c45_pangkat.c45_desc_pangkat as pangkat
                                                            FROM m01_induk LEFT JOIN c45_pangkat ON 
                                                            m01_induk.m01_kod_pangkat = c45_pangkat.c45_kod_pangkat 
                                                            WHERE m01_induk.m01_kodsumber LIKE '$searchvalue%'";

                                                            $orderby = " ORDER by m01_induk.m01_kodsumber";

                                                        }

                                                        if($filterby == 5){
                                                            $sql = "SELECT m01_induk.m01_kodsumber, m01_induk.m01_no_tentera as notentera, 
                                                                m01_induk.m01_kpbaru_anggota as nokpbaru, 
                                                                m01_induk.m01_nama_anggota as namapenuh, 
                                                                c45_pangkat.c45_desc_pangkat as pangkat
                                                            FROM m01_induk LEFT JOIN c45_pangkat ON 
                                                            m01_induk.m01_kod_pangkat = c45_pangkat.c45_kod_pangkat 
                                                            ";

                                                            $orderby = " ORDER by m01_induk.m01_kodsumber";

                                                        }


                                                        if($_SESSION['groupname']=='AHO'){
                                                            $where .= " AND m01_induk.m01_userid='".$_SESSION['userid']."'";
                                                        }

                                                    //echo $sql.$where.$orderby;
                                                    
                                                    $rows_induk = db_select($sql.$where.$orderby);
//
                                                    if(count($rows_induk) > 0){
                                                        echo '<tr><td colspan="6">';
                                                        echo '<div class="form-group">';
                                                        echo '<span class="text-left">Rekod ditemui: '.count($rows_induk).' rekod.</span><span class="text-info">&nbsp;&nbsp;[ Sila klik pada nama penuh untuk terperinci.]</span></div>';
                                                        echo '</td></tr>';
                                                    }
                                                    ?>

                                                    <?php $i=1; foreach($rows_induk as $row_induk): ?>
                                                    <tr>
                                                        <!--<td><div id="checkboxes"><input type="checkbox" id="cbox" value="<?php echo $row_induk['m01_kodsumber'] ?>" name="addCB[]" class="cb" /></div></td>-->
                                                        <td><?php echo $i ?></td>
                                                        <td><a title="Klik untuk terperinci" href="hr.view.employee.php?kodsumber=<?php echo $row_induk['m01_kodsumber'] ?>&notentera=<?php echo $row_induk['notentera'] ?>&nokpbaru=<?php echo $row_induk['nokpbaru'] ?>"><?php echo $row_induk['m01_kodsumber'] ?></a></td>

                                                        <td><a title="Klik untuk terperinci" href="hr.view.employee.php?kodsumber=<?php echo $row_induk['m01_kodsumber'] ?>&notentera=<?php echo $row_induk['notentera'] ?>&nokpbaru=<?php echo $row_induk['nokpbaru'] ?>"><?php echo $row_induk['namapenuh'] ?></a></td>
                                                        <td><?php echo $row_induk['nokpbaru'] ?></td>
                                                        <td><a class="btn btn-xs btn-info" title="Klik untuk terperinci" href="hr.view.employee.php?kodsumber=<?php echo $row_induk['m01_kodsumber'] ?>&notentera=<?php echo $row_induk['notentera'] ?>&nokpbaru=<?php echo $row_induk['nokpbaru'] ?>"><i class="icon-search"></i> Papar</a>
                                                        <a class="btn btn-xs btn-danger" title="Padam rekod" onclick="jsDelData('<?php echo $row_induk['m01_kodsumber'] ?>')"> <i class="icon-trash"></i> Padam</a>
                                                        </td>

                                                    </tr>
                                                    <?php $i++; endforeach; ?>
                                                    <?php }else{ ?>
                                                        <tr>
                                                            <td></td>

                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    <?php } ?>
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

        /* datepicker */
        window.prettyPrint && prettyPrint();
        $('.default-date-picker').datepicker({
            format: 'dd-mm-yyyy',
            beforeShow: function() {$('#ui-datepicker-div').maxZIndex(); }
        });
        /* datepicker */

        $('#example1').dataTable( {} );

        $('.alert').hide();

        $(document).on("click", ".tambah", function () {
            $('#cmd').val('AddDataPeribadi');
            $("#myModalLabel").html("Tambah Data");

        });



        $('#btnSearch').click(function(){

            //alert($('#filterby').val());

            var filterby = $('#filterby').val();
            //alert(filterby);
            switch(filterby){
                case "":
                    alert('Sila pilih kriteria');
                    $('#filterby').focus();
                    return false;
                break;

                case 1:
                case 2:
                case 3:
                case 4:
                    if($('#searchvalue').val()==""){
                        alert('Sila input carian');
                        $('#searchvalue').focus();
                        return false;
                    }else{
                        startFilter(this.value);
                    }
                break;

                case 5:
                    alert(this.value);
                    startFilter(this.value);
                break;

                
            }

/*

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
            */



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

        function startFilter(searchvalue){

            if($("#filterby").val()==""){
                alert('Sila pilih kriteria terlebih dahulu.');
                $("#filterby").focus();
                return false;
            }else{
                $('#search').submit();
            }
        }


        $('.simpan').click(function(){
            var datastring = $("#form_peribadi").serialize();

           // var time_valid = jsCompareTime( $("#masa_mula").val(),$("masa_tamat").val() )
            //alert(time_valid);

            if($('#kodsumber').val()==''){

                alert('Sila isikan kod sumber');
                $('#kodsumber').focus();
                return false;

            }else{

                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val(),
                    success: function(html)
                    {
                        $("#progress_peribadi").html(html);
                        //alert(html);
                        //location.reload();
                    }
                });
            }

        });



        var url = window.location;

        $('ul.sub a[href="'+ url +'"]').parent().addClass('active');
        $('ul.sub a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');

        $(".btnCancel").click(function(){
           location.reload();
        });
    });

    function jsDelData(id){

        var datastring = 'id='+id;
        if(y = confirm('Anda pasti untuk teruskan?')){
            if(y){
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val()+'&cmd=DelDataPeribadiCascade',
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
/*
    function toggleChecked(status) {
        $("#checkboxes input").each( function() {
            $(this).attr("checked",status);
        });
    }

    function jsEditData(p1,p2,p3,p4,p5,p6,p7){

        $(".modal-body #id").val( p1 );
        $(".modal-body #skim").val( p2 );
        $(".modal-body #siri").val( p3 );
        $(".modal-body #nama_kertas").val( p4 );
        //$(".modal-body #tarikh_dibuka").val( p5 );
        $(".modal-body #tarikh_peperiksaan").val( p5 );
        $(".modal-body #masa_mula").val( p6 );
        $(".modal-body #masa_tamat").val( p7 );
        $('#cmd').val('EditDataKertas');
        $("#myModalLabel").html("Pinda Data");
    }
    function jsDelData(id){

        var datastring = 'id='+id;
        if(y = confirm('Anda pasti untuk teruskan?')){
            if(y){
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val()+'&cmd=DelDataKertas',
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
    function jsVerifyData(id,status){

        var datastring = 'id='+id+'&kertas_status='+status;
        if(y = confirm('Anda pasti untuk teruskan?')){
            if(y){
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val()+'&cmd=VerifyDataKertas',
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
    */
    function jsCompareTime(start_time,end_time){

        //convert both time into timestamp
        var stt = new Date("November 13, 2013 " + start_time);
        stt = stt.getTime();

        var endt = new Date("November 13, 2013 " + end_time);
        endt = endt.getTime();

        //by this you can see time stamp value in console via firebug
        //console.log("Time1: "+ stt + " Time2: " + endt);

        if(stt > endt) {

            $("#masa_mula").after('<span class="error"><br>Start-time must be smaller then End-time.</span>');
            $("#masa_tamat").after('<span class="error"><br>End-time must be bigger then Start-time.</span>');

            return false;
        }else{
            return true;
        }
    }

</script>
</body>
</html>
