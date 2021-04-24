<?php
if (!isset($_GET["search_name"])) {
    ?>
        <script>
            window.location = '?page=home';
        </script>
    <?php
} else {
    $sql_search_user = 'SELECT * FROM account WHERE (FirstName LIKE "%' . $_GET["search_name"] . '%" OR Lastname LIKE "%' . $_GET["search_name"] . '%") AND acc_status = "accept"';
    $res_search_user = mysqli_query($connect, $sql_search_user);
    while ($fetch_search_user = mysqli_fetch_assoc($res_search_user)) {
    ?>
        <div class="card">
            <div class="card-body d-flex">
                <h5 class="mr-auto">ชื่อจริง นามสกุล</h5>
                <form action="?page=search&search_name=<?= $_GET["search_name"] ?>" method="POST">
                    <input type="hidden" name="user_info" value="<?= $fetch_search_user["user_id"] ?>">
                    <?php
                    if ($fetch_search_user["user_id"] != $_SESSION["user_id"]) {
                        $sql_check_friend = 'SELECT * FROM arefriend WHERE (user_id_1 = "' . $_SESSION["user_id"] . '" AND user_id_2 = "' . $fetch_search_user["USER_ID"] . '") OR (user_id_1 = "' . $fetch_search_user["USER_ID"] . '" AND user_id_2 = "' . $_SESSION["user_id"] . '")';
                        $res_check_friend = mysqli_query($connect, $sql_check_friend);
                        $fetch_check_friend = mysqli_fetch_assoc($res_check_friend);
                        if (mysqli_num_rows($res_check_friend) == 1) {
                            if ($fetch_check_friend["AreFriend"] == "True") {
                            ?>
                                <div class="btn btn-success">เพื่อน</div>
                            <?php
                            } else {
                                if ($fetch_check_friend["user_id_1"] == $_SESSION["user_id"]) {
                                ?>
                                    <div class="btn btn-secondary">กำลังรออนุมัติการเป็นเพื่อน</div>
                                <?php
                                } else {
                                ?>
                                    <div class="btn btn-secondary">ตอบรับคำขอเป็นเพื่อน</div>
                                <?php
                                }
                            }
                        } else {

                        }
                    }
                    ?>
                </form>
            </div>
        </div>
    <?php
    }
}