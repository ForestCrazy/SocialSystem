<?php
if (!isset($_GET['admin_page'])) {
    $_GET['admin_page'] = 'accept_account';
}

if ($_GET['admin_page'] == 'accept_account') {
    include './page/admin/accept_account.php';
} elseif ($_GET['admin_page'] == 'manage_account') {
    include './page/admin/manage_account.php';
} elseif ($_GET['admin_page'] == 'report_system') {
    include './page/admin/report_system.php';
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