<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">หน้าแรก <span class="sr-only">(current)</span></a></li>
                <?php
                if (isset($_SESSION['id'])) {
                    ?>
                <li><a href="edit.php">แก้ไขข้อมูลส่วนตัว</a></li>
                <li><a href="logout.php">ออกจากระบบ</a></li>
                <?php
                } else {
                    ?>
                <li><a href="register.php">สมัครสมาชิก</a></li>
                <li><a href="login.php">เข้าสู่ระบบ</a></li>
                <?php
                }
                ?>
            </ul>
            </div>
    </div>
</nav>