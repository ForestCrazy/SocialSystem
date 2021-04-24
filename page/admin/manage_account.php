<?php
if (UserInfo($_SESSION['user_id'])['level'] != 'admin') {
    ?>
    <script>
    window.location = '?page=home';
    </script>
    <?php
} else {
    $sql_account = 'SELECT * FROM account WHERE acc_status != "pending"';
    $res_account = mysqli_query($connect, $sql_account);

    if (isset($_POST['action_account'])) {
        if ($_POST['action_account'] == 'cancel') {
            $sql_cancel = 'UPDATE account SET acc_status = "cancel" WHERE user_id = "' . $_POST['user_id'] . '"';
            $res_cancel = mysqli_query($connect, $sql_cancel);
        } elseif ($_POST['action_account'] == 'accept') {
            $sql_accept = 'UPDATE account SET acc_status = "accept" WHERE user_id = "' . $_POST['user_id'] . '"';
            $res_accept = mysqli_query($connect, $sql_accept);
        } elseif ($_POST['action_account'] == 'delete') {
            $sql_delete = 'DELETE FROM account WHERE user_id = "' . $_POST['user_id'] . '"';
            $res_delete = mysqli_query($connect, $sql_delete);
        }
    }
    ?>
    <h4>จัดการบัญชี</h4>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Manage</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($fetch_account = mysqli_fetch_assoc($res_account)) {
            ?>
                <tr>
                    <td><?= $fetch_account['user_id'] ?></td>
                    <td><?= $fetch_account['username'] ?></td>
                    <td><?= $fetch_account['email'] ?></td>
                    <td><?= $fetch_account['FirstName'] ?></td>
                    <td><?= $fetch_account['LastName'] ?></td>
                    <td class='d-flex justify-content-center'>
                        <form action='' method='POST'>
                            <input type='hidden' name='user_id' value='<?= $fetch_account['user_id'] ?>'>
                            <div class='btn btn-primary' onclick='window.location = "?page=edit_info&user_id=<?= $fetch_account['user_id'] ?>"'>แก้ไข</div>
                            <?php
                            if ($fetch_account['acc_status'] == 'accept') { ?>
                                <button type='submit' class='btn btn-primary' name='action_account' value='cancel'>ยกเลิกบัญชี</button>
                            <?php } else {?>
                                <button type='submit' class='btn btn-primary' name='action_account' value='accept'>ปลดแบนบัญชี</button>
                            <?php } ?>
                        </form>
                        <form action='' method='POST'>
                            <input type='hidden' name='user_id' value='<?= $fetch_account['user_id'] ?>'>
                            <button type='submit' class='btn btn-danger ml-1' name='action_account' value='delete'>ลบบัญชี</button>
                        </form>
                        <div class='btn btn-info ml-1' onclick='window.location = "?page=home&user_id=<?= $fetch_account['user_id'] ?>"'>โพสต์ทั้งหมด</div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}