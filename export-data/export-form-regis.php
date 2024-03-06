<?php

require('fpdf.php');

include "../dbconnect.php";
include "../functions.php";

$sID = $_GET['sID'];

$sql = "SELECT * FROM groupsara WHERE ID = '{$sID}'";
$result_groupsara = mysqli_query($conn, $sql);
$row_groupsara = mysqli_fetch_assoc($result_groupsara);

#print_r($row_groupsara);

$sql = "SELECT a.*, b.school_name, c.user as staff_user, c.name as staff_name, c.tel as staff_tel, c.email as staff_email FROM studentreg a INNER JOIN schools b ON a.school_id = b.id INNER JOIN staff c ON a.staff_id = c.id WHERE a.groupsara_id = '{$sID}' ORDER BY staff_user, school_name ASC";

$result_score = mysqli_query($conn, $sql);

$count_row = mysqli_num_rows($result_score);

#print_r($count_row);


$add_page = 1;
$page_no = 1;
$i = 0;
$i_school = 0;
$id_teacher = 0;

$tmp_school_id = "";


// create PDF
$pdf = new FPDF('L', 'mm', 'A4');
// Add Thai font
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew', 'B', 'THSarabunNew_b.php');

// page 1
if ($count_row > 0) {
    while ($value = mysqli_fetch_assoc($result_score)) {
        $i++;
        if ($add_page == 1) {
            $pdf->AddPage('L', 'A4');

            $add_page = 0;

            $pos_x = 16;
            $pos_y = 10;

            //$pdf->Image('img/logo.jpg', 94, 6, 30); // Portrait Page Center
            //$pdf->Image('img/logo.jpg', 136, 6, 30); // Landing Page Center
            $pdf->Image('img/logo.jpg', 10, 6, 30); // Landing Page Left

            $pdf->SetFont('THSarabunNew', 'B', 16);

            if ($page_no != 1) {
                $pdf->SetXY(2, 10); // abscissa or Horizontal position
                $tmp_txt = "หน้า " . $page_no;
                $pdf->Cell(0, 0, iconv('UTF-8', 'cp874', $tmp_txt), 0, 1, 'R');
                $pdf->ln();
            }

            $pdf->SetXY($pos_x, $pos_y); // abscissa or Horizontal position
            $tmp_txt = "แบบบัญชีลงทะเบียนผู้เข้าร่วมการประกวดแข่งขัน";
            $pdf->Cell(0, 0, iconv('UTF-8', 'cp874', $tmp_txt), 0, 1, 'C');
            $pdf->ln();

            $pos_y += 6;
            $pdf->SetXY($pos_x, $pos_y); // abscissa or Horizontal position
            $tmp_txt = "กลุ่มสาระการเรียนรู้ " . $row_groupsara['group_name'];
            $pdf->Cell(0, 0, iconv('UTF-8', 'cp874', $tmp_txt), 0, 1, 'C');
            $pdf->ln();

            $pos_y += 6;
            $pdf->SetXY($pos_x, $pos_y); // abscissa or Horizontal position
            $tmp_txt = "รายการแข่งขัน " . $row_groupsara['activity_name'];
            $tmp_txt .= " ระดับการแข่งขัน " . $row_groupsara['class_name'];
            $pdf->Cell(0, 0, iconv('UTF-8', 'cp874', $tmp_txt), 0, 1, 'C');
            $pdf->ln();

            $pos_y += 6;
            $pdf->SetXY($pos_x, $pos_y); // abscissa or Horizontal position
            $tmp_txt = buddhistCalendar($row_groupsara['match_date']) ;
            $pdf->Cell(0, 0, iconv('UTF-8', 'cp874', $tmp_txt), 0, 1, 'C');
            $pdf->ln();

            // table head
            $pos_y += 8;
            $pdf->SetXY(9, $pos_y);
            $pdf->Cell(12, 8, iconv('UTF-8', 'cp874', 'ที่'), 1, 1, 'C');
            $pdf->SetXY(21, $pos_y);
            $pdf->Cell(60, 8, iconv('UTF-8', 'cp874', 'สถานศึกษา'), 1, 1, 'C');
            $pdf->SetXY(81, $pos_y);
            $pdf->Cell(52, 8, iconv('UTF-8', 'cp874', 'รายชื่อผู้เข้าร่วมแข่งขัน'), 1, 1, 'C');
            $pdf->SetXY(133, $pos_y);
            $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', 'ระดับชั้น'), 1, 1, 'C');
            $pdf->SetXY(153, $pos_y);
            $pdf->Cell(28, 8, iconv('UTF-8', 'cp874', 'ลายมือชื่อ'), 1, 1, 'C');
            $pdf->SetXY(181, $pos_y);
            $pdf->Cell(50, 8, iconv('UTF-8', 'cp874', 'รายชื่อผู้ควบคุม'), 1, 1, 'C');
            $pdf->SetXY(231, $pos_y);
            $pdf->Cell(28, 8, iconv('UTF-8', 'cp874', 'ลายมือชื่อ'), 1, 1, 'C');
            $pdf->SetXY(259, $pos_y);
            $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', 'หมายเหตุ'), 1, 1, 'C');
        }

        if ($value['school_id'] != $tmp_school_id) {
            $tmp_i_school = ++$i_school;
            $tmp_school_name = $value['school_name'];
            $tmp_school_id = $value['school_id'];

            $sql = "SELECT ID AS teacher_id, teacher_prefix, teacher_firstname, teacher_lastname, tel AS teacher_tel  FROM teacherreg WHERE groupsara_id = {$sID} AND staff_id = '{$value['staff_id']}' ORDER BY teacher_id ASC";
            $result_teacher = mysqli_query($conn, $sql);
            $teacherreg = mysqli_fetch_all($result_teacher, MYSQLI_ASSOC);
            $id_teacher = 0;

        } else {
            $tmp_school_name = "";
            $tmp_i_school = "";
            $id_teacher++;
        }

        // table row
        $pdf->SetFont('THSarabunNew', '', 16);
        $pos_y += 8;
        $pdf->SetXY(9, $pos_y);
        $pdf->Cell(12, 8, iconv('UTF-8', 'cp874', $tmp_i_school), 1, 1, 'C');
        $pdf->SetXY(21, $pos_y);
        $pdf->Cell(60, 8, iconv('UTF-8', 'cp874', $tmp_school_name), 1, 1, 'L');
        $pdf->SetXY(81, $pos_y);
        $tmp_txt = $value['student_prefix'] . $value['student_firstname'] . " " . $value['student_lastname'];
        $pdf->Cell(52, 8, iconv('UTF-8', 'cp874', $tmp_txt), 1, 1, 'L');
        $pdf->SetXY(133, $pos_y);
        $tmp_txt = $value['student_classroom'];
        $pdf->Cell(20, 8, iconv('UTF-8', 'cp874', $tmp_txt), 1, 1, 'C');
        $pdf->SetXY(153, $pos_y);
        $pdf->Cell(28, 8, iconv('UTF-8', 'cp874', ''), 1, 1, 'C');
        $pdf->SetXY(181, $pos_y);
        $tmp_txt = $teacherreg[$id_teacher]['teacher_prefix']  . $teacherreg[$id_teacher]['teacher_firstname'] . " " . $teacherreg[$id_teacher]['teacher_lastname'];
        $pdf->Cell(50, 8, iconv('UTF-8', 'cp874', $tmp_txt), 1, 1, 'L');
        $pdf->SetXY(231, $pos_y);
        $pdf->Cell(28, 8, iconv('UTF-8', 'cp874', ''), 1, 1, 'C');
        $pdf->SetXY(259, $pos_y);
        $pdf->Cell(30, 8, iconv('UTF-8', 'cp874', $teacherreg[$id_teacher]['teacher_tel']), 1, 1, 'C');





        // footer page
        if ($pos_y >= 175 || $i == $count_row) {
            $add_page = 1;
            $page_no++;
        }


    }

    $pdf->Output();
}


