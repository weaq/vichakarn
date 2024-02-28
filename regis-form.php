<?php
session_start();
include "login-chk.php";
$current_user = get_user_detail();

if (!$current_user['is_login']) {
    echo "<META HTTP-EQUIV=Refresh content=0;URL=login-form.php?ref=" . $_SERVER['PHP_SELF'] . ">";
    exit();
}

include "dbconnect.php";
include "header.php";

//$domain = 'http://127.0.0.1/wordpress/';
$domain = '/';
?>

<?php if (isset($_GET['success'])) : ?>
    <div class="alert alert-success text-center">
        <div class="h3">บันทึกข้อมูลเรียบร้อยแล้ว</div>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])) : ?>
    <div class="alert alert-danger">
        <h3>Sorry! Unable to submit the form.</h3>
    </div>
<?php endif; ?>

<?php if (isset($_GET['rm'])) : ?>
    <div class="alert alert-success text-center">

        <?php
        if ($_GET['sID'] && $current_user['is_login'] && isset($_GET['rm'])) {

            $error_delete = 1;

            $sql = "SELECT ID, activity_id, activity_name, group_name, group_status, class_id, class_name, student_no, teacher_no FROM groupsara WHERE ID = '" . $_GET['sID'] . "' ORDER BY activity_name ASC ";
            $tmp_result = mysqli_query($conn, $sql);
            $groupsara = [];
            if (mysqli_num_rows($tmp_result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($tmp_result)) {
                    $groupsara[] = $row;
                }
            }

            $sql = "DELETE FROM studentreg WHERE staff_id = {$current_user['user_id']} AND groupsara_id = {$_GET['sID']} ";
            if (mysqli_query($conn, $sql)) {
                $error_delete = 0;
            } else {
                $error_delete = 1;
            }

            $sql = "DELETE FROM teacherreg WHERE staff_id = {$current_user['user_id']} AND groupsara_id = {$_GET['sID']} ";
            if (mysqli_query($conn, $sql)) {
                $error_delete = 0;
            } else {
                $error_delete = 1;
            }

            if ($error_delete ==  0) {
                echo '<div class="h3">ยกเลิกการสมัคร ' . $groupsara[0]['activity_name'] . ' ' . $groupsara[0]['class_name'] . ' เรียบร้อยแล้ว</div>';
            }
        }
        ?>

    </div>
<?php endif; ?>

