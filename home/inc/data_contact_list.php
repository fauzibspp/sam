<?php
include_once('../../config/functions.php');
?>

<div class="alert alert-block alert-danger fade in" style="display: none">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>
                            <strong>Harap Maaf!</strong> <label class="lblMsg"></label>
                        </div>

                        <i class="icon-warning-sign"></i> Sila pilih penerima dibawah dan tekan butang OK
                        <br><br>

                        <?php

                        $qry = "SELECT userprofile.user_id,userprofile.user_name,groups.group_name from
                        userprofile join groups on groups.group_id = userprofile.user_group_id  order by groups.group_name ASC";
                        $rst = db_select($qry);

                        echo '<div class="checkboxes">';
                        $i=1;
                        foreach ($rst as $rows){

                            echo '<label class="label_check" for="checkbox-0'.$i.'">';

                            echo '<input name="receipientCB[]" id="receipientCB" value="'.$rows['user_id'].'" type="checkbox" /> '.ucwords($rows['user_name']).'&nbsp;&nbsp; - ['.$rows['group_name'].']';

                            echo '</label>';
                            $i++;
                        }
                        echo '</div>';

?>

