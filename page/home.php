<?php
if (!isset($_SESSION["user_id"]) OR !isset($_SESSION["username"])) {
    ?>
    <script>
        window.location = "?page=login";
    </script>
    <?php
} else {
    if (isset($_GET['user_id'])) {
        $sql_feed_post_list = 'SELECT * FROM (SELECT * FROM account WHERE user_id = "' . $_GET['user_id'] . '") AS account INNER JOIN post ON account.user_id = post.user_id ORDER BY post.post_id';
    } else {
        $sql_feed_post_list = 'SELECT * FROM (SELECT * FROM account LEFT JOIN (SELECT * FROM friendrelation WHERE (user_id_1 = "' . $_SESSION['user_id'] . '" OR user_id_2 = "' . $_SESSION['user_id'] . '") AND AreFriend = "True") AS friendrelation ON account.user_id = friendrelation.user_id_1 OR account.user_id = friendrelation.user_id_2 WHERE AreFriend IS NOT NULL) AS user_list INNER JOIN post ON user_list.user_id = post.user_id GROUP BY post.post_id ORDER BY post.post_id';
    }
    $res_feed_post_list = mysqli_query($connect, $sql_feed_post_list);

    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'cm') {
            $sql_cm = 'INSERT INTO comment (cm_message, user_id, post_id) VALUES ("' . $_POST['comment_msg'] . '", "' . $_SESSION['user_id'] . '", "' . $_POST['post_id'] . '")';
            $res_cm = mysqli_query($connect, $sql_cm);
            if ($res_cm) {
                ?>
                <script>
                window.location = window.location;
                </script>
                <?php
            }
        } elseif ($_POST['action'] == 'deletecm') {
            $sql_cm = 'DELETE FROM comment WHERE cm_id = "' . $_POST['cm_id'] . '"';
            $res_cm = mysqli_query($connect, $sql_cm);
            if ($res_cm) {
                ?>
                <script>
                window.location = window.location;
                </script>
                <?php
            }
        } elseif ($_POST['action'] == 'deletepost') {
            $sql_post = 'SELECT * FROM post WHERE post_id = "' . $_POST['post_id'] . '"';
            $res_post = mysqli_query($connect, $sql_post);
            $fetch_post = mysqli_fetch_assoc($res_post);
            if ($fetch_post['post_img'] != '') {
                unlink('./asset/img_post/' . $fetch_post['post_img']);
            }
            $sql_post = 'DELETE FROM post WHERE post_id = "' . $_POST['post_id'] . '"';
            $res_post = mysqli_query($connect, $sql_post);
            $sql_cm = 'DELETE FROM comment WHERE post_id = "' . $_POST['post_id'] . '"';
            $res_cm = mysqli_query($connect, $sql_cm);
            if ($res_post && $res_cm) {
                ?>
                <script>
                window.location = window.location;
                </script>
                <?php
            }
        }
    }
?>
    <h4>Feed</h4>
    <div class="row d-flex justify-content-center">
    <?php
    while ($fetch_feed_post_list = mysqli_fetch_assoc($res_feed_post_list)) {
        ?>
        <div class="p-2 col-md-8">
            <div class="bg-white border mt-2">
                <div>
                    <div class="d-flex flex-row justify-content-between align-items-center p-2 border-bottom">
                        <div class="d-flex flex-row align-items-center feed-text px-2"><img class="user-avatar-md" src="./asset/img_profile/<?= $fetch_feed_post_list['img_profile'] ?>" width="45">
                            <div class="d-flex flex-column flex-wrap ml-2"><span class="font-weight-bold"><?= $fetch_feed_post_list['FirstName'] . '&emsp;' . $fetch_feed_post_list['LastName'] ?></span><span class="text-black-50 time"><?= $fetch_feed_post_list['create_time'] ?></span></div>
                        </div>
                        <div class="feed-icon px-2">
                        <?php
                        if ($fetch_feed_post_list['user_id'] == $_SESSION['user_id'] OR UserInfo($_SESSION['user_id'])['level'] == 'admin') {
                        ?>
                            <form action='' method='POST'>
                                <input type='hidden' name='post_id' value='<?= $fetch_feed_post_list['post_id'] ?>'>
                                <div class='btn btn-secondary w-100' onclick='window.location="?page=manage_post&post_id=<?= $fetch_feed_post_list['post_id'] ?>"'>แก้ไข</div>
                                <button class='btn btn-danger w-100' name='action' value='deletepost'>ลบ</button>
                            </form>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
                <div class="p-2 px-3"><span><?= $fetch_feed_post_list['post_message'] ?></span></div>
                <?php if ($fetch_feed_post_list['post_img'] != '') { ?><div class="feed-image p-2 px-3"><img class="img-fluid img-responsive" src="./asset/img_post/<?= $fetch_feed_post_list['post_img'] ?>" style='max-height: 450px;'></div> <?php } ?>
                <ul class="list-unstyled">
                <?php
                $sql_feed_comment_list = 'SELECT * FROM comment WHERE post_id = "' . $fetch_feed_post_list['post_id'] . '" ORDER BY cm_id';
                $res_feed_comment_list = mysqli_query($connect, $sql_feed_comment_list);

                while ($fetch_feed_comment_list = mysqli_fetch_assoc($res_feed_comment_list)) {
                    $fetch_user_comment = UserInfo($fetch_feed_comment_list['user_id']);
                ?>
                    <li class="media border m-1 rounded d-flex flex-row align-items-center feed-text px-2">
                        <img class="user-avatar-md mr-1" src="./asset/img_profile/<?= $fetch_user_comment['img_profile'] ?>" alt="CommentProfile">
                        <div class="media-body">
                            <div class='d-flex justify-content-start'>
                                <div class='w-100'>
                                    <h5 class="mt-0 mb-1"><?= $fetch_user_comment['FirstName'] . '&emsp;' . $fetch_user_comment['LastName'] ?></h5>
                                    <?= $fetch_feed_comment_list['cm_message'] ?>
                                </div>
                                <?php
                                if ($fetch_feed_comment_list['user_id'] == $_SESSION['user_id'] OR UserInfo($_SESSION['user_id'])['level'] == 'admin') {
                                ?>
                                    <div class='col-2 d-flex justify-content-end'>
                                        <form action='' method='POST'>
                                            <input type='hidden' name='cm_id' value='<?= $fetch_feed_comment_list['cm_id'] ?>'>
                                            <div class='btn btn-secondary w-100' onclick='window.location="?page=manage_comment&cm_id=<?= $fetch_feed_comment_list['cm_id'] ?>"'>แก้ไข</div>
                                            <button class='btn btn-danger w-100' name='action' value='deletecm'>ลบ</button>
                                        </form>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                <?php
                }
                ?>
                </ul>
                <form action='' method='POST'>
                    <div class="d-flex justify-content-start m-1">
                        <input type='text' class='form-control' name='comment_msg'>
                        <input type='hidden' name='post_id' value='<?= $fetch_feed_post_list['post_id'] ?>'>
                        <input type='hidden' name='action' value='cm'>
                        <button type='submit' class='btn btn-success'>คอมเมนต์</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
    ?>
    </div>
<?php
}
?>