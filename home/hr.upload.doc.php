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
if($_GET['filecategory']==1){
    $title = "Upload Gambar";
}else if($_GET['filecategory']==2){
    $title = "Upload File";
}
?>

<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">

                <section class="panel">
                    <div class="inbox-head">
                        <h3><i class="icon-upload"></i> <?php echo $title ?></h3>
                    </div>
                    <header class="panel-heading">
                        *Sila masukkan semua maklumat dibawah dan klik butang "Upload"
                    </header>

                    <div class="panel-body">
                        <div class="input-group-btn">
                            <button id="btnback" class="btn btn-default"><i class="icon-backward"></i> Kembali</button>
                            <button style="float: right" type="button" id="startUpload" class="finish btn btn-success form-inline"><i class="icon-upload"></i> Upload</button>
                        </div>

                        <div id="result"></div>
                        <div id="loading"></div>

                            <input type="hidden" name="id" id="id" value=""/>
                            <input type="hidden" name="cmd" id="cmd" value="AddDataDoc"/>
                            <input type="hidden" name="kod_sumber" id="kod_sumber" value="<?php echo $_GET['kodsumber'] ?>"/>
                            <input type="hidden" name="nokpbaru" id="nokpbaru" value="<?php echo $_GET['nokpbaru'] ?>"/>
                            <input type="hidden" name="notentera" id="notentera" value="<?php echo $_GET['notentera'] ?>"/>
                            <input type="hidden" name="filecategory" id="filecategory" value="<?php echo $_GET['filecategory'] ?>"/>

                            <div class="modal-body">

                                <div class="form-group">
                                    <form class="dropzone" id="mulitplefileuploader">
                                        <i class="icon-upload">  </i><span>File...</span>
                                    </form>
                                    <div id="status"></div>
                                </div>

                            </div>

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

<!--script for this notification-->
<script src="js/notifications.js"></script>

<!-- upload multiple -->
<script src="assets/uploadmulti/jquery.fileuploadmulti.js"></script>
<script src="assets/tiles/js/jquery.magnific-popup.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(e) {
        $('#btnback').click(function(){
            location.href='hr.view.employee.php?kodsumber=<?php echo $_GET['kodsumber'] ?>&notentera=<?php echo $_GET['notentera'] ?>&nokpbaru=<?php echo $_GET['nokpbaru'] ?>';
        });
        $('#example1').dataTable( {} );

        //---
        var uploadObj = $("#mulitplefileuploader").uploadFile({
            url:"process.php",
            method: "POST",
            multiple:true,
            onSuccess:function(files,data,xhr)
            {
                //alert(data);
                $("#status").html("<font color='green'>Upload is success</font>");
            },
            afterUploadAll:function()
            {
                alert("Proses upload berjaya!!");
                location.href='hr.view.employee.php?kodsumber=<?php echo $_GET['kodsumber'] ?>&notentera=<?php echo $_GET['notentera'] ?>&nokpbaru=<?php echo $_GET['nokpbaru'] ?>';
            },
            onError: function(files,status,errMsg)
            {
                $("#status").html("<font color='red'>Upload is Failed</font>");
            },
            autoSubmit:false,
            fileName:"myfile",
            allowedTypes:"pdf,jpg",
            maxFileSize:1024*1024*12000,
            maxFileCount:1,
            dynamicFormData: function()
            {
                var data ={ cmd:"AddDataDoc","dir_owner":$('#kod_sumber').val(),"file_category":$('#filecategory').val()}
                return data;
            },
            showStatusAfterSuccess:true,
            dragDropStr: "<span><b>Seret dan lepaskan fail disini</b></span>",
            abortStr:" Henti",
            cancelStr:" Batal",
            doneStr:" Berjaya",
            deletelStr:" Padam",
            multiDragErrorStr: "Beberapa jenis fail tidak dibenarkan.",
            extErrorStr:"adalah tidak dibenarkan. Sambungan dibenarkan:",
            sizeErrorStr:"adalah tidak dibenarkan. Dibenarkan saiz max:",
            uploadErrorStr:"Muat naik tidak dibenarkan"
        });
        $("#startUpload").click(function()
        {
           /* if( $("#subject").val()==""){
                alert("Sila masukkan tajuk.");
                $("#subject").focus();
                return false;
            }else{

            }*/

            uploadObj.startUpload();
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

    });




</script>
</body>
</html>
