<?php
if (!isset($_SESSION["user_id"]) OR !isset($_SESSION["username"])) {
    ?>
    <script>
        window.location = "?page=home";
    </script>
    <?php
} else {
    // $sql_friend_list = 'SELECT * FROM friendrelation WHERE ((user_id_1 = "' . $_SESSION['user_id'] . '" OR user_id_2 = "' . $_SESSION['user_id'] . '") AND AreFriend = "True") AND (user_id_1 != "' . $_SESSION['user_id'] . '" OR user_id_2 != "' . $_SESSION['user_id'] . '")';
    // $res_friend_list = mysqli_query($connect, $sql_friend_list);
    $sql_friend_list = 'SELECT * FROM (SELECT * FROM friendrelation WHERE (user_id_1 = "' . $_SESSION['user_id'] . '" OR user_id_2 = "' . $_SESSION['user_id'] . '") AND AreFriend = "True") AS friendrelation INNER JOIN account ON friendrelation.user_id_1 = account.user_id OR friendrelation.user_id_2 = account.user_id WHERE (friendrelation.user_id_1 != friendrelation.user_id_2) AND account.user_id != "' . $_SESSION['user_id'] . '" GROUP BY account.user_id';
    $res_friend_list = mysqli_query($connect, $sql_friend_list);
    
    $sql_friend_pending = 'SELECT * FROM friendrelation INNER JOIN account ON friendrelation.user_id_2 = account.user_id WHERE user_id_1 = "' . $_SESSION['user_id'] . '" AND AreFriend = "False"';
    $res_friend_pending = mysqli_query($connect, $sql_friend_pending);
    
    $sql_friend_request = 'SELECT * FROM friendrelation INNER JOIN account ON friendrelation.user_id_1 = account.user_id WHERE user_id_2 = "' . $_SESSION['user_id'] . '" AND AreFriend = "False"';
    $res_friend_request = mysqli_query($connect, $sql_friend_request);

    $sql_not_friend = 'SELECT * FROM (SELECT * FROM account WHERE user_id != "' . $_SESSION['user_id'] . '") AS account LEFT JOIN (SELECT * FROM friendrelation WHERE user_id_1 = "' . $_SESSION['user_id'] . '" OR user_id_2 = "' . $_SESSION['user_id'] . '") AS friendrelation ON account.user_id = friendrelation.user_id_1 OR account.user_id = friendrelation.user_id_2 WHERE AreFriend IS NULL';
    $res_not_friend = mysqli_query($connect, $sql_not_friend);
?>
    <h4>??????????????????????????????????????? <?= mysqli_num_rows($res_friend_list) ?></h4>
    <?php
    if (mysqli_num_rows($res_friend_list) != 0) {
        while ($fetch_friend_list = mysqli_fetch_assoc($res_friend_list)) {
            if ($fetch_friend_list['user_id_1'] == $_SESSION['user_id']) {
                $fetch_user = UserInfo($fetch_friend_list['user_id_2']);
            } else {
                $fetch_user = UserInfo($fetch_friend_list['user_id_1']);
            }
        ?>
        <div class="card">
            <div class="card-body row">
                <div class="col-2">
                    <img src="<?= $fetch_user['img_profile'] ?>" style="max-height: 120px;" alt="" class="img-fluid">
                </div>
                <div class="col-6">
                    <h5 class="card-title"><?= $fetch_user['FirstName'] . '&emsp;' . $fetch_user['LastName'] ?></h5>
                </div>
                <div class="col-4">
                    <div class="float-right">
                        <form action='' method='POST'>
                            <button class='btn btn-danger' type='submit' name='action' value='deletefriend'>????????????????????????</button>
                            <input type='hidden' name='user_id' value='<?= $fetch_user['user_id'] ?>'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
    } else {
        ?>
        <div class="alert alert-warning" role="alert">
            ???????????????????????????????????????????????????
        </div>
        <?php
    }
    ?>

    <h4>?????????????????????????????????????????? <?= mysqli_num_rows($res_friend_pending) ?></h4>
    <?php
    if (mysqli_num_rows($res_friend_pending) > 0) {
        while ($fetch_friend_pending_list = mysqli_fetch_assoc($res_friend_pending)) {
            $fetch_user = UserInfo($fetch_friend_pending_list['user_id_2']);
        ?>
        <div class="card">
            <div class="card-body row">
                <div class="col-2">
                    <img src="<?= $fetch_user['img_profile'] ?>" style="max-height: 120px;" alt="" class="img-fluid">
                </div>
                <div class="col-6">
                    <h5 class="card-title"><?= $fetch_user['FirstName'] . '&emsp;' . $fetch_user['LastName'] ?></h5>
                </div>
                <div class="col-4">
                    <div class="float-right">
                        <form action='' method='POST'>
                            <button class='btn btn-warning' type='submit' name='action' value='cancelpending'>??????????????????</button>
                            <input type='hidden' name='user_id' value='<?= $fetch_user['user_id'] ?>'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
    } else {
        ?>
        <div class="alert alert-warning" role="alert">
            ????????????????????????????????????????????????????????????????????????????????????????????????
        </div>
        <?php
    }
    ?>

    <h4>?????????????????????????????????????????? <?= mysqli_num_rows($res_friend_request) ?></h4>
    <?php
    if (mysqli_num_rows($res_friend_request) > 0) {
        while ($fetch_friend_request_list = mysqli_fetch_assoc($res_friend_request)) {
            $fetch_user = UserInfo($fetch_friend_request_list['user_id_1']);
        ?>
        <div class="card">
            <div class="card-body row">
                <div class="col-2">
                    <img src="<?= $fetch_user['img_profile'] ?>" style="max-height: 120px;" alt="" class="img-fluid">
                </div>
                <div class="col-6">
                    <h5 class="card-title"><?= $fetch_user['FirstName'] . '&emsp;' . $fetch_user['LastName'] ?></h5>
                </div>
                <div class="col-4">
                    <div class="float-right">
                        <form action='' method='POST'>
                            <button class='btn btn-success' type='submit' name='action' value='acceptfriend'>???????????????????????????</button>
                            <input type='hidden' name='user_id' value='<?= $fetch_user['user_id'] ?>'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
    } else {
        ?>
        <div class="alert alert-warning" role="alert">
            ?????????????????????????????????????????????????????????
        </div>
        <?php
    }
    ?>
    
    <h4>???????????????????????????????????????????????? <?= mysqli_num_rows($res_not_friend) ?></h4>
    <?php
    if (mysqli_num_rows($res_not_friend) > 0) {
        while ($fetch_not_friend_list = mysqli_fetch_assoc($res_not_friend)) {
            $fetch_user = UserInfo($fetch_not_friend_list['user_id']);
        ?>
        <div class="card">
            <div class="card-body row">
                <div class="col-2">
                    <img src="<?= $fetch_user['img_profile'] ?>" style="max-height: 120px;" alt="" class="img-fluid">
                </div>
                <div class="col-6">
                    <h5 class="card-title"><?= $fetch_user['FirstName'] . '&emsp;' . $fetch_user['LastName'] ?></h5>
                </div>
                <div class="col-4">
                    <div class="float-right">
                        <form action='' method='POST'>
                            <button class='btn btn-primary' type='submit' name='action' value='addfriend'>?????????????????????????????????</button>
                            <input type='hidden' name='user_id' value='<?= $fetch_user['user_id'] ?>'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
    } else {
        ?>
        <div class="alert alert-warning" role="alert">
            ?????????????????????????????????????????????????????????
        </div>
        <?php
    }
    ?>
<?php
}
?>