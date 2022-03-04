<?php
if (!isset($_SESSION['user_id'])) {
    header("location:index.php?page=login");
} else {
?>
    <div class="col-lg-6 mx-auto">
        <div class="border border-1 p-2">
            <h5>สร้างโพสต์</h5>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <textarea class="form-control" name="post-text" id="floatingTextarea"></textarea>
                </div>
                <div class="mb-3">
                    <input class="form-control" type="file" name="uploadFile" id="uploadFile">
                </div>
                <button type="submit" class="btn btn-primary col-12" name="submit_post">สร้างโพสต์</button>
            </form>
        </div>
        <br />
        <?php
        $query = mysqli_query($connect, "SELECT * FROM post INNER JOIN user ON post.user_id = user.user_id WHERE user.user_id = '" . $_SESSION['user_id'] . "' ORDER BY post_id DESC");
        while ($row = mysqli_fetch_assoc($query)) {
            $query_comment = mysqli_query($connect, "SELECT * FROM comment INNER JOIN user ON comment.user_id = user.user_id WHERE comment.post_id = '" . $row['post_id'] . "' ORDER BY comment_id DESC");
        ?>
            <div class="border border-1 p-2">
                <div>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img style="max-width: 64px;" src="<?php echo $row['img']; ?>">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5><?php echo $row['firstname'] . " " . $row['lastname']; ?></h5>
                            <small><?php echo $row['time']; ?></small>
                        </div>
                        <?php
                        if ($row['user_id'] == $_SESSION['user_id']) {
                        ?>
                            <a href="?page=edit_post&post_id=<?php echo $row['post_id']; ?>">
                                <div class="btn btn-primary">แก้ไข</div>
                            </a>
                            <form action="" method="POST">
                                <button type="submit" class="btn btn-danger h-100" name="delete_post" value="<?php echo $row['post_id']; ?>">ลบ</button>
                            </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <hr />
                <p><?php echo $row['post_text']; ?></p>
                <div class="text-center">
                    <img class="img-fluid" src="<?php echo $row['post_img']; ?>" alt="">
                </div>
                <div class="p-2">
                    <form action="" method="POST">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="comment_text" aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="submit" name="submit_comment" value="<?php echo $row['post_id']; ?>" id="button-addon2">คอมเมนต์</button>
                        </div>
                    </form>
                    <?php
                    while ($row_comment = mysqli_fetch_assoc($query_comment)) {
                    ?>
                        <div class="border border-1 p-2">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img style="max-width: 48px;" src="<?php echo $row_comment['img']; ?>">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <?php echo $row_comment['firstname'] . " " . $row_comment['lastname']; ?><br />
                                    <small><?php echo $row_comment['comment_text']; ?></small>
                                </div>
                                <?php
                                if ($row_comment['user_id'] == $_SESSION['user_id']) {
                                ?>
                                    <a href="?page=edit_comment&comment_id=<?php echo $row_comment['comment_id']; ?>"><button class="btn btn-primary">แก้ไข</button></a>
                                    <form action="" method="POST">
                                        <button type="submit" class="btn btn-danger" name="delete_comment" value="<?php echo $row_comment['comment_id']; ?>">ลบ</button>
                                    </form>
                                <?php
                                }
                                ?>
                            </div>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <br />
        <?php
        }
        ?>
    </div>
<?php
    if (isset($_POST['submit_post'])) {
        $filename = NULL;
        if ($_FILES['uploadFile']['name'] != NULL) {
            $filename = "images/post/" . time() . $_FILES['uploadFile']['name'];
            move_uploaded_file($_FILES['uploadFile']['tmp_name'], $filename);
        }
        $query = "INSERT INTO post (post_text, post_img, user_id) VALUES ('" . $_POST['post-text'] . "', '" . $filename . "', '" . $_SESSION['user_id'] . "')";
        if (mysqli_query($connect, $query)) {
            echo "<script>alert('โพสต์สำเร็จ');</script>";
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('โพสต์ไม่สำเร็จ');</script>";
            echo "<script>window.location.href='index.php';</script>";
        }
    }
    if (isset($_POST['delete_post'])) {
        $query = "DELETE FROM post WHERE post_id = '" . $_POST['delete_post'] . "'";
        if (mysqli_query($connect, $query)) {
            echo "<script>alert('ลบโพสต์สำเร็จ');</script>";
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('ลบโพสต์ไม่สำเร็จ');</script>";
            echo "<script>window.location.href='index.php';</script>";
        }
    }
    if (isset($_POST['submit_comment'])) {
        if (mysqli_query($connect, "INSERT INTO comment (comment_text, post_id, user_id) VALUES ('" . $_POST['comment_text'] . "', '" . $_POST['submit_comment'] . "', '" . $_SESSION['user_id'] . "')")) {
            echo "<script>alert('คอมเมนต์สำเร็จ');</script>";
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('คอมเมนต์ไม่สำเร็จ');</script>";
            echo "<script>window.location.href='index.php';</script>";
        }
    }
    if (isset($_POST['delete_comment'])) {
        if (mysqli_query($connect, "DELETE FROM comment WHERE comment_id = '" . $_POST['delete_comment'] . "'")) {
            echo "<script>alert('ลบคอมเมนต์สำเร็จ');</script>";
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('ลบคอมเมนต์ไม่สำเร็จ');</script>";
            echo "<script>window.location.href='index.php';</script>";
        }
    }
}
