<?php

/*
function submitsForm($params)
{

    global $wpdb;

    $error = 0;
    $arr_insert_id = [];

    $current_user = wp_get_current_user();

    $sql = "SELECT * FROM wp_schools WHERE school_id = {$current_user->user_login}";
    $wp_schools = $wpdb->get_results($sql, ARRAY_A);

    $school_id = filter_var($wp_schools[0]['school_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $go_id = filter_var($wp_schools[0]['go_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $groupsara_id = filter_var($params['groupsara_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $activity_id = filter_var($params['activity_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $class_id = filter_var($params['class_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql = "SELECT ID, activity_id, activity_name, group_status, class_id, class_name, student_no, teacher_no FROM wp_groupsara WHERE ID = '" . $groupsara_id . "' ";
    $wp_groupsara = $wpdb->get_results($sql, ARRAY_A);

    $student_count = count($params['student_firstname']);
    $student_count = ($wp_groupsara[0]['student_no'] > $student_count) ? $student_count : $wp_groupsara[0]['student_no'];

    if ($wp_groupsara[0]['class_id'] != "11") {
        $teacher_count = count($params['coach_firstname']);
        $teacher_count = ($wp_groupsara[0]['teacher_no'] > $teacher_count) ? $teacher_count : $wp_groupsara[0]['teacher_no'];
    }


    // studentreg 
    $sql = "SELECT ID FROM wp_studentreg WHERE school_id = {$school_id} AND groupsara_id = {$groupsara_id} ";
    $student_reg_chk = $wpdb->get_results($sql, ARRAY_A);
    $count_student_reg_chk = count($student_reg_chk);

    if ($count_student_reg_chk == 0) {

        // insert studentreg
        for ($i = 0; $i < $student_count; $i++) {

            $student_prefix = filter_var($params['student_prefix'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_firstname = filter_var($params['student_firstname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_lastname = filter_var($params['student_lastname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_tel = !empty($params['student_tel'][$i]) ? filter_var($params['student_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "NULL";

            if (!empty($student_prefix) && !empty($student_firstname) && !empty($student_lastname)) {

                $sql = "INSERT INTO wp_studentreg (ID, reg_id, school_id, go_id, groupsara_id, activity_id, class_id, reg_status, student_prefix, student_firstname, student_lastname, display_name, student_image, tel) 
				VALUES (NULL, CURRENT_TIMESTAMP, '{$school_id}', '{$go_id}', '{$groupsara_id}', '{$activity_id}', '{$class_id}', NULL, '{$student_prefix}', '{$student_firstname}', '{$student_lastname}', NULL, NULL, {$student_tel});
				";

                if ($wpdb->query($sql)) {

                    if (isset($_FILES['student_img']['tmp_name'][$i]) && $_FILES['student_img']['size'][$i] > 0) {
                        echo $_FILES['student_img']['tmp_name'][$i];
                        echo "<br/>";
                    }


                    $arr_insert_id['student'][$i] = $wpdb->insert_id;

                    if (isset($_FILES['student_img']['tmp_name'][$i]) && $_FILES['student_img']['size'][$i] > 0) {
                        list($width, $height, $type, $attr) = getimagesize($_FILES['student_img']['tmp_name'][$i]);
                        if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                            upload_img($_FILES['student_img']['name'][$i], $_FILES['student_img']['size'][$i], $_FILES['student_img']['tmp_name'][$i], $_FILES['student_img']['type'][$i], $wpdb->insert_id, "student_img", $school_id);
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
            $student_tel = !empty($params['student_tel'][$i]) ? filter_var($params['student_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "NULL";

            if (!empty($student_prefix) && !empty($student_firstname) && !empty($student_lastname)) {

                $sql = "UPDATE wp_studentreg SET student_prefix = '{$student_prefix}', student_firstname = '{$student_firstname}', student_lastname = '{$student_lastname}', tel = '$student_tel' WHERE ID = {$student_reg_chk[$i]['ID']} 
				";

                $arr_insert_id['student'][$i] = $student_reg_chk[$i]['ID'];

                if (isset($_FILES['student_img']['tmp_name'][$i]) && $_FILES['student_img']['size'][$i] > 0) {
                    list($width, $height, $type, $attr) = getimagesize($_FILES['student_img']['tmp_name'][$i]);
                    if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                        upload_img($_FILES['student_img']['name'][$i], $_FILES['student_img']['size'][$i], $_FILES['student_img']['tmp_name'][$i], $_FILES['student_img']['type'][$i], $student_reg_chk[$i]['ID'], "student_img", $school_id);
                    }
                }

                if ($wpdb->query($sql)) {
                } else {
                    $error = 2;
                }
            }
        }

        // insert studentreg
        for ($i = $i; $i < $wp_groupsara[0]['student_no']; $i++) {

            $student_prefix = filter_var($params['student_prefix'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_firstname = filter_var($params['student_firstname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_lastname = filter_var($params['student_lastname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $student_tel = !empty($params['student_tel'][$i]) ? filter_var($params['student_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "NULL";

            if (!empty($student_prefix) && !empty($student_firstname) && !empty($student_lastname)) {

                $sql = "INSERT INTO wp_studentreg (ID, reg_id, school_id, go_id, groupsara_id, activity_id, class_id, reg_status, student_prefix, student_firstname, student_lastname, display_name, student_image, tel) 
				VALUES (NULL, CURRENT_TIMESTAMP, '{$school_id}', '{$go_id}', '{$groupsara_id}', '{$activity_id}', '{$class_id}', NULL, '{$student_prefix}', '{$student_firstname}', '{$student_lastname}', NULL, NULL, $student_tel);
				";

                if ($wpdb->query($sql)) {
                    $arr_insert_id['student'][$i] = $wpdb->insert_id;

                    if (isset($_FILES['student_img']['tmp_name'][$i]) && $_FILES['student_img']['size'][$i] > 0) {
                        list($width, $height, $type, $attr) = getimagesize($_FILES['student_img']['tmp_name'][$i]);
                        if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                            upload_img($_FILES['student_img']['name'][$i], $_FILES['student_img']['size'][$i], $_FILES['student_img']['tmp_name'][$i], $_FILES['student_img']['type'][$i], $wpdb->insert_id, "student_img", $school_id);
                        }
                    }
                } else {
                    $error = 3;
                }
            }
        }
    }


    if ($wp_groupsara[0]['class_id'] != "11") {
        // teacherreg 
        $sql = "SELECT ID FROM wp_teacherreg WHERE school_id = {$school_id} AND groupsara_id = {$groupsara_id} ";
        $teacher_reg_chk = $wpdb->get_results($sql, ARRAY_A);
        $count_teacher_reg_chk = count($teacher_reg_chk);

        if ($count_teacher_reg_chk == 0) {

            // insert teacherreg
            for ($i = 0; $i < $teacher_count; $i++) {

                $teacher_prefix = filter_var($params['coach_prefix'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_firstname = filter_var($params['coach_firstname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_lastname = filter_var($params['coach_lastname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_tel = filter_var($params['coach_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if (!empty($teacher_prefix) && !empty($teacher_firstname) && !empty($teacher_lastname)) {

                    $sql = "INSERT INTO wp_teacherreg (ID, reg_id, school_id, go_id, groupsara_id, activity_id, class_id, reg_status, teacher_prefix, teacher_firstname, teacher_lastname, display_name, teacher_image, tel ) 
			VALUES (NULL, CURRENT_TIMESTAMP, '{$school_id}', '{$go_id}', '{$groupsara_id}', '{$activity_id}', '{$class_id}', NULL, '{$teacher_prefix}', '{$teacher_firstname}', '{$teacher_lastname}', NULL, NULL, '{$teacher_tel}' );
			";

                    if ($wpdb->query($sql)) {
                        $arr_insert_id['teacher'][$i] = $wpdb->insert_id;

                        if (isset($_FILES['coach_img']['tmp_name'][$i]) && $_FILES['coach_img']['size'][$i] > 0) {
                            list($width, $height, $type, $attr) = getimagesize($_FILES['coach_img']['tmp_name'][$i]);
                            if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                                upload_img($_FILES['coach_img']['name'][$i], $_FILES['coach_img']['size'][$i], $_FILES['coach_img']['tmp_name'][$i], $_FILES['coach_img']['type'][$i], $wpdb->insert_id, "coach_img", $school_id);
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

                    $sql = "UPDATE wp_teacherreg SET teacher_prefix = '{$teacher_prefix}', teacher_firstname = '{$teacher_firstname}', teacher_lastname = '{$teacher_lastname}', tel = '{$teacher_tel}' WHERE ID = {$teacher_reg_chk[$i]['ID']} 
				";

                    $arr_insert_id['teacher'][$i] = $teacher_reg_chk[$i]['ID'];

                    if (isset($_FILES['coach_img']['tmp_name'][$i]) && $_FILES['coach_img']['size'][$i] > 0) {
                        list($width, $height, $type, $attr) = getimagesize($_FILES['coach_img']['tmp_name'][$i]);
                        if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                            upload_img($_FILES['coach_img']['name'][$i], $_FILES['coach_img']['size'][$i], $_FILES['coach_img']['tmp_name'][$i], $_FILES['coach_img']['type'][$i], $teacher_reg_chk[$i]['ID'], "coach_img", $school_id);
                        }
                    }

                    if ($wpdb->query($sql)) {
                    } else {
                        $error = 5;
                    }
                }
            }

            // insert teacherreg
            for ($i = $i; $i < $wp_groupsara[0]['teacher_no']; $i++) {

                $teacher_prefix = filter_var($params['coach_prefix'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_firstname = filter_var($params['coach_firstname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_lastname = filter_var($params['coach_lastname'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $teacher_tel = filter_var($params['coach_tel'][$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if (!empty($teacher_prefix) && !empty($teacher_firstname) && !empty($teacher_lastname)) {

                    $sql = "INSERT INTO wp_teacherreg (ID, reg_id, school_id, go_id, groupsara_id, activity_id, class_id, reg_status, teacher_prefix, teacher_firstname, teacher_lastname, display_name, teacher_image, tel ) 
			VALUES (NULL, CURRENT_TIMESTAMP, '{$school_id}', '{$go_id}', '{$groupsara_id}', '{$activity_id}', '{$class_id}', NULL, '{$teacher_prefix}', '{$teacher_firstname}', '{$teacher_lastname}', NULL, NULL, '{$teacher_tel}' );
			";

                    if ($wpdb->query($sql)) {
                        $arr_insert_id['teacher'][$i] = $wpdb->insert_id;

                        if (isset($_FILES['coach_img']['tmp_name'][$i]) && $_FILES['coach_img']['size'][$i] > 0) {
                            list($width, $height, $type, $attr) = getimagesize($_FILES['coach_img']['tmp_name'][$i]);
                            if ($width >= 200 && $width < 2000 && $height >= 200 && $height < 2000) {
                                upload_img($_FILES['coach_img']['name'][$i], $_FILES['coach_img']['size'][$i], $_FILES['coach_img']['tmp_name'][$i], $_FILES['coach_img']['type'][$i], $wpdb->insert_id, "coach_img", $school_id);
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
		//wp_redirect($params['base_page'] . '?error=1');
	} else {
		//wp_redirect($params['base_page'] . '?success=1');
	}
	

    //echo $params['base_page'];


    #wp_redirect($params['base_page'] . '?success=1&sID=' . $groupsara_id);
    //exit;
}

*/

/*
function upload_img($fileName, $fileSize, $fileTmpName, $fileType, $id, $dir_upload, $school_id)
{
    $uploadDirectory = "../img-upload/" . $dir_upload . "/";

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

*/

if (isset($_POST['submit'])) {
    
    print_r($_POST);
}

?>
