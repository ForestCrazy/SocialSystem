<?php
if (!isset($_SESSION["user_id"]) OR !isset($_SESSION["username"]) OR !isset($_SESSION["level"])) {
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
    $sql_user = 'SELECT * FROM account WHERE user_id = "' . $user_id . '"';
    $res_user = mysqli_query($connect, $sql_user);
    $fetch_user = mysqli_fetch_assoc($res_user);
    
    if (isset($_POST['submit_edit_user_info'])) {
        $file_name = UserInfo($user_id)['img_profile'];
        if ($_FILES['up']['size'] != 0) {
            unlink('./asset/img_profile/' . $file_name);
            if (move_uploaded_file($_FILES['up']['tmp_name'], './asset/img_profile/' . time() . $_FILES['up']['name'])) {
                $file_name = time() . $_FILES['up']['name'];
            }
        }

        $sql_update_info = 'UPDATE account SET FirstName = "' . $_POST['FirstName'] . '", LastName = "' . $_POST['LastName'] . '", email = "' . $_POST['email'] . '", birthday = "' . $_POST['birthday'] . '", img_profile = "' . $file_name . '" WHERE user_id = "' . $_SESSION['user_id'] . '" AND username = "' . $_SESSION['username'] . '"';
        $res_update_info = mysqli_query($connect, $sql_update_info);
        if ($res_update_info) {
            ?>
            <div class="alert alert-success" role="alert">
                อัพเดทข้อมูลสำเร็จ!
            </div>
            <script>
            setTimeout(() => {
                window.location = window.location;
            }, 2000);
            </script>
            <?php
        } else {
            ?>
            
            <?php
        }
    }
?>
    <h3 style="text-align: center;">แก้ไขข้อมูล</h3>
    <form action="" method="POST" enctype='multipart/form-data'>
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>ชื่อ</label>
                <input type="text" name="FirstName" class="form-control" value="<?= $fetch_user['FirstName'] ?>">
            </div>
            <div class="col-sm-6 form-group">
                <label>นามสกุล</label>
                <input type="text" name="LastName" class="form-control" value="<?= $fetch_user['LastName'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label>อีเมล</label>
            <input type="email" name="email" class="form-control" value="<?= $fetch_user['email'] ?>" required>
        </div>
        <div class="form-group">
            <label>วัน เดือน ปี เกิด</label>
            <input type="date" name="birthday" class="form-control" value="<?=  $fetch_user['birthday']?>" required>
        </div>
        <div class='form-group'>
            <label>โปรไฟล์</label>
            <input type='file' name='up' class='form-control'>
        </div>
        <button type="submit" class="btn btn-success col-12" name="submit_edit_user_info">แก้ไขข้อมูล</button>
    </form>
<?php
}
?>