<?php
include_once('../config/functions.php');

    $group_id=isset($_POST['id']) ? $_POST['id'] : NULL;
    $sql = "SELECT
    userprofile.user_id
    , userprofile.user_name
    , userprofile.user_phone
    , userprofile.user_email
    , userprofile.user_group_id
    FROM
    userprofile
    LEFT JOIN groupusers
        ON (userprofile.user_id = groupusers.user_id)
    LEFT JOIN groups
        ON (groups.group_id = groupusers.group_id)
    LEFT JOIN department
        ON (department.department_id = userprofile.user_dept_id) WHERE
       userprofile.user_group_id='0' OR userprofile.user_group_id IS NULL";

    $result = db_select($sql);
    ?>
<table  class="display table-responsive table table-bordered table-striped table-hover" id="example1">
    <thead>
    <tr>
        <th>Nama</th>
        <th>Telefon</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($result as $row){ ?>
        <tr>

            <td><?php echo $row['user_name'] ?></td>
            <td><?php echo $row['user_phone'] ?></td>
            <td>
                <a href="javascript:void(0)" onclick="jsJoinGroupUserData('<?php echo $row['user_id'] ?>','<?php echo $group_id ?>')" id="join_group" class="btn btn-success btn-xs join_group"><i class=" icon-save"></i></a>

            </td>
        </tr>
    <?php
    }
    
    ?>
    </tbody>
</table>