<?php
$owner = $_SESSION['userid'];
$group_id=$_SESSION['groupid'];
$rst = db_select("select count(*) as total from email_inbox where is_read=0 and receiver_id='$owner'");
$total = $rst[0]['total'];
?>
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <?php if(fnModuleAccessByGroup($_SESSION['groupid'],'1')) { ?>
            <li>
                <a class="active" href="../home">
                    <i class="icon-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php } ?>
            <?php if(fnModuleAccessByGroup($_SESSION['groupid'],'2')) { ?>
            <li class="sub-menu">
                <a href="javascript:void(0)" class="active">
                    <i class="icon-envelope"></i>
                    <span>Mail</span>
                </a>
                <ul class="sub">
                    <?php if(fnModuleAccessByUser($_SESSION['userid'],'3')) { ?><li><a  href="mail.compose.php"><i class="icon-edit-sign"></i>Compose</a> </li><?php } ?>
                    <?php if(fnModuleAccessByUser($_SESSION['userid'],'4')) { ?><li><a  href="mail.inbox.php"><i class="icon-inbox"></i>Inbox (<?php echo $total ?>)</a></li><?php } ?>
                    <?php if(fnModuleAccessByUser($_SESSION['userid'],'5')) { ?><li><a  href="mail.outbox.php"><i class="icon-envelope-alt"></i>Outbox</a></li><?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if(fnModuleAccessByGroup($_SESSION['groupid'],'6')) { ?>
            <li class="sub-menu">
                <a href="hr.list.employee.php" class="active">
                    <i class="icon-search"></i>
                    <span>Carian Induk</span>
                </a>
            </li>
            <?php } ?>
            
            <?php if(fnModuleAccessByGroup($_SESSION['groupid'],'7')) { ?>
                <li class="sub-menu">
                    <a href="javascript:void(0)" class="active">
                        <i class="icon-cogs"></i>
                        <span>Panel Kawalan</span>
                    </a>

                    <ul class="sub">
                        <li class="sub-menu"><a  href="#" class="active"><i class="icon-gear"></i>Hal Pengguna</a>
                            <ul class="sub">
                                <li><a  href="users.list.php"><i class="icon-user"></i>Pengguna</a></li>
                                <li><a  href="groups.list.php"><i class="icon-group"></i>Kumpulan</a></li>
                                <li><a  href="permissions.list.php"><i class="icon-group"></i>Role Kumpulan</a></li>
                                <li><a  href="permissions.list.user.php"><i class="icon-group"></i>Role Pengguna</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu"><a href="#" class="active"><i class="icon-list"></i>Kod Sistem</a>
                            <ul class="sub">
                                <li><a  href="isu.list.php"><i class=" icon-magic"></i>Isu</a></li>
                                <li><a  href="module.list.php"><i class=" icon-magic"></i>Modul</a></li>
                                <li><a  href="skim.list.php"><i class="icon-puzzle-piece"></i>Jawatan</a></li>
                                <li><a  href="pkt.list.php"><i class=" icon-magic"></i>Pangkat</a></li>
                                <li><a  href="unit.list.php"><i class=" icon-magic"></i>Unit</a></li>
                                <li><a  href="kor.list.php"><i class=" icon-magic"></i>Kor</a></li>
                                <li><a  href="activity.log.php"><i class=" icon-cogs"></i>Log</a></li>
                            </ul>
                        </li>



                    </ul>
                </li>
            <?php } ?>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>


