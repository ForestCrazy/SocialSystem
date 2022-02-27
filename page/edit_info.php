<?php
if (!isset($_SESSION["user_id"]) or !isset($_SESSION["username"])) {
?>
    <script>
        window.location = "?page=home";
    </script>
    <?php
} else {
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
    } else {
        $user_id = $_SESSION['user_id'];
    }
    $sql_user = 'SELECT * FROM account WHERE user_id = "' . $user_id . '"';
    $res_user = mysqli_query($connect, $sql_user);
    $fetch_user = mysqli_fetch_assoc($res_user);

    if (isset($_POST['submit_edit_user_info'])) {
        $file_name = UserInfo($user_id)['img_profile'];
        if ($_FILES['up']['size'] != 0) {
            unlink('./asset/img_profile/' . $file_name);
            if (move_uploaded_file($_FILES['up']['tmp_name'], './asset/img_profile/' . time() . $_FILES['up']['name'])) {
                $file_name = time() . $_FILES['up']['name'];
            }
        }

        $sql_update_info = 'UPDATE account SET FirstName = "' . $_POST['FirstName'] . '", LastName = "' . $_POST['LastName'] . '", email = "' . $_POST['email'] . '", birthday = "' . $_POST['birthday'] . '", img_profile = "' . $file_name . '" WHERE user_id = "' . $_SESSION['user_id'] . '" AND username = "' . $_SESSION['username'] . '"';
        $res_update_info = mysqli_query($connect, $sql_update_info);
        if ($res_update_info) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
        exit();
    }
    ?>
    <script>
        var cacheAccountProfile = null;
        var cacheDefaultAccountProfile = null;

        function inputAccountProfile(input) {
            if (input.files.length === 1) {
                cacheAccountProfile = input.files[0];
                cacheDefaultAccountProfile = $('#accountProfile').attr('src');
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#accountProfile').attr('src', e.target.result);
                    $('#inputAccountProfileBtnSection').removeClass('d-block');
                    $('#inputAccountProfileBtnSection').addClass('d-none');
                    $('#accountProfileActionSection').removeClass('d-none');
                    $('#accountProfileActionSection').addClass('d-block');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                console.error('file input not found');
            }
        }

        function cancelChangeAccountProfile() {
            if (cacheDefaultAccountProfile) {
                $('#accountProfile').attr('src', cacheDefaultAccountProfile);
                $('#inputAccountProfileBtnSection').removeClass('d-none');
                $('#inputAccountProfileBtnSection').addClass('d-block');
                $('#accountProfileActionSection').removeClass('d-block');
                $('#accountProfileActionSection').addClass('d-none');
            }
            cacheDefaultAccountProfile = null;
        }

        function confirmChangeAccountProfile() {
            var formData = new FormData();
            if (cacheAccountProfile) {
                formData.append('up', cacheAccountProfile);
            }
            formData.append('FirstName', $('#FirstName').val());
            formData.append('LastName', $('#LastName').val());
            formData.append('email', $('#email').val());
            formData.append('birthday', $('#birthday').val());
            formData.append('submit_edit_user_info', '');
            $.ajax({
                url: '?page=edit_info',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#inputAccountProfileBtnSection').removeClass('d-none');
                    $('#inputAccountProfileBtnSection').addClass('d-block');
                    $('#accountProfileActionSection').removeClass('d-block');
                    $('#accountProfileActionSection').addClass('d-none');
                    location.reload();
                }
            })
        }
    </script>
    <h3 style="text-align: center;">แก้ไขข้อมูล</h3>
    <div class='text-center'>
        <img class="z-depth-2 img-fluid" style="width: 64px; height: 64px;" id='accountProfile' src="/asset/img_profile/<?= $fetch_user['img_profile'] ?>">
    </div>
    <div class='d-block' id='inputAccountProfileBtnSection'>
        <div class='d-flex justify-content-center'>
            <div class='btn btn-outline-primary d-block' id='inputAccountProfileBtn' onclick="$('#inputAccountProfile').click();">เลือกรูป</div>
            <input type='file' class='d-none' id='inputAccountProfile' onchange='inputAccountProfile(this)' accept=".png, .jpg, .jpeg" />
        </div>
    </div>
    <div class='d-none' id='accountProfileActionSection'>
        <div class='d-flex justify-content-center'>
            <div class='btn btn-outline-danger' onclick='cancelChangeAccountProfile()'>ยกเลิก</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label>ชื่อ</label>
            <input type="text" name="FirstName" id="FirstName" class="form-control" value="<?= $fetch_user['FirstName'] ?>">
        </div>
        <div class="col-sm-6 form-group">
            <label>นามสกุล</label>
            <input type="text" name="LastName" id="LastName" class="form-control" value="<?= $fetch_user['LastName'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label>อีเมล</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= $fetch_user['email'] ?>" required>
    </div>
    <div class="form-group">
        <label>วัน เดือน ปี เกิด</label>
        <input type="date" name="birthday" id="birthday" class="form-control" value="<?= $fetch_user['birthday'] ?>" required>
    </div>
    <button class="btn btn-success col-12" name="submit_edit_user_info" onclick="confirmChangeAccountProfile()">แก้ไขข้อมูล</button>
<?php
}
?>