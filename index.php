<?php
require 'includes/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>ระบบเครือข่ายสังคม</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">หน้าหลัก</a>
                    </li>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $_SESSION['username']; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="?page=edit_info">แก้ไขข้อมูล</a>
                                </li>
                                <li><a class="dropdown-item" href="?page=change_password">เปลี่ยนรหัสผ่าน</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="?page=logout">ออกจากระบบ</a></li>
                            </ul>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=login">เข้าสู่ระบบ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=register">สมัครสมาชิก</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <br />
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'login':
                    include 'page/login.php';
                    break;
                case 'register':
                    include 'page/register.php';
                    break;
                case 'edit_info':
                    include 'page/edit_info.php';
                    break;
                case 'change_password':
                    include 'page/change_password.php';
                    break;
                case 'logout':
                    include 'page/logout.php';
                    break;
                case 'change_password':
                    include 'page/change_password.php';
                    break;
                case 'edit_post':
                    include 'page/edit_post.php';
                    break;
                case 'edit_comment':
                    include 'page/edit_comment.php';
                    break;
                default:
                    include 'page/home.php';
                    break;
            }
        } else {
            include 'page/home.php';
        }
        ?>
    </div>
</body>

</html>