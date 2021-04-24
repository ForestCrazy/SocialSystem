<?php
if (!isset($_SESSION["user_id"]) OR !isset($_SESSION["username"]) OR !isset($_SESSION["level"])) {
    ?>
    <script>
        window.location = "?page=login";
    </script>
    <?php
} else {
    if (isset($_GET['cm_id'])) {
        $sql_cm = 'SELECT * FROM comment WHERE cm_id = "' . $_GET['cm_id'] . '"';
        $res_cm = mysqli_query($connect, $sql_cm);
        $fetch_cm = mysqli_fetch_assoc($res_cm);

        if (isset($_POST['submit_edit_cm'])) {
            $sql_edit_cm = 'UPDATE comment SET cm_message = "' . $_POST['cm_msg'] . '" WHERE cm_id = "' . $_GET['cm_id'] . '"';
            $res_edit_cm = mysqli_query($connect, $sql_edit_cm);
            if ($res_edit_cm) {
                ?>
                <div class="alert alert-success" role="alert">
                    แก้ไขคอมเมนต์สำเร็จ
                </div>
                <script>
                setTimeout(() => {
                    window.location = '?page=home';
                }, 3000);
                </script>
                <?php
            }
        }
    ?>
    <h3 style="text-align: center;">แก้ไขคอมเมนต์</h3>
    <form action="" method="POST">
        <div class="form-group">
            <label>คอมเมนต์</label>
            <input type="text" name="cm_msg" class="form-control" value="<?= $fetch_cm['cm_message'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success col-12" name="submit_edit_cm">แก้ไขคอมเมนต์</button>
    </form>
    <?php
    } else {

    }
}
?>