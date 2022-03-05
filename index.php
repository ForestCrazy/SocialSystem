<?php
include 'includes/function.php';
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include 'includes/navbar.php';
    ?>
    <div class="container">
        <div class="row">
            <div style="margin-left: auto; margin-right: auto; float: none;" class="col-md-4" enctype="multipart/form-data">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h5 class="text-center">โพสต์</h5>
                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" name="text">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input type="file" id="exampleInputFile" name="uploadimg">
                    </div>
                    <button type="submit" class="btn btn-default" name="submit">Submit</button>
                </form>
            </div>
        </div>
        <br />
        <?php
        $result = mysqli_query($conn, "SELECT * FROM post INNER JOIN user ON post.u_id = user.id WHERE user.id = '" . $_SESSION['id'] . "'");
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="row">
                <div style="margin-left: auto; margin-right: auto; border: 1px solid black; float: none;" class="col-md-4">
                    <h5><?php echo $row['firstname'] . "&nbsp;" . $row['lastname']; ?></h5>
                    <p><?php echo $row['text']; ?></p>
                    <img src="<?php echo $row['image']; ?>" style="width: 100%;" />
                </div>
            </div>
            <br />
        <?php
        }
        ?>
    </div>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
    $file = "";
    if ($_FILES['uploadimg']['name'] != "") {
        $file = "post/" . time() . $_FILES['uploadimg']['name'];
        move_uploaded_file($_FILES['uploadimg']['tmp_name'], "post/" . time() . $_FILES['uploadimg']['name']);
    }
    if (mysqli_query($conn, "INSERT INTO post (text, image, u_id) VALUES ('" . $_POST['text'] . "', '" . $file . "', '" . $_SESSION['id'] . "')")) {
        echo "<script>alert('โพสต์สำเร็จ');window.location = 'index.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด');window.location = 'index.php';</script>";
    }
}
