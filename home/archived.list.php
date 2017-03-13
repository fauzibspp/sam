?php include_once('../config/config.php');
?>
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

    <!-- Custom styles for editor -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/froala_editor.min.css" rel="stylesheet" type="text/css">

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
                <i class="icon-th-list"></i> Senarai Arkib
            </header>
            <div class="panel-body">
                <?php
                $salt = 'm0h2014';
                $token = sha1(mt_rand(1,1000000) . $salt);
                $_SESSION['token'] = $token;
                echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
                ?>

                <!--tab nav start-->
                <section class="panel">
                    <header class="panel-heading tab-bg-dark-navy-blue">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#a">
                                    <i class="icon-book"></i>
                                    Topik
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#b">
                                    <i class="icon-table"></i>
                                    JSU
                                </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#c">
                                    <i class="icon-file-text"></i>
                                    Soalan
                                </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#d">
                                    <i class="icon-file-text"></i>
                                    Set Soalan
                                </a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="a" class="tab-pane active">
                                <!-- div a -->
                                <div class="table-responsive adv-table">

                                    <table  class="display table table-bordered table-striped" id="example1">
                                        <thead>
                                        <tr>
                                            <th colspan="3">

                                                <button type="button" class="btnRestoreA btn btn-info"><i class="icon-reply"> Restore</i></button>
                                                <button type="button" class="btnDeleteA btn btn-danger"><i class="icon-bitbucket"> Padam</i></button>
                                                &nbsp;

                                            </th>
                                        </tr>
                                        <tr>
                                            <th><input type="checkbox" onclick="toggleChecked(this.checked)" id="checkAll" /></th>
                                            <th>Topik</th>
                                            <th>Skim</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        connDB();

                                        $qry = "SELECT t.topic_id,t.topic_name,s.scheme_name,t.userid from topic as t left join scheme as s
                                        on s.scheme_id = t.topic_scheme_id WHERE t.topic_active = 0 ORDER By s.scheme_name ASC";
                                        $rst = mysql_query($qry) Or Die('Error No:'.mysql_errno().' Desc:'.mysql_error());
                                        while($row = mysql_fetch_assoc($rst)){
                                            ?>
                                            <tr class="gradeX">
                                                <td><div id="checkboxes"><input type="checkbox" id="cbox" value="<?php echo $row['topic_id'] ?>" name="addCB[]" class="cb" /></div></td>
                                                <td><?php echo $row['topic_name'] ?></td>
                                                <td><?php echo $row['scheme_name'] ?><div class="text-muted"><?php echo $row['userid'] ?></div> </td>
                                            </tr>
                                        <?php }
                                        mysql_free_result($rst);
                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                                <!-- div a -->
                            </div>
                            <div id="b" class="tab-pane">
                                <!-- div b -->
                                <div class="table-responsive adv-table">

                                    <table  class="display table table-bordered table-striped" id="example2">
                                        <thead>
                                        <tr>
                                            <th colspan="3">

                                                <button type="button" class="btnRestoreB btn btn-info"><i class="icon-reply"> Restore</i></button>
                                                <button type="button" class="btnDeleteB btn btn-danger"><i class="icon-bitbucket"> Padam</i></button>
                                                &nbsp;

                                            </th>
                                        </tr>
                                        <tr>
                                            <th><input type="checkbox" onclick="toggleChecked(this.checked)" id="checkAll" /></th>
                                            <th>Topik</th>
                                            <th>Skim</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        connDB();

                                        $qry = "SELECT j.jsu_id,j.jsu_scheme_set,s.scheme_name, j.userid FROM jsu_master AS j
                                        LEFT JOIN scheme AS s ON s.scheme_id = j.jsu_scheme_id WHERE jsu_scheme_status = 99
                                        ORDER BY j.jsu_scheme_name ASC";
                                        $rst = mysql_query($qry) Or Die('Error No:'.mysql_errno().' Desc:'.mysql_error());
                                        while($row = mysql_fetch_assoc($rst)){
                                            ?>
                                            <tr class="gradeX">
                                                <td><div id="checkboxes"><input type="checkbox" id="cbox" value="<?php echo $row['jsu_id'] ?>" name="addCB[]" class="cb" /></div></td>
                                                <td><?php echo $row['jsu_scheme_set'] ?></td>
                                                <td><?php echo $row['scheme_name'] ?><span class="text-muted"><br/><?php echo $row['userid'] ?></span></td>
                                            </tr>
                                        <?php }
                                        mysql_free_result($rst);
                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                                <!-- div b -->
                            </div>
                            <div id="c" class="tab-pane">
                                <!-- div c -->
                                <div class="table-responsive adv-table">

                                    <table  class="display table table-bordered table-striped" id="example3">
                                        <thead>
                                        <tr>
                                            <th colspan="3">

                                                <button type="button" class="btnRestoreC btn btn-info"><i class="icon-reply"> Restore</i></button>
                                                <button type="button" class="btnDeleteC btn btn-danger"><i class="icon-bitbucket"> Padam</i></button>
                                                &nbsp;

                                            </th>
                                        </tr>
                                        <tr>
                                            <th><input type="checkbox" onclick="toggleChecked(this.checked)" id="checkAll" /></th>
                                            <th>Soalan</th>
                                            <th>Skim</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        connDB();

                                        $qry = "SELECT q.question_id,q.question_name,s.scheme_name,q.question_author FROM questions AS q
                                        LEFT JOIN scheme AS s ON s.scheme_id = q.scheme_id WHERE q.question_status=99
                                        ORDER BY q.question_name asc";
                                        $rst = mysql_query($qry) Or Die('Error No:'.mysql_errno().' Desc:'.mysql_error());
                                        while($row = mysql_fetch_assoc($rst)){
                                            $soalan = AesCtr::decrypt($row['question_name'], 'inTelIn$ideCorei5', 256);
                                            $soalan = base64_decode($soalan);
                                            ?>
                                            <tr class="gradeX">
                                                <td><div id="checkboxes"><input type="checkbox" id="cbox" value="<?php echo $row['question_id'] ?>" name="addCB[]" class="cb" /></div></td>
                                                <td><?php echo $soalan ?></td>
                                                <td><?php echo $row['scheme_name'] ?>
                                                <div class="text-muted"><?php echo $row['question_author'] ?></div>
                                                </td>
                                            </tr>
                                        <?php }
                                        mysql_free_result($rst);
                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                                <!-- div c -->
                            </div>

                            <div id="d" class="tab-pane">
                                <!-- div d -->
                                <div class="table-responsive adv-table">

                                    <table  class="display table table-bordered table-striped" id="example4">
                                        <thead>
                                        <tr>
                                            <th colspan="3">

                                                <button type="button" class="btnRestoreD btn btn-info"><i class="icon-reply"> Restore</i></button>
                                                <button type="button" class="btnDeleteD btn btn-danger"><i class="icon-bitbucket"> Padam</i></button>
                                                &nbsp;

                                            </th>
                                        </tr>
                                        <tr>
                                            <th><input type="checkbox" onclick="toggleChecked(this.checked)" id="checkAll" /></th>
                                            <th>Nama Set</th>
                                            <th>Skim</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        connDB();
                                        $qry = "SELECT qs.questions_set_id,qs.questions_set_name, qs.userid, s.scheme_name,u.user_name FROM
                                        questions_set AS qs LEFT JOIN scheme AS s
                                        ON qs.scheme_id = s.scheme_id
                                        LEFT JOIN userprofile AS u ON u.user_id = qs.userid
                                        WHERE qs.questions_set_status = 99 ORDER BY qs.questions_set_created desc";

                                        $rst = mysql_query($qry) Or Die('Error No:'.mysql_errno().' Desc:'.mysql_error());
                                        while($row = mysql_fetch_assoc($rst)){
                                            ?>
                                            <tr class="gradeX">
                                                <td><div id="checkboxes"><input type="checkbox" id="cbox" value="<?php echo $row['questions_set_id'] ?>" name="addCB[]" class="cb" /></div></td>
                                                <td><?php echo $row['questions_set_name'] ?><span class="text-muted"><?php echo $row['userid'] ?></span> </td>
                                                <td><?php echo $row['scheme_name'] ?><br/>
                                                    <div class="text-muted"><?php echo $row['userid'] ?></div>
                                                </td>
                                            </tr>
                                        <?php }
                                        mysql_free_result($rst);
                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                                <!-- div d -->
                            </div>
                        </div>
                    </div>
                </section>
                <!--tab nav start-->






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

