<?php
session_start();
include "config.php";
$error = '';
if (isset($_REQUEST['submit']) and !empty($_POST['user']) and !empty($_POST['passwd'])) {
    $_SESSION['sess_user'] = $_POST['user'];
    $_SESSION['sess_passwd'] = md5($_POST['passwd']);
    $_SESSION['sess_user_id'] = "";

    if (!empty($_REQUEST["ref"])) {
        $url = $url_server . $_REQUEST["ref"];
    } else {
        $url = $url_server . dirname($_SERVER['PHP_SELF']);
    }

    include "dbconnect.php";
    $sql = "SELECT * FROM staff WHERE user LIKE '$_POST[user]' AND passwd LIKE '" . md5($_POST['passwd']) . "' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // update last login
        // update last login
        $sql = "UPDATE `staff` SET id = LAST_INSERT_ID(id), last_login = now() WHERE `user` LIKE '$_SESSION[sess_user]' ";
        mysqli_query($conn, $sql);

        $_SESSION['sess_user_id'] = mysqli_insert_id($conn);
        $_SESSION['sess_user'] = $_POST['user'];
        $_SESSION['sess_passwd'] = md5($_POST['passwd']);

        echo 'Login success : redirect to ' . $url;
        header('Location: '.$url);
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }

    mysqli_free_result($result);
    mysqli_close($conn);
} else {
    $_SESSION['sess_user_id'] = "";
    $_SESSION['sess_user'] = "";
    $_SESSION['sess_passwd'] = "";
}
?>
<?php include("header.php"); ?>

<div class="d-flex justify-content-center flex-nowrap">

    <form method="post">
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger">
                <h5><?php echo $error; ?></h5>
            </div>
        <?php endif; ?>
        <div class="form-group h4">
            เข้าสู่ระบบ
        </div>
        <div class="form-group">
            <label for="user">ชื่อผู้ใช้:</label>
            <input type="text" class="form-control" id="user" placeholder="Enter user" name="user">
        </div>
        <div class="form-group">
            <label for="passwd">รหัสผ่าน:</label>
            <input type="password" class="form-control" id="passwd" placeholder="Enter password" name="passwd">
        </div>
        <div class="form-group form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="remember"> Remember me
            </label>
        </div>
        <button type="submit" class="btn btn-primary" id="submit" name="submit">เข้าสู่ระบบ</button>
    </form>
</div>
<?php include("footer.php"); ?>