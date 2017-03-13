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

    <title>Form Wizard</title>

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

<section id="main-content">
<section class="wrapper site-min-height">

<!-- page start-->

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <i class="icon-th-list"></i> Senarai Notis
            </header>
            <div class="panel-body">

                <div class="table-responsive adv-table">
                    <?php
                    $salt = 'm0h2014';
                    $token = sha1(mt_rand(1,1000000) . $salt);
                    $_SESSION['token'] = $token;
                    echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
                    ?>

                    <table  class="display table table-bordered table-striped" id="example1">
                        <thead>
                        <tr>
                            <td colspan="4"><button style="float: left;" type="button" class="sentBtn btn btn-danger" disabled=""><i class="icon-bitbucket"> Clear Notis</i> </button></td>
                        </tr>
                        <tr>
                            <th><input type="checkbox" onclick="toggleChecked(this.checked)" id="checkAll" /></th>
                            <th>Perihal Notis</th>
                            <th>Pelaku</th>
                            <th>Tarikh</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        //connDB();
                        $scheme_id =  $_SESSION['schemaid'];
                        if($_SESSION['groupid']==1){//pentadbir
                            $qry = "SELECT notice_id,notice_msg as msg,notice_actor_id,notice_created FROM notifications WHERE FIND_IN_SET(notice_typeid,'1') AND notice_status='seen' ORDER BY notice_created DESC";
                        }else{
                            $qry = "";
                        }
                        if(!empty($qry)){

                        $rst = db_select($qry);
                        foreach ($rst as $row){
                            ?>
                            <tr class="gradeX">
                                <td>

                                    <div id="checkboxes"><input type="checkbox" id="cbox" value="<?php echo $row['notice_id'] ?>" name="addCB[]" class="cb" /></div>

                                </td>
                                <td><?php echo $row['msg']?></td>
                                <td><?php echo $row['notice_actor_id'] ?></td>
                                <td><?php echo $row['notice_created'] ?></td>
                            </tr>
                        <?php }
                        
                        }
                        ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </section>
    </div>
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
<!--<script src="js/jquery.js"></script>-->
<script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.js"></script>
<!-- jquery.form submit -->
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
<!--notification script-->
<script src="js/notifications.js"></script>

<script type="text/javascript">

//step wizard
$(document).ready(function() {
    $('#example1').dataTable( {
        //"aaSorting": [[ 0, "asc" ]]
    } );

    var url = window.location;
    $('ul.sub a[href="'+ url +'"]').parent().addClass('active');
    $('ul.sub a').filter(function() {
        return this.href == url;
    }).parent().addClass('active');

    $('[data-load-remote]').on('click',function(e) {
        e.preventDefault();
        var $this = $(this);
        var remote = $this.data('load-remote');
        if(remote) {
            $($this.data('remote-target')).load(remote);
        }
    });
    /* checkbox and submit button */
    if($('#cbox').length==0){
        $('#checkAll:checkbox').prop('disabled',true);
    }else{
        $('#checkAll:checkbox').prop('disabled',false);
    }
    $('input:checkbox').change(function () {
        $('.sentBtn:button').prop('disabled', $('input:checkbox:checked').length == 0)
    });
    $('.sentBtn').click(function(){
        var datacheck = $('.cb:checked').map(function(i,n){
            return $(n).val();
        }).get();

        if(confirm("Anda pasti untuk teruskan ?")){
            //alert($('#token').val());
            $.post("process.php",{
                    'addCB[]' : datacheck,
                    cmd:'DeleteNoticeLog',
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
});
function toggleChecked(status) {
    $("#checkboxes input").each( function() {
        $(this).attr("checked",status);
    });

}
</script>


</body>
</html>
