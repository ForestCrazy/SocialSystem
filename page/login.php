<?php
if(isset($_SESSION["user_id"]) OR isset($_SESSION["username"])) {
    ?>
    <script>
        window.location = "?page=home";
    </script>
    <?php
} else {
    if (isset($_POST["submit_login"])) {
        $sql_check_user = 'SELECT * FROM account WHERE username = "' . $_POST["username"] . '" AND password = "' . $_POST["password"] . '"';
        $res_check_user = mysqli_query($connect, $sql_check_user);
        if (mysqli_num_rows($res_check_user) == 1) {
            $fetch_check_user = mysqli_fetch_assoc($res_check_user);
            if ($fetch_check_user["acc_status"] == "pending") {
            ?>
                <div class="alert alert-primary" role="alert">
                    รอการอนุมัติบัญชี
                </div>
            <?php
            } elseif ($fetch_check_user["acc_status"] == "cancel") {
            ?>
                <div class="alert alert-danger" role="alert">
                    บัญชีคุณถูกระงับการใช้งาน
                </div>
            <?php
            } else {
                $_SESSION["user_id"] = $fetch_check_user["user_id"];
                $_SESSION["username"] = $fetch_check_user["username"];
            ?>
                <div class="alert alert-success" role="alert">
                    เข้าสู่ระบบสำเร็จ กำลังพาท่านไปหน้าหลัก
                </div>
                <script>
                    setTimeout(() => {
                        window.location = '?page=home';
                    }, 3000);
                </script>
            <?php
            }
            
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
            </div>
            <?php
        }
    }
    ?>
    <h3 style="text-align: center;">เข้าสู่ระบบ</h3>
    <form action="" method="POST">
        <div class="form-group">
            <label>ชื่อผู้ใช้</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>รหัสผ่าน</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success col-12" name="submit_login">เข้าสู่ระบบ</button>
    </form>
    <?php
}