<?php
include_once('../config/functions.php');

if(isset($_POST['id'])){
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
       groupusers.group_id='$group_id' ";

    $result = db_select($sql);
    ?>
<table class="display table-responsive table table-bordered table-striped table-hover" id="example1">
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
                <a href="javascript:void(0)" onclick="jsDeleteData('<?php echo $row['user_id'] ?>','<?php echo $row['user_group_id'] ?>')" id="remove_user" class="btn btn-danger btn-xs remove_user"><i class="icon-trash"></i></a>

            </td>
        </tr>
    <?php
    }
    
    ?>
    </tbody>
</table>

<?php
}
?>
