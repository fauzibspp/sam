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
    $v_owner = $_SESSION['userid'];
    ?>
    <!-- modal 1 -->

    <!-- modal 1 -->

    <section id="main-content">
        <!-- start -->
        <section class="wrapper">
            <!--mail inbox start-->
            <div class="mail-box">

                <aside class="lg-side">
                    <div class="inbox-head">
                        <h3><i class="icon-external-link"></i> Draft</h3>

                        <form class="pull-right position" action="#">
                            <div class="input-append">
                                <input type="text"  placeholder="Search Mail" class="sr-input">
                                <button type="button" class="btn sr-btn"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="inbox-body">
                        <div class="mail-option">
                            <div class="chk-all">
                                <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                                <div class="btn-group" >
                                    <a class="btn mini all" href="#" data-toggle="dropdown">
                                        All
                                        <i class="icon-angle-down "></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"> None</a></li>
                                        <li><a href="#"> Read</a></li>
                                        <li><a href="#"> Unread</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="btn-group">
                                <a class="btn mini tooltips" href="#" data-toggle="dropdown" data-placement="top" data-original-title="Refresh">
                                    <i class=" icon-refresh"></i>
                                </a>
                            </div>
                            <div class="btn-group hidden-phone">
                                <a class="btn mini blue" href="#" data-toggle="dropdown">
                                    More
                                    <i class="icon-angle-down "></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"><i class="icon-pencil"></i> Mark as Read</a></li>
                                    <li><a href="#"><i class="icon-ban-circle"></i> Spam</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <a class="btn mini blue" href="#" data-toggle="dropdown">
                                    Move to
                                    <i class="icon-angle-down "></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"><i class="icon-pencil"></i> Mark as Read</a></li>
                                    <li><a href="#"><i class="icon-ban-circle"></i> Spam</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#"><i class="icon-trash"></i> Delete</a></li>
                                </ul>
                            </div>

                            <ul class="unstyled inbox-pagination">
                                <li><span>1-50 of 234</span></li>
                                <li>
                                    <a href="#" class="np-btn"><i class="icon-angle-left  pagination-left"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="np-btn"><i class="icon-angle-right pagination-right"></i></a>
                                </li>
                            </ul>
                        </div>
                        <table class="table table-inbox table-hover">
                            <tbody>
                            <?php
                            //connDB();
                            $qry = "SELECT messageid as id,sender_id as sender,receiver_id as receiver,SUBJECT AS subjects,created_at as created,
        is_read,has_attachments FROM email_inbox
        WHERE receiver_id='$v_owner' ORDER BY created_at DESC";

                            $rst = db_select($qry);

                            foreach($rst as $row_mail):

                                if($row_mail['is_read']==0){
                                    $subject = '<strong>'.$row_mail['subjects'].'</strong>';
                                    $icon_read = '<i class="icon-folder-close-alt"></i>';
                                }else{
                                    $subject = $row_mail['subjects'];
                                    $icon_read = '<i class="icon-folder-open-alt"></i>';
                                }

                                if($row_mail['has_attachments']==1){
                                    $attachment_clip = '<i class="icon-paper-clip"></i>';
                                    $mail_open = 'id='.$row_mail['id'].'&subject='.$row_mail['subjects'].'&from='.$row_mail['sender'].'&date='.$row_mail['created'].'&attach_file=Y';
                                    $mail_open = base64_url_encode($mail_open);
                                }else{
                                    $attachment_clip = "";
                                    $mail_open = 'id='.$row_mail['id'].'&subject='.$row_mail['subjects'].'&from='.$row_mail['sender'].'&date='.$row_mail['created'].'&attach_file=N';
                                    $mail_open = base64_url_encode($mail_open);
                                }

                                ?>
                                <tr class="unread">
                                    <td class="inbox-small-cells">
                                        <input type="checkbox" class="mail-checkbox">
                                    </td>
                                    <td class="inbox-small-cells"><?php echo $icon_read ?></td>
                                    <td class="view-message  dont-show"><?php echo $row_mail['sender'] ?></td>
                                    <td class="view-message "><a href="mail.inbox.open.php?url=<?php echo base64_encode($mail_open) ?>"><?php echo $subject ?></a> </td>
                                    <td class="view-message  inbox-small-cells"><?php echo $attachment_clip ?></td>
                                    <td class="view-message  text-right"><?php echo $row_mail['created'] ?></td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                            </tbody>
                        </table>
                    </div>
                </aside>
            </div>
            <!--mail inbox end-->
        </section>
        <!-- end --->
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

<!--script for this notification-->
<script src="js/notifications.js"></script>

<script type="text/javascript">
    $(document).ready(function(e) {

        $('#example1').dataTable( {} );

        $('.alert').hide();

        $(document).on("click", ".tambah", function () {
            $('#cmd').val('AddDataLocation');
            $("#myModalLabel").html("Tambah Data");
        });

        $('.simpan').click(function(){
            var datastring = $("#form1").serialize();
            if($('#Lokasi').val()==''){
                $('.alert').show();
                $('.lblMsg').html('Sila isikan data berikut.');
                $('#Lokasi').focus();
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



        var url = window.location;

        $('ul.sub a[href="'+ url +'"]').parent().addClass('active');
        $('ul.sub a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');
    });

    function jsEditData(id,sKey,sName,sNegeri){
        $(".modal-body #Id").val( id );
        $(".modal-body #Poskod").val( sKey );
        $(".modal-body #Lokasi").val( sName );
        $(".modal-body #negeri").val( sNegeri );
        $('#cmd').val('EditDataLocation');
        $("#myModalLabel").html("Pinda Data");
    }
    function jsDelData(id){

        var datastring = 'Id='+id;
        if(y = confirm('Anda pasti untuk teruskan?')){
            if(y){
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val()+'&cmd=DelDataLocation',
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
