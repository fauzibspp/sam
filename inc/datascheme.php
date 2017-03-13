<?php
include_once('../config/functions.php');


if(isset($_POST['userid'])){
    $list_scheme_id = array();
    $userid=isset($_POST['userid']) ? $_POST['userid'] : NULL;
    $list_scheme_id = isset($_POST['scheme_id']) ? $_POST['scheme_id'] : NULL;
    $scheme_arr = explode(',',$list_scheme_id);
    $list_scheme_count = count($scheme_arr);

    if($list_scheme_count > 1){

        $scheme_arr = explode(',',$list_scheme_id);

        $qry = "SELECT scheme_id,schema_name from view_scheme";
        $rst = db_select($qry);

        $checked = "";
        echo '<ul>';
        foreach ($rst as $row){
            $scheme_id = $row['scheme_id'];
            $scheme_name = $row['schema_name'];

            if(!in_array($scheme_id,$scheme_arr)){
                echo '<li><input type="checkbox" name="skim[]" value="'.$scheme_id.'"> '.$scheme_name.'</li>';
            }else{

                echo '<li><input type="checkbox" name="skim[]" value="'.$scheme_id.'" checked> '.$scheme_name.'</li>';
            }

        }

        echo '</ul>';
    }else{
        $qry = "SELECT scheme_id,schema_name from view_scheme";
        $rst = db_select($qry);
        echo '<ul>';
        foreach ($rst as $row){
            $scheme_id = $row['scheme_id'];
            $scheme_name = $row['schema_name'];
            if($list_scheme_id==$scheme_id){
                echo '<li><input type="checkbox" name="skim[]" value="'.$scheme_id.'" checked> '.$scheme_name.'</li>';
            }else{
                echo '<li><input type="checkbox" name="skim[]" value="'.$scheme_id.'"> '.$scheme_name.'</li>';
            }


        }
        echo '</ul>';
    }
    



}

?>

