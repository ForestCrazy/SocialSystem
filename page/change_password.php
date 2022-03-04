<?php
if (!isset($_SESSION['user_id'])) {
    header("location:index.php?page=login");
} else {
?>
    <h4 class="text-center">เปลี่ยนรหัสผ่าน</h4>
    <form action="" method="POST" class="col-lg-4 mx-auto">
        <div class="mb-3">
            <label for="password" class="form-label">รหัสผ่านใหม่</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary col-12" name="submit_edit">เปลี่ยนรหัสผ่าน</button>
    </form>
<?php
}
if (isset($_POST['submit_edit'])) {
    $query_edit = mysqli_query($connect, "UPDATE user SET password = '". hash('sha256', $_POST['password']) ."' WHERE user_id = '". $_SESSION['user_id'] ."'");
    if ($query_edit) {
        echo "<script>alert('เปลี่ยนรหัสผ่านสำเร็จ')</script>";
        echo "<script>window.location.href='index.php?page=change_password';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด');</script>";
        echo "<script>window.location.href='index.php?page=change_password';</script>";
    }
}
