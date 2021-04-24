<?php
if (!isset($_SESSION["user_id"]) OR !isset($_SESSION["username"]) OR !isset($_SESSION["level"])) {
    ?>
    <script>
        window.location = "?page=home";
    </script>
    <?php
} else {
    if (isset($_POST['submit_post'])) {
        $file_name = '';
        if ($_FILES['up']['size'] != 0) {
            if (move_uploaded_file($_FILES['up']['tmp_name'], './asset/img_post/' . time() . $_FILES['up']['name'])) {
                $file_name = time() . $_FILES['up']['name'];
            }
        }
        
        $sql_post = 'INSERT INTO post (post_message, post_img, user_id) VALUES ("' . $_POST['post_msg'] . '", "' . $file_name . '", "' . $_SESSION['user_id'] . '")';
        $res_post = mysqli_query($connect, $sql_post);
        if ($res_post) {
            ?>
            <div class="alert alert-success" role="alert">
                โพสต์สำเร็จ
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
?>
    <h3 style="text-align: center;">สร้างโพสต์</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" name="up" class="form-control">
        </div>
        <div class="form-group">
            <textarea class="form-control" rows="5" name="post_msg"></textarea>
        </div>
        <button type="submit" class="btn btn-success col-12" name="submit_post">โพสต์</button>
    </form>
<?php
}
?>