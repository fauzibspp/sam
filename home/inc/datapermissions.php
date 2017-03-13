<?php
include_once('../../config/functions.php');
if(isset($_POST['group_id'])){
    $group_id = $_POST['group_id'];
    $cmd = $_POST['cmd'];

?>

<div class="alert alert-block alert-danger fade in" style="display: none">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>Harap Maaf!</strong> <label class="lblMsg"></label>
                        </div>
                        <input type="hidden" name="cmd" id="cmd" value="<?php echo $cmd ?>"/>
                        <?php echo fnSelect('group_id','group_name','groups',$group_id,'groupId','form-control input-sm m-bot15','Kumpulan','','','required="required"'); ?>

                        <?php

                        $qry = "SELECT perm_id,perm_key,perm_name from permissions";
                        $rst = db_select($qry);
                        echo '<div class="checkboxes">';
                        $i=1;
                        foreach ($rst as $rows){

                            echo '<label class="label_check" for="checkbox-0'.$i.'">';
                            $exist = db_check_data_exist("select role_group_id,role_permission_id from roleaccess where role_group_id='".$group_id."' and role_permission_id='".$rows['perm_id']."'");
                            if($exist===FALSE){
                                echo '<input name="addCB[]" id="addCB" value="'.$rows['perm_id'].'" type="checkbox" /> '.$rows['perm_name'];
                            }else{
                                echo '<input name="addCB[]" id="addCB" value="'.$rows['perm_id'].'" type="checkbox" checked /> '.$rows['perm_name'];
                            }


                            echo '</label>';
                            $i++;
                        }
                        echo '</div>';
}
?>

