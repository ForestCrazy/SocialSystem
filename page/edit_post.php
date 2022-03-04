<?php
if (!isset($_SESSION['user_id'])) {
    header("location:index.php?page=login");
} else {
    $row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM post WHERE post_id = '" . $_GET['post_id'] . "'"))
?>
    <h4 class="text-center">แก้ไขโพสต์</h4>
    <form action="" method="POST" class="col-lg-4 mx-auto" enctype="multipart/form-data">
        <div class="mb-3">
            <textarea class="form-control" name="post-text" id="floatingTextarea"><?php echo $row['post_text']; ?></textarea>
        </div>
        <div class="mb-3">
            <input type="hidden" name="post_img" value="<?php echo $row['post_img']; ?>">
            <input class="form-control" type="file" name="uploadFile" id="uploadFile">
        </div>
        <button type="submit" class="btn btn-primary col-12" name="submit_edit" value="<?php echo $row['post_id']; ?>">แก้ไขโพสต์</button>
    </form>
<?php
}
if (isset($_POST['submit_edit'])) {
    $filename = $_POST['post_img'];
    if ($_FILES['uploadFile']['name'] != NULL) {
        $filename = "images/post/" . time() . $_FILES['uploadFile']['name'];
        move_uploaded_file($_FILES['uploadFile']['tmp_name'], $filename);
    }
    $query_edit = mysqli_query($connect, "UPDATE post SET post_text = '" . $_POST['post-text'] . "', post_img = '" . $filename . "' WHERE post_id = '" . $_POST['submit_edit'] . "'");
    if ($query_edit) {
        echo "<script>alert('แก้ไขโพสต์สำเร็จ');</script>";
        echo "<script>window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด');</script>";
        echo "<script>window.location.href='index.php';</script>";
    }
}
