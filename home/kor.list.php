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


    <!--alertify css-->
    <link rel="stylesheet" href="css/alertify.core.css" />
    <link rel="stylesheet" href="css/alertify.default.css" id="toggleCSS" />

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
    //$jenissoalan = '';
    $v_owner = $_SESSION['userid'];
    ?>
    
    
    <!-- start modal 1 -->
    <div id="dialog-form" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade">
        <div class="modal-dialog table-responsive" >
                <div class="modal-content">
                    <form name="form1" id="form1" class="form-horizontal" role="form">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 id="myModalLabel">Tambah Data</h4>
                    </div>
                    
                    <div class="modal-body">
                        <div class="alert alert-block alert-danger fade in">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>Harap Maaf!</strong> <label class="lblMsg"></label>
                        </div>
                        <input type="text" name="Id" id="Id" value="" class="form-control" placeholder="Kod" />
                        <input type="hidden" name="cmd" id="cmd" value=""/>

                        <input type="text" name="Desc" id="Desc" value="" class="form-control" placeholder="Deskripsi" />
                    </div>
                    <div class="modal-footer">
						<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
						<button type="button" class="btn btn-success simpan">Simpan</button>
                    </div>
                    </form>
                </div>
        </div>
    </div>
    <!-- end modal 1 -->
    
    
    

    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <i class="icon-file"></i> Senarai Kor/Bidang Kepakaran
                        </header>
                        <!--widget start-->
                        
                        

                        
                        <section class="panel">
                            <div class="panel-body">
                                <a href="#dialog-form" id="0" class="btn tambah sentBtn btn-send" data-toggle="modal">
                                <i class="icon-plus"></i> Tambah Data</a>
                            
                            
                                <?php
                                $salt = 'm0h2014';
                                $token = sha1(mt_rand(1,1000000) . $salt);
                                $_SESSION['token'] = $token;
                                echo '<input id="token" type="hidden" name="token" value="'.$token.'" />';
                                ?>
                                  <article class="media">
                                            <section class="panel">
                                                <div class="media-body">
                                                    <!-- start list media-body-->
													<div class="adv-table">
													
													
							<!--------mula table	-->					
													
							<table  class="display table table-bordered table-striped table-hover" id="example1">
							<thead>
                            <tr>
                                <th colspan="8">
                                    <input style="float: left;" type="button" class="deleteBtn btn btn-send" value="Hapus" disabled />
                                </th>
                            </tr>
								<tr>
                                    <th><input type="checkbox" onclick="toggleChecked(this.checked)" id="checkAll" /></th>
									<th>Id</th>
									<th>Nama Isu</th>
									<th></th>
								</tr>
							</thead>
							
							<tbody>
								<?php 

                                    $fld1 = "c33_kod_kor";
                                    $fld2 = "c33_desc_kor";
                                    $tbl1 = "c33_kor";
									
									$sql = "SELECT
											$fld1,
											$fld2 as descriptions
											FROM
											$tbl1
											";
									$cnt =1;
                                    $rst = db_select($sql);
									foreach ($rst as $row){
									
									
								?>
								<tr>
                                    <td><div id="checkboxes"><input type="checkbox" id="cbox" value="<?php echo $row[$fld1] ?>" name="addCB[]" class="cb" /></div></td>
									<td><?php echo $row[$fld1] ?></td>
									<td><?php echo $row['descriptions'] ?></td>
									<td>
                                        <a href="#dialog-form" onclick="jsEditData('<?php echo $row[$fld1] ?>','<?php echo $row['descriptions']  ?>')"  class="btn btn-default btn-xs pinda" data-toggle="modal"><i class="icon-pencil"></i></a>
										<a href="javascript:void(0)" onclick="jsDelData('<?php echo $row[$fld1] ?>')" id="<?php echo $row[$fld1] ?>"  class="btn btn-danger btn-xs padam"><i class="icon-trash"></i></a>
									</td>
								</tr>
								<?php
									$cnt++;
									}
								?>
							</tbody>
							</table>
							<!--------end table	-->					




													
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
<script src="js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="js/respond.min.js" ></script>
<script src="js/jquery.validate.min.js" ></script>

<!--common script for all pages-->
<script src="js/common-scripts.js"></script>

<!--script for this alertify-->
<script src="js/alertify.min.js"></script>
<script src="js/notifications.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {

        $('#example1').dataTable( {} );

        $('.alert').hide();

        $(document).on("click", ".tambah", function () {
            $('#cmd').val('AddDataDictionary');
            $("#myModalLabel").html("Tambah Data");
            $("#form1 #Desc").val('');
        });

        $('.simpan').click(function(){
            var datastring = $("#form1").serialize();
            if($('#Desc').val()==''){
                $('.alert').show();
                $('.lblMsg').html('Sila isikan data berikut.');
                $('#Desc').focus();
                return false;
            }else{
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val()+'&tbl=c33_kor',
                    success: function(html)
                    {
                        alert(html);
                        location.reload();
                    }
                });
            }

        });

    /* checkbox and submit button */
    if($('#cbox').length==0){
        $('#checkAll:checkbox').prop('disabled',true);
    }else{
        $('#checkAll:checkbox').prop('disabled',false);
    }
    $('input:checkbox').change(function () {
        $('.deleteBtn:button').prop('disabled', $('input:checkbox:checked').length == 0)
    });

    $('.deleteBtn').click(function(){

        var datacheck = $('.cb:checked').map(function(i,n){
            return $(n).val();
        }).get();

        if(confirm("Anda pasti untuk teruskan ?")){
            $.post("process.php",{
                    'addCB[]' : datacheck,
                    cmd:'MultiDelDataDictionary',
                    tbl:'c33_kor',
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



        var url = window.location;

        $('ul.sub a[href="'+ url +'"]').parent().addClass('active');
        $('ul.sub a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');
});
function toggleChecked(status) {
    $("#checkboxes input").each( function() {
        $(this).attr("checked",status);
    });

}
function jsEditData(id,sName){
    $(".modal-body #Id").val( id );
    $(".modal-body #Desc").val( sName );
    $('#cmd').val('EditDataDictionary');
    $("#myModalLabel").html("Pinda Data");
}
function jsDelData(id){

        var datastring = 'Id='+id;
        if(y = confirm('Anda pasti untuk teruskan?')){
            if(y){
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: datastring + '&token='+$('#token').val()+'&cmd=DelDataDictionary&tbl=c33_kor',
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
