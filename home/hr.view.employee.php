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

    <title>Profile</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
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
      <!--popup-->
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

          .biru{
              background-color: blue;
              width: 200px;
          }
          .kuning{
              background-color: #ffff00;
              width: 200px;
          }
          .hijau{
              background-color: #008000;
              width: 200px;
          }
          .oren{
              background-color: orange;
              width: 200px;
          }
          #top_panel{
              position: relative;
          }
          /*print*/
          @media screen {
              #printSection {
                  display: none;
              }
          }

          @media print {
              body * {
                  visibility:hidden;
              }
              #printSection, #printSection * {
                  visibility:visible;
              }
              #printSection {
                  position:absolute;
                  left:0;
                  top:0;
              }
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

      <!-- start modal 1 -->

      <div id="dialog-form-snap" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog table-responsive" >
              <div class="modal-content">

                      <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                          <h4 id="myModalLabel"><i class="icon-camera"> </i>Ambil Gambar </h4>
                      </div>

                      <div class="modal-body row">
                          <!-- content -->
                          <div class="col-md-6">
                              <script type="text/javascript" src="webcam.js"></script>
                              <script language="JavaScript">
                                  document.write( webcam.get_html(240, 250) );
                              </script>

                              <div id="upload_results"></div>
                          </div>
                          <div class="col-md-6">
                              <img id="preview_image"/>
                          </div>
                          <!-- content -->



              </div>
              <div class="modal-footer">

                  <button type="button" class="btn btn-success btnSnap"><i class="icon-camera"></i> Snap</button>
                  <button class="btn btn-danger btnClose" data-dismiss="modal" aria-hidden="true">Tutup</button>
                  <!--<button type="button" class="btn btn-info btnDefaultPhoto"><i class="icon-picture"></i> Set Default</button>-->
              </div>



          </div>
      </div>
      </div>
      <!-- end modal 1 -->
      <!-- start modal 2 -->

      <div id="dialog-form-card" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog table-responsive" >
              <div class="modal-content">

                      <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                          <h4 id="myModalLabel"><i class="icon-credit-card"> </i>Kad Bekas Pesara </h4>
                      </div>

                      <div class="modal-body">
                          <!-- content -->
                          <div id="print_card">
                            <!--<img id="preview_card" src="">-->
                              <span id="preview_card"></span>
                          </div>
                          <!-- content -->
                      </div>
              <div class="modal-footer">

                  <button type="button" class="btn btn-success btnPrint"><i class="icon-print"></i> Cetak</button>
                  <button class="btn btn-danger btnClose" data-dismiss="modal" aria-hidden="true">Tutup</button>

              </div>



          </div>
      </div>
      </div>
      <!-- end modal 2 -->

      <!--main content start-->
      <section id="main-content">
          <?php
          //connDB();
          $salt = 'm0h2014';
          $token = sha1(mt_rand(1,1000000) . $salt);
          $_SESSION['token'] = $token;
          echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
          $userid = $_SESSION['userid'];
          $qry = "SELECT
                    m01_induk.m01_kodsumber as kod_sumber,
                    m01_induk.m01_no_tentera as notentera,
                    m01_induk.m01_kpbaru_anggota as nokpbaru,
                    c45_pangkat.c45_kod_pangkat as kod_pangkat,
                    c45_pangkat.c45_desc_pangkat as pangkat,
                    m01_induk.m01_nama_anggota as namapenuh,
                    m01_induk.m01_gelaran as gelaran,
                    m01_induk.m01_skim as skim,
                    c76_unit.c76_kod_unit as kod_unit,
                    c76_unit.c76_shortform_unit as unit,
                    c65_taraf_khidmat.c65_kod_taraf_khid as kod_tarafkhidmat,
                    c65_taraf_khidmat.c65_desc_taraf_khid as tarafkhidmat,
                    c33_kor.c33_kod_kor as kod_kor,
                    c33_kor.c33_desc_kor as kor,
                    c31_khidmat.c31_kod_khidmat as kod_khidmat,
                    c31_khidmat.c31_desc_khidmat as khidmat,
                    DATE_FORMAT(m01_induk.m01_tkh_tmk,'%d.%m.%Y') as tmk,
                    DATE_FORMAT(m01_induk.m01_tkh_ttp,'%d.%m.%Y') as ttp,
                    m01_induk.m01_kplama as nokplama,
                    DATE_FORMAT(m01_induk.m01_tkh_lahir,'%d.%m.%Y') as tkhlahir,
                    m01_induk.m01_telhp as telhp,
                    m01_induk.m01_telrumah as telrumah,
                    m01_induk.m01_telpejabat as telpej,
                    c13_jantina.c13_kod_jantina as kod_jantina,
                    c13_jantina.c13_desc_jantina as jantina,
                    c30_keturunan.c30_kod_keturunan as kod_keturunan,
                    c30_keturunan.c30_desc_keturunan as keturunan,
                    m01_induk.m01_kod_status_kahwin as kod_tarafkahwin,
                    c60_status_kahwin.c60_desc_status_kahwin as tarafkahwin,
                    c74_ugama.c74_kod_ugama as kod_agama,
                    c74_ugama.c74_desc_ugama as agama,
                    m01_induk.m01_status_khidmat as status_khidmat,
                    m01_induk.m01_emailrasmi as emailrasmi,
                    m01_induk.m01_emailperibadi as emailperibadi,
                    m01_induk.m01_gambar as gambar,
                    m01_induk.m01_kod_jawatan as jawatan,
                    m01_induk.m01_penempatan as penempatan,
                    m01_induk.m01_latarbelakang as latarbelakang,
                    m01_induk.m01_potensi as potensi,
                    m01_induk.m01_keperluan as keperluan,
                    m01_induk.m01_rancangan_hadapan as rancangan_hadapan,
                    m01_induk.m01_hal_lain as hal_lain,
                    m01_induk.m01_pegawai_pengendali as pegawai_pengendali,
                    userprofile.user_name as nama_pegawai_pengendali,
                    c01_status_khidmat.c01_desc_status_khidmat as status_khidmat_tentera
                    FROM
                    m01_induk
                    LEFT JOIN userprofile ON userprofile.user_id = m01_induk.m01_pegawai_pengendali
                    LEFT JOIN c13_jantina ON c13_jantina.c13_kod_jantina = m01_induk.m01_kod_jantina
                    LEFT JOIN c30_keturunan ON c30_keturunan.c30_kod_keturunan = m01_induk.m01_kod_keturunan
                    LEFT JOIN c31_khidmat ON c31_khidmat.c31_kod_khidmat = m01_induk.m01_kod_khidmat
                    LEFT JOIN c33_kor ON c33_kor.c33_kod_kor = m01_induk.m01_kod_kor
                    LEFT JOIN c45_pangkat ON c45_pangkat.c45_kod_pangkat = m01_induk.m01_kod_pangkat
                    LEFT JOIN c65_taraf_khidmat ON c65_taraf_khidmat.c65_kod_taraf_khid = m01_induk.m01_kod_taraf_khidmat
                    LEFT JOIN c60_status_kahwin ON c60_status_kahwin.c60_kod_status_kahwin = m01_induk.m01_kod_status_kahwin
                    LEFT JOIN c74_ugama ON c74_ugama.c74_kod_ugama = m01_induk.m01_kod_agama
                    LEFT JOIN c76_unit ON c76_unit.c76_kod_unit = m01_induk.m01_kod_unit
                    LEFT JOIN c01_status_khidmat ON c01_status_khidmat.c01_kod_status_khidmat = m01_induk.m01_status_khidmat";

                    //WHERE m01_induk.m01_no_tentera = '".$_GET['notentera']."' or m01_induk.m01_kpbaru_anggota='".$_GET["nokpbaru"]."'";

                    if(!empty($_GET['notentera']) && !empty($_GET['nokpbaru'])){
                        $where .=" WHERE m01_induk.m01_no_tentera = '".$_GET['notentera']."' AND m01_induk.m01_kpbaru_anggota = '".$_GET['nokpbaru']."'";

                    }else if(!empty($_GET['nokpbaru'])){
                        $where .=" WHERE m01_induk.m01_kpbaru_anggota = '".$_GET['nokpbaru']."'";

                    }else if(!empty($_GET['notentera'])) {
                        $where .= " WHERE m01_induk.m01_no_tentera = '" . $_GET['notentera'] . "'";

                    }else if(!empty($_GET['kodsumber'])){
                        $where .= " WHERE m01_induk.m01_kodsumber ='" . $_GET['kodsumber']. "'";
                    }

                    if($_SESSION['groupname']=='AHO'){
                        $where .= " AND m01_induk.m01_userid='".$_SESSION['userid']."'";
                    }
          //echo $qry.$where;
                    

          //$rst = mysql_query($qry.$where) or die("Error:".mysql_error());
          $row = db_select($qry.$where);//mysql_fetch_assoc($rst);
          if (count($row) > 0 ) {
              $kod_sumber = $row[0]['kod_sumber'];
              $notentera =$row[0]['notentera'];
              $nokpbaru = $row[0]['nokpbaru'];
              $kod_pangkat = $row[0]['kod_pangkat'];
              $pangkat = $row[0]['pangkat'];
              $namapenuh = $row[0]['namapenuh'];
              $gelaran = $row[0]['gelaran'];
              $skim = $row[0]['skim'];
              $kod_unit = $row[0]['kod_unit'];
              $unit = $row[0]['unit'];
              $kod_tarafkhidmat = $row[0]['kod_tarafkhidmat'];
              $tarafkhidmat = $row[0]['tarafkhidmat'];
              $kod_kor = $row[0]['kod_kor'];
              $kor = $row[0]['kor'];
              $kod_khidmat = $row[0]['kod_khidmat'];
              $khidmat = $row[0]['khidmat'];
              $tmk = $row[0]['tmk'];
              $ttp = $row[0]['ttp'];
              $nokplama = $row[0]['nokplama'];
              $tkhlahir = $row[0]['tkhlahir'];
              $telhp = $row[0]['telhp'];
              $telpej = $row[0]['telpej'];
              $telrumah = $row[0]['telrumah'];
              $kod_jantina = $row[0]['kod_jantina'];
              $jantina = $row[0]['jantina'];
              $kod_keturunan = $row[0]['kod_keturunan'];
              $keturunan = $row[0]['keturunan'];
              $kod_tarafkahwin = $row[0]['kod_tarafkahwin'];
              $tarafkahwin = $row[0]['tarafkahwin'];
              $kod_agama = $row[0]['kod_agama'];
              $agama = $row[0]['agama'];
              $status_khidmat = $row[0]['status_khidmat'];
              $emarilrasmi = $row[0]['emailrasmi'];
              $emailperibadi = $row[0]['emailperibadi'];
              $gambar = $row[0]['gambar'];
              $penempatan = $row[0]['penempatan'];
              $jawatan = $row[0]['jawatan'];
              $status_khidmat_tentera = $row[0]['status_khidmat_tentera'];
              $latarbelakang = $row[0]['latarbelakang'];
              $potensi = $row[0]['potensi'];
              $keperluan = $row[0]['keperluan'];
              $rancangan_hadapan = $row[0]['rancangan_hadapan'];
              $hal_lain = $row[0]['hal_lain'];
              $pegawai_pengendali = $row[0]['pegawai_pengendali'];
              $nama_pegawai_pengendali = $row[0]['nama_pegawai_pengendali'];
          }

          ?>

          <section class="wrapper">
              <!-- page start-->


              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
