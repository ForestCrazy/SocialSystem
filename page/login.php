<?php
if (isset($_SESSION['user_id'])) {
    header("location:index.php");
} else {
?>
    <h4 class="text-center">เข้าสู่ระบบ</h4>
    <form action="" method="POST" class="col-lg-4 mx-auto">
        <div class="mb-3">
            <label for="username" class="form-label">ชื่อผู้ใช้</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">รหัสผ่าน</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary col-12" name="submit_login">เข้าสู่ระบบ</button>
    </form>
<?php
}
if (isset($_POST['submit_login'])) {
    $query_login = mysqli_query($connect, "SELECT * FROM user WHERE username = '". $_POST['username'] ."' AND password = '". hash('sha256', $_POST['password']) ."'");
    if (mysqli_num_rows($query_login) == 1) {
        $fetch_login = mysqli_fetch_assoc($query_login);
        $_SESSION['user_id'] = $fetch_login['user_id'];
        $_SESSION['username'] = $fetch_login['username'];
        echo "<script>alert('เข้าสู่ระบบสำเร็จ');</script>";
        echo "<script>window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');</script>";
        echo "<script>window.location.href='index.php?page=login';</script>";
    }
}