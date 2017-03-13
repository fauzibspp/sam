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

    <title><?php echo appname ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />

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
    <?php
    #initial variable
    $category = '';
    $v_owner = $_SESSION['userid'];
    ?>


    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="inbox-head">
                            <h3><i class="icon-envelope-alt"></i> Outbox</h3>
                        </div>
                        <header class="panel-heading">
                            *Sila klik pada subjek untuk membaca mesej.
                        </header>
                        <!--widget start-->
                        <section class="panel">
                            <div class="panel-body">
                                <?php
                                $salt = 'm0h2014';
                                $token = sha1(mt_rand(1,1000000) . $salt);
                                $_SESSION['token'] = $token;
                                $user_id = $_SESSION['userid'];
                                echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
                                ?>
                                <article class="media">
                                    <section class="panel">
                                        <div class="inbox-body">
                                            <!-- start list media-body-->
                                            <div class="adv-table">
                                                <!-- start content -->
                                                <table class="table table-inbox table-hover"  id="example1">

                                                    <?php
                                                    //connDB();
                                                    $qry = "SELECT messageid as id,sender_id as sender,receiver_id as receiver,SUBJECT AS subjects,
                                                    DATE_FORMAT(created_at,'%b %d %Y %h:%i %p') as created,
                                                    is_read,has_attachments FROM email_outbox
                                                    WHERE sender_id='$v_owner' ORDER BY created_at DESC";

                                                    $rows_mail = db_select($qry);
                                                    
                                                    echo '<thead>';
                                                    echo '<tr><td colspan="6">';
                                                    echo '<div class="mail-option">';
                                                    echo '<div class="btn-group">
                                                    <a class="btn btn-info btnReload" href="javascript:void(0)" title="Refresh">
                                                        <i class=" icon-refresh"></i>
                                                    </a>&nbsp;
                                                    </div>';

                                                    echo '<div class="btn-group" >
                                                    <a class="btn mini all btn-default" href="#" data-toggle="dropdown">
                                                        Action
                                                        <i class="icon-angle-down "></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                            <li><a href="javascript:void(0)"><i class="icon-pencil"></i> Mark as Read</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="javascript:void(0)" class="deleteBtn"><i class="icon-trash"></i> Delete</a></li>
                                                    </ul>
                                                    </div>
                                                    </div>';




                                                    echo '</td></tr>';
                                                    echo '<tr>
                                                        <th><input type="checkbox" onclick="toggleChecked(this.checked)" id="checkAll" /></th>
                                                        <th>&nbsp;</th>
                                                        <th>Kepada</th>
                                                        <th>Subjek</th>
                                                        <th>Lampiran</th>
                                                        <th class="text-right">Tarikh</th>
                                                    </tr>';
                                                    echo '</thead>';
                                                    echo '</tbody>';
                                                    foreach($rows_mail as $row_mail):

                                                        if($row_mail['is_read']==0){
                                                            $subject = '<strong>'.$row_mail['subjects'].'</strong>';
                                                            $icon_read = '<i class="icon-folder-close-alt"></i>';
                                                        }else{
                                                            $subject = $row_mail['subjects'];
                                                            $icon_read = '<i class="icon-folder-open-alt"></i>';
                                                        }

                                                        if($row_mail['has_attachments']==1){
                                                            $attachment_clip = '<i class="icon-paper-clip"></i>';
                                                            $mail_open = 'id='.$row_mail['id'].'&subject='.$row_mail['subjects'].'&from='.$row_mail['sender'].'&to='.$row_mail['receiver'].'&date='.$row_mail['created'].'&attach_file=Y';
                                                            $mail_open = base64_url_encode($mail_open);
                                                        }else{
                                                            $attachment_clip = "";
                                                            $mail_open = 'id='.$row_mail['id'].'&subject='.$row_mail['subjects'].'&from='.$row_mail['sender'].'&to='.$row_mail['receiver'].'&date='.$row_mail['created'].'&attach_file=N';
                                                            $mail_open = base64_url_encode($mail_open);
                                                        }

                                                        ?>
                                                        <tr class="unread">
                                                            <td class="inbox-small-cells">
                                                                <div id="checkboxes"><input type="checkbox" id="cbox" value="<?php echo $row_mail['id'] ?>" name="addCB[]" class="cb" /></div>
                                                            </td>
                                                            <td class="inbox-small-cells"><?php echo $icon_read ?></td>
                                                            <td class="view-message  dont-show"><?php echo $row_mail['receiver'] ?></td>
                                                            <td class="view-message "><a href="mail.outbox.open.php?url=<?php echo base64_encode($mail_open) ?>"><?php echo $subject ?></a> </td>
                                                            <td class="view-message  inbox-small-cells"><?php echo $attachment_clip ?></td>
                                                            <td class="view-message  text-right"><?php echo $row_mail['created'] ?></td>
                                                        </tr>
                                                    <?php
                                                    endforeach;
                                                    ?>
                                                    </tbody>
                                                </table>
                                                <!-- end content -->
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
<!--<script src="js/jquery.form.js" type="text/javascript"></script>-->
<script src="js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="js/respond.min.js" ></script>
<script src="js/jquery.validate.min.js" ></script>

