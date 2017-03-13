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
                        <h3><i class="icon-forward"></i> Forward</h3>
                    </div>
                    <header class="panel-heading">
                        *Sila isikan maklumat dibawah dan tekan butang "Hantar".
                    </header>


                    <div class="panel-body">
                        <div class="input-group-btn">
                            <button style="float: right" type="button" id="startSubmit" class="finish btn btn-success form-inline"><i class="icon-envelope-alt"></i> Hantar</button>
                        </div>


                        <div id="result"></div>
                        <div id="loading"></div>
                        <form id="composeform" action="process_message.php" name="composeform" enctype="multipart/form-data">
                            <?php
                            $salt = 'abc123';
                            $token = sha1(mt_rand(1,1000000) . $salt);
                            $_SESSION['token'] = $token;
                            echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
                            $url = base64_decode(base64_url_decode($_GET['url']));
                            //echo $url;
                            parse_str($url);
                            $message = fnGetRecord1Param('messageid','textbody','email_outbox',$id);
                            ?>
                            <input type="hidden" name="cmd" id="cmd" value="OutboxForward"/>
                            <input type="hidden" name="id" id="id" value="<?php echo $id ?>"/>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="email_to" id="email_to" class="form-control" placeholder="Kepada" value="<?php //echo $from ?>" />
                                </div>
                                <div class="form-group">

                                    <input type="text" name="email_subject" id="email_subject" class="form-control" placeholder="Subjek" value="Fwd: <?php echo $subject ?>" />
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control error" cols="60" rows="5" id="email_message" name="email_message" placeholder="Mesej">
                                        <p>
                                            ---------- Forward message ----------<br>
                                            From : <?php echo $from ?><br>
                                            Date : <?php echo $date ?><br>
                                            Subject : <?php echo $subject ?><br>
                                            To : <?php echo $to ?><br>
                                        </p>
                                        <p></p>
                                        <?php echo $message ?>
                                    </textarea>
                                </div>
                                <?php
                                $source_file = '../attachments/';
                                $sql = "SELECT d05_user_id AS file_owner, d05_filenamecurrent AS filename FROM attachments_outbox WHERE d05_messageid = '$id'";
                                $rst = mysql_query($sql) or die('Error: '.mysql_error());
                                $rows_file = array();
                                while($row = mysql_fetch_assoc($rst)){
                                    $rows_file[] = $row;
                                }
                                ?>
                                <div class="form-group">
                                    <div id="more-multifile">
                                        <?php foreach($rows_file as $row_file): ?>
                                        <input type="file" name="files[]"  />
                                        <?php endforeach; ?>
                                        <ul>
                                        <?php foreach($rows_file as $row_file): ?>
                                        <li><label><input type="checkbox" name="file-list[]" value="<?php echo $source_file.$row_file['file_owner'].'/'.$row_file['filename'] ?>" checked="checked"><?php echo $row_file['filename'] ?></label></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    </div>

                                </div>


                            </div>
                        </form>
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

<!--script for editor -->
<script src="js/froala_editor.min.js"></script>

<!--script for this notification-->
<script src="js/notifications.js"></script>
<script src="assets/tiles/js/jquery.magnific-popup.min.js"></script>

<!-- upload multiple -->
<script src="assets/multifile/jquery.multiFile.js"></script>

<script type="text/javascript">
    $(document).ready(function(e) {

        $("#more-multifile").multiFile();

        $('#email_message').editable({
            inlineMode: false,
            buttons: ['undo', 'redo' , 'sep', 'bold', 'italic', 'underline'],
            spellcheck: true
        });

        $("#startSubmit").click(function()
        {
            if( $("#email_to").val()==""){
                alert("Sila masukkan penerima.");
                $("#email_to").focus();
                return false;
            }else  if( $("#email_subject").val()==""){
                alert("Sila masukkan tajuk.");
                $("#email_subject").focus();
                return false;
            }else{
                $("#result").html('<img src="./img/progressbar.gif" />');

                $('#composeform').ajaxSubmit({
                    target: '#loading',
                    success: function(response){
                        alert(response);
                        $("#result").html('').hide();
                        location.reload();
                    }
                });
            }
        });

        //open dialog box

        $("#email_to").click(function(){
            $("#dialog-form").modal('show');
            var url = 'inc/data_contact_list.php';
            $.post(url, {} ,function(data) {
                $("#dialog-form .modal-body").html(data).show();
            });
        });

        //return value from dialog box
        $('form#form_receipient').submit(function(e){
            e.preventDefault();
            var datacheck = $('.modal-body #receipientCB:checked').map(function(i,n){
                return $(n).val();
            }).get();

            if(datacheck.length > 0){
                var selected, variable = '';
                $(this).find('input[type="checkbox"]').each(function(){
                   selected = $(this).val();
                   if( $(this).is(':checked') ){
                       variable += selected + ', ';
                   }
                });

                var contact_list = variable.replace(/,\s*$/, '');
                $("#email_to").focus();
                $("#email_to").val(contact_list).append(contact_list);
                //auto close aftar click button ok
                $('#dialog-form').modal('hide');

            }else{
                if($("#email_to").val() != ''){ $("#email_to").val(''); }
                alert('Sila tandakan sekurang-kurangnya satu satu rekod penerima');
                return false;
            }


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

        $('#email_message').editable({
            inlineMode: false,
            buttons: ['undo', 'redo' , 'sep', 'bold', 'italic', 'underline'],
            spellcheck: true
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
