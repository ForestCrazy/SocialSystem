<?php
if (UserInfo($_SESSION['user_id'])['level'] != 'admin') {
    ?>
    <script>
        window.location = '?page=home';
    </script>
    <?php
} else {
    $sql_account = 'SELECT * FROM account WHERE acc_status = "pending"';
    $res_account = mysqli_query($connect, $sql_account);

    if (isset($_POST['accept_account'])) {
        $sql_edit_account = 'UPDATE account SET acc_status = "accept" WHERE user_id = "' . $_POST['user_id'] . '"';
        $res_edit_account = mysqli_query($connect, $sql_edit_account);
        if ($res_edit_account) {
            ?>
            <script>
                window.location = window.location;
            </script>
            <?php
        }
    }
    ?>
    <h4>อนุมัติบัญชี</h4>
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
                    <td>
                        <form action='' method='POST'>
                            <input type='hidden' name='user_id' value='<?= $fetch_account['user_id'] ?>'>
                            <button type='submit' class='btn btn-success' name='accept_account'>อนุมัติบัญชี</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}