<!--common script for all pages-->
<script src="js/common-scripts.js"></script>

<!--script for notification-->
<script src="js/notifications.js"></script>

<!-- upload multiple -->
<script src="assets/uploadmulti/jquery.fileuploadmulti.js"></script>
<script src="assets/tiles/js/jquery.magnific-popup.min.js"></script>


<script type="text/javascript">
$(document).ready(function(e) {

    $('#example1').dataTable( {} );

    $('.alert').hide();

    //---

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


    /*
     $('.close').click(function(){
     $('#video-modal.modal').find('video').attr('src', '');
     });
     $('.btn-primary').click(function(){
     $('#video-modal.modal').find('video').attr('src', '');
     });
     */

    /* checkbox and submit button */
    if($('#cbox').length==0){
        $('#checkAll:checkbox').prop('disabled',true);
    }else{
        $('#checkAll:checkbox').prop('disabled',false);
    }
    $('input:checkbox').change(function () {
        $('.submitBtn:button').prop('disabled', $('input:checkbox:checked').length == 0)
        $('.deleteBtn:button').prop('disabled', $('input:checkbox:checked').length == 0)
    });

    $('.submitBtn').click(function(){

        var datacheck = $('.cb:checked').map(function(i,n){
            return $(n).val();
        }).get();

        if(datacheck.length > 0){

            $("#dialog-form").modal('show');

            var cmd = 'SubmitDataReport';
            var url = 'inc/datareceipient.php';
            $.post(url, {report_id: datacheck,cmd: cmd} ,function(data) {
                $(".modal-body").html(data).show();
            });

        }else{
            alert('Sila pilih sekurang-kurangnya satu rekod.');
            return false;
        }

    });
    /* checkbox and submit button */

    /*button from dialog form*/
    $('form#form_receipient').submit(function(e){
        e.preventDefault();

        var datacheck = $('.modal-body #receipientCB:checked').map(function(i,n){
            return $(n).val();
        }).get();

        var datastring = $("#form_receipient").serialize();

        if(datacheck.length > 0){
            $.ajax({
                type: 'post',
                url: 'process.php',
                data: datastring + '&token='+$('#token').val(),
                success: function(html)
                {
                    alert(html);
                    location.reload();
                }
            });
        }else{
            alert('Sila tandakan sekurang-kurangnya satu satu rekod penerima');
            return false;
        }

    });
    /*
     $('.simpan').click(function(){
     var datacheck = $('#form_receipient:checked').map(function(i,n){
     return $(n).val();
     }).get();

     var datastring = $("#form_receipient").serialize();

     if(datacheck.length < 0){
     alert('Sila tandakan sekurang-kurangnya satu satu rekod penerima');
     return false;
     }else{

     $.ajax({
     type: 'post',
     url: 'process.php',
     data: datastring + '&token='+$('#token').val(),
     success: function(html)
     {
     alert(html);
     location.reload();
     }
     });
     }
     });
     */


    /* checkbox and submit button */

    $('.deleteBtn').click(function(){
        var datacheck = $('.cb:checked').map(function(i,n){
            return $(n).val();
        }).get();

        if(confirm("Anda pasti untuk teruskan ?")){
            $.post("process_message.php",{
                    'addCB[]' : datacheck,
                    cmd:'DelAllMsgOutbox',
                    token:$('#token').val(),
                    type: "results"},
                function(data){
                    alert(data);
                    location.reload();
                });
        }else{
            return false;
        }
    });
    /* checkbox and submit button */

    $('.btnReload').click(function(){
        location.reload();
    });
});
function toggleChecked(status) {
    $("#checkboxes input").each( function() {
        $(this).attr("checked",status);
    });
}

function fnLoadVideo(videoid,filename){
    $('#video_id').val(videoid);
    $('#file_name').val(filename);
    var src = '../files/'+filename;
    $('#video-modal').modal('show');
    $('#video-modal video').attr('src', src);

}


function jsDelData(id,filename){

    var datastring = 'id='+id+'&filename='+filename;
    if(y = confirm('Anda pasti untuk teruskan?')){
        if(y){
            $.ajax({
                type: 'post',
                url: 'process_message.php',
                data: datastring +'&cmd=DelMsg',
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
                data: datastring +'&cmd=VerifyDataReport',
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
