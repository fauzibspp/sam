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
      <!--main content start-->
      <section id="main-content">
          <?php
          connDB();
          $salt = 'm0h2014';
          $token = sha1(mt_rand(1,1000000) . $salt);
          $_SESSION['token'] = $token;
          echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
          $userid = $_SESSION['userid'];
          $qry = "SELECT
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
                    c13_jantina.c13_kod_jantina as kod_jantina,
                    c13_jantina.c13_desc_jantina as jantina,
                    c30_keturunan.c30_kod_keturunan as kod_keturunan,
                    c30_keturunan.c30_desc_keturunan as keturunan,
                    c60_status_kahwin.c60_kod_status_kahwin as kod_tarafkahwin,
                    c60_status_kahwin.c60_desc_status_kahwin as tarafkahwin,
                    c74_ugama.c74_kod_ugama as kod_agama,
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
          $rst = mysql_query($qry) or die("Error:".mysql_error());
          $row = mysql_fetch_assoc($rst);
          ?>

          <section class="wrapper">
              <!-- page start-->


              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <button type="button" id="btnBack" name="btnBack" class="btn btn-info" value="<?php echo $_GET['notentera'] ?>"><i class="icon-backward"></i> Kembali</button>
                              <button style="float: right" type="button" id="btnPrint" name="btnPrint" class="btn btn-primary"><i class="icon-print"></i> Cetak</button>
                          </header>
                      </section>
                  </div>
              </div>

              <div class="row" id="printThis">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel" id="top_panel">

                          <div class="user-heading round">
                              <?php if(isset($row['gambar'])) { ?>
                                  <a href="javascript:void(0)">
                                      <img src="documents/<?php echo $row['notentera'] .'/'. $row['gambar'] ?>" alt="">
                                  </a>
                              <?php }else{ ?>
                                  <a href="javascript:void(0)">
                                      <img src="img/unknown.png" alt="">
                                  </a>
                              <?php } ?>
                              <h1><?php echo  $row['notentera'] ?></h1>
                              <h5><?php echo  $row['pangkat'] ?></h5>
                              <h5><?php echo $row['namapenuh'] ?></h5>
                          </div>
                          <nav class="site-navigation page-navigation">
                              <ul class="nav nav-pills nav-stacked">
                                  <li><a href="#section_peribadi"> <i class="icon-user"></i> Butir Peribadi</a></li>
                                  <li><a href="#section_waris"> <i class="icon-heart"></i> Waris</a></li>
                                  <li><a href="#section_gambar"> <i class="icon-picture"></i> Gambar</a></li>
                                  <li><a href="#section_dokumen"> <i class="icon-file"></i> Dokumen</a></li>

                              </ul>
                          </nav>


                      </section>
                  </aside>

                  <aside class="profile-info col-lg-9">

                      <section class="panel">
                          <header class="panel-heading">
                              <i class="icon-bookmark-empty"></i> <a name="bookmark_peribadi"> Perkhidmatan</a>

                          </header>
                          <div class="panel-body bio-graph-info">

                              <div id="peribadi" class="row">
                                  <form id="form_peribadi" name="form_peribadi" class="form-inline" action="process.php" method="post">
                                      <div id="progress_peribadi"></div>
                                      <div class="panel-body">

                                          <input type="hidden" id="cmd" name="cmd" value="EditDataPeribadi" />

                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span>No.Tentera </span>:
                                                  <input type="text" class="form-control" id="notentera" name="notentera" value="<?php echo $row['notentera'] ?>" required="required">
                                              </div>
                                          </div>

                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span>No.KP Baru </span>:
                                                  <input type="text" class="form-control" id="nokpbaru" name="nokpbaru" value="<?php echo $row['nokpbaru'] ?>" required="required">
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span>Pangkat </span>:
                                                  <?php echo fnSelect('c45_kod_pangkat','c45_desc_pangkat','c45_pangkat',$row['kod_pangkat'],'pkt','form-control','Pangkat',' WHERE c45_desc_pangkat IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Nama Penuh </span>:
                                                  <input type="text" class="form-control" id="namapenuh" name="namapenuh" value="<?php echo $row['namapenuh'] ?>" required="required">
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Gelaran </span>:
                                                  <input type="text" class="form-control" id="gelaran" name="gelaran" value="<?php echo $row['gelaran'] ?>" required="required">
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Skim </span>:
                                                  <select id="skim" name="skim" class="form-control">
                                                      <option value="" selected="">--PILIH--</option>
                                                      <option value="PEG" <?php if($row['skim']=='PEG') echo 'selected'; ?>>Pegawai</option>
                                                      <option value="LLP" <?php if($row['skim']=='LLP') echo 'selected'; ?>>Lain-Lain Pangat</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Unit </span>:
                                                  <?php echo fnSelect('c76_kod_unit','c76_desc_unit','c76_unit',$row['kod_unit'],'unit','form-control','Unit',' WHERE c76_desc_unit IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Taraf Khidmat </span>:
                                                  <?php echo fnSelect('c65_kod_taraf_khid','c65_desc_taraf_khid','c65_taraf_khidmat',$row['kod_tarafkhidmat'],'tkhidmat','form-control','Taraf Khidmat',' WHERE c65_desc_taraf_khid IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Kor </span>:
                                                  <?php echo fnSelect('c33_kod_kor','c33_desc_kor','c33_kor',$row['kod_kor'],'kor','form-control','Kor',' WHERE c33_desc_kor IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Khidmat </span>:
                                                  <?php echo fnSelect('c31_kod_khidmat','c31_desc_khidmat','c31_khidmat',$row['kod_khidmat'],'khidmat','form-control','Khidmat',' WHERE c31_desc_khidmat IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>

                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span><i class="icon-calendar"></i> Masuk Khidmat </span>:
                                                  <input type="text" class="form-control default-date-picker" id="tmk" name="tmk" value="<?php echo $row['tmk'] ?>" required="required">
                                              </div>
                                          </div>

                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span><i class="icon-calendar"></i> Tamat Khidmat </span>:
                                                  <input type="text" class="form-control default-date-picker" id="ttp" name="ttp" value="<?php echo $row['ttp'] ?>" required="required">
                                              </div>
                                          </div>

                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span><i class="icon-map-marker"></i> Penempatan </span>:
                                                  <input type="text" class="form-control" id="penempatan" name="penempatan" value="<?php echo $row['penempatan'] ?>" required="required">
                                              </div>
                                          </div>

                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span><i class="icon-map-marker"></i> No.KP Lama </span>:
                                                  <input type="text" class="form-control" id="nokplama" name="nokplama" value="<?php echo $row['nokplama'] ?>" required="required">
                                              </div>
                                          </div>

                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span><i class="icon-calendar"></i> Tarikh Lahir </span>:
                                                  <input type="text" class="form-control default-date-picker" id="tlahir" name="tlahir" value="<?php echo $row['tkhlahir'] ?>" required="required">
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span><i class="icon-mobile-phone"></i> Telefon Bimbit </span>:
                                                  <input type="text" class="form-control" id="telhp" name="telhp" value="<?php echo $row['telhp'] ?>" required="required">
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span><i class="icon-mobile-phone"></i> Telefon Rumah </span>:
                                                  <input type="text" class="form-control" id="telrumah" name="telrumah" value="<?php echo $row['telrumah'] ?>" required="required">
                                              </div>
                                          </div>

                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Jantina </span>:
                                                  <?php echo fnComboBox3('c13_kod_jantina','c13_desc_jantina','c13_jantina',$row['kod_jantina'],'jantina','form-control','Jantina',' WHERE c13_desc_jantina IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Keturunan </span>:
                                                  <?php echo fnSelect('c30_kod_keturunan','c30_desc_keturunan','c30_keturunan',$row['kod_keturunan'],'keturunan','form-control','Keturunan',' WHERE c30_desc_keturunan IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Taraf Kahwin </span>:
                                                  <?php echo fnSelect('c60_kod_status_kahwin','c60_desc_status_kahwin','c60_status_kahwin',$row['kod_tarafkahwin'],'tkahwin','form-control','Taraf Kahwin',' WHERE c60_desc_status_kahwin IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>

                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span>Agama </span>:
                                                  <?php echo fnSelect('c74_kod_ugama','c74_desc_ugama','c74_ugama',$row['kod_agama'],'agama','form-control','Agama',' WHERE c74_desc_ugama IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span>Email Rasmi </span>:
                                                  <input type="text" class="form-control" id="emailrasmi" name="emailrasmi" value="<?php echo $row['emailrasmi'] ?>" required="required">
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span>Email Peribadi </span>:
                                                  <input type="text" class="form-control" id="emailperibadi" name="emailperibadi"  value="<?php echo $row['emailperibadi'] ?>" required="required">
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
                                  <div class="bio-row">
                                      <p><span>Nama Penuh </span>: <?php echo $row['namapenuh'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Unit/Jabatan </span>: <?php echo $row['unit'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Skim </span>: <?php echo $row['skim'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Taraf Khidmat </span>: <?php echo $row['tarafkhidmat'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Kor</span>: <?php echo $row['kor'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Perkhidmatan </span>: <?php echo $row['khidmat']?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span><i class="icon-calendar"></i> TMK</span>: <?php echo $row['tmk']?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span><i class="icon-calendar"></i> TTP</span>: <?php echo $row['ttp']?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span><i class="icon-map-marker"></i> Penempatan</span>: <?php echo $row['penempatan']?></p>
                                  </div>
                              </div>

                          </div>
                      </section>

                      <section class="panel" id="section_peribadi">
                          <header class="panel-heading">
                              <i class="icon-user"></i> Peribadi
                          </header>
                          <div class="panel-body bio-graph-info">

                              <div class="row">
                                  <div class="bio-row">
                                      <p><span>No.KP Lama </span>: <?php echo $row['nokplama'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>No.KP Baru </span>: <?php echo $row['nokpbaru'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span><i class="icon-mobile-phone"></i> Tel H/P </span>: <?php echo $row['telhp'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span><i class="icon-phone"></i> Tel Rumah</span>: <?php echo $row['telrumah'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Jantina</span>: <?php echo $row['jantina'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Keturunan </span>: <?php echo $row['keturunan']?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Taraf Kahwin</span>: <?php echo $row['tarafkahwin']?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Agama</span>: <?php echo $row['agama']?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span><i class="icon-envelope"></i> Rasmi</span>: <?php echo $row['emailrasmi']?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span><i class="icon-envelope-alt"></i> Peribadi</span>: <?php echo $row['emailperibadi']?></p>
                                  </div>
                              </div>
                          </div>
                      </section>
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
                                        w04_pasangan.w04_tempat_kahwin as tempatkahwin
                                        FROM
                                        w04_pasangan WHERE w04_pasangan.w04_no_tentera ='".$_GET['notentera']."'";
                      $rst = mysql_query($sql_waris) or die('Error:'.mysql_error());
                      $rows_waris = array();

                      while ($row = mysql_fetch_assoc($rst)){
                          $rows_waris[] = $row;
                      }

                      //Dokumen
                      $sql = "SELECT id,filename,filesize,filetype,fileowner
                        FROM documents WHERE  filecategory = 2 AND fileowner = '".$_GET['notentera']."' order by entry_date DESC";
                      $rst = mysql_query($sql) or die('Error:'.mysql_error());
                      $rows_doc = array();
                      while ($row = mysql_fetch_assoc($rst)){
                          $rows_doc[] = $row;
                      }
                      //Gambar
                      $sql = "SELECT id,filename,filesize,filetype,fileowner
                        FROM documents WHERE  filecategory = 1 AND fileowner = '".$_GET['notentera']."' order by entry_date DESC";
                      $rst = mysql_query($sql) or die('Error:'.mysql_error());
                      $rows_img = array();
                      while ($row = mysql_fetch_assoc($rst)){
                          $rows_img[] = $row;
                      }

                      ?>

                      <section class="panel" id="section_waris">
                          <header class="panel-heading">
                              <i class="icon-heart"></i><a name="bookmark_waris"> Waris</a>

                          </header>
                          <div class="panel-body bio-graph-info">
                              <div id="waris" class="row">
                                  <form id="form_waris" name="form_waris" class="form-inline" action="process.php" method="post">
                                  <div id="progress_waris"></div>
                                  <div class="panel-body">

                                          <input type="hidden" id="cmd" name="cmd" value="AddDataWaris" />
                                          <input type="hidden" id="notentera" name="notentera" value="<?php echo $_GET['notentera'] ?>" />

                                          <div class="bio-row">
                                                  <div class="col-lg-6">
                                                  <span>No.KP Baru </span>:
                                                  <input type="text" class="form-control" id="nokpbaru" name="nokpbaru" data-mask="999999-99-9999" placeholder="999999-99-9999" required="required">
                                                  </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Nama Penuh </span>:
                                                  <input type="text" class="form-control" id="namapenuh" name="namapenuh" required="required">
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span><i class="icon-calendar"></i> Tarikh Lahir </span>:
                                                  <input type="text" class="form-control default-date-picker" id="tkhlahir" name="tkhlahir" required="required">
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span>Keturunan </span>:
                                                  <?php echo fnSelect('c30_kod_keturunan','c30_desc_keturunan','c30_keturunan','','keturunan','form-control','Keturunan',' WHERE c30_desc_keturunan IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span>Agama </span>:
                                                  <?php echo fnSelect('c74_kod_ugama','c74_desc_ugama','c74_ugama','','agama','form-control','Agama',' WHERE c74_desc_ugama IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span><i class="icon-map-marker"></i> Tempat Kahwin </span>:
                                                  <input type="text" class="form-control" id="tempatkahwin" name="tempatkahwin" required="required">
                                              </div>

                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-6">
                                                  <span><i class="icon-calendar"></i> Tarikh Kahwin </span>:
                                                  <input type="text" class="form-control default-date-picker" id="tkhkahwin" name="tkhkahwin" required="required">
                                              </div>
                                          </div>
                                          <div class="bio-row">
                                              <div class="col-lg-10">
                                                  <span><i class="icon-link"></i> Pertalian </span>:
                                                  <?php echo fnSelect('c50_kod_pertalian','c50_desc_pertalian','c50_pertalian','','pertalian','form-control','Pertalian',' WHERE c50_desc_pertalian IS NOT NULL','','required="required"') ?>
                                              </div>
                                          </div>

                                  </div>
                                  <footer class="panel-footer">
                                      <button id="btnSaveWaris" type="submit" class="btn-primary btn-sm"><i class="icon-save"></i> Simpan </button>
                                      <button id="btnCloseWaris" type="button" class="btn-warning btn-sm"><i class="icon-remove"></i> Tutup </button>
                                  </footer>
                                  </form>
                              </div>

                              <div class="row">
                                  <div class="panel-body">
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
                                      <?php foreach($rows_waris as $waris): ?>
                                          <tr>
                                              <td><?php echo $waris['nokpbaru'] ?></td>
                                              <td><?php echo $waris['namawaris'] ?></td>
                                              <td><?php echo $waris['tkhlahir'] ?></td>
                                              <td><?php echo $waris['tkhkahwin'] ?></td>

                                          </tr>
                                      <?php endforeach; ?>

                                      </tbody>
                                  </table>
                                  </div>
                              </div>
                          </div>
                      </section>

                      <section class="panel" id="section_gambar">
                          <header class="panel-heading">
                              <i class="icon-picture"></i> <a name="bookmark_gambar"> Gambar</a>

                          </header>
                          <div class="panel-body bio-graph-info">
                              <div class="row">
                                  <div class="panel-body">
                                      <?php
                                      echo '<table class="print_img1" style="display: none" width="100%" border="0" cellpadding="3" cellspacing="0">';
                                      echo '<tr>';
                                      for($i=0;$i<=count($rows_img);$i=$i+1){
                                          foreach($rows_img as $img)
                                          {
                                              $i++;
                                              if($i%5==0){
                                                  echo '<td width="100" align="center"><img src="../documents/'.$_GET["notentera"]."/".$img["filename"].'" border="0" style="max-width:100px" /></td></tr><tr>';
                                              } else {
                                                  echo '<td width="100" align="center"><img src="../documents/'.$_GET["notentera"]."/".$img["filename"].'" border="0" style="max-width:100px" /></td>';
                                              }
                                          }
                                      }
                                      echo '</tr>';
                                      echo '</table>';

                                      ?>
                                      <div class="panel-body bio-graph-info print_img2">
                                          <div class="row">
                                              <?php for($i=0;$i<count($rows_img);$i=$i+1) { ?>
                                                  <?php
                                                  foreach($rows_img as $img)
                                                  {
                                                      $i++;
                                                      if($i%5==0){
                                                          ?>
                                                          <div class="col-lg-3 col-sm-3">

                                                              <img style="max-width:200px;max-height: 200px" src="../documents/<?php echo $_GET['notentera'].'/'.$img['filename'] ?>">


                                                          </div>
                                                      <?php }else{ ?>
                                                          <div class="col-lg-3 col-sm-3">

                                                              <img style="max-width:100px;max-height: 200px" src="../documents/<?php echo $_GET['notentera'].'/'.$img['filename'] ?>"><br />

                                                          </div>
                                                      <?php } ?>

                                                  <?php
                                                  }
                                              }
                                              ?>
                                          </div>

                                      </div>
                                  </div>
                              </div>
                          </div>
                      </section>

                      <section class="panel" id="section_dokumen">
                          <header class="panel-heading">
                              <i class="icon-file-text"></i> <a name="dokumen"> Dokumen</a>

                          </header>
                          <div class="panel-body bio-graph-info">
                              <div class="row">
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


                                                  </td>

                                              </tr>
                                          <?php endforeach; ?>
                                          </tbody>
                                      </table>
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
      $('#btnPrint').click(function(){
          printElement(document.getElementById("printThis"));
          $('.site-navigation').hide();
          $("#sidebar").hide();
          $(".print_img2").hide();
          $(".print_img1").show();
          loadPrint();

      });
      $('#btnBack').click(function(){
          location.href='hr.view.employee.php?notentera='+$(this).val();
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

      //
      $('#pangkat').hide();
      $('.addPangkat').click(function(){
          if(!$('#pangkat').show()){
              $('#pangkat').toggle('slow');
          }
      });
      $('#btnClosePangkat').click(function(){
          $('#pangkat').slideUp('slow');
      });

      //
      $('#kursus').hide();
      $('.addKursus').click(function(){
          if(!$('#kursus').show()){
              $('#kursus').toggle('slow');
          }
      });
      $('#btnCloseKursus').click(function(){
          $('#kursus').slideUp('slow');
      });

      //
      $('#misi').hide();
      $('.addMisi').click(function(){
          if(!$('#misi').show()){
              $('#misi').toggle('slow');
          }
      });
      $('#btnCloseMisi').click(function(){
          $('#misi').slideUp('slow');
      });

      //
      $('#dkt').hide();
      $('.addDKT').click(function(){
          if(!$('#dkt').show()){
              $('#dkt').toggle('slow');
          }
      });
      $('#btnCloseDKT').click(function(){
          $('#dkt').slideUp('slow');
      });

      //
      $('#bmi').hide();
      $('.addBMI').click(function(){
          if(!$('#bmi').show()){
              $('#bmi').toggle('slow');
          }
      });
      $('#btnCloseBMI').click(function(){
          $('#bmi').slideUp('slow');
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
      //pangkat
      $('#form_pangkat').on('submit', function(e){
          var y = confirm('Anda pasti untuk teruskan?');
          if(y){
              e.preventDefault();
              $("#progress_pangkat").html('<img src="img/loading.gif" />');
              $(this).ajaxSubmit({
                  target: '#progress_pangkat',
                  success: function(response){
                      alert(response);
                      $("#progress_pangkat").html('').hide();
                      location.reload();
                  }
              });
          }else{
              return false;
          }
      });
      //kursus
      $('#form_kursus').on('submit', function(e){
          var y = confirm('Anda pasti untuk teruskan?');
          if(y){
              e.preventDefault();
              $("#progress_kursus").html('<img src="img/loading.gif" />');
              $(this).ajaxSubmit({
                  target: '#progress_kursus',
                  success: function(response){
                      alert(response);
                      $("#progress_kursus").html('').hide();
                      location.reload();
                  }
              });
          }else{
              return false;
          }
      });
      //misi
      $('#form_misi').on('submit', function(e){
          var y = confirm('Anda pasti untuk teruskan?');
          if(y){
              e.preventDefault();
              $("#progress_misi").html('<img src="img/loading.gif" />');
              $(this).ajaxSubmit({
                  target: '#progress_misi',
                  success: function(response){
                      alert(response);
                      $("#progress_misi").html('').hide();
                      location.reload();
                  }
              });
          }else{
              return false;
          }
      });
      //dkt
      $('#form_dkt').on('submit', function(e){
          var y = confirm('Anda pasti untuk teruskan?');
          if(y){
              e.preventDefault();
              $("#progress_dkt").html('<img src="img/loading.gif" />');
              $(this).ajaxSubmit({
                  target: '#progress_dkt',
                  success: function(response){
                      alert(response);
                      $("#progress_dkt").html('').hide();
                      location.reload();
                  }
              });
          }else{
              return false;
          }
      });
      //bmi
      $('#form_bmi').on('submit', function(e){
          var y = confirm('Anda pasti untuk teruskan?');
          if(y){
              e.preventDefault();
              $("#progress_bmi").html('<img src="img/loading.gif" />');
              $(this).ajaxSubmit({
                  target: '#progress_bmi',
                  success: function(response){
                      alert(response);
                      $("#progress_bmi").html('').hide();
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

  });
      function jsImageDefault(filename,fileowner){
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
      function jsUpdateWaris(cmd,param1,param2,param3,param4,param5,param6,param7,param8){
          if(!$('#waris').show()){
              $('#waris').toggle('slow');
          }
          $('#form_waris #nokpbaru').attr("disabled", "disabled");
          $("#form_waris #cmd").val(cmd);
          $("#form_waris #nokpbaru").val(param1);
          $("#form_waris #namapenuh").val(param2);
          $("#form_waris #agama").val(param3);
          $("#form_waris #keturunan").val(param4);
          $("#form_waris #pertalian").val(param5);
          $("#form_waris #tkhlahir").val(param6);
          $("#form_waris #tkhkahwin").val(param7);
          $("#form_waris #tempatkahwin").val(param8);
      }
      function jsUpdateAnak(cmd,param1,param2,param3,param4,param5,param6,param7){

          if(!$('#anak').show()){
              $('#anak').toggle('slow');
          }
          $('#form_anak #nokpbaru').attr("disabled", "disabled");
          $("#form_anak #cmd").val(cmd);
          $("#form_anak #nokpbaru").val(param1);
          $("#form_anak #namapenuh").val(param2);
          $("#form_anak #sijillahir").val(param3);
          $("#form_anak #tkhlahir").val(param4);
          $("#form_anak #tempatlahir").val(param5);
          $("#form_anak #jantina").val(param6);
          $("#form_anak #pertalian").val(param7);
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
          $(".site-navigation").show();
          $("#sidebar").show();
          $(".print_img2").show();
          $(".print_img1").hide();
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