<!--                              <button type="button" id="btnModePrint" name="btnModePrint" class="btn btn-primary" value="--><?php //echo $_GET['kodsumber'] ?><!--"><i class="icon-print"></i> Mode Cetak</button>-->
<!--                              <a href="#dialog-form-snap" id="btnTakePhoto" class="btn btn-warning" data-toggle="modal">-->
<!--                                  <i class="icon-camera"></i> Ambil Gambar</a>-->
                              <button type="button" id="btnRefresh" name="btnRefresh" class="btn btn-primary"><i class="icon-refresh"></i> Refresh</button>
                          </header>
                      </section>
                  </div>
              </div>

              <div class="row">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel" id="top_panel">

                          <div class="user-heading round">
                              <?php if(isset($row[0]['gambar'])) { ?>
                              <a title="Papar" href="documents/<?php echo $kod_sumber.'/'.$gambar ?>" class="image-popup-vertical-fit btn btn-info btn-xs">
                                      <img id="default_image" src="documents/<?php echo $kod_sumber .'/'. $gambar ?>" alt="">
                                  </a>
                              <?php }else{ ?>
                                  <a href="javascript:void(0)">
                                      <img src="img/unknown.png" alt="">
                                  </a>
                              <?php } ?>

                              <h5><?php echo $namapenuh ?></h5>
                              <input type="hidden" id="kod_sumber" name="kod_sumber" value="<?php echo $kod_sumber?>">
                              <input type="hidden" id="noten" value="<?php echo $notentera?>">
                              <input type="hidden" id="noten_hash" value="<?php echo md5($notentera) ?>">
                              <input type="hidden" id="namapenuh" value="<?php echo $namapenuh ?>">
                          </div>
                          <nav class="site-navigation page-navigation">


                              <ul class="nav nav-pills nav-stacked">
                                  <li><a href="#"> <i class="icon-user"></i>Kod Sumber: <p class="text-primary"><?php echo $kod_sumber?></p></a></li>
                                  <li><a href="#"> <i class="icon-user"></i>No.KP: <p class="text-primary"><?php echo $nokpbaru?></p></a></li>
                                  <li><a href="#"> <i class="icon-mobile-phone"></i> Tel HP: <p class="text-primary"><?php echo $telhp ?></p></a></li>
                                  <li><a href="#"> <i class="icon-envelope"></i> Email: <p class="text-primary"><?php echo $emailperibadi?></p></a></li>
                                  <li><a href="#"> <i class="icon-user-md"></i> AHO:<p class="text-primary"><?php echo $nama_pegawai_pengendali ?></p></a></li>
                              </ul>
                          </nav>


                      </section>
                  </aside>

                  <?php
                  //Waris
                  $sql_waris = "SELECT
                                        w04_pasangan.w04_no_kp_pasangan as nokpbaru,
                                        w04_pasangan.w04_nama_pasangan as namawaris,
                                        w04_pasangan.w04_kod_ugama_pasangan as agama,
                                        w04_pasangan.w04_kod_keturunan_pasangan as keturunan,
                                        w04_pasangan.w04_kod_pertalian as pertalian,
                                        date_format(w04_pasangan.w04_tkh_lahir,'%d.%m.%Y') as tkhlahir,
                                        date_format(w04_pasangan.w04_tkh_kahwin,'%d.%m.%Y') as tkhkahwin,
                                        w04_pasangan.w04_tempat_kahwin as tempatkahwin,
                                        w04_pasangan.w04_pekerjaan as pekerjaan,w04_pasangan.w04_akademik as akademik,
                                        w04_pasangan.w04_hobi as hobi
                                        FROM
                                        w04_pasangan WHERE w04_pasangan.w04_kodsumber ='".$_GET['kodsumber']."'";

                  $rows_waris = db_select($sql_waris);

                  //Anak
                  $sql_anak = "SELECT w01_anak.w01_no_kp_anak as nokpbaru, 
                        w01_anak.w01_nama_anak as namaanak, 
                        date_format(w01_anak.w01_tkh_lahir_anak,'%d.%m.%Y') as tkhlahir, 
                        c13_jantina.c13_kod_jantina as kod_jantina,
                        c13_jantina.c13_desc_jantina as jantina
                    FROM w01_anak LEFT JOIN c13_jantina ON w01_anak.w01_kod_jantina_anak = c13_jantina.c13_kod_jantina
                    WHERE w01_anak.w01_kodsumber = '".$_GET['kodsumber']."'";

                    $rows_anak = db_select($sql_anak);



                  //Dokumen = 2
                  $sql = "SELECT id,filename,filesize,filetype,fileowner
                        FROM documents WHERE  filecategory = 2 AND fileowner = '".$_GET['kodsumber']."' order by entry_date DESC";
                  //$rst = mysql_query($sql) or die('Error:'.mysql_error());
                  $rows_doc = db_select($sql);
//                  while ($row = mysql_fetch_assoc($rst)){
//                      $rows_doc[] = $row;
//                  }
                  //Gambar = 1
                  $sql = "SELECT id,filename,filesize,filetype,fileowner
                        FROM documents WHERE  filecategory = 1 AND fileowner = '".$_GET['kodsumber']."' order by entry_date DESC";
                  //$rst = mysql_query($sql) or die('Error:'.mysql_error());
                  $rows_img = db_select($sql);
