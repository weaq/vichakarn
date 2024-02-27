<?php
session_start();
include "login-chk.php";
?>
<?php
include "dbconnect.php";

if (isset($_REQUEST['submit'])) {

    $sql = "UPDATE `staff` SET tel = '" . $_REQUEST['tel'] . "', email = '" . $_REQUEST['email'] . "' ";
    $error = '';
    $set_session_password = 0;

    //print_r($_REQUEST);

    if (!empty($_REQUEST['oldpasswd']) OR !empty($_REQUEST['newpasswd']) OR !empty($_REQUEST['confnewpasswd'])) {
        if ($_REQUEST['newpasswd'] != $_REQUEST['confnewpasswd']) {
            $error = 'โปรด ตั้งค่ารหัสผ่านใหม่ ให้ตรงกับ ยืนยันรหัสผ่านใหม่';
        } else if (strlen($_REQUEST['newpasswd']) < 6) {
            $error = 'หากต้องการตั้งค่ารหัสผ่านใหม่ โปรดตั้งค่าให้มีความยาวไม่น้อยกว่า 6 ตัวอักษร';
        } else {

            $sql1 = "SELECT * FROM `staff` WHERE `user` LIKE '" . $_SESSION['sess_user'] . "' AND `passwd` LIKE '" . md5($_REQUEST['oldpasswd']) . "' LIMIT 1";
            $result = mysqli_query($conn, $sql1);

            if (mysqli_num_rows($result) > 0) {
                $sql .= ", passwd = '" . md5($_REQUEST['newpasswd']) . "' ";
                $set_session_password = 1 ;
            } else {
                $error = 'รหัสผ่านเดิมไม่ถูกต้อง';
            }
        }
    }

    if (empty($error)) {
        $sql .= ", last_login = now() WHERE `id` = " . $_SESSION['sess_user_id'] . " ";
        mysqli_query($conn, $sql);
        $error = 'แก้ไขข้อมูลเรียบร้อยแล้ว';
        if ($set_session_password == 1) {
            $_SESSION['sess_passwd'] = md5($_POST['newpasswd']);
        }
    }

}

$sql = "SELECT * FROM `staff` WHERE `user` LIKE '" . $_SESSION['sess_user'] . "' AND `passwd` LIKE '" . $_SESSION['sess_passwd'] . "' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $tel = $row['tel'];
        $email = $row['email'];
    }
}
?>

<?php include("header.php"); ?>

<div class="mb-4 h4"><?php echo $name; ?></div>
<form method="post" action="" autocomplete="off">
    <div class="form-row">
        <div class="form-group col-md-12 h5">
            ข้อมูลพื้นฐาน
        </div>
    </div>

    <?php if ($error) { ?>
    <div class="form-row">
        <div class="form-group col-md-12 text-warning">
            <?php
                echo $error;
            ?>
        </div>
    </div>
    <?php } ?>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="tel">หมายเลขโทรศัพท์</label>
            <input type="text" class="form-control" id="tel" name="tel" value="<?php echo $tel; ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $email; ?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12 h5">
            แก้ไขรหัสผ่าน
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="user">ชื่อผู้ใช้</label>
            <input type="text" class="form-control" id="hidden_user" name="hidden_user" value="<?php echo $_SESSION['sess_user']; ?>" disabled>
            <input type="hidden" id="user" name="user" value="<?php echo $_SESSION['sess_user']; ?>">

        </div>
        <div class="form-group col-md-6">
            <label for="oldpasswd">รหัสผ่านเดิม</label>
            <input type="password" class="form-control" id="oldpasswd" name="oldpasswd" autocomplete="old-password">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="newpasswd">ตั้งค่ารหัสผ่านใหม่</label>
            <input type="password" class="form-control" id="newpasswd" name="newpasswd" autocomplete="new-password">
        </div>
        <div class="form-group col-md-6">
            <label for="confnewpasswd">ยืนยันรหัสผ่านใหม่</label>
            <input type="password" class="form-control" id="confnewpasswd" name="confnewpasswd" autocomplete="new-password">
        </div>
    </div>

    <button type="submit" class="btn btn-primary" id="submit" name="submit">บันทึก</button>
</form>
<?php include("footer.php"); ?>