<form name="contact_form" method="POST" action="regis-form-process.php" enctype="multipart/form-data" autocomplete="on" accept-charset="utf-8">

    <?php

    $output = "";

    if ($_GET['sID'] && $current_user['is_login'] && empty($_GET['rm'])) {

        $sql = "SELECT ID, activity_id, activity_name, group_name, group_status, class_id, class_name, student_no, teacher_no FROM groupsara WHERE ID = '" . $_GET['sID'] . "' ORDER BY activity_name ASC ";
        $tmp_result = mysqli_query($conn, $sql);
        $groupsara = [];
        if (mysqli_num_rows($tmp_result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($tmp_result)) {
                $groupsara[] = $row;
            }
        }

        $sql = "SELECT * FROM studentreg WHERE staff_id = {$current_user['user_id']} AND groupsara_id = {$_GET['sID']} ";
        $tmp_result = mysqli_query($conn, $sql);
        $student_reg_chk = [];
        if (mysqli_num_rows($tmp_result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($tmp_result)) {
                $student_reg_chk[] = $row;
            }
        }


        $sql = "SELECT * FROM teacherreg WHERE staff_id = {$current_user['user_id']} AND groupsara_id = {$_GET['sID']} ";
        $tmp_result = mysqli_query($conn, $sql);
        $teacher_reg_chk = [];
        if (mysqli_num_rows($tmp_result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($tmp_result)) {
                $teacher_reg_chk[] = $row;
            }
        }


        // get school name
        $sql = "SELECT school_name FROM schools WHERE id = {$student_reg_chk[0]['school_id']} AND staff_id = {$current_user['user_id']} ";
        $tmp_result = mysqli_query($conn, $sql);
        $school_name = [];
        if (mysqli_num_rows($tmp_result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($tmp_result)) {
                $school_name[] = $row;
            }
        }


        $tmp_col = ($groupsara[0]['class_id'] == "11") ? "col-md-3" : "col-md-4";

        $output = '
		<div class="container my-3">
            <div class="h4">' . $current_user['user_name'] . '</div>
            <div class="h5">ลงทะเบียนแข่งขัน กลุ่มสาระการเรียนรู้ ' . $groupsara[0]['group_name'] . '</div>
            <div class="h5">กิจกรรม ' . $groupsara[0]['activity_name'] . ' '  . $groupsara[0]['class_name'] . ' '  . '</div>

            <div class="h5 font-weight-bold text-center mt-2">สถานศึกษาที่เป็นตัวแทน</div>
            <div class="form-group">
                <label for="school_name" >ชื่อสถานศึกษา:</label>
                <input type="text" class="form-control" id="school_name" name="school_name" required value="' . $school_name[0]['school_name'] . '">
            </div>

			<div class="h5 font-weight-bold text-center mt-2">ชื่อผู้แข่งขัน</div>
		';

        for ($i = 0; $i < $groupsara[0]['student_no']; $i++) {
            $tmp_num = $i + 1;

            $img_url = './img-upload/student_img/' . $student_reg_chk[$i]['ID'] . '.jpg';

            $img_url = (file_exists($img_url)) ? 'img-upload/student_img/' . $student_reg_chk[$i]['ID'] . '.jpg' : 'img-upload/unknow.jpg';

            $output .= '
            <div class="border px-3 py-3 my-3">
                <div class="font-weight-bold">ผู้แข่งขัน คนที่ ' . $tmp_num . '</div>
                <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="mt-2 ' . $tmp_col . '">
                            <label class="form-label">คำนำหน้า</label>
                            <input type="text" class="form-control" id="student_prefix[' . $i . ']" name="student_prefix[' . $i . ']" value="' . $student_reg_chk[$i]['student_prefix'] . '" >
                        </div>
                        <div class="mt-2 ' . $tmp_col . '">
                            <label class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" id="student_firstname[' . $i . ']" name="student_firstname[' . $i . ']" value="' . $student_reg_chk[$i]['student_firstname'] . '" >
                        </div>
                        <div class="mt-2 ' . $tmp_col . '">
                            <label class="form-label">สกุล</label>
                            <input type="text" class="form-control" id="student_lastname[' . $i . ']" name="student_lastname[' . $i . ']" value="' . $student_reg_chk[$i]['student_lastname'] . '" >
                        </div>
                        ';

            if ($groupsara[0]['class_id'] == "11") {
                $output .= '
                        <div class="mt-2 col-md-3">
                            <label class="form-label">หมายเลขโทรศัพท์</label>
                            <input type="text" class="form-control" id="student_tel[' . $i . ']" name="student_tel[' . $i . ']" value="' . $student_reg_chk[$i]['tel'] . '" >
                        </div>
                ';
            }

            $output .= '
                    </div>
                    <div class="row">
                        <div class="input-group mt-2 mx-3">
                        <label class="input-group-text" for="student_img[' . $i . ']">เลือกรูปถ่าย</label>
                            <input type="file" class="form-control" id="student_img[' . $i . ']" name="student_img[' . $i . ']">
                            
                        </div>
                    </div>

                </div>
                <div class="col-md-2">
                    <img src="' . $img_url . '" class="rounded img-fluid" >
                </div>
                </div>
            </div>
			';
        }


        if ($groupsara[0]['class_id'] != "11") {
            $output .= '
			<div class="h5 font-weight-bold text-center mt-3">ชื่อผู้ควบคุม</div>
			';
            for ($i = 0; $i < $groupsara[0]['teacher_no']; $i++) {
                $tmp_num = $i + 1;
                $img_url = './img-upload/coach_img/' . $teacher_reg_chk[$i]['ID'] . '.jpg';

                $img_url = (file_exists($img_url)) ? 'img-upload/coach_img/' . $teacher_reg_chk[$i]['ID'] . '.jpg' : 'img-upload/unknow.jpg';

                $output .= '
            <div class="border px-3 py-3 my-3">
			<div class="font-weight-bold">ผู้ควบคุม คนที่ ' . $tmp_num . '</div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="mt-2 col-md-3">
                                <label class="form-label">คำนำหน้า</label>
                                <input type="text" class="form-control" id="coach_prefix[' . $i . ']" name="coach_prefix[' . $i . ']" value="' . $teacher_reg_chk[$i]['teacher_prefix'] . '" >
                            </div>
                            <div class="mt-2 col-md-3">
                                <label class="form-label">ชื่อ</label>
                                <input type="text" class="form-control" id="coach_firstname[' . $i . ']" name="coach_firstname[' . $i . ']" value="' . $teacher_reg_chk[$i]['teacher_firstname'] . '" >
                            </div>
                            <div class="mt-2 col-md-3">
                                <label class="form-label">สกุล</label>
                                <input type="text" class="form-control" id="coach_lastname[' . $i . ']" name="coach_lastname[' . $i . ']" value="' . $teacher_reg_chk[$i]['teacher_lastname'] . '" >
                            </div>
                            <div class="mt-2 col-md-3">
                                <label class="form-label">หมายเลขโทรศัพท์</label>
                                <input type="text" class="form-control" id="coach_tel[' . $i . ']" name="coach_tel[' . $i . ']" value="' . $teacher_reg_chk[$i]['tel'] . '" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="custom-file mt-2 mx-3">
                                <input type="file" class="custom-file-input" id="coach_img[' . $i . ']" name="coach_img[' . $i . ']">
                                <label class="custom-file-label" for="coach_img[' . $i . ']">เลือกรูปถ่าย</label>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <img src="' . $img_url . '" class="rounded img-fluid" >
                    </div>
                </div>
            </div>

			';
            }
        }

        $output .= '
        <div class="mt-3 mb-3 text-center">
            <input type="hidden" id="groupsara_id" name="groupsara_id" value="' . $groupsara[0]['ID'] . '">
            <input type="hidden" id="activity_id" name="activity_id" value="' . $groupsara[0]['activity_id'] . '">
            <input type="hidden" id="class_id" name="class_id" value="' . $groupsara[0]['class_id'] . '">

            <input type="hidden" name="action" value="contact_form">
            <input type="hidden" name="base_page" value="' . basename($_SERVER['REQUEST_URI']) . '">

            <div class="row">
                <div class="col-md-6 text-center">
                    <div class="btn btn-warning mx-3 my-3" onclick="js_remove_record()">ยกเลิกการลงทะเบียน</div>
                </div>
                <div class="col-md-6 text-center">
                    <button type="submit" id="submit" name="submit" class="btn btn-primary mx-3 my-3">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
        ';
    }


    echo $output;
    ?>

</form>

<script type="text/javascript">
        $(function() {
            $("#school_name").autocomplete({
                source: 'autocomplete-school-name.php',
            });
        });
    </script>

<script>
    function js_remove_record() {
        let text = "คุณแน่ใจหรือว่าต้องการ ลบข้อมูล ?";
        if (confirm(text) == true) {
            window.location = '<?php echo "?sID=" . $_GET['sID'] . "&rm=1"; ?>'
        } else {
            text = "ยกเลิกการลบข้อมูล";
        }
    }
</script>



<?php

include "footer.php";

?>