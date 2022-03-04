<?php
if (!isset($_SESSION['user_id'])) {
    header("location:index.php?page=login");
} else {
    $row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM comment WHERE comment_id = '".$_GET['comment_id']."'"));
?>
    <h4 class="text-center">แก้ไขคอมเมนต์</h4>
    <form action="" method="POST" class="col-lg-4 mx-auto">
        <div class="mb-3">
            <input type="text" class="form-control" id="comment_text" name="comment_text" value="<?php echo $row['comment_text']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary col-12" name="submit_edit" value="<?php echo $row['comment_id']; ?>">แก้ไขคอมเมนต์</button>
    </form>
<?php
}
if (isset($_POST['submit_edit'])) {
    $query_edit = mysqli_query($connect, "UPDATE comment SET comment_text = '".$_POST['comment_text']."' WHERE comment_id = '".$_POST['submit_edit']."'");
    if ($query_edit) {
        echo "<script>alert('แก้ไขคอมเมนต์สำเร็จ');</script>";
        echo "<script>window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด');</script>";
        echo "<script>window.location.href='index.php';</script>";
    }
}