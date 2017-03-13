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
          //connDB();
          $salt = 'm0h2014';
          $token = sha1(mt_rand(1,1000000) . $salt);
          $_SESSION['token'] = $token;
          echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
          $userid = $_SESSION['userid'];
          $qry = "SELECT
                                userprofile.user_id
                                , userprofile.user_name
                                , userprofile.user_phone_ext
                                , department.department_name
                                , groups.group_name
                                , userprofile.user_phone
                                , userprofile.user_email
                                , userprofile.user_images
                                , userprofile.user_scheme_id
                                , userprofile.unit_name
                                , userprofile.unit_address
                                , userprofile.unit_postcode
                                , userprofile.unit_state
                            FROM
                                groups
                                LEFT JOIN userprofile
                                    ON (groups.group_id = userprofile.user_group_id)
                                LEFT JOIN department
                                    ON (department.department_id = userprofile.user_dept_id)
                                    WHERE userprofile.user_id='$userid'";
          //$rst = mysql_query($qry) or die("Error:".mysql_error());
          $row = db_select($qry);
          ?>
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">

                          <div class="user-heading round">
                              <?php if(isset($row[0]['user_images'])) { ?>
                                  <a href="javascript:void(0)">
                                      <img src="profiles/<?php echo $row[0]['user_images'] ?>" alt="">
                                  </a>
                              <?php }else{ ?>
                                  <a href="javascript:void(0)">
                                      <img src="img/unknown.png" alt="">
                                  </a>
                              <?php } ?>
                              <h1><?php echo $_SESSION['userid']?></h1>
                              <p><?php echo $_SESSION['email']?></p>
                          </div>

                          <ul class="nav nav-pills nav-stacked">
                              <li class="active"><a href="profile.php"> <i class="icon-user"></i> Profil</a></li>
                              <li><a href="javascript:void(0)" class="viewLog"> <i class="icon-calendar"></i> Aktiviti Terkini<span class="label label-danger pull-right r-activity"><?php 
                                          fnSQLCustom("select count(*) as totalrecord from log_activity where log_userid='".$_SESSION['userid']."' AND log_status='unseen'","totalrecord");
                                          //echo fnCheckCountRecordItem2($_SESSION['userid'],'unseen','log_activity','log_userid','log_status','*') ?></span></a></li>
                              <li><a href="profile-edit.php"> <i class="icon-edit"></i> Sunting Profil</a></li>
                          </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">

                      <section class="panel">

                          <div class="panel-body bio-graph-info">
                              <h1>Profil</h1>
                              <div class="row">
                                  <div class="bio-row">
                                      <p><span>Nama Penuh </span>: <?php echo $row[0]['user_name'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Unit/Jabatan </span>: <?php echo $row[0]['unit_name'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Jabatan </span>: <?php echo $row[0]['unit_address'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Negeri </span>: <?php echo $row[0]['unit_state'] ?></p>
                                  </div>

                                  <div class="bio-row">
                                      <p><span>Skim </span>: <?php echo fnSQLCustomWithWhileLoop('SELECT CONCAT(scheme_name," - ",scheme_gred) AS scheme_group FROM scheme WHERE FIND_IN_SET(scheme_id,"'.$row[0]['user_scheme_id'].'")','scheme_group'); ?>

                                  </div>
                                  <div class="bio-row">
                                      <p><span>Kumpulan</span>: <?php echo $row[0]['group_name'] ?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Tel(HP) </span>: <?php echo $row[0]['user_phone']?></p>
                                  </div>
                                  <div class="bio-row">
                                      <p><span>Tel(Pej) </span>: <?php echo $row[0]['user_phone_ext']?></p>
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

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
  <!--notification script-->
  <script src="js/notifications.js"></script>

  <script type="text/javascript">

      //knob
      $(".knob").knob();

      $('.viewLog').click(function(){

          $.ajax({
              type: 'post',
              url: 'process.php',
              data: 'cmd=ResetLogActivity' + '&token='+$('#token').val(),
              cache: false,
              success: function(html)
              {
                  //alert(html);
                  location.href="profile-activity.php";
              }
          });
      });

  </script>


  </body>
</html>
