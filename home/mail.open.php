<?php include_once('../config/functions.php') ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
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
                <?php
                $url = base64_decode(base64_url_decode($_GET['url']));
                //echo $url;
                parse_str($url);

                $message = fnSQLCustom("select textbody from email_inbox where messageid='$id'","textbody");

                $sql_update = "UPDATE email_inbox SET is_read=1 WHERE messageid='$id'";
                db_query($sql_update);

                if($attach_file=='Y'){
                    $sql_attach = "SELECT d05_messageid as message_id, d05_filenamecurrent as filename,d05_filesize,
                     d05_filetype as filetype FROM
                            attachments_inbox WHERE d05_messageid ='".$id."' and d05_user_receipient='$v_owner'";
                   
                    $rows_attach = db_select($sql_attach);

//                    while($row = mysql_fetch_assoc($rst)){
//                        $rows_attach[] = $row;
//                    }
                }

                ?>
                <section class="panel">
                    <div class="inbox-head">
                        <h3><i class="icon-folder-open-alt"></i> Baca Mail</h3>
                    </div>
                    <header class="panel-heading">
                        <?php echo strtoupper($subject) ?>
                    </header>

                    <div class="panel-body">
                        <div class="input-group-btn">
                            <span class="text-muted">
                                <i class="icon-user"></i> : <?php echo $from ?>
                                <i class="icon-time"></i> : <?php echo $date ?>
                            </span>

                            <?php if ($attach_file=='Y'): ?>
                                <div class="btn-group hidden-phone">
                                    <a class="btn mini blue" href="#" data-toggle="dropdown">
                                        <i class="icon-paperclip"></i> Attachment
                                        <i class="icon-angle-down "></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php foreach($rows_attach as $row_attach):
                                            switch($row_attach['filetype']){
                                                case "image/jpeg";
                                                    "image/gif";
                                                    "image/png";
                                                    "image/jpg";
                                                    $class = 'image-popup-vertical-fit';
                                                    break;
                                                case "video/mp4";
                                                    "video/mpeg";
                                                    "video/flv";
                                                    "video/wmv";
                                                    "application/pdf";
                                                    $class = 'iframe-popup';
                                                    break;
                                                default:
                                                    $class = 'iframe-popup';

                                            }
                                            ?>
                                        <li>
                                            <a class="<?php echo $class ?>" href="../attachments/<?php echo $v_owner ?>/<?php echo $id ?>/<?php echo $row_attach['filename'] ?>" >
                                            <i class="icon-file"></i> <?php echo $row_attach['filename'] ?></a>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>

                                </div>
                            <?php endif; ?>


                            <button style="float: right" type="button" id="startUpload" class="finish btn btn-success btn-sm form-inline"><i class="icon-envelope-alt"></i> Hantar</button>
                        </div>
                        <div id="result"></div>
                        <div id="loading"></div>
                        <!-- content message -->
                        <span class="text-primary"><?php echo $message ?></span>
                        <!-- content message -->
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

<script type="text/javascript">
    $(document).ready(function(e) {

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
        $('.iframe-popup').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });

    });

    function jsDelData(id,filename){

        var datastring = 'id='+id+'&filename='+filename;
        if(y = confirm('Anda pasti untuk teruskan?')){
            if(y){
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring +'&cmd=MailDelete',
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
    function jsVerifyData(id,is_read){

        var datastring = 'id='+id+'&is_read='+is_read;
        if(y = confirm('Anda pasti untuk teruskan?')){
            if(y){
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring +'&cmd=MailRead',
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
