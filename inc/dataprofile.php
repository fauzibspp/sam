<?php
include_once('../config/functions.php');

if(isset($_GET['id'])){
    $id=isset($_GET['id']) ? $_GET['id'] : NULL;
    $qry = "SELECT
    userprofile.user_name
    , userprofile.user_id
    , userprofile.user_phone
    , userprofile.user_email
    , groups.group_name
    , userprofile.unit_name
    , userprofile.unit_address
    , userprofile.unit_postcode
    , userprofile.user_scheme_id
    , userprofile.user_images
    FROM
    userprofile
    JOIN groups ON userprofile.user_group_id = groups.group_id
    WHERE userprofile.user_id = '$id'";

    $rst = db_select($qry);

    $user_name = '';
    $user_email = '';
    $user_phone = '';
    $group_name = '';
    $unit_name = '';
    $unit_address = '';
    $unit_postcode = '';

    if (count($rst) > 0 ) {
        $user_name = $rst[0]['user_name'];
        $user_email = $rst[0]['user_email'];
        $user_phone = $rst[0]['user_phone'];
        $group_name = $rst[0]['group_name'];
        $unit_name = $rst[0]['unit_name'];
        $unit_address = $rst[0]['unit_address'];
        $unit_postcode = $rst[0]['unit_postcode'];
        $user_images = $rst[0]['user_images'];
        $user_scheme_id = $rst[0]['user_scheme_id'];
    }

}

?>
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <aside class="profile-nav col-lg-3">
            <section class="panel">
                <div class="user-heading round">
                    <?php if(isset($user_images)) { ?>
                        <a href="javascript:void(0)">
                            <img src="profiles/<?php echo $user_images ?>" alt="">
                        </a>
                    <?php }else{ ?>
                        <a href="javascript:void(0)">
                            <img src="img/unknown.png" alt="">
                        </a>
                    <?php } ?>
                    <h1><?php echo $user_name ?></h1>
                    <p><?php echo $user_email ?></p>

                </div>
            </section>
        </aside>
        <aside class="profile-info col-lg-9">

            <section class="panel">

                <div class="panel-body bio-graph-info">
                    <h1>Butir Peribadi</h1>
                    <div class="row">
                        <div class="bio-row">
                            <p><span>Nama Penuh </span>: <?php echo $user_name; ?></p>
                        </div>

                        <div class="bio-row">
                            <p><span>Unit/Jabatan </span>: <?php echo $unit_name ?></p>
                        </div>
                        <div class="bio-row">
                            <p><span>Alamat</span>: <?php echo $unit_address ?></p>
                        </div>
                        <div class="bio-row">
                            <p><span>Skim </span>: <?php echo fnSQLCustomWithWhileLoop('SELECT CONCAT(scheme_name," - ",scheme_gred) AS scheme_group FROM scheme WHERE FIND_IN_SET(scheme_id,"'.$user_scheme_id.'")','scheme_group'); ?></p>
                        </div>

                        <div class="bio-row">
                            <p><span>Email </span>: <?php echo $user_email; ?></p>
                        </div>
                        <div class="bio-row">
                            <p><span>Mobile </span>: <?php echo $user_phone; ?></p>
                        </div>

                    </div>
                </div>
            </section>

        </aside>
    </div>

    <!-- page end-->
</section>
