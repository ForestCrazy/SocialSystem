<?php
if (UserInfo($_SESSION['user_id']) == 'admin') {
    ?>
    <script>
    window.location = '?page=home';
    </script>
    <?php
} else {
    $sql_account = 'SELECT * FROM account';
    $res_account = mysqli_query($connect, $sql_account);
    $sql_post = 'SELECT * FROM post';
    $res_post = mysqli_query($connect, $sql_post);
    $sql_cm = 'SELECT * FROM comment';
    $res_cm = mysqli_query($connect, $sql_cm);
    $sql_account_accept = 'SELECT * FROM account WHERE acc_status = "accept"';
    $res_account_accept = mysqli_query($connect, $sql_account_accept);
    $sql_account_pending = 'SELECT * FROM account WHERE acc_status = "pending"';
    $res_account_pending = mysqli_query($connect, $sql_account_pending);
    $sql_account_cancel = 'SELECT * FROM account WHERE acc_status = "cancel"';
    $res_account_cancel = mysqli_query($connect, $sql_account_cancel);
    ?>
    <h4>รายงานระบบ</h4>
    <div class='row'>
        <div class='col-sm-4 mt-1'>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">จำนวนบัญชีในระบบ</h5>
                    <p class="card-text"><?= mysqli_num_rows($res_account) ?></p>
                </div>
            </div>
        </div>
        <div class='col-sm-4 mt-1'>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">จำนวนโพสต์ในระบบ</h5>
                    <p class="card-text"><?= mysqli_num_rows($res_post) ?></p>
                </div>
            </div>
        </div>
        <div class='col-sm-4 mt-1'>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">จำนวนคอมเมนต์ในระบบ</h5>
                    <p class="card-text"><?= mysqli_num_rows($res_cm) ?></p>
                </div>
            </div>
        </div>
        <div class='col-sm-4 mt-1'>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">จำนวนบัญชีที่อนุมัติแล้ว</h5>
                    <p class="card-text"><?= mysqli_num_rows($res_account_accept) ?></p>
                </div>
            </div>
        </div>
        <div class='col-sm-4 mt-1'>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">จำนวนบัญชีที่ยังไม่อนุมัติ</h5>
                    <p class="card-text"><?= mysqli_num_rows($res_account_pending) ?></p>
                </div>
            </div>
        </div>
        <div class='col-sm-4 mt-1'>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">จำนวนบัญชีที่ระงับการใช้งาน</h5>
                    <p class="card-text"><?= mysqli_num_rows($res_account_cancel) ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}