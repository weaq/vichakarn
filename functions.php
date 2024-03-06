<?php
function buddhistCalendar($ymd)
{
	$ymd = explode("-", $ymd);
	$thai_month = array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
	$y = $ymd[0] + 543;
	$m = $thai_month[intval($ymd[1])];
	$d = intval($ymd[2]);
	$output = "วันที่ " . $d . " เดือน " . $m . " พ.ศ. " . $y;
	return $output;
}

function ranking_txt($ranking)
{
	if ($ranking == 1) {
		$ranking_txt = " ชนะเลิศ";
	} else  if ($ranking == 2) {
		$ranking_txt = " รองชนะเลิศ อันดับ 1";
	} else if ($ranking == 3) {
		$ranking_txt = " รองชนะเลิศ อันดับ 2";
	} else {
		$ranking_txt = "";
	}
	return $ranking_txt;
}

function aword($score)
{
	if ($score >= 80) {
		$award = " ระดับเกียรติบัตรเหรียญทอง";
	} else if ($score >= 70) {
		$award = " ระดับเกียรติบัตรเหรียญเงิน";
	} else if ($score >= 60) {
		$award = " ระดับเกียรติบัตรเหรียญทองแดง";
	} else if ($score >= 1) {
		$award = " ระดับเกียรติบัตรชมเชย";
	} else {
		$award = "";
	}
	return $award;
}
