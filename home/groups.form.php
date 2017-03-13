<?php
	//error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
    include_once('../config/functions.php');
	//connDB();

	$kod = isset($_POST['id']) ? $_POST['id'] : NULL;
	
	
	$qry2 = 'SELECT
			group_id,
			group_name,
			group_desc
			FROM
			groups
		WHERE group_id="'.$kod.'"';
	$row2 = db_select($qry2);
   $modekod = 'add';
   //$row2 = mysql_fetch_array($result2);
   if( count($result2) > 0 ){
   		 $modekod = 'edit';
   		 $v_kod		= $row2[0]['group_id'];
   		 $v_nama	= $row2[0]['group_name'];
   		 $v_desc	= $row2[0]['group_desc'];
	}

	

?>
<form class="form-horizontal" id="form-skim">

	<div class="control-group">
		<label class="control-label" for="topik">Nama</label>
		<div class="controls">
			<input type="text" id="nama" class="form-control" name="nama" value="<?php echo $v_nama?>">
		</div>
	</div>


	<div class="control-group">
		<label class="control-label" for="jenis">Penerangan</label>
		<div class="controls">
			<input type="text" id="desc" class="form-control" name="desc" value="<?php echo $v_desc ?>">
		</div>
	</div>
	<input type="hidden" id="mode_kod" name="mode_kod" value="<?php echo $modekod; ?>">
	<input type="hidden" id="kod" name="kod" value="<?php echo $v_kod; ?>">
</form>