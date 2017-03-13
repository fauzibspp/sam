<?php

include_once('../../config/functions.php');


if(isset($_POST['id'])){
    $id=isset($_POST['id']) ? $_POST['id'] : NULL;
    $id_topic = isset($_POST['id_topic']) ? $_POST['id_topic'] : NULL;

    $sql = "SELECT c08_dun_index AS id,CONCAT(c08_dun_kod,' ',c08_dun_nama) AS dun_name
    FROM dun WHERE c08_dun_kod_parlimen='$id' Order By c08_dun_kod ASC";

    $result = db_select($sql);
    echo '<select name="dun" id="dun" class="form-control input-sm m-bot15 text-info">';
    echo '<option value="" selected=selected>- Dun -</option>';
    foreach ($result as $rows){
        $kod= $rows['id'];
        $desc = $rows['dun_name'];

        if($kod == $id_topic){
            echo '<option value="'.$kod.'" selected="selected" class="'.$class.'">'.stripslashes($desc).'</option>';
        }else{
            echo '<option value="'.$kod.'" class="'.$class.'">'.stripslashes($desc).'</option>';
        }

    }
    echo '<select>';
}

?>
