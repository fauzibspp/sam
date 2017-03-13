<?php

include_once('../../config/functions.php');


if(isset($_POST['id'])){
    $id=isset($_POST['id']) ? $_POST['id'] : NULL;
    $id_topic = isset($_POST['id_topic']) ? $_POST['id_topic'] : NULL;

    $sql = "SELECT c07_parlimen_kod AS id,CONCAT(c07_parlimen_kod,' ',c07_parlimen_nama) AS parliment_name
    FROM parliment WHERE c07_negeri_kod='$id' Order By c07_parlimen_kod ASC";

    $result = db_select($sql);
    echo '<select name="parliment" id="parliment" class="form-control input-sm m-bot15">';
    echo '<option value="" selected=selected>- Parlimen -</option>';
    foreach ($result as $rows){
        $kod= $rows['id'];
        $desc = $rows['parliment_name'];

        if($kod == $id_topic){
            echo '<option value="'.$kod.'" selected="selected" class="'.$class.'">'.stripslashes($desc).'</option>';
        }else{
            echo '<option value="'.$kod.'" class="'.$class.'">'.stripslashes($desc).'</option>';
        }

    }
    echo '<select>';
}

?>
