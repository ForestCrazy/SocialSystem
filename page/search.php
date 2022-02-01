<?php
if (!isset($_GET["search_name"])) {
    ?>
        <script>
            window.location = '?page=home';
        </script>
    <?php
} else {
    $explode_search_user = preg_replace('!\s+!', ' ', $_GET['search_name']);
    $explode_search_user = explode(' ', $explode_search_user);
    if (count($explode_search_user) == 2) {
        $sql_search_user = 'SELECT * FROM account WHERE (Firstname LIKE "%' . $explode_search_user[0] . '%" OR Lastname LIKE "%' . $explode_search_user[1] . '%") AND acc_status = "accept"';
    } else {
        $sql_search_user = 'SELECT * FROM account WHERE (FirstName LIKE "%' . $_GET["search_name"] . '%" OR Lastname LIKE "%' . $_GET["search_name"] . '%") AND acc_status = "accept"';
    }
    $res_search_user = mysqli_query($connect, $sql_search_user);
    while ($fetch_search_user = mysqli_fetch_assoc($res_search_user)) {
    ?>
        <div class="card">
            <div class="card-body d-flex row">
                <div class="col-2">
                    <img src="./asset/img_profile/<?= $fetch_search_user['img_profile'] ?>" style="max-height: 120px;" alt="" class="img-fluid">
                </div>
                <div class='col-6'>
                    <h5 class="mr-auto"><?= $fetch_search_user['FirstName'] . '&emsp;' . $fetch_search_user['LastName'] ?></h5>
                </div>
                <div class='col-4'>
                    <?php
                    if ($fetch_search_user["user_id"] != $_SESSION["user_id"]) {
                        $sql_check_friend = 'SELECT * FROM friendrelation WHERE (user_id_1 = "' . $_SESSION["user_id"] . '" AND user_id_2 = "' . $fetch_search_user["user_id"] . '") OR (user_id_1 = "' . $fetch_search_user["user_id"] . '" AND user_id_2 = "' . $_SESSION["user_id"] . '")';
                        $res_check_friend = mysqli_query($connect, $sql_check_friend);
                        $fetch_check_friend = mysqli_fetch_assoc($res_check_friend);
                        if (mysqli_num_rows($res_check_friend) > 0) {
                            if ($fetch_check_friend["AreFriend"] == "True") {
                            ?>
                                <div class="btn btn-primary">เพื่อน</div>
                            <?php
                            } else {
                                if ($fetch_check_friend["user_id_1"] == $_SESSION["user_id"]) {
                                ?>
                                    <div class="btn btn-secondary">กำลังรออนุมัติการเป็นเพื่อน</div>
                                <?php
                                } else {
                                ?>
                                <form action='' method='POST'>
                                    <input type='hidden' name='user_id' value='<?= $fetch_search_user['user_id'] ?>'>
                                    <button class="btn btn-secondary" name='action' value='acceptfriend'>ตอบรับคำขอเป็นเพื่อน</button>
                                </form>
                                <?php
                                }
                            }
                        } else {
                            ?>
                                <form action='' method='POST'>
                                    <input type='hidden' name='user_id' value='<?= $fetch_search_user['user_id'] ?>' >
                                    <button type='submit' class='btn btn-success' name='action' value='addfriend'>เพิ่มเพื่อน</button>
                                </form>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    }
}