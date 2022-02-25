<?php
include './system/connect.php';
if ((isset($_SESSION["user_id"]) or isset($_SESSION["username"]) or isset($_SESSION["level"])) and (!isset($_SESSION["user_id"]) or !isset($_SESSION["username"]))) {
?>
    <script>
        window.location = "?page=login"
    </script>
<?php
}

if (!isset($_GET["page"])) {
    $_GET["page"] = "home";
}
if (!$_GET) {
    $_GET["page"] = "home";
}
if (!$_GET["page"]) {
    $_GET["page"] = "home";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social System | ระบบเครือข่ายสังคม</title>
    <link rel="stylesheet" href="./asset/css/bootstrap.css">
    <script src="./asset/js/jquery-3.6.0.min.js"></script>
    <script src="./asset/js/bootstrap.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="?page=home">SocialSystem</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?page=home">หน้าหลัก</a>
                </li>

                <?php
                if (isset($_SESSION["username"])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=create_post">สร้างโพสต์</a>
                    </li>
                <?php
                }
                ?>
            </ul>

            <style>
                .user-avatar-md {
                    height: 32px;
                    width: 32px
                }

                .dropdown-menu-right {
                    right: 0;
                    left: auto;
                }
            </style>
            <?php
            if (isset($_SESSION["username"])) {
            ?>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle pl-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="./asset/img_profile/<?= UserInfo($_SESSION['user_id'])['img_profile'] ?>" alt="" class="user-avatar-md"> <?= $_SESSION['username'] ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="?page=edit_info">แก้ไขข้อมูล</a>
                        <a class="dropdown-item" href="?page=friend">เพื่อน</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="?page=logout">ออกจากระบบ</a>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle pl-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        บัญชี
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="?page=login">เข้าสู่ระบบ</a>
                        <a class="dropdown-item" href="?page=register">สมัครสมาชิก</a>
                    </div>
                </div>
            <?php
            }
            ?>

            <?php
            if (isset($_SESSION["username"])) {
                if (UserInfo($_SESSION['user_id'])['level'] == "admin") {
            ?>
                    <div class="dropdown">
                        <a class="btn btn-success dropdown-toggle" href="#" id="navbarDropdownSystem" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            จัดการระบบ
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownSystem">
                            <a class="dropdown-item" href="?page=admin&admin_page=accept_account">อนุมัติบัญชี</a>
                            <a class="dropdown-item" href="?page=admin&admin_page=manage_account">จัดการบัญชี</a>
                            <a class="dropdown-item" href="?page=home&active_all_user">โพสต์ทั้งหมดในระบบ</a>
                            <a class="dropdown-item" href="?page=admin&admin_page=report_system">รายงานระบบ</a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </nav>
    <?php
    if (isset($_GET['page'])) {
        if ($_GET["page"] == "home" or $_GET["page"] == "search") {
    ?>
            <div class="col-md-3 row p-1 m-0">
                <input class="form-control col-9 pl-1" style="width: unset!important" type="search" id="search_name" name="search_name" placeholder="ค้นหาผู้ใช้" aria-label="Search">
                <div class="btn btn-outline-success my-2 my-sm-0 col-3" onclick="window.location = '?page=search&search_name=' + $('#search_name').val()">ค้นหา</div>&emsp;
            </div>
    <?php
        }
    }
    ?>
    <div class="container">
        <?php
        if ($_GET["page"] == "home") {
            include './page/home.php';
        } elseif ($_GET["page"] == "edit_info") {
            include './page/edit_info.php';
        } elseif ($_GET["page"] == "create_post") {
            include './page/create_post.php';
        } elseif ($_GET["page"] == "friend") {
            include './page/friend.php';
        } elseif ($_GET["page"] == "admin") {
            include './page/admin.php';
        } elseif ($_GET["page"] == "manage_post") {
            include './page/manage_post.php';
        } elseif ($_GET["page"] == "manage_comment") {
            include './page/manage_comment.php';
        } elseif ($_GET["page"] == "friend") {
            include './page/friend.php';
        } elseif ($_GET["page"] == "search") {
            include './page/search.php';
        } elseif ($_GET["page"] == "login") {
            include './page/login.php';
        } elseif ($_GET["page"] == "register") {
            include './page/register.php';
        } elseif ($_GET["page"] == "logout") {
            include './page/logout.php';
        } else {
        ?>
            <div class="alert alert-primary" role="alert">
                404! ไม่พบหน้าที่ท่านกำลังร้องขอ กำลังพากลับไปหน้าหลัก...
            </div>
            <script>
                setTimeout(() => {
                    window.location = "?page=home";
                }, 3000);
            </script>
        <?php
        }
        ?>
    </div>
</body>

</html>
<?php
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'deletefriend') {
        $sql_delete_friend = 'DELETE FROM friendrelation WHERE (user_id_1 = "' . $_POST['user_id'] . '" AND user_id_2 = "' . $_SESSION['user_id'] . '") OR (user_id_2 = "' . $_POST['user_id'] . '" AND user_id_1 = "' . $_SESSION['user_id'] . '")';
        $res_delete_friend = mysqli_query($connect, $sql_delete_friend);
?>
        <script>
            setTimeout(() => {
                window.location = window.location;
            }, 1000);
        </script>
    <?php
    } elseif ($_POST['action'] == 'acceptfriend') {
        $sql_accept_friend = 'UPDATE friendrelation SET AreFriend = "True" WHERE user_id_1 = "' . $_POST['user_id'] . '" AND user_id_2 = "' . $_SESSION['user_id'] . '"';
        $res_accept_friend = mysqli_query($connect, $sql_accept_friend);
    ?>
        <script>
            setTimeout(() => {
                window.location = window.location;
            }, 1000);
        </script>
    <?php
    } elseif ($_POST['action'] == 'cancelpending') {
        $sql_cancel_pending_friend = 'DELETE FROM friendrelation WHERE user_id_1 = "' . $_SESSION['user_id'] . '" AND user_id_2 = "' . $_POST['user_id'] . '"';
        $res_cancel_pending_friend = mysqli_query($connect, $sql_cancel_pending_friend);
    ?>
        <script>
            setTimeout(() => {
                window.location = window.location;
            }, 1000);
        </script>
    <?php
    } elseif ($_POST['action'] == 'addfriend') {
        $sql_check_friend = 'SELECT * FROM friendrelation WHERE (user_id_1 = "' . $_SESSION['user_id'] . '" AND user_id_2 = "' . $_POST['user_id'] . '") OR (user_id_1 = "' . $_POST['user_id'] . '" AND user_id_2 = "' . $_SESSION['user_id'] . '")';
        $res_check_friend = mysqli_query($connect, $sql_check_friend);
        if (mysqli_num_rows($res_check_friend) == 0) {
            $sql_add_friend = 'INSERT INTO friendrelation (AreFriend, user_id_1, user_id_2) VALUES ("False", "' . $_SESSION['user_id'] . '", "' . $_POST['user_id'] . '")';
            $res_add_friend = mysqli_query($connect, $sql_add_friend);
        }
    ?>
        <script>
            setTimeout(() => {
                window.location = window.location;
            }, 1000);
        </script>
<?php
    }
}
