<?php
if(isset($_SESSION["user_id"]) OR isset($_SESSION["username"])) {
    ?>
    <script>
        window.location = "?page=home";
    </script>
    <?php
} else {
    if (isset($_POST["submit_register"])) {
        $sql_check_user = 'SELECT * FROM account WHERE username = "' . $_POST["username"] . '" OR email = "' . $_POST["email"] . '"';
        $res_check_user = mysqli_query($connect, $sql_check_user);
        if (mysqli_num_rows($res_check_user) > 0) {
            ?>
            <div class="alert alert-success" role="alert">
                ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้แล้ว
            </div>
            <?php
        } else {
            $file_name = '';
            if ($_FILES['up']['size'] != 0) {
                if (move_uploaded_file($_FILES['up']['tmp_name'], './asset/img_profile/' . time() . $_FILES['up']['name'])) {
                    $file_name = time() . $_FILES['up']['name'];
                }
            }
            $sql_insert_user = 'INSERT INTO account (`FirstName`, `LastName`, `username`, `password`, `email`, `birthday`, `img_profile`) VALUES ("' . $_POST["FirstName"] . '", "' . $_POST["LastName"] . '", "' . $_POST["username"] . '", "' . $_POST["password"] . '", "' . $_POST["email"] . '", "' . $_POST["birthday"] . '", "' . $file_name . '")';
            $res_insert_user = mysqli_query($connect, $sql_insert_user);
            if ($res_insert_user) {
            ?>
                <div class="alert alert-success" role="alert">
                    สมัครสมาชิกสำเร็จ
                </div>
                <script>
                    setTimeout(() => {
                        window.location = '?page=login';
                    }, 3000);
                </script>
            <?php
            } else {
            ?>
                <div class="alert alert-danger" role="alert">
                    เกิดข้อผิดพลาดไม่ทราบสาเหตุ
                </div>
            <?php
            }
        }
    }
    ?>
    <h3 style="text-align: center;">สมัครสมาชิก</h3>
    <form action="" method="POST" enctype='multipart/form-data'>
        <div class="row">
            <div class="col-sm-6 form-group">
                <label>ชื่อ</label>
                <input type="text" name="FirstName" class="form-control" required>
            </div>
            <div class="col-sm-6 form-group">
                <label>นามสกุล</label>
                <input type="text" name="LastName" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label>ชื่อผู้ใช้</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>รหัสผ่าน</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>อีเมล</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>วัน เดือน ปี เกิด</label>
            <input type="date" name="birthday" class="form-control" required>
        </div>
        <div class='form-group'>
            <label>โปรไฟล์</label>
            <input type='file' name='up' class='form-control' required>
        </div>
        <button type="submit" class="btn btn-success col-12" name="submit_register">สมัครสมาชิก</button>
    </form>
    <?php
}