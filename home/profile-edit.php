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

    <title>Profile Edit</title>

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
          $userid = $_SESSION['userid'];
          $qry = "SELECT
                                userprofile.user_id
                                , userprofile.user_name
                                , userprofile.user_phone_ext
                                , department.department_id
                                , department.department_name
                                , groups.group_id
                                , groups.group_name
                                , userprofile.user_phone
                                , userprofile.user_email
                                , userprofile.user_images
                                , scheme.scheme_id
                                , scheme.scheme_name
                                , scheme.scheme_gred
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
                                LEFT JOIN scheme
                                    ON (scheme.scheme_id = userprofile.user_scheme_id)
                                    WHERE userprofile.user_id='$userid'";
          //$rst = mysql_query($qry) or die("Error:".mysql_error());
          $row = db_select($qry);

                    $salt = 'm0h2014';
                    $token = sha1(mt_rand(1,1000000) . $salt);
                    $_SESSION['token'] = $token;
                    echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
          ?>
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                              <?php if(isset($row['user_images'])) { ?>
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
                              <li><a href="profile-activity.php"> <i class="icon-calendar"></i> Aktiviti Terkini <span class="label label-danger pull-right r-activity"><?php fnSQLCustom("select count(*) as totalrecord from log_activity where log_userid='".$_SESSION['userid']."' AND log_status='unseen'","totalrecord"); ?></span></a></li>
                              <li  class="active"><a href="profile-edit.php"> <i class="icon-edit"></i> Sunting Profil</a></li>
                          </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">
                      <section class="panel">

                          <div class="panel-body bio-graph-info">
                              <h1> Sunting Profil</h1>
                              <form class="form-horizontal" role="form" id="form_profile">

                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Nama Penuh</label>
                                      <div class="col-lg-6">
                                          <input type="text" class="form-control" id="username" name="username" placeholder=" " value="<?php echo $row[0]['user_name'] ?>">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Unit/Jabatan</label>
                                      <div class="col-lg-6">
                                          <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder=" " value="<?php echo $row[0]['unit_name'] ?>">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Alamat Bertugas</label>
                                      <div class="col-lg-6">
                                          <input type="text" class="form-control" id="unit_address" name="unit_address" placeholder=" " value="<?php echo $row[0]['unit_address'] ?>">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Poskod</label>
                                      <div class="col-lg-6">
                                          <input type="text" class="form-control" id="unit_postcode" name="unit_postcode" placeholder=" " value="<?php echo $row[0]['unit_postcode'] ?>">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Negeri</label>
                                      <div class="col-lg-6">
                                          <?php //echo fnSelect('state_name','state_name','state',$row['unit_state'],'unit_state','form-control input-sm m-bot15','Negeri','','','required="required"'); ?>
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Tel (HP)</label>
                                      <div class="col-lg-6">
                                          <input type="text" class="form-control" id="hp_phone" name="hp_phone" placeholder=" " value="<?php echo $row[0]['user_phone'] ?>">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Tel (Pej)</label>
                                      <div class="col-lg-6">
                                          <input type="text" class="form-control" id="office_phone" name="office_phone" placeholder=" " value="<?php echo $row[0]['user_phone_ext'] ?>">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Email</label>
                                      <div class="col-lg-6">
                                          <input type="text" class="form-control" id="email" name="email" placeholder=" " value="<?php echo $row[0]['user_email']   ?>">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <button id="btnSimpan1" type="button" class="btn btn-success">Simpan</button>
                                          <input type="hidden" name="cmd" id="cmd" value="EditProfile">

                                      </div>
                                  </div>
                              </form>
                          </div>
                      </section>
                      <section>
                          <div class="panel panel-primary">
                              <div class="panel-heading"> Pinda Katalaluan</div>
                              <div class="panel-body">
                                  <div id="msgresults"></div>
                                  <form class="form-horizontal" role="form" id="form_password" name="form_password">
                                      <input type="hidden" id="cmd" name="cmd" value="EditPassword">
                                      <div class="form-group">
                                          <label  class="col-lg-2 control-label">Katalaluan Semasa</label>
                                          <div class="col-lg-6">
                                              <input type="password" class="form-control" id="c-pwd" name="c-pwd" placeholder=" " required="required" maxlength="15">
                                              (Mak:15 aksara)
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label  class="col-lg-2 control-label">Katalaluan Baru</label>
                                          <div class="col-lg-6">
                                              <input type="password" class="form-control" id="n-pwd" name="n-pwd" placeholder=" " required="required" maxlength="15">
                                              (Mak:15 aksara)
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label  class="col-lg-2 control-label">Ulang Katalaluan Baru</label>
                                          <div class="col-lg-6">
                                              <input type="password" class="form-control" id="rt-pwd" name="rt-pwd" placeholder=" " required="required" maxlength="15">
                                              (Mak:15 aksara)
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10">
                                              <button type="button" class="btn btn-info" id="btnSimpan2">Simpan</button>

                                          </div>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </section>
                      <section>
                          <div class="panel panel-primary">
                              <div class="panel-heading"> Sets Avatar</div>
                              <div class="panel-body">
                                  <form class="form-horizontal" role="form" enctype="multipart/form-data" action="process_upload.php" method="POST" id="uploadform" name="uploadform">

                                      <div class="form-group">
                                          <label  class="col-lg-2 control-label">Tukar Avatar</label>
                                          <div class="col-lg-6">
                                              <input type="file" class="file-pos" id="image_file" name="image_file">

                                          </div>
                                          <div id="onsuccessmsg"></div>
                                      </div>

                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10">
                                              <button type="submit" class="btn btn-info">Simpan</button>

                                          </div>
                                      </div>
                                  </form>
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
    <!-- jquery.form submit -->
    <script src="js/jquery.form.js" type="text/javascript"></script>
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
            $("#btnSimpan1").click(function(){
                var datastring = $("#form_profile").serialize();
                $.ajax({//make the Ajax Request
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val(),
                    success: function(html)
                    {
                        alert(html);
                        location.reload();
                    }//end success
                }); //end ajax
            });

            $("#btnSimpan2").click(function(e){
                var y = confirm('Anda pasti untuk teruskan?');
                if(y){
                    var datastring = $("#form_password").serialize();
                    $("#msgresults").html('<img src="img/loading.gif"/>');
                    $.ajax({//make the Ajax Request
                        type: 'post',
                        url: 'process.php',
                        data: datastring + '&token='+$('#token').val(),
                        success: function(html)
                        {
                            //alert(html);
                            $("#msgresults").html(html);
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                            //location.reload();
                        }//end success
                    }); //end ajax
                }

            });



            $('#uploadform').on('submit', function(e){
                var y = confirm('Anda pasti untuk teruskan?');
                if(y){
                    e.preventDefault();
                    $("#onsuccessmsg").html('<img src="img/loading.gif"/>');
                    $(this).ajaxSubmit({
                        target: '#onsuccessmsg',
                        success: function(response,status){
                            //alert(status + response);
                            $("#onsuccessmsg").html(response);
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);

                        }
                    });
                }else{ return false; }
            });


        });
        function onsuccess(response,status){
            $("#onsuccessmsg").html("Status :<b>"+status+'</b><br><br>Response Data :<div id="msg" style="border:5px solid #CCC;padding:15px;">'+response+'</div>');
        }
    </script>

  </body>
</html>
