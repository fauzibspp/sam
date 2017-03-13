<?php
include_once('../config/functions.php');
?>
<!doctype html>
<html lang="en">
<head>
    <title><?php appname ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9,chrome=1">

</head>
<?php
if(isset($_POST['status'])){
    $status = $_POST['status'];
    $owner=$_POST['owner'];
    $group = $_POST['group'];
    $skim = $_POST['skim'];

    $qry_log = "SELECT log_event,log_created FROM log_activity WHERE log_event LIKE '%$status%'";


    $rows_log = db_select($qry_log);

    ?>
    <div class="table-responsive adv-table">
        <div class="heading">
            <h4>SENARAI PENGGUNA</h4>
        </div>
        <table  class="display table table-bordered table-striped" id="example1">

            <thead>
            <tr>
                <th>Bil.</th>
                <th>Log Aktiviti/No.KP/Alamat IP</th>
                <th>Waktu Aktiviti</th>
            </tr>
            </thead>
            <tbody>
    <?php
    $i=1;
    foreach($rows_log as $row_log): ?>

        <tr class="gradeX text-info">
            <td><?php echo $i ?>.</td>
            <td><?php echo $row_log['log_event'] ?> </td>
            <td><?php echo $row_log['log_created'] ?></td>
        </tr>
    <?php $i++;endforeach; ?>
    </tbody>
    </table>
    </div>
<?php } ?>
