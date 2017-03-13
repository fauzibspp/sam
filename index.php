<?php
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include_once('config/config.php');
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Fauzi">
    <meta name="keyword" content="Question,Assessment">
    <link rel="shortcut icon" href="home/img/favicon.png">

    <title><?php echo APP_NAME ?></title>

    <!-- Bootstrap core CSS -->
    <link href="home/css/bootstrap.min.css" rel="stylesheet">
    <link href="home/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="home/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="home/css/style.css" rel="stylesheet">
    <link href="home/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>

    <![endif]-->
    <style type="text/css" media="all">
        .form-signin{
            border: 1px solid #e5e5e5;
            box-shadow: rgba(200,200,200,0.7) 0 4px 10px -1px;
			
        }
				
		
		.parent
		{
		  position : relative;		  
		}
		.child
		{
		  position : absolute;

		  top: 0 ;
		  right: 0 ;
		  bottom : 0 ;
		  left : 0 ;
		  margin : auto;
		}
		#video-bg {
		  position: fixed;
		  top: 0; right: 0; bottom: 0; left: 0;
		  overflow: hidden;
		}
		#video-bg > video {
		  position: absolute;
		  top: 0;
		  left: 0;
		  width: 100%;
		  height: 100%;
		}
		/* 1. No object-fit support: */
		@media (min-aspect-ratio: 16/9) {
		  #video-bg > video { height: 300%; top: -100%; }
		}
		@media (max-aspect-ratio: 16/9) {
		  #video-bg > video { width: 300%; left: -100%; }
		}
		/* 2. If supporting object-fit, overriding (1): */
		@supports (object-fit: cover) {
		  #video-bg > video {
			top: 0; left: 0;
			width: 100%; height: 100%;
			object-fit: cover;
		  }
		}

    </style>
</head>
  <body>
  <!--<body class="login-body">-->
  <?php
  function checkHTTPS() {
      if(!empty($_SERVER['HTTPS']))
          if($_SERVER['HTTPS'] !== 'off')
              return true; //https
          else
              return false; //http
      else
          if($_SERVER['SERVER_PORT'] == 443)
              return true; //https
          else
              return false; //http
  }
  function curPageURL(){
      $pageURL = 'http';
      if (isset($_SERVER['HTTPS']) == "on") {
          $pageURL .= "s";
      }else{
          $pageURL .= "";
      }

      $pageURL .= "://";

      if ($_SERVER['SERVER_PORT'] != "80") {
          $pageURL .= $_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
      } else {
          $pageURL .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
      }
      return $pageURL;
  }
  #$defaultAddress = 'https://'.$servername.':443/'.$aliasname .'/';
  $defaultAddress = 'http://'.hostname.':8080/'.$aliasname .'/';
  if(isset($_SESSION['userid'])){
    echo '<script>location.href="home/"</script>';
  }
  ?>
	<div class="parent">	

		
	<div class="child">
    <!--<div class="container">-->
		
        <div id="box">
            <form action="" method="post" class="form-signin">
                <?php

                $curPageURL = curPageURL();
                $salt = 'abc123';
                $token = sha1(mt_rand(1,1000000) . $salt);
                $_SESSION['token'] = $token;
                echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
                ?>
                <h2 class="form-signin-heading">SISTEM <?php echo APP_NAME ?> </h2>
                <div class="login-wrap">

                    <input type="text" name="username" autocomplete="off" id="username" class="form-control text-primary" placeholder="Id Pengguna" autofocus/>
                    <input type="password" name="password" class="form-control text-primary" placeholder="Katalaluan" autocomplete="off" id="password"/><br/>

                    <button type="submit" class="btn btn-lg btn-login btn-block" id="login"/><i class="icon-ok-sign"></i>&nbsp;Log In</button>
                    <span class='msg'></span>
                    <div id="error"></div>
                </div>

                <!-- Modal -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Lupa Katalaluan ?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Masukkan alamat email untuk reset katalaluan anda.</p>
                                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                                <button class="btn btn-success" type="button"><i class="icon-envelope"></i>&nbsp;Hantar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal -->
            </form>


        </div>

    </div> <!--child-->
	
	</div> <!--parent -->



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.ui.shake.js"></script>
    <script src="lib/aes.js">/* AES JavaScript implementation */</script>
    <script src="lib/aes-ctr.js">/* AES Counter Mode implementation */</script>
    <script src="js/rollups/md5.js"></script>

  <script type="text/javascript">
        $(document).ready(function() {

            $('#login').click(function()
            {
                var username=$("#username").val();
                var password=$("#password").val();
                //alert('My Password:'+password);
                var hash = CryptoJS.MD5(password);
                //alert('Hash:'+hash);
                var password_cipher = password;//Aes.Ctr.encrypt(hash, 'inTelIn$ideCorei5', 256);
                //alert('Encrypt:'+password_cipher);
                var token = $("#token").val();
                var dataString = 'userid='+username+'&userpwd='+password_cipher+'&token='+token;
                if($.trim(username).length>0 && $.trim(password).length>0)
                {


                    $.ajax({
                        type: "POST",
                        url: "login.php",
                        data: dataString,
                        cache: false,
                        beforeSend: function(){ $("#login").val('Berhubung...');},
                        success: function(data){
                            //alert(data);

                            switch(data){
                                case "1": location.href="home/";
                                    break;
								case "2": alert('Log masuk tidak sah. Sila cuba lagi.');
									break;
                                default:
                                    $('#box').shake();
                                    $("#login").val('Login')
                                    $("#error").html("<span style='color:#cc0000'>Error:</span> Id Pengguna dan Katalaluan tidak sah!!. ");

                                    //location.reload();

                            }


                        }
                    });

                }
                return false;
            });


        });
    </script>


  </body>
</html>
