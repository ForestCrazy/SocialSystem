<?php
include 'includes/function.php';
if (isset($_SESSION['id'])) {
    header("Location: index.php");
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
        <form action="" method="POST" style="margin-left: auto; margin-right: auto; width: 40%;" enctype="multipart/form-data">
            <h4 class="text-center">Register</h4>
            <div class="form-group">
                <label for="exampleInputUsername">Username</label>
                <input type="text" class="form-control" id="exampleInputUsername" name="Username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="exampleInputFirstName">FirstName</label>
                <input type="text" class="form-control" id="exampleInputFirstName" name="FirstName" placeholder="FirstName">
            </div>
            <div class="form-group">
                <label for="exampleInputLastName">LastName</label>
                <input type="text" class="form-control" id="exampleInputLastName" name="LastName" placeholder="LastName">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="Password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" id="exampleInputFile" name="uploadProfile">
            </div>
            <button type="submit" class="btn btn-default" name="register">Submit</button>
        </form>
    </div>
</body>

</html>
<?php
if (isset($_POST['register'])) {
    if ($_FILES['uploadProfile']['name'] != "") {
        move_uploaded_file($_FILES['uploadProfile']['tmp_name'], "profile/" . time() . $_FILES['uploadProfile']['name']);
    }
    if (mysqli_query($conn, "INSERT INTO user (username, password, firstname, lastname, profile) VALUES ('" . $_POST['Username'] . "', '" . $_POST['Password'] . "', '" . $_POST['FirstName'] . "', '" . $_POST['LastName'] . "', '" . time() . $_FILES['uploadProfile']['name'] . "')")) {
        $_SESSION['id'] = mysqli_insert_id($conn);
        $_SESSION['username'] = $_POST['Username'];
        echo "<script>alert('Register Success');</script>";
        echo "<script>window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Register Fail');</script>";
        echo "<script>window.location.href='register.php';</script>";
    }
}