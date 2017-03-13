<?php
include_once('../../config/functions.php');


if(isset($_POST['report_id'])){
    //$_SESSION['report_id'] = $_POST['report_id'];
    $cmd = $_POST['cmd'];

?>

<div class="alert alert-block alert-danger fade in" style="display: none">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>Harap Maaf!</strong> <label class="lblMsg"></label>
                        </div>
                        <input type="hidden" name="cmd" id="cmd" value="<?php echo $cmd ?>"/>

                        <i class="icon-warning-sign"></i> Sila pilih penerima dibawah dan tekan butang OK
                        <br><br>

                        <?php

                        for($i = 0;$i<count($_POST['report_id']);$i++){
                            echo '<input type="hidden" name="report_id[]" id="report_id" value='.$_POST['report_id'][$i].'>';
                        }

                        $qry = "SELECT group_id,group_name from groups order by group_name ASC";
                        $rst = db_select($qry);

                        echo '<div class="checkboxes">';
                        $i=1;
                        foreach ($rst as $rows){

                            echo '<label class="label_check" for="checkbox-0'.$i.'">';

                            echo '<input name="receipientCB[]" id="receipientCB" value="'.$rows['group_id'].'" type="checkbox" /> '.$rows['group_name'];

                            echo '</label>';
                            $i++;
                        }
                        echo '</div>';
}
?>

