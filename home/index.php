<?php include_once('../config/functions.php'); ?>
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


    <style>
        .uncompleted{
            -webkit-animation: bgblink 3s;  /* Chrome, Safari, Opera */
            -webkit-animation-iteration-count: infinite;  /* Chrome, Safari, Opera */
            font-weight: bolder;
        }
        @-webkit-keyframes bgblink {
            from {background-color: #fff;}
            50% {color:#cd0a0a}
            to {background-color: #fff;}

        }
        @keyframes bgblink {
            from {background-color: #fff;}
            50% {background-color:#cd0a0a}
            to {background-color: #fff;}
        }
        /*print*/
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
<?php
$userid = $_SESSION['userid'];
$hariini = fnSQLCustom('SELECT DATE_FORMAT(CURDATE(),"%d-%m-%Y")  AS hariini','hariini');
$currTime = fnSQLCustom('SELECT DATE_FORMAT(CURDATE(),"%r")  AS currTime','currTime');
$currMonth = date('m');
$prevYear = date('Y', strtotime('-1 year'));
$currYear = date('Y');
$en = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September','October','November', 'December');
$en_num = array('01','02','03','04','05','06','07','08','09','10','11','12');
$my = array('Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis');
$currMonth = str_ireplace($en_num,$my,$currMonth);
?>

<!--main content start-->
<section id="main-content">
<section class="wrapper">

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myFullApplicantModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Senarai</h4>
            </div>
            <div class="panel-body"><button id="btnPrint" class="btn btn-success btn-xs" type="button" style="float: right"> Cetak</button></div>
            <div class="modal-body" id="printThis"></div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default btn-xs" type="button">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--state overview start-->
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="icon-desktop"></i>
            </div>
            <div class="value">
                <h1 class="count">
                    <?php echo fnSQLCustom('SELECT COUNT(*) AS total_record FROM userlog WHERE logby="'.$userid.'" AND YEAR(logtime)="'.$currYear.'" AND logdesc="LOGIN SUCCESS"','total_record'); ?>
                </h1>
                <span class="text-primary">Jumlah Penggunaan</span>
                <span class="text-primary">Tahun <?php echo $currYear ?></span>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="icon-envelope"></i>
            </div>
            <div class="value">
                <h1 class=" count2">

                    <a href="mail.inbox.php">
                        <?php echo $total; //fnSQLCustom("select count(*) as total from email_inbox where is_read=0 and receiver_id='$userid'","total"); ?>

                    </a>
                </h1>
                <span class="text-primary">Inbox Mail</span>

            </div>
        </section>
    </div>

    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="icon-group"></i>
            </div>
            <div class="value">
                <h1 class=" count3">
                    <a href="#myFullApplicantModal" data-toggle="modal" onclick="jsLoadData('aho','<?php echo $_SESSION['userid'] ?>')">
                        <?php
                        echo fnSQLCustom('SELECT COUNT(*) AS total_record FROM userprofile where user_id<>"admin"','total_record');
                        ?>
                    </a>
                </h1>
                <span class="text-primary">Jumlah AHO</span>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="icon-group"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    <a href="#myFullApplicantModal" data-toggle="modal" onclick="jsLoadData('sumber','<?php echo $_SESSION['userid'] ?>')">
                        <?php
                        if($_SESSION['groupname']=='AHO'){
                            $where .= " WHERE m01_userid='".$_SESSION['userid']."'";
                        }
                        echo fnSQLCustom('SELECT COUNT(*) AS total_record FROM  m01_induk'.$where,'total_record');
                        ?>
                    </a>
                </h1>
                <span class="text-primary">Jumlah Sumber</span>
            </div>
        </section>
    </div>
</div>
<!--state overview end-->

<div class="row">

    <div class="col-lg-6">
        <!--custom chart start-->
        <div class="border-head">
            <h3>Carta Isu Pertemuan Bagi Tahun <?php echo $currYear ?></h3>
        </div>
        <div id="stat5"></div>


        <!--custom chart end-->
    </div>
    <div class="col-lg-6">
        <!--custom chart start-->
        <div class="border-head">
            <h3>Carta Kekerapan Menggunakan Sistem Bagi Tahun <?php echo $currYear ?></h3>
        </div>

        <section class="panel">
            <div class="panel-body">
                <div class="custom-bar-chart">
                    <ul class="y-axis">
                        <li><span>100</span></li>
                        <li><span>80</span></li>
                        <li><span>60</span></li>
                        <li><span>40</span></li>
                        <li><span>20</span></li>
                        <li><span>0</span></li>
                    </ul>
                    <?php

                    for($i=0; $i < count($my); $i++){

                        $data_login = fnSQLCustom('SELECT COUNT(*) AS total_record FROM userlog WHERE logby="'.$userid.'" AND YEAR(logtime)="'.$currYear.'" AND MONTH(logtime)="'.$en_num[$i].'" AND logdesc="LOGIN SUCCESS"','total_record');
                        //$data_login = (int)$data_login / 100;
                        echo '<div class="bar">
                                    <div class="title">'.$my[$i].'</div>
                                        <div class="value tooltips" data-original-title="'.$data_login.' kali" data-toggle="tooltip" data-placement="top">'.$data_login.'</div>
                                  </div>';
                    }
                    ?>

                </div>
            </div>
        </section>


<!--        custom chart end-->
    </div>

</div>


<br>
<div class="row state-overview">
    <section class="panel col-lg-12">
        <div class="revenue-head">
                                  <span>
                                      <i class="icon-bar-chart"></i>
                                  </span>
            <h3>Carta Pie </h3>
                                  <span class="rev-combo pull-right">
                                     <?php echo $currYear ?>
                                  </span>
        </div>
    </section>
<!--    <div class="col-lg-3 col-sm-6">-->
<!--        <section class="panel">-->
<!--            <!-- statistic -->
<!--            <div id="stat1" style="min-width: 200px; height: 200px; margin: 0 auto"></div>-->
<!--            <!-- statistic -->
<!---->
<!--        </section>-->
<!--    </div>-->
    <div class="col-md-4">
        <section class="panel">
            <!-- statistic -->
            <div id="stat2" style="min-width: 200px; height: 200px; margin: 0 auto"></div>
            <!-- statistic -->
        </section>
    </div>

    <div class="col-md-4">
        <section class="panel">
            <!-- statistic -->
            <div id="stat3" style="min-width: 200px; height: 200px; margin: 0 auto"></div>
            <!-- statistic -->
        </section>
    </div>
    <div class="col-md-4">
        <section class="panel">
            <!-- statistic -->
            <div id="stat4" style="min-width: 200px; height: 200px; margin: 0 auto"></div>
            <!-- statistic -->
        </section>
    </div>
</div>

    <div class="row">
        <div class="col-lg-12">
            <div id="stat6"></div>
        </div>
    </div>




<div class="row">
    <div class="col-lg-12">
        <!--work progress start-->
        <!--timeline start-->
        <section class="panel">
            <div class="revenue-head">
                                  <span>
                                      <i class="icon-bar-chart"></i>
                                  </span>
                <h3>Timeline Bulan <?php echo $currMonth ?></h3>
                                  <span class="rev-combo pull-right">
                                     <?php echo $currMonth.' '.$currYear ?>
                                  </span>
            </div>
            <div class="panel-body">

                <?php

                #$items_per_group = 5;
                #$total_records = fnSQLCustom("SELECT COUNT(*) AS t_records from log_activity WHERE log_userid='$userid' AND DATE_FORMAT(log_created,'%d-%m-%Y')='$hariini'",'t_records');
                #$total_groups  = ceil($total_records/$items_per_group);

                $qry_log = "SELECT DATE_FORMAT(log_created,'%d') AS day_num,
                DATE_FORMAT(log_created,'%M') as month_name,
                DAYNAME(log_created) as day_name, DATE_FORMAT(log_created,'%r') AS log_time,
                log_event FROM log_activity WHERE log_userid='$userid' and year(log_created)=year(CURRENT_TIMESTAMP) AND MONTH(log_created)=MONTH(CURRENT_TIMESTAMP ) order by log_created desc";
                $rst = db_select($qry_log);

                ?>

                <div class="timeline">
                    <?php
                    $i=0;

                        foreach ($rst as $row){

                        $month_name = str_ireplace($en, $my, $row['month_name']);
                        if($row['day_name']=='Sunday'){
                            $day_name = 'Ahad';
                        }else if($row['day_name']=='Monday'){
                            $day_name = 'Isnin';
                        }else if($row['day_name']=='Tuesday'){
                            $day_name = 'Selasa';
                        }else if($row['day_name']=='Wednesday'){
                            $day_name = 'Rabu';
                        }else if($row['day_name']=='Thursday'){
                            $day_name = 'Khamis';
                        }else if($row['day_name']=='Friday'){
                            $day_name = 'Jumaat';
                        }else if($row['day_name']=='Saturday'){
                            $day_name = 'Sabtu';
                        }
                        if($i%2 == 0)
                        {
                            $class1 = 'timeline-item';
                            $class2 = 'timeline-desk';
                            $class3 = 'arrow';
                            $class4 = 'timeline-icon red';
                            $class5 = 'timeline-date';
                            $class6 = 'red';
                            echo '<article class="'.$class1.'">
                                <div class="'.$class2.'">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <span class="'.$class3.'"></span>
                                            <span class="'.$class4.'"></span>
                                            <span class="'.$class5.'">'.$row['log_time'].'</span>
                                            <h1 class="'.$class6.'">'.$row['day_num'].'&nbsp;'.$month_name.' | '.$day_name.'</h1>
                                            <p>'.$row['log_event'].'</p>
                                        </div>
                                    </div>
                                </div>
                            </article>';

                        }else{
                            $class1 = 'timeline-item alt';
                            $class2 = 'timeline-desk';
                            $class3 = 'arrow alt';
                            $class4 = 'timeline-icon green';
                            $class5 = 'timeline-date';
                            $class6 = 'green';
                            echo '<article class="'.$class1.'">
                                <div class="'.$class2.'">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <span class="'.$class3.'"></span>
                                            <span class="'.$class4.'"></span>
                                            <span class="'.$class5.'">'.$row['log_time'].'</span>
                                            <h1 class="'.$class6.'">'.$row['day_num'].'&nbsp;'.$month_name.' | '.$day_name.'</h1>
                                            <p>'.$row['log_event'].'</p>
                                        </div>
                                    </div>
                                </div>
                            </article>';
                        }
                        $i++;
                    }
                    ?>

                </div>

                <div class="clearfix">&nbsp;</div>
            </div>
        </section>
        <!--timeline end-->
        <!--work progress end-->
    </div>
</div>
</section>
</section>
<!--main content end-->



<!--footer start-->
<?php include_once("footer.php") ?>
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

<script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="js/respond.min.js" ></script>
<script src="js/jquery.validate.min.js" ></script>

<!--common script for all pages-->
<script src="js/common-scripts.js"></script>
<script src="js/notifications.js"></script>
<!--highchart-->
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    //--------------------------chart by kor
//    var optionsA = {
//        chart: {
//            renderTo: 'stat1',
//            plotBackgroundColor: null,
//            plotBorderWidth: null,
//            plotShadow: false
//        },
//        title: {
//            text: 'Mengikut Kor'
//        },
//        tooltip: {
//            formatter: function() {
//                return '<b>'+ this.point.name +'</b>: '+ parseFloat(this.percentage).toFixed(2) +' %'+'<br/>Total: '+this.y;
//            }
//        },
//        plotOptions: {
//            pie: {
//                allowPointSelect: true,
//                cursor: 'pointer',
//                dataLabels: {
//                    enabled: true,
//                    color: '#000000',
//                    connectorColor: '#000000',
//                    formatter: function() {
//
//                        return '<b>'+ this.point.name +'</b>: '+ parseFloat(this.percentage).toFixed(2) +' %'+'<br/>Total: '+this.y;
//
//                    }
//                }
//            }
//        },
//        series: [{
//            type: 'pie',
//            name: 'Browser share',
//            point:{
//                events:{
//                    click:function(){
//                        //alert('Name:'+ this.name + '  Value:'+ this.y + '  Id: ' + this.x);
//                        //loadPopup(this.name,this.x,this.y);
//                    }
//                }
//            },
//            data: []
//        }]
//    }
//
//    $.getJSON("stat.bycorp_json.php", function(json) {
//        optionsA.series[0].data = json;
//        chart = new Highcharts.Chart(optionsA);
//    });
    //--------------------------chart category
    var optionsB = {
        chart: {
            renderTo: 'stat2',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Mengikut Jantina'
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ parseFloat(this.percentage).toFixed(2) +' %'+'<br/>Total: '+this.y;
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ parseFloat(this.percentage).toFixed(2) +' %'+'<br/>Total: '+this.y;
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            point:{
                events:{
                    click:function(){
                        //alert('Name:'+ this.name + '  Value:'+ this.y + '  Id: ' + this.x);
                        //loadPopup(this.name,this.x,this.y);
                    }
                }
            },
            data: []
        }]
    }

    $.getJSON("stat.bygender_json.php", function(json) {
        optionsB.series[0].data = json;
        chart = new Highcharts.Chart(optionsB);
    });
    //--------------------------chart type
    var optionsC = {
        chart: {
            renderTo: 'stat3',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Mengikut Bangsa'
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ parseFloat(this.percentage).toFixed(2) +' %'+'<br/>Total: '+this.y;
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ parseFloat(this.percentage).toFixed(2) +' %'+'<br/>Total: '+this.y;
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            point:{
                events:{
                    click:function(){
                        //alert('Name:'+ this.name + '  Value:'+ this.y + '  Id: ' + this.x);
                        //loadPopup(this.name,this.x,this.y);
                    }
                }
            },
            data: []
        }]
    }

    $.getJSON("stat.byrace_json.php", function(json) {
        optionsC.series[0].data = json;
        chart = new Highcharts.Chart(optionsC);
    });
    //==============chart by agama
    var optionsD = {
        chart: {
            renderTo: 'stat4',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Mengikut Agama'
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ parseFloat(this.percentage).toFixed(2) +' %'+'<br/>Total: '+this.y;
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ parseFloat(this.percentage).toFixed(2) +' %'+'<br/>Total: '+this.y;
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            point:{
                events:{
                    click:function(){
                        //alert('Name:'+ this.name + '  Value:'+ this.y + '  Id: ' + this.x);
                        //loadPopup(this.name,this.x,this.y);
                    }
                }
            },
            data: []
        }]
    }

    $.getJSON("stat.byreligion_json.php", function(json) {
        optionsD.series[0].data = json;
        chart = new Highcharts.Chart(optionsD);
    });
    //=================================================
//    $.getJSON("stat.byrace_json.php", function(json) {
//        optionsC.series[0].data = json;
//        chart = new Highcharts.Chart(optionsC);
//    });
    //==============chart by isu
    var optionsE = {
        chart: {
            renderTo: 'stat5',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Mengikut Isu Pertemuan'
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.point.name +'</b>: '+ parseFloat(this.percentage).toFixed(2) +' %'+'<br/>Total: '+this.y;
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ parseFloat(this.percentage).toFixed(2) +' %'+'<br/>Total: '+this.y;
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            point:{
                events:{
                    click:function(){
                        //alert('Name:'+ this.name + '  Value:'+ this.y + '  Id: ' + this.x);
                        loadPopup('isu','<?php echo $_SESSION['userid'] ?>',this.name,this.x);
                    }
                }
            },
            data: []
        }]
    }

    $.getJSON("stat.byisu_json.php", function(json) {
        optionsE.series[0].data = json;
        chart = new Highcharts.Chart(optionsE);
    });
    //=====================================================


    var optionsF =
    {
        chart: {
            renderTo: 'stat6',
            defaultSeriesType: 'spline'
        },
        title: {
            text: 'Kekerapan Pertemuan Mengikut AHO Tahun 2016'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category',
            categories: [],
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            title: {
                text: 'Kekerapan Pertemuan'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        plotOptions: {
            spline: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
//        tooltip: {
//            formatter: function() {
//                return '<b>'+ this.series.name +'</b><br/>'+
//                    this.x +': '+ this.y;
//            }
//        },
        series: [{}]
    }
    var url ="stat.byaho_json.php";

    $.getJSON(url, function(json) {

        optionsF.xAxis.categories = json[0]['data'];

        for(var i=0; i < json.length - 1; i++){
            optionsF.series[i] = json[i+1];
        }

        var chart = new Highcharts.Chart(optionsF);
    });

    $('#example1').dataTable( { } );

    $('#myFullApplicantModal').on('shown.bs.modal', function () {
        $(this).find('.modal-dialog').css({width:'auto',
            height:'auto',
            'max-height':'100%'});
    });

    /* checkbox and submit button */
    document.getElementById("btnPrint").onclick = function() {
        printElement(document.getElementById("printThis"));
        //printElement(document.getElementById("printThisToo"), true, "<hr />");
        $("#sidebar").hide();
        loadPrint();
    }
});


function loadPopup(filter,owner,queryby, x){


    $("#myFullApplicantModal").modal();
    $("#myFullApplicantModal .modal-body").html('<img src="img/loading.gif">');
    $.ajax({//make the Ajax Request
        type: 'post',
        url: 'inc/data-general-list.php',
        data: {filter:filter, owner:owner, queryby:queryby, x:x},
        success: function(html)
        {
            //alert(html);
            $("#myFullApplicantModal .modal-body").html(html);
        }//end success
    }); //end ajax
}

function jsLoadData(filter,owner){
    //filter='aho'; owner='admin'
    $("#myFullApplicantModal .modal-body").html('<img src="img/loading.gif">');
    $.ajax({//make the Ajax Request
        type: 'post',
        url: 'inc/data-general-list.php',
        data: {filter:filter, owner:owner},
        success: function(html)
        {
            //alert(html);
            $("#myFullApplicantModal .modal-body").html(html);
        }//end success
    }); //end ajax
}
function jsLoadDataLog(status,owner,group,skim){
    $("#myFullApplicantModal .modal-body").html('<img src="img/loading.gif">');
    $.ajax({//make the Ajax Request
        type: 'post',
        url: '../inc/data-logevent-list.php',
        data: {status:status, owner:owner, group:group, skim:skim},
        success: function(html)
        {
            //alert(html);
            $("#myFullApplicantModal .modal-body").html(html);
        }//end success
    }); //end ajax
}
function loadPrint() {
    window.print();
    setTimeout(function () { window.close(); }, 100);
    $("#sidebar").show();
}
function printElement(elem, append, delimiter) {
    var domClone = elem.cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }

    if (append !== true) {
        $printSection.innerHTML = "";
    }

    else if (append === true) {
        if (typeof(delimiter) === "string") {
            $printSection.innerHTML += delimiter;
        }
        else if (typeof(delimiter) === "object") {
            $printSection.appendChlid(delimiter);
        }
    }

    $printSection.appendChild(domClone);
}
</script>
</body>
</html>