<!--script for editor -->
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




    $('#example1').dataTable( { } );
    $('#example2').dataTable( { } );
    $('#example3').dataTable( { } );
    $('#example4').dataTable( { } );


    /* checkbox and submit button */
    if($('#cbox').length==0){
        $('#checkAll:checkbox').prop('disabled',true);
    }else{
        $('#checkAll:checkbox').prop('disabled',false);
    }
    $('input:checkbox').change(function () {
        $('.sentBtn:button').prop('disabled', $('input:checkbox:checked').length == 0)
    });

    $('.btnRestoreA').click(function(e){
        e.preventDefault();
        var datacheck = $('.cb:checked').map(function(){
           return $(this).val();
        }).get();
        if(datacheck==''){
            alert('Sila tanda sekurang-kurangnya satu rekod');
        }else{
            if(confirm("Anda pasti untuk teruskan ?")){
                $.post("process.php",{
                        'addCB[]' : datacheck,
                        cmd:'RestoreDataTopic',
                        token:$('#token').val(),
                        type: "results"},
                    function(data){
                        alert(data);
                        location.reload();
                    });
            }else{
                return false;
            }
        }
    });
    $('.btnDeleteA').click(function(e){
        e.preventDefault();
        var datacheck = $('.cb:checked').map(function(){
            return $(this).val();
        }).get();
        if(datacheck==''){
            alert('Sila tanda sekurang-kurangnya satu rekod');
        }else{
            if(confirm("Anda pasti untuk teruskan ?")){
                $.post("process.php",{
                        'addCB[]' : datacheck,
                        cmd:'DeleteDataTopic',
                        token:$('#token').val(),
                        type: "results"},
                    function(data){
                        alert(data);
                        location.reload();
                    });
            }else{
                return false;
            }
        }
    });

    $('.btnRestoreB').click(function(e){
        e.preventDefault();
        var datacheck = $('.cb:checked').map(function(){
            return $(this).val();
        }).get();
        if(datacheck==''){
            alert('Sila tanda sekurang-kurangnya satu rekod');
        }else{
            if(confirm("Anda pasti untuk teruskan ?")){
                $.post("process.php",{
                        'addCB[]' : datacheck,
                        cmd:'RestoreDataJSU',
                        token:$('#token').val(),
                        type: "results"},
                    function(data){
                        alert(data);
                        location.reload();
                    });
            }else{
                return false;
            }
        }
    });

    $('.btnDeleteB').click(function(e){
        e.preventDefault();
        var datacheck = $('.cb:checked').map(function(){
            return $(this).val();
        }).get();
        if(datacheck==''){
            alert('Sila tanda sekurang-kurangnya satu rekod');
        }else{
            if(confirm("Anda pasti untuk teruskan ?")){
                $.post("process.php",{
                        'addCB[]' : datacheck,
                        cmd:'DeleteDataJSU',
                        token:$('#token').val(),
                        type: "results"},
                    function(data){
                        alert(data);
                        location.reload();
                    });
            }else{
                return false;
            }
        }
    });

    $('.btnRestoreC').click(function(e){
        e.preventDefault();
        var datacheck = $('.cb:checked').map(function(){
            return $(this).val();
        }).get();
        if(datacheck==''){
            alert('Sila tanda sekurang-kurangnya satu rekod');
        }else{
            if(confirm("Anda pasti untuk teruskan ?")){
                $.post("process.php",{
                        'addCB[]' : datacheck,
                        cmd:'RestoreDataQuestion',
                        token:$('#token').val(),
                        type: "results"},
                    function(data){
                        alert(data);
                        location.reload();
                    });
            }else{
                return false;
            }
        }
    });
    $('.btnDeleteC').click(function(e){
        e.preventDefault();
        var datacheck = $('.cb:checked').map(function(){
            return $(this).val();
        }).get();
        if(datacheck==''){
            alert('Sila tanda sekurang-kurangnya satu rekod');
        }else{
            if(confirm("Anda pasti untuk teruskan ?")){
                $.post("process.php",{
                        'addCB[]' : datacheck,
                        cmd:'DeleteDataQuestion',
                        token:$('#token').val(),
                        type: "results"},
                    function(data){
                        alert(data);
                        location.reload();
                    });
            }else{
                return false;
            }
        }
    });
    //=========
    $('.btnRestoreD').click(function(e){
        e.preventDefault();
        var datacheck = $('.cb:checked').map(function(){
            return $(this).val();
        }).get();
        if(datacheck==''){
            alert('Sila tanda sekurang-kurangnya satu rekod');
        }else{
            if(confirm("Anda pasti untuk teruskan ?")){
                $.post("process.php",{
                        'addCB[]' : datacheck,
                        cmd:'RestoreDataQuestionSet',
                        token:$('#token').val(),
                        type: "results"},
                    function(data){
                        alert(data);
                        location.reload();
                    });
            }else{
                return false;
            }
        }
    });
    $('.btnDeleteD').click(function(e){
        e.preventDefault();
        var datacheck = $('.cb:checked').map(function(){
            return $(this).val();
        }).get();
        if(datacheck==''){
            alert('Sila tanda sekurang-kurangnya satu rekod');
        }else{
            if(confirm("Anda pasti untuk teruskan ?")){
                $.post("process.php",{
                        'addCB[]' : datacheck,
                        cmd:'DeleteDataQuestionSet',
                        token:$('#token').val(),
                        type: "results"},
                    function(data){
                        alert(data);
                        location.reload();
                    });
            }else{
                return false;
            }
        }
    });

    /* checkbox and submit button */


});
function jsEditData(cmd,kodsoalan,kodskim,kodtopik,kodaras,kodjenis,soalan,jawapansoalan)
{
    if($("#row1").hide()){
        $("#row1").show();
        $("#row2").hide();
    }

    $('#cmd').val(cmd);
    $('#kodsoalan').val(kodsoalan);
    $('#skim').val(kodskim)
    //--------
    $("#chain_select").html('<img src="img/loading.gif">');
    $.ajax({//make the Ajax Request
        type: 'post',
        url: '../inc/datatopik.php',
        data: 'id='+kodskim+'&id_topic='+kodtopik,
        success: function(html)
        {
            //alert(html);
            $("#chain_select").html(html);
        }//end success
    }); //end ajax
    //--------
    $('#kognitif').val(kodaras);
    $('#jenissoalan').val(kodjenis);
    if(kodjenis==1){            //objektif
        $("#jawapan_soalan").show();
        $("#jawapan_soalan").val(jawapansoalan);
        $("#div_obj").show();
        //multiple textarea

        $(document).ready(function()
        {
            $.getJSON('../inc/dataobj.php', { id: kodsoalan }, function(data) {
                var data_length = data.length;
                for(var i=0; i < data_length; i++){
                    //$('#index_obj'+i).val(data[i]['kod_obj']);
                    $('#jawapan_obj'+i).editable("setHTML", data[i]['jawapan_obj'], true);
                }
            });

        });
        $("#div_essei").hide();
    }else if(kodjenis==2){      //essei
        $("#jawapan_soalan").hide();
        $("#jawapan_soalan").removeAttr('required');
        $("#div_essei").show();
        $('#jawapan_essei').editable("setHTML", jawapansoalan, true);
        $("#div_obj").hide();
    }else{
        $("#div_obj").hide();
        $("#div_essei").hide();
        $("#jawapan_soalan").hide();
    }
    $('#soalan').editable("setHTML", soalan, true);
    $('#btnCancel').show();
}

