<?php
if (!isset($_SESSION["user_id"]) or !isset($_SESSION["username"])) {
?>
    <script>
        window.location = "?page=home";
    </script>
    <?php
} else {
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
    } else {
        $user_id = $_SESSION['user_id'];
    }

    if (isset($_POST['submit_edit_password'])) {
        $sql_update_info = 'UPDATE account SET password = "' . $_POST['password'] . '" WHERE user_id = "' . $_SESSION['user_id'] . '" AND username = "' . $_SESSION['username'] . '"';
        $res_update_info = mysqli_query($connect, $sql_update_info);
        if ($res_update_info) {
    ?>
            <div class="alert alert-success" role="alert">
                เปลี่ยนรหัสผ่านสำเร็จ
            </div>
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
    <h3 style="text-align: center;">เปลี่ยนรหัสผ่าน</h3>
    <form action="" method="POST">
        <div class="form-group">
            <label>รหัสผ่าน</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button class="btn btn-success col-12" type="submit" name="submit_edit_password">เปลี่ยนรหัสผ่าน</button>
    </form>
<?php
}
?>