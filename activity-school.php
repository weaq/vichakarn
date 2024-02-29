<?php
session_start();
include "login-chk.php";
$current_user = get_user_detail();

include "dbconnect.php";
include "functions.php";
include "header.php";

?>

<div class=" mt-3 mb-5">
    <?php

    $sID = $_GET['sID'];

    if ($sID) {

        $sql = "SELECT a.id as school_id, a.school_name, a.staff_id, c.user as staff_user, c.name as staff_name FROM schools a 
        INNER JOIN (SELECT DISTINCT(school_id) FROM studentreg WHERE groupsara_id = '{$sID}') b 
        ON a.id = b.school_id 
        INNER JOIN staff c 
        ON c.id = a.staff_id
        ORDER BY school_id ASC";
        $tmp_result = mysqli_query($conn, $sql);
        $school_score = [];
        if (mysqli_num_rows($tmp_result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($tmp_result)) {
                $school_score[] = $row;
            }
        }

        $sql = "SELECT * FROM groupsara WHERE ID = {$sID} ";
        $tmp_result = mysqli_query($conn, $sql);
        $groupsara = [];
        if (mysqli_num_rows($tmp_result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($tmp_result)) {
                $groupsara[] = $row;
            }
        }

        echo '<div class="text-center h5 my-3">';
        echo '<div>รายชื่อผู้ร่วมประกวดแข่งขันทักษะทางวิชาการ</div>';
        echo '<div>กลุ่มสาระการเรียนรู้ ' . $groupsara[0]['group_name'] . '</div>';
        echo '<div>รายการแข่งขัน ' . $groupsara[0]['activity_name'] . '</div>';
        echo '<div>ระดับการแข่งขัน ' . $groupsara[0]['class_name'] . '</div>';
        if (!empty($groupsara[0]['match_date'])) {
            echo '<div>' . buddhistCalendar($groupsara[0]['match_date']) . '</div>';
        }
        echo '</div>';

        if (isset($school_score) > 0) {

    ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>สังกัด</th>
                        <th>สถานศึกษา</th>
                        <th>ผู้แข่งขัน</th>
                        <th>ผู้ควบคุม</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    foreach ($school_score as $key => $value) {

                        $sql = "SELECT ID AS student_id, student_prefix, student_firstname, student_lastname  FROM studentreg WHERE groupsara_id = {$sID} AND school_id = '{$value['school_id']}' ORDER BY student_id ASC";
                        $tmp_result = mysqli_query($conn, $sql);
                        $studentreg = [];
                        if (mysqli_num_rows($tmp_result) > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($tmp_result)) {
                                $studentreg[] = $row;
                            }
                        }
                        $student_txt = "";
                        foreach ($studentreg as $s) {
                            $student_txt .= $s['student_prefix'] . " " . $s['student_firstname'] . " " . $s['student_lastname'] . "<br>";
                        }

                        $sql = "SELECT ID AS teacher_id, teacher_prefix, teacher_firstname, teacher_lastname, tel AS teacher_tel  FROM teacherreg WHERE groupsara_id = {$sID} AND school_id = '{$value['school_id']}' ORDER BY teacher_id ASC";
                        $tmp_result = mysqli_query($conn, $sql);
                        $teacherreg = [];
                        if (mysqli_num_rows($tmp_result) > 0) {
                            // output data of each row
                            while ($row = mysqli_fetch_assoc($tmp_result)) {
                                $teacherreg[] = $row;
                            }
                        }
                        $teacher_txt = "";
                        foreach ($teacherreg as $s) {
                            $teacher_txt .= $s['teacher_prefix'] . " " . $s['teacher_firstname'] . " " . $s['teacher_lastname'] . "<br>";
                        }

                        echo '<tr>';
                        echo '<td>' . $value['staff_name'] . '</td>';
                        echo '<td>' . $value['school_name'] . '</td>';
                        echo '<td>' . $student_txt . '</td>';
                        echo '<td>' . $teacher_txt . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>
            </table>


    <?php
        } else {
            echo '<div class="text-center h4">ไม่มีผู้เข้าแข่งขัน</div>';
        }
    } else {
        // redirect to page
        echo '<div class="text-center h4">ไม่พบข้อมูลการประกวด</div>';
    }
    ?>

</div>

<?php

include "footer.php";

?>