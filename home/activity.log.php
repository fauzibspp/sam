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

    <!-- Custom styles for editor -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/froala_editor.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
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
        <section class="wrapper site-min-height">
            <!-- start modal 1 -->
            <!-- end modal 1 -->
            <!-- start modal 2 -->

            <!-- end modal 2 -->
            <!-- page start-->
            <div class="row" id="row1">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <i class="icon-th-list"></i> Senarai Log Aktiviti Keseluruhan Pengguna
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
                                        <th colspan="12">
                                            <button style="float: left;" type="button" class="sentBtn btn btn-danger" disabled /><i class="icon-bitbucket"> Padam</i> </button>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th><input type="checkbox" onclick="toggleChecked(this.checked)" id="checkAll" /></th>
                                        <th>Aktiviti/Pengguna</th>
                                        <th>Tarikh</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    //connDB();
                                    $userid = $_SESSION['userid'];
                                    $qry = "SELECT
                                        log_id,log_event,log_created,log_userid
                                        from log_activity WHERE date_format(log_created,'%Y-%m-%d') = CURRENT_DATE
                                        order by log_userid,log_created DESC
                                        ";

                                    $rst = db_select($qry);
                                    foreach ($rst as $row){
                                        ?>
                                        <tr class="gradeX">
                                            <td>

                                                <div id="checkboxes"><input type="checkbox" id="cbox" value="<?php echo $row['log_id'] ?>" name="addCB[]" class="cb" /></div>

                                            </td>
                                            <td>
                                                <?php echo $row['log_event']  ?><br>
                                                <span class="text-muted"><?php echo $row['log_userid'] ?></span>
                                            </td>
                                            <td><?php echo $row['log_created'] ?></td>

                                        </tr>
                                    <?php }
                                   
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


        $('#example1').dataTable( {
            //"aaSorting": [[ 0, "asc" ]]
        } );


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
                        cmd:'DeleteActivityLog',
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
