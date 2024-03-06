<?php
session_start();
include "login-chk.php";
$current_user = get_user_detail();

if (isset($_POST['submit']) && $current_user['is_login']) {
    #print_r($_POST);
    $chk_student_firstname = array_filter($_POST['student_firstname']);
    #print_r($chk_student_firstname);
    if (count($chk_student_firstname) > 0 && $_POST['school_name']) {
        submitsForm($_POST, $current_user);
    } else {
        echo 'error';
    }
} else {
    echo 'กรุณาเข้าสู่ระบบ';
}


function submitsForm($params, $current_user)
{
    include "dbconnect.php";

    $error = 0;
    $arr_insert_id = [];


    $sql = "SELECT id FROM schools WHERE staff_id = {$current_user['user_id']} AND school_name LIKE '{$params['school_name']}' LIMIT 1";
    $tmp_result = mysqli_query($conn, $sql);
    $arr_schools = [];
    if (mysqli_num_rows($tmp_result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($tmp_result)) {
            $arr_schools[] = $row;
        }
        $school_id = $arr_schools[0]['id'];
    } else {
        $sql = "INSERT INTO schools (id, school_name, staff_id) VALUES (NULL, '{$params['school_name']}', '{$current_user['user_id']}')";

        if (mysqli_query($conn, $sql)) {
            $school_id = mysqli_insert_id($conn);
            #echo "New record created successfully. Last inserted ID is: " . $last_id;
        } else {
            echo "Error.";
            #echo $sql . "<br>" . mysqli_error($conn);
        }
    }

    $groupsara_id = filter_var($params['groupsara_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $activity_id = filter_var($params['activity_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $class_id = filter_var($params['class_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql = "SELECT ID, activity_id, activity_name, group_status, class_id, class_name, student_no, teacher_no FROM groupsara WHERE ID = '" . $groupsara_id . "' ";
    $tmp_result = mysqli_query($conn, $sql);
    $arr_groupsara = [];
    if (mysqli_num_rows($tmp_result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($tmp_result)) {
            $arr_groupsara[] = $row;
        }
    }

    $student_count = count($params['student_firstname']);
    $student_count = ($arr_groupsara[0]['student_no'] > $student_count) ? $student_count : $arr_groupsara[0]['student_no'];

    if ($arr_groupsara[0]['class_id'] != "11") {
        $teacher_count = count($params['coach_firstname']);
        $teacher_count = ($arr_groupsara[0]['teacher_no'] > $teacher_count) ? $teacher_count : $arr_groupsara[0]['teacher_no'];
    }

    // studentreg 
    $sql = "SELECT ID FROM studentreg WHERE staff_id = {$current_user['user_id']} AND groupsara_id = {$groupsara_id} ";
    $tmp_result = mysqli_query($conn, $sql);
    $student_reg_chk = [];
    if (mysqli_num_rows($tmp_result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($tmp_result)) {
            $student_reg_chk[] = $row;
        }
    }

    $count_student_reg_chk = count($student_reg_chk);

    echo $count_student_reg_chk;

    if ($count_student_reg_chk == 0) {

        // insert studentreg
        for ($i = 0; $i < $student_count; $i++) {

            $student_prefix = filter_var($params['student_prefix'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_firstname = filter_var($params['student_firstname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_lastname = filter_var($params['student_lastname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $student_cid = filter_var($params['student_cid'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_classroom = filter_var($params['student_classroom'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $student_tel = !empty($params['student_tel'][$i]) ? filter_var($params['student_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "NULL";

            if (!empty($student_prefix) && !empty($student_firstname) && !empty($student_lastname)) {

                $sql = "INSERT INTO studentreg (ID, school_id, staff_id, groupsara_id, activity_id, class_id, student_prefix, student_firstname, student_lastname, student_cid, student_classroom, display_name, student_image, tel) 
				VALUES (NULL, '{$school_id}', '{$current_user['user_id']}', '{$groupsara_id}', '{$activity_id}', '{$class_id}', '{$student_prefix}', '{$student_firstname}', '{$student_lastname}', '{$student_cid}', '{$student_classroom}', NULL, NULL, '{$student_tel}' );
				";

                if (mysqli_query($conn, $sql)) {

                    if (isset($_FILES['student_img']['tmp_name'][$i]) && $_FILES['student_img']['size'][$i] > 0) {
                        echo $_FILES['student_img']['tmp_name'][$i];
                        echo "<br/>";
                    }


                    $arr_insert_id['student'][$i] = mysqli_insert_id($conn);

                    if (isset($_FILES['student_img']['tmp_name'][$i]) && $_FILES['student_img']['size'][$i] > 0) {
                        list($width, $height, $type, $attr) = getimagesize($_FILES['student_img']['tmp_name'][$i]);
                        if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                            upload_img($_FILES['student_img']['name'][$i], $_FILES['student_img']['size'][$i], $_FILES['student_img']['tmp_name'][$i], $_FILES['student_img']['type'][$i], $arr_insert_id['student'][$i], "student_img", $school_id);
                        }
                    }
                } else {
                    $error = 1;
                }
            }
        }
    } else {

        // update
        for ($i = 0; $i < $count_student_reg_chk; $i++) {

            $student_prefix = filter_var($params['student_prefix'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_firstname = filter_var($params['student_firstname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_lastname = filter_var($params['student_lastname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $student_cid = filter_var($params['student_cid'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_classroom = filter_var($params['student_classroom'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $student_tel = !empty($params['student_tel'][$i]) ? filter_var($params['student_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "NULL";

            if (!empty($student_prefix) && !empty($student_firstname) && !empty($student_lastname)) {

                $sql = "UPDATE studentreg SET school_id = '{$school_id}', student_prefix = '{$student_prefix}', student_firstname = '{$student_firstname}', student_lastname = '{$student_lastname}', student_cid = '{$student_cid}', student_classroom = '{$student_classroom}', tel = '$student_tel' WHERE ID = {$student_reg_chk[$i]['ID']} 
				";

                $arr_insert_id['student'][$i] = $student_reg_chk[$i]['ID'];

                if (isset($_FILES['student_img']['tmp_name'][$i]) && $_FILES['student_img']['size'][$i] > 0) {
                    list($width, $height, $type, $attr) = getimagesize($_FILES['student_img']['tmp_name'][$i]);
                    if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                        upload_img($_FILES['student_img']['name'][$i], $_FILES['student_img']['size'][$i], $_FILES['student_img']['tmp_name'][$i], $_FILES['student_img']['type'][$i], $student_reg_chk[$i]['ID'], "student_img", $school_id);
                    }
                }

                if (mysqli_query($conn, $sql)) {
                } else {
                    $error = 2;
                }
            }
        }

        // insert studentreg
        for ($i = $i; $i < $arr_groupsara[0]['student_no']; $i++) {

            $student_prefix = filter_var($params['student_prefix'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_firstname = filter_var($params['student_firstname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_lastname = filter_var($params['student_lastname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $student_cid = filter_var($params['student_cid'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_classroom = filter_var($params['student_classroom'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $student_tel = !empty($params['student_tel'][$i]) ? filter_var($params['student_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "NULL";

            if (!empty($student_prefix) && !empty($student_firstname) && !empty($student_lastname)) {

                $sql = "INSERT INTO studentreg (ID, school_id, staff_id, groupsara_id, activity_id, class_id, student_prefix, student_firstname, student_lastname, student_cid, student_classroom, display_name, student_image, tel) 
				VALUES (NULL, '{$school_id}', '{$current_user['user_id']}', '{$groupsara_id}', '{$activity_id}', '{$class_id}', '{$student_prefix}', '{$student_firstname}', '{$student_lastname}', '{$student_cid}', '{$student_classroom}', NULL, NULL, '{$student_tel}');
				";

                if (mysqli_query($conn, $sql)) {
                    $arr_insert_id['student'][$i] = mysqli_insert_id($conn);

                    if (isset($_FILES['student_img']['tmp_name'][$i]) && $_FILES['student_img']['size'][$i] > 0) {
                        list($width, $height, $type, $attr) = getimagesize($_FILES['student_img']['tmp_name'][$i]);
                        if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                            upload_img($_FILES['student_img']['name'][$i], $_FILES['student_img']['size'][$i], $_FILES['student_img']['tmp_name'][$i], $_FILES['student_img']['type'][$i], $arr_insert_id['student'][$i], "student_img", $school_id);
                        }
                    }
                } else {
                    $error = 3;
                }
            }
        }
    }


    if ($arr_groupsara[0]['class_id'] != "11") {
        // teacherreg 
        $sql = "SELECT ID FROM teacherreg WHERE staff_id = {$current_user['user_id']} AND groupsara_id = {$groupsara_id} ";
        $tmp_result = mysqli_query($conn, $sql);
        $teacher_reg_chk = [];
        if (mysqli_num_rows($tmp_result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($tmp_result)) {
                $teacher_reg_chk[] = $row;
            }
        }

        $count_teacher_reg_chk = count($teacher_reg_chk);

        if ($count_teacher_reg_chk == 0) {

            // insert teacherreg
            for ($i = 0; $i < $teacher_count; $i++) {

                $teacher_prefix = filter_var($params['coach_prefix'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_firstname = filter_var($params['coach_firstname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_lastname = filter_var($params['coach_lastname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_tel = filter_var($params['coach_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if (!empty($teacher_prefix) && !empty($teacher_firstname) && !empty($teacher_lastname)) {

                    $sql = "INSERT INTO teacherreg (ID, school_id, staff_id, groupsara_id, activity_id, class_id, teacher_prefix, teacher_firstname, teacher_lastname, display_name, teacher_image, tel ) 
			VALUES (NULL, '{$school_id}', '{$current_user['user_id']}', '{$groupsara_id}', '{$activity_id}', '{$class_id}', '{$teacher_prefix}', '{$teacher_firstname}', '{$teacher_lastname}', NULL, NULL, '{$teacher_tel}' );
			";


                    if (mysqli_query($conn, $sql)) {
                        $arr_insert_id['teacher'][$i] = mysqli_insert_id($conn);

                        if (isset($_FILES['coach_img']['tmp_name'][$i]) && $_FILES['coach_img']['size'][$i] > 0) {
                            list($width, $height, $type, $attr) = getimagesize($_FILES['coach_img']['tmp_name'][$i]);
                            if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                                upload_img($_FILES['coach_img']['name'][$i], $_FILES['coach_img']['size'][$i], $_FILES['coach_img']['tmp_name'][$i], $_FILES['coach_img']['type'][$i], $arr_insert_id['teacher'][$i], "coach_img", $school_id);
                            }
                        }
                    } else {
                        $error = 4;
                    }
                }
            }
        } else {

            // update
            for ($i = 0; $i < $count_teacher_reg_chk; $i++) {

                $teacher_prefix = filter_var($params['coach_prefix'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_firstname = filter_var($params['coach_firstname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_lastname = filter_var($params['coach_lastname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_tel = filter_var($params['coach_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if (!empty($teacher_prefix) && !empty($teacher_firstname) && !empty($teacher_lastname)) {

                    $sql = "UPDATE teacherreg SET school_id = '{$school_id}', teacher_prefix = '{$teacher_prefix}', teacher_firstname = '{$teacher_firstname}', teacher_lastname = '{$teacher_lastname}', tel = '{$teacher_tel}' WHERE ID = {$teacher_reg_chk[$i]['ID']} 
				";

                    $arr_insert_id['teacher'][$i] = $teacher_reg_chk[$i]['ID'];

                    if (isset($_FILES['coach_img']['tmp_name'][$i]) && $_FILES['coach_img']['size'][$i] > 0) {
                        list($width, $height, $type, $attr) = getimagesize($_FILES['coach_img']['tmp_name'][$i]);
                        if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                            upload_img($_FILES['coach_img']['name'][$i], $_FILES['coach_img']['size'][$i], $_FILES['coach_img']['tmp_name'][$i], $_FILES['coach_img']['type'][$i], $teacher_reg_chk[$i]['ID'], "coach_img", $school_id);
                        }
                    }

                    if (mysqli_query($conn, $sql)) {
                    } else {
                        $error = 5;
                    }
                }
            }

            // insert teacherreg
            for ($i = $i; $i < $arr_groupsara[0]['teacher_no']; $i++) {

                $teacher_prefix = filter_var($params['coach_prefix'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_firstname = filter_var($params['coach_firstname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_lastname = filter_var($params['coach_lastname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_tel = filter_var($params['coach_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if (!empty($teacher_prefix) && !empty($teacher_firstname) && !empty($teacher_lastname)) {

                    $sql = "INSERT INTO teacherreg (ID, school_id, staff_id, groupsara_id, activity_id, class_id, teacher_prefix, teacher_firstname, teacher_lastname, display_name, teacher_image, tel ) 
			VALUES (NULL, '{$school_id}', '{$current_user['user_id']}', '{$groupsara_id}', '{$activity_id}', '{$class_id}', '{$teacher_prefix}', '{$teacher_firstname}', '{$teacher_lastname}', NULL, NULL, '{$teacher_tel}' );
			";

                    if (mysqli_query($conn, $sql)) {
                        $arr_insert_id['teacher'][$i] = mysqli_insert_id($conn);

                        if (isset($_FILES['coach_img']['tmp_name'][$i]) && $_FILES['coach_img']['size'][$i] > 0) {
                            list($width, $height, $type, $attr) = getimagesize($_FILES['coach_img']['tmp_name'][$i]);
                            if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                                upload_img($_FILES['coach_img']['name'][$i], $_FILES['coach_img']['size'][$i], $_FILES['coach_img']['tmp_name'][$i], $_FILES['coach_img']['type'][$i], $arr_insert_id['teacher'][$i], "coach_img", $school_id);
                            }
                        }
                    } else {
                        $error = 6;
                    }
                }
            }
        }
    }


    //print_r($arr_insert_id);
    if ($error) {
        $newURL = $params['base_page'] . '?sID=' . $params['activity_id'] . '&error=1';
        header('Location: ' . $newURL);
    } else {
        $newURL = $params['base_page'] . '?sID=' . $params['activity_id'] . '&success=1';
        header('Location: ' . $newURL);
    }


    //exit;


}




function upload_img($fileName, $fileSize, $fileTmpName, $fileType, $id, $dir_upload, $school_id)
{
    $uploadDirectory = "img-upload/" . $dir_upload . "/";

    $upload_errors = []; // Store errors here

    $fileExtensionsAllowed = ['jpeg', 'jpg']; //['jpeg', 'jpg', 'png']; // These will be the only file extensions allowed 


    //$fileName =  $image['name'];
    //$fileSize = $image['size'];
    //$fileTmpName  = $image['tmp_name'];
    //$fileType = $image['type'];


    $fileExtension = strtolower(end(explode('.', $fileName)));


    $uploadPath = $uploadDirectory . basename($id) . '.' . $fileExtension;

    echo "<br/>" . $uploadPath;

    if (!in_array($fileExtension, $fileExtensionsAllowed)) {
        $upload_errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
    }

    if ($fileSize > 2000000) {
        $upload_errors[] = "File exceeds maximum size (500kB)";
    }

    if (empty($upload_errors)) {

        if (file_exists($uploadPath)) {
            chmod($uploadPath, 0755); //Change the file permissions if allowed
            unlink($uploadPath); //remove the file
        }

        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
            echo "The file " . basename($fileName) . " has been uploaded";
        } else {
            echo "An error occurred. Please contact the administrator.";
        }
    } else {
        foreach ($upload_errors as $error) {
            echo $error . "The file " . basename($fileName) . " upload errors" . "<br/>\n";
        }
    }
}
