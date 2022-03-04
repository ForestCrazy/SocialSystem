<?php
if (isset($_SESSION['user_id'])) {
    header("location:index.php");
} else {
?>
    <h4 class="text-center">สมัครบัญชี</h4>
    <form action="" method="POST" class="col-lg-4 mx-auto" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label">ชื่อผู้ใช้</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">รหัสผ่าน</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">ชื่อ</label>
            <input type="firstname" class="form-control" id="firstname" name="firstname" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">นามสกุล</label>
            <input type="lastname" class="form-control" id="lastname" name="lastname" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">เพศ</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender1" value="male" required>
                <label class="form-check-label" for="gender1">
                    ชาย
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender2" value="female" required>
                <label class="form-check-label" for="gender2">
                    หญิง
                </label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="uploadFile">อัพโหลดรูปภาพโปรไฟล์</label>
            <input class="form-control" type="file" name="uploadFile" id="uploadFile">
        </div>
        <button type="submit" class="btn btn-primary col-12" name="submit_register">สมัครบัญชี</button>
    </form>
<?php
}
if (isset($_POST['submit_register'])) {
    $filename = NULL;
    if ($_FILES['uploadFile']['name'] != NULL) {
        $filename = "images/user/" . time() . $_FILES['uploadFile']['name'];
        move_uploaded_file($_FILES['uploadFile']['tmp_name'], $filename);
    }
    $query_register = mysqli_query($connect, "INSERT INTO user (username, password, firstname, lastname, gender, img) VALUES ('" . $_POST['username'] . "', '" . hash('sha256', $_POST['password']) . "', '" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['gender'] . "', '" . $filename . "')");
    if ($query_register) {
        $_SESSION['user_id'] = mysqli_insert_id($connect);
        $_SESSION['username'] = $_POST['username'];
        echo "<script>alert('สร้างบัญชีสำเร็จ')</script>";
        echo "<script>window.location.href='index.php?page=home';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด');</script>";
        echo "<script>window.location.href='index.php?page=register';</script>";
    }
}
