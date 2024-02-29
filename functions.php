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
