<?php
//include_once("../config/functions.php");
if(empty($_SESSION['userid'])){
    echo '<script>location.href="../logout.php";</script>';
}
?>
<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
    </div>
    <!--logo start-->
    <a href="../home/" class="logo">&nbsp;<?php echo appname ?><span>System</span></a>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu">
    <!--  notification start -->
    <ul class="nav top-menu">
    <!-- notification dropdown start-->
    <li id="header_notification_bar" class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

            <i class="icon-bell-alt"></i>
            <span class="badge bg-warning"></span>
        </a>
        <ul class="dropdown-menu extended notification">
            <div class="notify-arrow notify-arrow-yellow"></div>
            <li>
                <p class="yellow"></p>
            </li>
           <!-- loop your notice list here -->
            <div class="listNotice"></div>

            <!-- loop your notice list here -->
            <li>
                <a href="listnotificationdetails.php" class="viewAllNotice">...Lihat semua notis</a>
            </li>
        </ul>
    </li>
    <!-- notification dropdown end -->
    </ul>
    </div>
    <div class="top-nav ">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">

            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <?php
                    $images = $_SESSION['user_avatar'];
                    if(!empty($images)){
                        $images = 'profiles/'.$images;
                    }else{
                        $images = 'img/unknown-small.gif';
                    }
                    ?>
                    <img alt="" src="<?php echo $images ?>" width="29px" height="29px">
                    <span class="username"><?php echo $_SESSION['userid'] ?> - [<?php echo $_SESSION['groupname'] ?>]</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li><a href="profile.php"><i class=" icon-suitcase"></i>Profil</a></li>
                    <li><a href="listnotificationdetails.php" class="viewAllNotice"><i class="icon-bell-alt"></i> Notifikasi<span class="badge bg-warning"></span></a></li>
                    <li><a href="../logout.php"><i class="icon-key"></i> Keluar</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->
    </div>
</header>


