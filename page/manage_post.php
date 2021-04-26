<?php
if (!isset($_SESSION["user_id"]) OR !isset($_SESSION["username"])) {
    ?>
    <script>
        window.location = "?page=home";
    </script>
    <?php
} else {
    $sql_feed_post = 'SELECT * FROM post WHERE post_id = "' . $_GET['post_id'] . '"';
    $res_feed_post = mysqli_query($connect, $sql_feed_post);
    $fetch_feed_post = mysqli_fetch_assoc($res_feed_post);
    if (isset($_POST['submit_edit_post'])) {
        if ($_POST['post_msg'] != '' OR $_FILES['up']['size'] != 0) {
            $file_name = $fetch_feed_post['post_img'];
            if ($_FILES['up']['size'] != 0) {
                if (move_uploaded_file($_FILES['up']['tmp_name'], './asset/img_post/' . time() . $_FILES['up']['name'])) {
                    $file_name = time() . $_FILES['up']['name'];
                }
            }
            
            $sql_post = 'UPDATE post SET post_message = "' . $_POST['post_msg'] . '", post_img = "' . $file_name . '" WHERE post_id = "' . $fetch_feed_post['post_id'] . '"';
            $res_post = mysqli_query($connect, $sql_post);
            if ($res_post) {
                ?>
                <div class="alert alert-success" role="alert">
                    แก้ไขโพสต์สำเร็จ
                </div>
                <script>
                    setTimeout(() => {
                        window.location = '?page=home';
                    }, 3000);
                </script>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" role="alert">
                    เกิดข้อผิดพลาด
                </div>
                <?php
            }
        }
    }
?>
    <h3 style="text-align: center;">แก้ไขโพสต์</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" name="up" class="form-control">
        </div>
        <div class="form-group">
            <textarea class="form-control" rows="5" name="post_msg"><?= $fetch_feed_post['post_message'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-success col-12" name="submit_edit_post">แก้ไขโพสต์</button>
    </form>
<?php
}
?>