function jsDelData(cmd,kodsoalan,jenissoalan){
    if(confirm("Anda pasti untuk teruskan?")){
        $.post("process.php",{
                kodsoalan : kodsoalan,
                jenissoalan : jenissoalan,
                cmd:cmd,
                token:$('#token').val(),
                type: "results"},
            function(data){
                alert(data);
                location.reload();
            });
    }else{
        return false;
    }
}
function jsAddDataAnswer(cmd,kodsoalan,kodjawapan){
    // alert(kodjawapan);
    if(kodjawapan==1){
        if($('#div-answer-essei').show()){
            $('#div-answer-essei').hide();
        }
        $('#cmd').val(cmd);
        $('#kodsoalan_obj').val(kodsoalan);
        $('#no_soalan_obj').text(kodsoalan);
        $('#div-answer-obj').show();

    }else if(kodjawapan==2){
        if($('#div-answer-obj').show()){
            $('#div-answer-obj').hide();
        }
        $('#cmd').val(cmd);
        $('#kodsoalan_essei').val(kodsoalan);
        $('#no_soalan_essei').text(kodsoalan);
        $('#div-answer-essei').show();
    }
}
function toggleChecked(status) {
    $("#checkboxes input").each( function() {
        $(this).attr("checked",status);
    });

}

</script>


</body>
</html>
