<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
include_once('../config/functions.php') ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Profile Activity</title>

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
    <style type="text/css">
        .animation_image {background: #F9FFFF;border: 1px solid #E1FFFF;padding: 10px;width: 500px;margin-right: auto;margin-left: auto;}
    </style>
  </head>

  <body>

  <section id="container" class="">
      <!--header start-->
      <?php include_once("header.php") ?>
      <!--header end-->
      <!--sidebar start-->
      <?php include_once("sidebar.php") ?>
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
                                , scheme.scheme_name
                                , scheme.scheme_gred
                            FROM
                                groups
                                LEFT JOIN userprofile
                                    ON (groups.group_id = userprofile.user_group_id)
                                LEFT JOIN department
                                    ON (department.department_id = userprofile.user_dept_id)
                                LEFT JOIN scheme
                                    ON (scheme.scheme_id = userprofile.user_scheme_id)
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
                              <li><a href="profile.php"> <i class="icon-user"></i> Profil</a></li>
                              <li class="active"><a href="profile-activity.php" class="viewLog"> <i class="icon-calendar"></i> Aktiviti Terkini<span class="label label-danger pull-right r-activity"><?php fnSQLCustom("select count(*) as totalrecord from log_activity where log_userid='".$_SESSION['userid']."' AND log_status='unseen'","totalrecord"); ?></span></a></li>
                              <li><a href="profile-edit.php"> <i class="icon-edit"></i> Sunting Profil</a></li>
                          </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">

                      <section class="panel">
                          <div class="panel-body profile-activity">
                              <h5 class="pull-right"> <?php

                                  echo $hariini = fnSQLCustom('SELECT DATE_FORMAT(CURDATE(),"%d-%m-%Y")  AS hariini','hariini');
                                  $items_per_group = 5;
                                  $total_records = fnSQLCustom("SELECT COUNT(*) AS t_records from log_activity WHERE log_status='seen' and log_userid='$userid' AND DATE_FORMAT(log_created,'%d-%m-%Y')='$hariini'",'t_records');
                                  $total_groups  = ceil($total_records/$items_per_group);
                                  ?>  </h5>
                              <!-- output results here -->
                              <div id="results"></div>
                              <div class="animation_image" style="display:none" align="center"><img src="img/loading.gif"></div>
                          </div>
                      </section>
                  </aside>
              </div>

              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
      <?php include_once("footer.php") ?>
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
      $(document).ready(function(){

          $('.viewLog').click(function(){
              $.ajax({
                  type: 'post',
                  url: 'process.php',
                  data: 'cmd=ResetLogActivity' + '&token='+$('#token').val(),
                  cache: false,
                  success: function(html)
                  {
                      //alert(html);

                  }
              });
          });

          //start auto load more data
          var track_load = 0; //total loaded record group(s)
          var loading  = false; //to prevents multipal ajax loads
          var total_groups = <?php echo $total_groups; ?>; //total record group(s)

          $('#results').load("data-activity.php", {'group_no':track_load}, function() {track_load++;}); //load first group

          $(window).scroll(function() { //detect page scroll

              if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
              {

                  if(track_load <= total_groups && loading==false) //there's more data to load
                  {
                      loading = true; //prevent further ajax loading
                      $('.animation_image').show(); //show loading image

                      //load data from the server using a HTTP POST request
                      $.post('data-activity.php',{'group_no': track_load}, function(data){

                          $("#results").append(data); //append received data into the element

                          //hide loading image
                          $('.animation_image').hide(); //hide loading image once data is received

                          track_load++; //loaded group increment
                          loading = false;

                      }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

                          alert(thrownError); //alert with HTTP error
                          $('.animation_image').hide(); //hide loading image
                          loading = false;

                      });

                  }
              }
          });
          //end auto load more dat


      });
  </script>
    </body>
</html>
