<?php

include_once('../../config/functions.php');

if(isset($_POST['id'])){
    $id=isset($_POST['id']) ? $_POST['id'] : NULL;
    $id_topic = isset($_POST['id_topic']) ? $_POST['id_topic'] : NULL;
    //echo $id_topic;
    $sql = "SELECT
        t.id,
        CONCAT(REPEAT('&nbsp;&nbsp;',LENGTH(p.path) - LENGTH(REPLACE(p.path,'/',''))),t.category_name ) AS category_name,
        t.parent_id,t.id
       FROM report_category t
       LEFT JOIN report_category_path p ON t.id = p.id
       WHERE t.parent_id = '$id' AND t.category_active=1
       ORDER BY p.path ASC";

    $result = db_select($sql);
    echo '<select name="report_subcategory" id="report_subcategory" class="form-control input-sm m-bot15">';
    echo '<option value="" selected=selected>- Sub Kategori -</option>';
   foreach ($result as $rows){
        $kod= $rows['id'];
        $desc = $rows['category_name'];
        if ($rows['parent_id']=="" OR $rows['parent_id']==0) {
            $class= 'bold';
        }else{
            $class='unbold';
        }

        if($kod == $id_topic){
            echo '<option value="'.$kod.'" selected="selected" class="'.$class.'">'.stripslashes($desc).'</option>';
        }else{
            echo '<option value="'.$kod.'" class="'.$class.'">'.stripslashes($desc).'</option>';
        }

    }
    echo '<select>';
}

?>

<style type="text/css">
    .bold{
        font-weight: bold;
        font-size: 14px;
    }
</style>
