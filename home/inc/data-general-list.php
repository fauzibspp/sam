<?php
include_once('../../config/functions.php');
?>
<!doctype html>
<html lang="en">
<head>
    <title><?php echo appname ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9,chrome=1">

</head>
<?php
if(isset($_POST['owner'])) {
    $owner = $_POST['owner'];
    $filter = $_POST['filter'];

    switch ($filter) {
        case 'aho':
            $query = "select user_id,user_name,user_phone from userprofile where user_group_id='3' order by user_id ASC";
            $rows = db_select($query);

            echo '<div class="table-responsive adv-table">';
            echo '<div class="heading"><h4>SENARAI KESELURUHAN PEGAWAI PENGENDALI (AHO)</h4></div>';
            echo '<table class="display table table-bordered table-striped" id="example1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Bil</th><th>No.Tentera/ID</th><th>Nama Penuh</th><th>Telefon HP</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $i = 1;
            foreach ($rows as $row) {
                echo '<tr class="gradeX text-info">';
                echo '<td>'.$i.'.</td>';
                echo '<td>' . $row['user_id'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td>' . $row['user_phone'] . '</td>';
                echo '</tr>';
                $i++;
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';

            break;
        case 'sumber':
            $query = "select m01_kodsumber as kod_sumber,m01_nama_anggota as nama_sumber, m01_telhp as hp_sumber from m01_induk order by m01_kodsumber ASC";
            $rows = db_select($query);

            echo '<div class="table-responsive adv-table">';
            echo '<div class="heading"><h4>SENARAI KESELURUHAN SUMBER</h4></div>';
            echo '<table class="display table table-bordered table-striped" id="example1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Bil</th><th>Kod Sumber</th><th>Nama Penuh</th><th>Telefon HP</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $i = 1;
            foreach ($rows as $row) {
                echo '<tr class="gradeX text-info">';
                echo '<td>'.$i.'.</td>';
                echo '<td>' . $row['kod_sumber'] . '</td>';
                echo '<td>' . $row['nama_sumber'] . '</td>';
                echo '<td>' . $row['hp_sumber'] . '</td>';
                echo '</tr>';
                $i++;
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';

            break;
        
        case 'isu': //list sumber base on issue
                    $queryby = $_POST['queryby'];
                    $x = $_POST['x'];

            $query = "SELECT pertemuan.kod_sumber, 
                m01_induk.m01_nama_anggota AS nama_sumber, 
                m01_induk.m01_gelaran AS gelaran_sumber, 
                pertemuan.pegawai_pengendali as id_peg_pengendali,
                userprofile.user_name as nama_peg_pengendali
            FROM pertemuan INNER JOIN class_pertemuan ON pertemuan.class_pertemuan = class_pertemuan.id
                 LEFT JOIN m01_induk ON pertemuan.kod_sumber = m01_induk.m01_kodsumber
                 LEFT JOIN userprofile ON pertemuan.pegawai_pengendali = userprofile.user_id
            WHERE class_pertemuan.nama_pertemuan = '$queryby'
            GROUP BY pertemuan.class_pertemuan";

            $rows = db_select($query);

            echo '<div class="table-responsive adv-table">';
            echo '<div class="heading"><h4>SENARAI SUMBER BERKAITAN '.strtoupper($queryby).'</h4></div>';
            echo '<table class="display table table-bordered table-striped" id="example1">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Bil</th><th>Kod Sumber</th><th>Nama Penuh</th><th>Pegawai Pengendali (AHO)</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            $i = 1;
            foreach ($rows as $row) {
                echo '<tr class="gradeX text-info">';
                echo '<td>'.$i.'.</td>';
                echo '<td>' . $row['kod_sumber'] . '</td>';
                echo '<td>' . $row['nama_sumber'] . '<br><span class="text-info">Gelaran: '.$row['gelaran_sumber'].'</span></td>';
                echo '<td>' . $row['id_peg_pengendali'] . '<br><span class="text-info">'.$row['nama_peg_pengendali'].'</span></td>';
                echo '</tr>';
                $i++;
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';



            break;
        default:
            $query = "";
    }

}
?>

