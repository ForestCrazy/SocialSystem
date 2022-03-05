<?php
if (!isset($_SESSION['user_id'])) {
    header("location:index.php?page=login");
} else {
    $user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE user_id = '" . $_SESSION['user_id'] . "'"))
?>
    <h4 class="text-center">แก้ไขข้อมูล</h4>
    <form action="" method="POST" class="col-lg-4 mx-auto" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label">ชื่อผู้ใช้</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">ชื่อ</label>
            <input type="firstname" class="form-control" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>">
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">นามสกุล</label>
            <input type="lastname" class="form-control" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>">
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">เพศ</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender1" value="male" <?php if ($user['gender'] == "male") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                <label class="form-check-label" for="gender1">
                    ชาย
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender2" value="female" <?php if ($user['gender'] == "female") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                <label class="form-check-label" for="gender2">
                    หญิง
                </label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="uploadFile">อัพโหลดรูปภาพโปรไฟล์</label>
            <input class="form-control" type="file" name="uploadFile" id="uploadFile">
            <input type="hidden" name="img" value="<?php echo $user['img']; ?>">
        </div>
        <button type="submit" class="btn btn-primary col-12" name="submit_edit">บันทึกการแก้ไข</button>
    </form>
<?php
}
if (isset($_POST['submit_edit'])) {
    $filename = $_POST['img'];
    if ($_FILES['uploadFile']['name'] != NULL) {
        unlink($filename);
        $filename = "images/user/" . time() . $_FILES['uploadFile']['name'];
        move_uploaded_file($_FILES['uploadFile']['tmp_name'], $filename);
    }
    $query_edit = mysqli_query($connect, "UPDATE user SET firstname = '" . $_POST['firstname'] . "', lastname = '" . $_POST['lastname'] . "', gender = '" . $_POST['gender'] . "', img = '" . $filename . "' WHERE user_id = '" . $_SESSION['user_id'] . "'");
    if ($query_edit) {
        echo "<script>alert('แก้ไขข้อมูลสำเร็จ')</script>";
        echo "<script>window.location.href='index.php?page=edit_info';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด');</script>";
        echo "<script>window.location.href='index.php?page=edit_info';</script>";
    }
}