//                  while ($row = mysql_fetch_assoc($rst)){
//                      $rows_img[] = $row;
//                  }
                  $sql = "select id,perkara,date_format(tarikh_laporan,'%d.%m.%Y') as tarikh_laporan
                  from pertemuan where kod_sumber='".$_GET['kodsumber']."' order by perkara DESC";
                  $rows_rpt = db_select($sql);
                  ?>
                  <aside class="profile-info col-lg-9">

                      <!-- create tab section -->
                      <section class="panel">
                          <header class="panel-heading tab-bg-dark-navy-blue tab-right ">
                              <ul class="nav nav-tabs pull-right">
                                  <li class="active">
                                      <a data-toggle="tab" href="#A1">
                                          <i class="icon-bookmark-empty"></i>
                                          Butiran Peribadi
                                      </a>
                                  </li>
                                  <li class="">
                                      <a data-toggle="tab" href="#A2">
                                          <i class="icon-heart"></i>
                                          Butiran Waris
                                      </a>
                                  </li>
                                  <li class="">
                                      <a data-toggle="tab" href="#A3">
                                          <i class="icon-picture"></i>
                                          Gambar
                                      </a>
                                  </li>
                                  <li class="">
                                      <a data-toggle="tab" href="#A4">
                                          <i class="icon-file"></i>
                                          Dokumen
                                      </a>
                                  </li>
                                  <li class="">
                                      <a data-toggle="tab" href="#A5">
                                          <i class="icon-file-text-alt"></i>
                                          Laporan Pertemuan
                                      </a>
                                  </li>
                              </ul>
                              <span class="hidden-sm wht-color">Biodata Sumber</span>
                          </header>
                          <div class="panel-body">
                              <div class="tab-content">
                                  <div id="A1" class="tab-pane active">
                                      <!-- start A1 -->
                                      <section class="panel">
                                          <header class="panel-heading">
                                              <i class="icon-bookmark-empty"></i> <a name="bookmark_peribadi"></a>
                                              <span class="text-right" style="float: right"> <a href="javascript:void(0)" class="btn addPeribadi"><i class="icon-pencil"></i> Kemaskini Data</a></span>
                                          </header>
                                          <div class="panel-body bio-graph-info">

                                              <div id="peribadi" class="row">
                                                  <!-- content -->

                                                  <div id="progress_peribadi"></div>
                                                  <div class="panel-body">
                                                      <form id="form_peribadi" name="form_peribadi" class="form-inline" action="process.php" method="post">
                                                      <input type="hidden" id="cmd" name="cmd" value="EditDataPeribadi" />
                                                          <input type="hidden" id="kod_sumber" name="kod_sumber" value="<?php echo $_GET['kodsumber'] ?>">
                                                          <div class="row">
                                                              <div class="col-md-12">
                                                                  <div class="col-md-4">
                                                                      <span><i class="icon-user-md"></i> Pegawai Pengendali (AHO)</span>:
                                                                      <?php db_combo_box("select user_id, user_name from userprofile WHERE user_id <> 'admin'","pegawai_pengendali",$pegawai_pengendali,"user_id","user_name","","--Sila Pilih--","","form-control");?>
                                                                  </div>
                                                              </div>
                                                          </div>

                                                          <div class="row">
                                                          <div class="col-md-12">

                                                              <div class="col-md-4">
                                                                  <span><i class="icon-credit-card"></i> No.KP Baru</span>:
                                                                  <input type="text" class="form-control" id="nokpbaru" name="nokpbaru" value="<?php echo $nokpbaru ?>" data-mask="999999-99-9999" placeholder="000000-00-0000">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-credit-card"></i> No.Tentera </span>:
                                                                  <input type="text" class="form-control" id="notentera" name="notentera" value="<?php echo $notentera ?>">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Pangkat </span>:
                                                                  <?php
                                                                  db_combo_box("select c45_kod_pangkat,c45_desc_pangkat from c45_pangkat where c45_desc_pangkat IS NOT NULL","pkt",$kod_pangkat,"c45_kod_pangkat","c45_desc_pangkat","","Pangkat","","form-control");
                                                                  //echo fnSelect('c45_kod_pangkat','c45_desc_pangkat','c45_pangkat',$kod_pangkat,'pkt','form-control','Pangkat',' WHERE c45_desc_pangkat IS NOT NULL','','') ?>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-4">
                                                                  <span>Nama Penuh </span>:
                                                                  <input type="text" class="form-control" id="namapenuh" name="namapenuh" value="<?php echo $namapenuh ?>" style="text-transform: uppercase">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Nama Gelaran </span>:
                                                                  <input type="text" class="form-control" id="gelaran" name="gelaran" value="<?php echo $gelaran ?>">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Khidmat </span>:
                                                                  <?php
                                                                  db_combo_box("select c31_kod_khidmat,c31_desc_khidmat from c31_khidmat WHERE c31_desc_khidmat IS NOT NULL","khidmat",$kod_khidmat,"c31_kod_khidmat","c31_desc_khidmat","","","","form-control");
                                                                  //echo fnSelect('c31_kod_khidmat','c31_desc_khidmat','c31_khidmat',$kod_khidmat,'khidmat','form-control','Khidmat',' WHERE c31_desc_khidmat IS NOT NULL','','') ?>
                                                              </div>
                                                          </div>
                                                      </div>

                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-4">
                                                                  <span>Perkhidmatan/Kor/Rej </span>:
                                                                  <?php
                                                                  db_combo_box("select c33_kod_kor, c33_desc_kor from c33_kor WHERE c33_desc_kor IS NOT NULL","kor",$kod_kor,"c33_kod_kor","c33_desc_kor","","","","form-control");
                                                                  //echo fnSelect('c33_kod_kor','c33_desc_kor','c33_kor',$kod_kor,'kor','form-control','Kor',' WHERE c33_desc_kor IS NOT NULL','','') ?>
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Pasukan/Jabatan </span>:
                                                                  <?php
                                                                  db_combo_box("select c76_kod_unit, c76_desc_unit from c76_unit WHERE c76_desc_unit IS NOT NULL","unit",$kod_unit,"c76_kod_unit","c76_desc_unit","","","","form-control");
                                                                  //echo fnSelect('c76_kod_unit','c76_desc_unit','c76_unit',$kod_unit,'unit','form-control','Unit',' WHERE c76_desc_unit IS NOT NULL','','') ?>
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Jawatan </span>:
                                                                  <input type="text" class="form-control" id="jawatan" name="jawatan" value="<?php echo $jawatan ?>">
                                                              </div>
                                                          </div>
                                                      </div>

                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-map-marker"></i> Penempatan </span>:
                                                                  <input type="text" class="form-control" id="penempatan" name="penempatan" value="<?php echo $penempatan ?>">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-calendar"></i> TMT </span>:
                                                                  <input type="text" class="form-control default-date-picker" id="tmk" name="tmk" value="<?php echo $tmk ?>">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-calendar"></i> TTP </span>:
                                                                  <input type="text" class="form-control default-date-picker" id="ttp" name="ttp" value="<?php echo $ttp ?>">
                                                              </div>
                                                          </div>
                                                      </div>

                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-mobile-phone"></i> Telefon Pejabat </span>:
                                                                  <input type="text" class="form-control" id="telpej" name="telpej" value="<?php echo $telpej ?>">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-mobile-phone"></i> Telefon Rumah </span>:
                                                                  <input type="text" class="form-control" id="telrumah" name="telrumah" value="<?php echo $telrumah ?>">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-mobile-phone"></i> Telefon Bimbit </span>:
                                                                  <input type="text" class="form-control" id="telhp" name="telhp" value="<?php echo $telhp ?>">
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-credit-card"></i> No.KP Lama </span>:
                                                                  <input type="text" class="form-control" id="nokplama" name="nokplama" value="<?php echo $nokplama ?>">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-calendar"></i> Tarikh Lahir </span>:
                                                                  <input type="text" class="form-control default-date-picker" id="tlahir" name="tlahir" value="<?php echo $tkhlahir ?>">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Jantina </span>:
                                                                  <?php
                                                                  db_combo_box("select c13_kod_jantina, c13_desc_jantina from c13_jantina WHERE c13_desc_jantina IS NOT NULL","jantina",$kod_jantina,"c13_kod_jantina","c13_desc_jantina","","","","form-control");
                                                                  //echo fnComboBox3('c13_kod_jantina','c13_desc_jantina','c13_jantina',$kod_jantina,'jantina','form-control','Jantina',' WHERE c13_desc_jantina IS NOT NULL','','') ?>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-md-12">


                                                              <div class="col-md-4">
                                                                  <span>Bangsa </span>:
                                                                  <?php
                                                                  db_combo_box("select c30_kod_keturunan, c30_desc_keturunan from c30_keturunan WHERE c30_desc_keturunan IS NOT NULL","keturunan",$kod_keturunan,"c30_kod_keturunan","c30_desc_keturunan","","","","form-control");
                                                                  //echo fnSelect('c30_kod_keturunan','c30_desc_keturunan','c30_keturunan',$kod_keturunan,'keturunan','form-control','Bangsa',' WHERE c30_desc_keturunan IS NOT NULL','','') ?>
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Agama </span>:
                                                                  <?php
                                                                  db_combo_box("select c74_kod_ugama, c74_desc_ugama from c74_ugama WHERE c74_desc_ugama IS NOT NULL","agama",$kod_agama,"c74_kod_ugama","c74_desc_ugama","","","","form-control");
                                                                  //echo fnSelect('c74_kod_ugama','c74_desc_ugama','c74_ugama',$kod_agama,'agama','form-control','Agama',' WHERE c74_desc_ugama IS NOT NULL','','') ?>
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Taraf Kahwin </span>:
                                                                  <?php
                                                                  db_combo_box("select c60_kod_status_kahwin, c60_desc_status_kahwin from c60_status_kahwin WHERE c60_desc_status_kahwin IS NOT NULL","tkahwin",$kod_tarafkahwin,"c60_kod_status_kahwin","c60_desc_status_kahwin","","","","form-control");
                                                                  //echo fnSelect('c60_kod_status_kahwin','c60_desc_status_kahwin','c60_status_kahwin',$kod_tarafkahwin,'tkahwin','form-control','Taraf Kahwin',' WHERE c60_desc_status_kahwin IS NOT NULL','','') ?>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-md-12">


                                                              <div class="col-md-4">
                                                                  <span><i class="icon-envelope"></i> Email Rasmi </span>:
                                                                  <input type="text" class="form-control" id="emailrasmi" name="emailrasmi" value="<?php echo $emarilrasmi ?>">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-envelope"></i> Email Peribadi </span>:
                                                                  <input type="text" class="form-control" id="emailperibadi" name="emailperibadi"  value="<?php echo $emailperibadi ?>">
                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Status </span>:
                                                                  <?php
                                                                  db_combo_box("select c01_kod_status_khidmat, c01_desc_status_khidmat from c01_status_khidmat WHERE c01_desc_status_khidmat IS NOT NULL","status_khidmat",$status_khidmat,"c01_kod_status_khidmat","c01_desc_status_khidmat","","","","form-control");
                                                                  //echo fnSelect('c01_kod_status_khidmat','c01_desc_status_khidmat','c01_status_khidmat',$status_khidmat,'status_khidmat','form-control','Status Khidmat','','','') ?>
                                                              </div>
                                                          </div>
                                                      </div>

                                                          <div class="row">
                                                              <div class="col-md-12">
                                                                  <div class="col-md-6">
                                                                      <span><i class="icon-edit"></i> Latarbelakang Perhubungan </span>:
                                                                      <textarea class="form-control" id="latarbelakang" name="latarbelakang" cols="2" rows="2"><?php echo $latarbelakang ?></textarea>
                                                                  </div>
                                                                  <div class="col-md-6">
                                                                      <span><i class="icon-edit"></i> Potensi Sebagai Sumber</span>:
                                                                      <textarea class="form-control" id="potensi" name="potensi" cols="2" rows="2"><?php echo $potensi ?></textarea>
                                                                  </div>
                                                              </div>

                                                          </div>

                                                          <div class="row">
                                                              <div class="col-md-12">
                                                                  <div class="col-md-6">
                                                                      <span><i class="icon-edit"></i> Keperluan/Motivasi </span>:
                                                                      <textarea class="form-control" id="keperluan" name="keperluan" cols="2" rows="2"><?php echo $keperluan ?></textarea>
                                                                  </div>
                                                                  <div class="col-md-6">
                                                                      <span><i class="icon-edit"></i> Rancangan Perhubungan Akan Datang</span>:
                                                                      <textarea class="form-control" id="rancangan_hadapan" name="rancangan_hadapan" cols="2" rows="2"><?php echo $rancangan_hadapan ?></textarea>
                                                                  </div>
                                                              </div>

                                                          </div>

                                                          <div class="row">
                                                              <div class="col-md-12">
                                                                  <div class="col-md-12">
                                                                      <span><i class="icon-edit"></i> Hal-hal Lain </span>:
                                                                      <textarea class="form-control" id="hal_lain" name="hal_lain" cols="2" rows="2"><?php echo $hal_lain ?></textarea>
                                                                  </div>

                                                              </div>

                                                          </div>



                                                  </div>
                                                  <footer class="panel-footer">
                                                      <button id="btnSavePeribadi" type="submit" class="btn-primary btn-sm"><i class="icon-save"></i> Simpan </button>
                                                      <button id="btnClosePeribadi" type="button" class="btn-warning btn-sm"><i class="icon-remove"></i> Tutup </button>
                                                  </footer>

                                                  </form>

                                          </div>
                                              <div class="row">
                                                  <!-- Display Info -->
                                                  <div class="panel-body">

                                                      <div class="row">
                                                          <div class="col-md-12">

                                                              <div class="col-md-4">
                                                                  <span><i class="icon-credit-card"></i> No.KP Baru</span>:
                                                                  <p class="text-primary"><?php echo $nokpbaru ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-credit-card"></i> No.Tentera </span>:
                                                                  <p class="text-primary"><?php echo $notentera ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Pangkat </span>:
                                                                  <p class="text-primary"><?php echo $pangkat ?></p>

                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-4">
                                                                  <span>Nama Penuh </span>:
                                                                  <p class="text-primary"><?php echo $namapenuh ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Nama Gelaran </span>:
                                                                  <p class="text-primary"><?php echo $gelaran ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Khidmat </span>:
                                                                  <p class="text-primary"><?php echo $khidmat ?></p>

                                                              </div>
                                                          </div>
                                                      </div>

                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-4">
                                                                  <span>Perkhidmatan/Kor/Rej </span>:
                                                                  <p class="text-primary"><?php echo $kor ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Pasukan/Jabatan </span>:
                                                                  <p class="text-primary"><?php echo $unit ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Jawatan </span>:
                                                                  <p class="text-primary"><?php echo $jawatan ?></p>

                                                              </div>
                                                          </div>
                                                      </div>

                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-map-marker"></i> Penempatan </span>:
                                                                  <p class="text-primary"><?php echo $penempatan ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-calendar"></i> TMT </span>:
                                                                  <p class="text-primary"><?php echo $tmk ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-calendar"></i> TTP </span>:
                                                                  <p class="text-primary"><?php echo $ttp ?></p>

                                                              </div>
                                                          </div>
                                                      </div>

                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-mobile-phone"></i> Telefon Pejabat </span>:
                                                                  <p class="text-primary"><?php echo $telpej ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-mobile-phone"></i> Telefon Rumah </span>:
                                                                  <p class="text-primary"><?php echo $telrumah ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-mobile-phone"></i> Telefon Bimbit </span>:
                                                                  <p class="text-primary"><?php echo $telhp ?></p>

                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-credit-card"></i> No.KP Lama </span>:
                                                                  <p class="text-primary"><?php echo $nokplama ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-calendar"></i> Tarikh Lahir </span>:
                                                                  <p class="text-primary"><?php echo $tkhlahir ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Jantina </span>:
                                                                  <p class="text-primary"><?php echo $jantina ?></p>

                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-md-12">


                                                              <div class="col-md-4">
                                                                  <span>Bangsa </span>:
                                                                  <p class="text-primary"><?php echo $keturunan ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Agama </span>:
                                                                  <p class="text-primary"><?php echo $agama ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Taraf Kahwin </span>:
                                                                  <p class="text-primary"><?php echo $tarafkahwin ?></p>

                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="row">
                                                          <div class="col-md-12">


                                                              <div class="col-md-4">
                                                                  <span><i class="icon-envelope"></i> Email Rasmi </span>:
                                                                  <p class="text-primary"><?php echo $emarilrasmi ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span><i class="icon-envelope"></i> Email Peribadi </span>:
                                                                  <p class="text-primary"><?php echo $emailperibadi ?></p>

                                                              </div>
                                                              <div class="col-md-4">
                                                                  <span>Status </span>:
                                                                  <p class="text-primary"><?php echo $status_khidmat_tentera ?></p>

                                                              </div>
                                                          </div>
                                                      </div>
                                                      <p></p>
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-6">
                                                                  <span><i class="icon-edit"></i> Latarbelakang Perhubungan </span>:
                                                                  <p class="text-primary"><?php echo $latarbelakang ?></p>
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <span><i class="icon-edit"></i> Potensi Sebagai Sumber</span>:
                                                                  <p class="text-primary"><?php echo $potensi ?></p>
                                                              </div>
                                                          </div>

                                                      </div>
                                                      <p></p>
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-6">
                                                                  <span><i class="icon-edit"></i> Keperluan/Motivasi </span>:
                                                                  <p class="text-primary"><?php echo $keperluan ?></p>
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <span><i class="icon-edit"></i> Rancangan Perhubungan Akan Datang</span>:
                                                                  <p class="text-primary"><?php echo $rancangan_hadapan ?></p>
                                                              </div>
                                                          </div>

                                                      </div>
                                                      <p></p>
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <div class="col-md-12">
                                                                  <span><i class="icon-edit"></i> Hal-hal Lain </span>:
                                                                  <p class="text-primary"><?php echo $hal_lain ?></p>
                                                              </div>

                                                          </div>

                                                      </div>


                                                  </div>
                                                  <!-- end Display Info -->
                                              </div>
                                      </section>

                                      <!-- end A1 -->
                                  </div>

                                  <div id="A2" class="tab-pane">
                                      <!-- start A2 -->
                                      <section class="panel" id="section_waris">
                                          <header class="panel-heading">
                                              <i class="icon-heart"></i>  Isteri/Suami
                                              <span style="float: right"> <a href="javascript:void(0)" class="btn addWaris"><i class="icon-plus"></i> Tambah Data</a></span>
                                          </header>
                                              <div class="panel-body bio-graph-info">
                                              <div id="waris" class="row">
                                                  <form id="form_waris" name="form_waris" class="form-inline" action="process.php" method="post">
                                                      <div id="progress_waris"></div>
                                                      <div class="panel-body">

                                                          <input type="hidden" id="cmd" name="cmd" value="AddDataWaris" />
                                                          <input type="hidden" id="kod_sumber" name="kod_sumber" value="<?php echo $_GET['kodsumber'] ?>" />
                                                          <input type="hidden" id="notentera" name="notentera" value="<?php echo $_GET['notentera'] ?>" />
                                                          <input type="hidden" id="nokpbaruanggota" name="nokpbaruanggota" value="<?php echo $_GET['nokpbaru'] ?>" />

                                                          <div class="row">
                                                              <div class="col-md-12">
                                                                  <div class="col-md-3">
                                                                      <span><i class="icon-credit-card"></i> No.KP Baru </span>:
                                                                      <p class="text-primary"><input type="text" class="form-control" id="nokpbaru" name="nokpbaru" data-mask="999999-99-9999" placeholder="999999-99-9999"></p>

                                                                  </div>
                                                                  <div class="col-md-3">
                                                                      <span><i class="icon-credit-card"></i> Nama Waris </span>:
                                                                      <p class="text-primary"><input type="text" class="form-control" id="nama_pasangan" name="nama_pasangan"></p>

                                                                  </div>
                                                                  <div class="col-md-3">
                                                                      <span><i class="icon-calendar"></i> Tarikh Lahir </span>:
                                                                      <p class="text-primary"><input type="text" class="form-control default-date-picker" id="tkhlahir" name="tkhlahir"></p>

                                                                  </div>
                                                                  <div class="col-md-3">
                                                                      <span><i class="icon-level-down"></i> Keturunan</span>:
                                                                      <p class="text-primary"><?php db_combo_box("select c30_kod_keturunan, c30_desc_keturunan from c30_keturunan WHERE c30_desc_keturunan IS NOT NULL","keturunan","","c30_kod_keturunan","c30_desc_keturunan","","","","form-control"); ?></p>

                                                                  </div>
                                                              </div>
                                                          </div>

                                                          <div class="row">
                                                              <div class="col-md-12">
                                                                  <div class="col-md-4">
                                                                      <span><i class="icon-bell"></i> Agama </span>:
                                                                      <p class="text-primary"><?php db_combo_box("select c74_kod_ugama, c74_desc_ugama from c74_ugama WHERE c74_desc_ugama IS NOT NULL","agama","","c74_kod_ugama","c74_desc_ugama","","","","form-control");?></p>

                                                                  </div>
                                                                  <div class="col-md-4">
                                                                      <span><i class="icon-pinterest-sign"></i> Tempat Kahwin </span>:
                                                                      <p class="text-primary"><input type="text" class="form-control" id="tempatkahwin" name="tempatkahwin"></p>

                                                                  </div>
                                                                  <div class="col-md-4">
                                                                      <span><i class="icon-calendar"></i> Tarikh Kahwin</span>:
                                                                      <p class="text-primary"><input type="text" class="form-control default-date-picker" id="tkhkahwin" name="tkhkahwin"></p>

                                                                  </div>
                                                              </div>
                                                          </div>

                                                          <div class="row">
                                                              <div class="col-md-12">
                                                                  <div class="col-md-3">
                                                                      <span><i class="icon-link"></i> Pertalian </span>:
                                                                      <p class="text-primary"><?php db_combo_box("select c50_kod_pertalian, c50_desc_pertalian from c50_pertalian WHERE c50_desc_pertalian IS NOT NULL","pertalian","","c50_kod_pertalian","c50_desc_pertalian","","","","form-control"); ?></p>

                                                                  </div>
                                                                  <div class="col-md-3">
                                                                      <span><i class="icon-gear"></i> Pekerjaan </span>:
                                                                      <p class="text-primary"><input type="text" class="form-control" id="pekerjaan" name="pekerjaan"></p>

                                                                  </div>
                                                                  <div class="col-md-3">
                                                                      <span><i class="icon-certificate"></i> Kelulusan Akademik</span>:
                                                                      <p class="text-primary"><input type="text" class="form-control" id="akademik" name="akademik"></p>

                                                                  </div>
                                                                  <div class="col-md-3">
                                                                      <span><i class="icon-puzzle-piece"></i> Hoki/Kegemaran</span>:
                                                                      <p class="text-primary"><input type="text" class="form-control" id="hobi" name="hobi"></p>

                                                                  </div>
                                                              </div>
                                                          </div>




                                                      </div>
                                                      <footer class="panel-footer">
                                                          <button id="btnSaveWaris" type="submit" class="btn-primary btn-sm"><i class="icon-save"></i> Simpan </button>
                                                          <button id="btnCloseWaris" type="button" class="btn-warning btn-sm"><i class="icon-remove"></i> Tutup </button>
                                                      </footer>
                                                  </form>
                                              </div>
                                                  <!-- waris -->
                                              <div class="row">
                                                  <div class="panel-body">
                                                      <table class="table table-striped table-bordered">
                                                          <thead>
                                                          <tr>
                                                              <th>No.KP</th>
                                                              <th>Nama</th>
                                                              <th>Tarikh Lahir</th>
                                                              <th>Tarikh Kahwin</th>
                                                              <th></th>
                                                          </tr>
                                                          </thead>
                                                          <tbody>
                                                          <?php foreach($rows_waris as $waris): ?>
                                                              <tr>
                                                                  <td><?php echo $waris['nokpbaru'] ?></td>
                                                                  <td><?php echo $waris['namawaris'] ?></td>
                                                                  <td><?php echo $waris['tkhlahir'] ?></td>
                                                                  <td><?php echo $waris['tkhkahwin'] ?></td>
                                                                  <td>
                                                                      <a title="Kemaskini" href="javascript:void(0)" class="btn btn-info btn-xs" onclick="jsUpdateWaris('EditDataWaris','<?php echo $waris['nokpbaru']  ?>','<?php echo addslashes($waris['namawaris'])?>','<?php echo $waris['agama']?>','<?php echo $waris['keturunan']?>','<?php echo $waris['pertalian']?>','<?php echo $waris['tkhlahir']?>','<?php echo $waris['tkhkahwin']?>','<?php echo addslashes($waris['tempatkahwin']) ?>','<?php echo $waris['pekerjaan'] ?>','<?php echo $waris['akademik'] ?>','<?php echo $waris['hobi'] ?>')"><i class="icon-edit"></i> </a>
                                                                      <a title="Padam" href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="jsDelDataRecord('w04_pasangan','w04_no_kp_pasangan','<?php echo $waris['nokpbaru'] ?>','','')"><i class="icon-remove-circle"></i> </a>

                                                                  </td>
                                                              </tr>
                                                          <?php endforeach; ?>

                                                          </tbody>
                                                      </table>
                                                  </div>
                                              </div>

                                                  <header class="panel-heading">
                                                      <i class="icon-heart"></i> Anak
                                                      <span style="float: right"> <a href="javascript:void(0)" class="btn addAnak"><i class="icon-plus"></i> Tambah Data</a></span>
                                                  </header>
                                                  <div class="panel-body bio-graph-info">
                                                      <div id="anak" class="row">
                                                          <form id="form_anak" name="form_anak" class="form-inline" action="process.php" method="post">
                                                              <div id="progress_anak"></div>
                                                              <div class="panel-body">

                                                                  <input type="hidden" id="cmd" name="cmd" value="AddDataAnak" />
                                                                  <input type="hidden" id="kod_sumber" name="kod_sumber" value="<?php echo $_GET['kodsumber'] ?>" />
                                                                  <input type="hidden" id="notentera" name="notentera" value="<?php echo $_GET['notentera'] ?>" />
                                                                  <input type="hidden" id="nokpbaruanggota" name="nokpbaruanggota" value="<?php echo $_GET['nokpbaru'] ?>" />


                                                                  <div class="row">
                                                                      <div class="col-md-12">
                                                                          <div class="col-md-3">
                                                                              <span><i class="icon-credit-card"></i> No.KP Baru </span>:
                                                                              <p class="text-primary"><input type="text" class="form-control" id="nokpbaru" name="nokpbaru" data-mask="999999-99-9999" placeholder="999999-99-9999"></p>

                                                                          </div>
                                                                          <div class="col-md-3">
                                                                              <span><i class="icon-credit-card"></i> Nama Anak </span>:
                                                                              <p class="text-primary"><input type="text" class="form-control" id="nama_anak" name="nama_anak"></p>

                                                                          </div>
                                                                          <div class="col-md-3">
                                                                              <span><i class="icon-calendar"></i> Tarikh Lahir </span>:
                                                                              <p class="text-primary"><input type="text" class="form-control default-date-picker" id="tkhlahir" name="tkhlahir"></p>

                                                                          </div>
                                                                          <div class="col-md-3">
                                                                              <span><i class="icon-level-down"></i> Jantina</span>:
                                                                              <p class="text-primary"><?php db_combo_box("select c13_kod_jantina, c13_desc_jantina from c13_jantina WHERE c13_desc_jantina IS NOT NULL","jantina","","c13_kod_jantina","c13_desc_jantina","","","","form-control"); ?></p>

                                                                          </div>
                                                                      </div>
                                                                  </div>

                                                              </div>
                                                              <footer class="panel-footer">
                                                                  <button id="btnSaveAnak" type="submit" class="btn-primary btn-sm"><i class="icon-save"></i> Simpan </button>
                                                                  <button id="btnCloseAnak" type="button" class="btn-warning btn-sm"><i class="icon-remove"></i> Tutup </button>
                                                              </footer>
                                                          </form>
                                                      </div>
                                                  </div>

                                                  <!-- anak -->
                                                  <div class="row">
                                                      <div class="panel-body">
                                                          <table class="table table-striped table-bordered">
                                                              <thead>
                                                              <tr>
                                                                  <th>No.KP</th>
                                                                  <th>Nama</th>
                                                                  <th>Tarikh Lahir</th>
                                                                  <th>Jantina</th>
                                                                  <th></th>
                                                              </tr>
                                                              </thead>
                                                              <tbody>
                                                              <?php foreach($rows_anak as $anak): ?>
                                                                  <tr>
                                                                      <td><?php echo $anak['nokpbaru'] ?></td>
                                                                      <td><?php echo $anak['namaanak'] ?></td>
                                                                      <td><?php echo $anak['tkhlahir'] ?></td>
                                                                      <td><?php echo $anak['jantina'] ?></td>
                                                                      <td>
                                                                          <a title="Kemaskini" href="javascript:void(0)" class="btn btn-info btn-xs" onclick="jsUpdateAnak('EditDataAnak','<?php echo $anak['nokpbaru']  ?>','<?php echo addslashes($anak['namaanak'])?>','<?php echo $anak['tkhlahir']?>','<?php echo $anak['kod_jantina']?>')"><i class="icon-edit"></i> </a>
                                                                          <a title="Padam" href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="jsDelDataRecord('w01_anak','w01_no_kp_anak','<?php echo $anak['nokpbaru'] ?>','','')"><i class="icon-remove-circle"></i> </a>

                                                                      </td>
                                                                  </tr>
                                                              <?php endforeach; ?>

                                                              </tbody>
                                                          </table>
                                                      </div>
                                                  </div>


                                          </div>
                                      </section>
                                      <!-- end A2 -->
                                  </div>

                                  <div id="A3" class="tab-pane">
                                      <!-- start A3 -->
                                      <header class="panel-heading">
                                      <i class="icon-picture"></i>
                                      <span style="float: right"> <a href="hr.upload.doc.php?kodsumber=<?php echo $_GET['kodsumber'] ?>&notentera=<?php echo $_GET['notentera'] ?>&nokpbaru=<?php echo $_GET["nokpbaru"] ?>&filecategory=1" class="btn addDoc"><i class="icon-plus"></i> Upload Gambar</a></span>
                                      </header>
                                          <div class="panel-body">
                                          <table class="table table-striped table-bordered">
                                              <thead>
                                              <tr>
                                                  <th>Nama Fail</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <?php foreach($rows_img as $img): ?>
                                                  <tr>
                                                      <td>
                                                          <?php echo $img['filename'] ?><a title="Papar" href="documents/<?php echo $_GET['kodsumber'].'/'.$img['filename'] ?>" class="image-popup-vertical-fit btn btn-info btn-xs" style="float: right;"><i class="icon-picture"></i> </a>
                                                          <a title="Padam" href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="jsDelDataRecord('documents','id','<?php echo $img['id'] ?>','<?php echo $img['filename'] ?>')" style="float: right;"><i class="icon-remove-circle"></i> </a>
                                                          <a title="Set Gambar Profil" href="javascript:void(0)" class="btn btn-primary btn-xs" onclick="jsImageDefault('<?php echo $img['filename'] ?>','<?php echo $_GET['kodsumber'] ?>')" style="float: right;"><i class="icon-ok"></i> </a>
                                                      </td>

                                                  </tr>
                                              <?php endforeach; ?>
                                              </tbody>
                                          </table>
                                      </div>
                                      <!-- end A3 -->
                                  </div>
                                  <div id="A4" class="tab-pane">
                                      <!-- start A4 -->
                                      <header class="panel-heading">
                                      <i class="icon-file"></i>
                                      <span style="float: right"> <a href="hr.upload.doc.php?kodsumber=<?php echo $_GET['kodsumber'] ?>&notentera=<?php echo $_GET['notentera'] ?>&nokpbaru=<?php echo $_GET["nokpbaru"] ?>&filecategory=2" class="btn addDoc"><i class="icon-plus"></i> Upload Dokumen</a></span>
                                      </header>
                                          <div class="panel-body">
                                          <table class="table table-striped table-bordered">
                                              <thead>
                                              <tr>
                                                  <th>Nama Fail</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <?php foreach($rows_doc as $doc): ?>
                                                  <tr>
                                                      <td>
                                                          <?php echo $doc['filename'] ?>
                                                          <a title="Papar" class="iframe-popup btn btn-info btn-xs" href="documents/<?php echo $_GET['kodsumber'].'/'.$doc['filename'] ?>" style="float: right;"><i class="icon-file"></i> </a>
                                                          <a title="Padam" href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="jsDelDataRecord('documents','id','<?php echo $doc['id'] ?>','<?php echo $doc['filename'] ?>','<?php echo $_GET['notentera'] ?>')" style="float: right;"><i class="icon-remove-circle"></i> </a>
                                                      </td>

                                                  </tr>
                                              <?php endforeach; ?>
                                              </tbody>
                                          </table>
                                      </div>
                                      <!-- end A4 -->
                                  </div>
                                  <div id="A5" class="tab-pane">
                                      <!-- start A5 -->
                                      <header class="panel-heading">
                                          <i class="icon-file-text-alt"></i>
                                          <span style="float: right"> <a href="hr.register.report.php?kodsumber=<?php echo $_GET['kodsumber'] ?>&notentera=<?php echo $_GET['notentera'] ?>&nokpbaru=<?php echo $_GET["nokpbaru"] ?>" class="btn addRpt"><i class="icon-plus"></i> Daftar Laporan</a></span>
                                      </header>
                                      <div class="panel-body">
                                          <table class="table table-striped table-bordered">
                                              <thead>
                                              <tr>
                                                  <th>Perkara</th>
                                                  <th>Bertarikh</th>
                                                  <th></th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <?php foreach($rows_rpt as $row): ?>
                                                  <tr>
                                                      <td><a href="hr.view.report.php?kodsumber=<?php echo $_GET['kodsumber'] ?>&notentera=<?php echo $_GET['notentera'] ?>&nokpbaru=<?php echo $_GET['nokpbaru'] ?>&id=<?php echo $row['id'] ?>">
                                                          <?php echo strtoupper($row['perkara']) ?>
                                                          </a>
                                                      </td>
                                                      <td><?php echo $row['tarikh_laporan'] ?></td>
                                                      <td>
                                                          <a title = "Papar" class="btn btn-primary btn-xs" href="hr.view.report.php?kodsumber=<?php echo $_GET['kodsumber'] ?>&notentera=<?php echo $_GET['notentera'] ?>&nokpbaru=<?php echo $_GET['nokpbaru'] ?>&id=<?php echo $row['id'] ?>">
                                                              <i class="icon-file-text"></i>
                                                          </a>
                                                          <a title="Padam" href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="jsDelDataRecord('pertemuan','id','<?php echo $row['id'] ?>','','<?php echo $_GET['kodsumber'] ?>')"><i class="icon-remove-circle"></i> </a>
                                                      </td>

                                                  </tr>
                                              <?php endforeach; ?>
                                              </tbody>
                                          </table>
                                      </div>
                                      <!-- end A5 -->
                                  </div>
                              </div>
                          </div>
                      </section>

                  </aside>
              </div>

              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
      <?php include_once("footer.php")?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="js/respond.min.js" ></script>
    <script src="js/jquery.form.js" type="text/javascript"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
  <!--notification script-->
  <script src="js/notifications.js"></script>

  <!-- upload multiple -->
  <script src="assets/uploadmulti/jquery.fileuploadmulti.js"></script>

  <!-- popup -->
  <script src="assets/tiles/js/jquery.magnific-popup.min.js"></script>

  <!--input mask-->
  <script src="js/inputmask.js" type="text/javascript"></script>

  <!--date picker -->
  <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

  <!--combined scroll-->
  <script type="text/javascript" src="assets/combinedscroll/jquery.combinedScroll.js"></script>

  <script type="text/javascript">
  $(document).ready(function(){

      $('.btnClose').click(function(){
         location.reload();
      });

      //Verify Print Data Card
//      $('#btnVerifyCard').click(function(){
//          //alert($('#noten').val());
//          var confirmation = confirm('Anda pasti untuk mengesahkan cetakkan kad pesara bagi '+$('#noten').val()+'\n'+$('#namapenuh').val());
//          if(confirmation){
//              $.post("process.php",{
//                      id : $('#noten').val(),
//                      cmd:'VerifyPrintCard',
//                      type: "results"},
//                  function(data){
//                      alert(data);
//                      location.reload();
//                  });
//          }else{
//              return false;
//          }
//      });

      $('.btnDefaultPhoto').click(function(){
          var name = $('#preview_image').attr('src');
          //alert(name);
          if(typeof(name)=='undefined' || typeof(name)=='') {
              alert('Sila aktifkan kamera dan snap terlebih dahulu.');
              return false;
          }else{
              var fileNameIndex = name.lastIndexOf("/") + 1;
              var filename = name.substr(fileNameIndex);
              var fileowner =   $('#form_peribadi #kod_sumber').val();
              //alert(filename + fileowner);
              jsImageDefault(filename,fileowner);
              //alert(filename + $('#noten').val());
          }
      });


      function fileExists(url) {
          if(url){
              var req = new XMLHttpRequest();
              req.open('GET', url, false);
              req.send();
              return req.status==200;
          } else {
              return false;
          }
      }

      function ImageExist(url)
      {
          var img = new Image();
          img.src = url;
          return img.height != 0;
      }

      $('#btnRefresh').click(function(){
         location.reload();
      });
      //========= camera snap shot ===========
      $('.btnSnap').click(function(){
          take_snapshot();
      });
      $('.btnClose').click(function(){
          document.getElementById('preview_image').src = "";
      });

      function take_snapshot(){
          webcam.set_api_url( 'process_snap.php?kodsumber='+$('#form_peribadi #kod_sumber').val() );
          webcam.set_quality( 90 ); // JPEG quality (1 - 100)
          webcam.set_shutter_sound( true ); // play shutter click sound
          webcam.set_hook( 'onComplete', my_completion_handler);
          // take snapshot and upload to server
          document.getElementById('upload_results').innerHTML = '<h4>Uploading...</h4>';
          webcam.snap();
      }

      function my_completion_handler(msg) {
          //alert(msg);
          // extract URL out of PHP output
          if (msg.match(/(http\:\/\/\S+)/)) {
              // show JPEG image in page
              document.getElementById('upload_results').innerHTML ='<h4>Upload Successful!</h4>';

              // reset camera for another shot
              webcam.reset();
              document.getElementById('upload_results').innerHTML = "";
              document.getElementById('preview_image').src = msg;
          }
          else {alert("PHP Error: " + msg);
          }
      }
      //========= camera snap shot ===========



      $('#btnModePrint').click(function(){
         location.href='hr.print.employee.php?kodsumber='+$(this).val();
      });
      $('.page-navigation').onePageNav();
      //knob
      $(".knob").knob();

      //magnific image popup
      $('.image-popup-vertical-fit').magnificPopup({
          type: 'image',
          closeOnContentClick: true,
          mainClass: 'mfp-img-mobile',
          image: {
              verticalFit: true
          }
      });
      //magnific file popup
      $('.iframe-popup').magnificPopup({
          disableOn: 700,
          type: 'iframe',
          mainClass: 'mfp-fade',
          removalDelay: 160,
          preloader: false,
          fixedContentPos: false
      });
      //peribadi
      $('#peribadi').hide();
      $('.addPeribadi').click(function(){
          if(!$('#peribadi').show()){
              $('#peribadi').toggle('slow');
          }
      });
      $('#btnClosePeribadi').click(function(){
          $('#peribadi').slideUp('slow');
      });
      //waris
      $('#waris').hide();
      $('.addWaris').click(function(){
          if(!$('#waris').show()){
              $('#waris').toggle('slow');
          }
      });
      $('#btnCloseWaris').click(function(){
          $('#waris').slideUp('slow');
      });

      //
      $('#anak').hide();
      $('.addAnak').click(function(){
          if(!$('#anak').show()){
              $('#anak').toggle('slow');
          }
      });
      $('#btnCloseAnak').click(function(){
          $('#anak').slideUp('slow');
      });



      /* datepicker */
      window.prettyPrint && prettyPrint();
      $('.default-date-picker').datepicker({
          format: 'dd-mm-yyyy'
      });
      //peribadi
      $('#form_peribadi').on('submit', function(e){

          var y = confirm('Anda pasti untuk teruskan?');
          if(y){
              e.preventDefault();
              $("#progress_peribadi").html('<img src="img/loading.gif" />');
              $(this).ajaxSubmit({
                  target: '#progress_peribadi',
                  success: function(response){
                      alert(response);
                      $("#progress_peribadi").html('').hide();
                      location.reload();
                  }
              });
          }else{
              return false;
          }
      });
      //waris
      $('#form_waris').on('submit', function(e){
          if($('#form_waris #nokpbaru').is(':disabled')){
              $("#form_waris #nokpbaru").removeAttr("disabled");
          }
          var y = confirm('Anda pasti untuk teruskan?');
          if(y){
              e.preventDefault();
              $("#progress_waris").html('<img src="img/loading.gif" />');
              $(this).ajaxSubmit({
                  target: '#progress_waris',
                  success: function(response){
                      alert(response);
                      $("#progress_waris").html('').hide();
                      location.reload();
                  }
              });
          }else{
              return false;
          }
      });
      //anak
      $('#form_anak').on('submit', function(e){
          if($('#form_anak #nokpbaru').is(':disabled')){
              $("#form_anak #nokpbaru").removeAttr("disabled");
          }
          var y = confirm('Anda pasti untuk teruskan?');
          if(y){
              e.preventDefault();
              $("#progress_anak").html('<img src="img/loading.gif" />');
              $(this).ajaxSubmit({
                  target: '#progress_anak',
                  success: function(response){
                      alert(response);
                      $("#progress_anak").html('').hide();
                      location.reload();
                  }
              });
          }else{
              return false;
          }
      });


      //url
      $('.nav-stacked li a').click(function(e) {
          var $this = $(this);
          if (!$this.hasClass('active')) {
              $this.addClass('active');

          }
          e.preventDefault();
      });

      //print
      $('.btnPrint').click(function(){
         var confirm_print = confirm('Anda pasti untuk cetak?');
          if(confirm_print){
              printElement(document.getElementById("print_card"));
              $("#sidebar").hide();
              loadPrint();
          }else{
              return false;
          }
      });

  });
      function jsImageDefault(filename,fileowner){
          //alert(filename + fileowner);
          //return false;
          if(confirm("Set gambar profile! Anda pasti untuk teruskan?")){
              $.post("process.php",{
                      filename : filename,
                      fileowner : fileowner,
                      cmd:'SetImageDefault',
                      type: "results"},
                  function(data){
                      alert(data);
                      location.reload();
                  });
          }else{
              return false;
          }
      }

      function jsDelDataRecord(tablename,fieldwhere,id,filename,fileowner){
          if(confirm("Anda pasti untuk teruskan?")){
              $.post("process.php",{
                      tablename : tablename,
                      fieldwhere : fieldwhere,
                      filename : filename,
                      fileowner : fileowner,
                      id : id,
                      cmd:'DelDataRecord',
                      type: "results"},
                  function(data){
                      alert(data);
                      location.reload();
                  });
          }else{
              return false;
          }

      }
      function jsUpdatePeribadi(cmd,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19,p20,p21,p22,p23){
          if(!$('#peribadi').show()){
              $('#peribadi').toggle('slow');
          }
          $('#form_waris #notentera').attr("disabled", "disabled");
          $("#form_waris #cmd").val(cmd);
          $("#form_waris #notentera").val(p1);
          $("#form_waris #nokpbaru").val(p2);
          $("#form_waris #namapenuh").val(p3);
          $("#form_waris #agama").val(p4);
          $("#form_waris #keturunan").val(p5);
          $("#form_waris #pertalian").val(p6);
          $("#form_waris #tkhlahir").val(p7);
          $("#form_waris #tkhkahwin").val(p8);
          $("#form_waris #tempatkahwin").val(p9);
      }
      function jsUpdateWaris(cmd,param1,param2,param3,param4,param5,param6,param7,param8,param9,param10,param11){
          if(!$('#waris').show()){
              $('#waris').toggle('slow');
          }
          $('#form_waris #nokpbaru').attr("disabled", "disabled");
          $("#form_waris #cmd").val(cmd);
          $("#form_waris #nokpbaru").val(param1);
          $("#form_waris #nama_pasangan").val(param2);
          $("#form_waris #agama").val(param3);
          $("#form_waris #keturunan").val(param4);
          $("#form_waris #pertalian").val(param5);
          $("#form_waris #tkhlahir").val(param6);
          $("#form_waris #tkhkahwin").val(param7);
          $("#form_waris #tempatkahwin").val(param8);
          $("#form_waris #pekerjaan").val(param9);
          $("#form_waris #akademik").val(param10);
          $("#form_waris #hobi").val(param11);
      }
      function jsUpdateAnak(cmd,param1,param2,param3,param4,param5,param6,param7){

          if(!$('#anak').show()){
              $('#anak').toggle('slow');
          }
          $('#form_anak #nokpbaru').attr("disabled", "disabled");
          $("#form_anak #cmd").val(cmd);
          $("#form_anak #nokpbaru").val(param1);
          $("#form_anak #nama_anak").val(param2);
          //$("#form_anak #sijillahir").val(param3);
          $("#form_anak #tkhlahir").val(param3);
          //$("#form_anak #tempatlahir").val(param5);
          $("#form_anak #jantina").val(param4);
          //$("#form_anak #pertalian").val(param7);
      }
      function jsUpdatePangkat(cmd,param1,param2,param3,param4,param5){
          if(!$('#pangkat').show()){
              $('#pangkat').toggle('slow');
          }
          $("#form_pangkat #cmd").val(cmd);
          $("#form_pangkat #id").val(param1);
          $("#form_pangkat #pangkat").val(param2);
          $("#form_pangkat #pangkat_kelas").val(param3);
          $("#form_pangkat #mula").val(param4);
          $("#form_pangkat #okeransi").val(param5);
      }
      function jsUpdateKursus(cmd,param1,param2,param3,param4,param5,param6){
          if(!$('#kursus').show()){
              $('#kursus').toggle('slow');
          }
          $("#form_kursus #cmd").val(cmd);
          $("#form_kursus #id").val(param1);
          $("#form_kursus #kursus").val(param2);
          $("#form_kursus #mula").val(param3);
          $("#form_kursus #tamat").val(param4);
          $("#form_kursus #tempat").val(param5);
          $("#form_kursus #keputusan").val(param6);
      }
      function jsUpdateMisi(cmd,param1,param2,param3,param4,param5,param6){
          if(!$('#misi').show()){
              $('#misi').toggle('slow');
          }
          $("#form_misi #cmd").val(cmd);
          $("#form_misi #id").val(param1);
          $("#form_misi #misi").val(param2);
          $("#form_misi #mula").val(param3);
          $("#form_misi #tamat").val(param4);
          $("#form_misi #tempat").val(param5);
          $("#form_misi #negara").val(param6);
      }
      function jsUpdateDKT(cmd,param1,param2,param3,param4){
          if(!$('#dkt').show()){
              $('#dkt').toggle('slow');
          }
          $("#form_dkt #cmd").val(cmd);
          $("#form_dkt #id").val(param1);
          $("#form_dkt #dkt").val(param2);
          $("#form_dkt #mula").val(param3);
          $("#form_dkt #okeransi").val(param4);
      }
      function jsUpdateBMI(cmd,param1,param2,param3,param4,param5){
          if(!$('#bmi').show()){
              $('#bmi').toggle('slow');
          }
          $("#form_bmi #cmd").val(cmd);
          $("#form_bmi #id").val(param1);
          $("#form_bmi #berat").val(param2);
          $("#form_bmi #tinggi").val(param3);
          $("#form_bmi #mula").val(param4);
          $("#form_bmi #okeransi").val(param5);
      }
      function loadPrint() {
          window.print();
          setTimeout(function () { window.close(); }, 100);
          $("#sidebar").show();
      }
      function printElement(elem, append, delimiter) {
          var domClone = elem.cloneNode(true);

          var $printSection = document.getElementById("printSection");

          if (!$printSection) {
              var $printSection = document.createElement("div");
              $printSection.id = "printSection";
              document.body.appendChild($printSection);
          }

          if (append !== true) {
              $printSection.innerHTML = "";
          }

          else if (append === true) {
              if (typeof(delimiter) === "string") {
                  $printSection.innerHTML += delimiter;
              }
              else if (typeof(delimiter) === "object") {
                  $printSection.appendChlid(delimiter);
              }
          }

          $printSection.appendChild(domClone);
      }


  </script>


  </body>
</html>
