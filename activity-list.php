<?php
session_start();
include("header.php");
include("dbconnect.php");
?>

<div class="container mt-3 mb-5">
	<?php
	// group
	$sql = "SELECT DISTINCT(group_id) as group_id, group_name FROM groupsara ORDER BY group_id ASC";
	$result = mysqli_query($conn, $sql);

	echo '<div class="form-group">';
	echo '<label for="sel1">กลุ่มสาระการเรียนรู้:</label>';
	echo '<select class="form-control" name="group" onchange="location = this.value;">';

	echo '<option value="?group_id=0" selected >กรุณาเลือกกลุ่มสาระ</option>';

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$selected = ($_GET['group_id'] == $row['group_id']) ? "selected" : "";
			// list
			echo '<option value="?group_id=' . $row['group_id'] . '" ' . $selected . '>' . $row['group_name'] . '</option>';
		}
	}

	echo '</select>';
	echo '</div>';

	?>
	<?php


	// class
	if ($_GET['group_id']) {

		// get class array
		
		$sql = "SELECT DISTINCT(class_id) as class_id ,class_name FROM `groupsara` WHERE group_id = '{$_GET['group_id']}' ORDER BY class_id ASC ";
		$tmp_result = mysqli_query($conn, $sql);
		$arr_class = [];
		if (mysqli_num_rows($tmp_result) > 0) {
			// output data of each row
			while ($row = mysqli_fetch_assoc($tmp_result)) {
				$arr_class[] = $row;
			}
		}


		
		$sql = "SELECT COUNT(activity_name) as count_activity_name, activity_name FROM groupsara WHERE group_id = '{$_GET['group_id']}' GROUP BY activity_name ORDER BY `groupsara`.`activity_name` ASC";
		$tmp_result = mysqli_query($conn, $sql);
		$arr_activity_name = [];
		if (mysqli_num_rows($tmp_result) > 0) {
			// output data of each row
			while ($row = mysqli_fetch_assoc($tmp_result)) {
				$arr_activity_name[] = $row;
			}
		}


	?>


		<table class="table table-hover">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th colspan="<?php echo count($arr_class); ?>" class="text-center">ระดับ</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<th>ชื่อกิจกรรม</th>
					<?php
					foreach ($arr_class as $value) {
						echo '<th class="text-center">' . $value['class_name'] . '</th>';
					}
					?>
					<th class="text-center">ประเภท</th>
				</tr>
			</thead>
			<tbody>

				<?php

				foreach ($arr_activity_name as $row) {
					echo '<tr>';
					echo '<td>' . $row['activity_name'] . '</td>';

					$txt_activity_type = "";

					foreach ($arr_class as $value) {

						if (!empty($_SESSION['sess_user'])) {

							$sql = "SELECT * FROM groupsara WHERE activity_name LIKE '%{$row['activity_name']}%' AND class_id = '{$value['class_id']}' AND group_id = '{$_GET['group_id']}' ";
							$tmp_result = mysqli_query($conn, $sql);
							$result_activity = [];
							if (mysqli_num_rows($tmp_result) > 0) {
								// output data of each row
								while ($row = mysqli_fetch_assoc($tmp_result)) {
									$result_activity[] = $row;
								}
							}



							if ($result_activity[0]['student_no']) {


								$sql = "SELECT COUNT(id) as cid FROM `studentreg` WHERE groupsara_id = '{$result_activity[0]['ID']}' AND school_id = '{$current_user->user_login}' ";
								$tmp_result = mysqli_query($conn, $sql);
								$result_count_student = [];
								if (mysqli_num_rows($tmp_result) > 0) {
									// output data of each row
									while ($row = mysqli_fetch_assoc($tmp_result)) {
										$result_count_student[] = $row;
									}
								}


								$sql = "SELECT COUNT(id) as cid FROM `teacherreg` WHERE groupsara_id = '{$result_activity[0]['ID']}' AND school_id = '{$current_user->user_login}' ";
								$tmp_result = mysqli_query($conn, $sql);
								$result_count_teacher = [];
								if (mysqli_num_rows($tmp_result) > 0) {
									// output data of each row
									while ($row = mysqli_fetch_assoc($tmp_result)) {
										$result_count_teacher[] = $row;
									}
								}


								if ($value['class_id'] == "11") {
									if (empty($result_count_student[0]['cid'])) {
										echo '<td class="text-center"><a href="regis-form.php?sID=' . $result_activity[0]['ID'] . '" class="text-danger">ไม่ได้ส่ง</a></td>';
									} else if ($result_count_student[0]['cid'] >= $result_activity[0]['student_no_min']) {
										echo '<td class="text-center"><a href="regis-form.php?sID=' . $result_activity[0]['ID'] . '" class="text-success">ส่งครบแล้ว</a></td>';
									} else {
										echo '<td class="text-center"><a href="regis-form.php?sID=' . $result_activity[0]['ID'] . '">ส่งไม่ครบ ' . $result_count_student[0]['cid'] . '/' . $result_count_teacher[0]['cid'] . '</a></td>';
									}
								} else {
									if (empty($result_count_student[0]['cid']) && empty($result_count_teacher[0]['cid'])) {
										echo '<td class="text-center"><a href="regis-form.php?sID=' . $result_activity[0]['ID'] . '" class="text-danger">ไม่ได้ส่ง</a></td>';
									} else if ($result_count_student[0]['cid'] >= $result_activity[0]['student_no_min'] && $result_count_teacher[0]['cid'] > 0) {
										echo '<td class="text-center"><a href="regis-form.php?sID=' . $result_activity[0]['ID'] . '" class="text-success">ส่งครบแล้ว</a></td>';
									} else {
										echo '<td class="text-center"><a href="regis-form.php?sID=' . $result_activity[0]['ID'] . '">ส่งไม่ครบ ' . $result_count_student[0]['cid'] . '/' . $result_count_teacher[0]['cid'] . '</a></td>';
									}
								}
							} else {
								echo '<td class="bg-secondary">&nbsp;</td>';
							}
						} else {
							// not login 
							$sql = "SELECT * FROM groupsara WHERE activity_name LIKE '%{$row['activity_name']}%' AND class_id = '{$value['class_id']}' AND group_id = '{$_GET['group_id']}' ";
							$tmp_result = mysqli_query($conn, $sql);
							$result_activity = [];
							if (mysqli_num_rows($tmp_result) > 0) {
								// output data of each row
								while ($row = mysqli_fetch_assoc($tmp_result)) {
									$result_activity[] = $row;
								}
							}



							if ($result_activity[0]['student_no']) {

								$sql = "SELECT COUNT(DISTINCT(school_id)) as school_count FROM `studentreg` WHERE groupsara_id = '{$result_activity[0]['ID']}' ";
								$tmp_result = mysqli_query($conn, $sql);
								$school_id_count = [];
								if (mysqli_num_rows($tmp_result) > 0) {
									// output data of each row
									while ($row = mysqli_fetch_assoc($tmp_result)) {
										$school_id_count[] = $row;
									}
								}



								if ($school_id_count[0]['school_count']) {
									echo '<td class="text-center">';
									echo '<a href="../activity-school/?sID=' . $result_activity[0]['ID'] . '" target="_blank" >' . $school_id_count[0]['school_count'] . ' โรง </a>';
									echo '</td>';
								} else {
									echo '<td class="text-center"> - </td>';
								}
							} else {
								echo '<td class="bg-secondary">&nbsp;</td>';
							}
						}

						if ($result_activity[0]['student_no'] == 1) {
							$txt_activity_type = "เดี่ยว";
						} else if ($result_activity[0]['student_no'] == 2) {
							$txt_activity_type = "คู่";
						} else if ($result_activity[0]['student_no'] >= 3) {
							if ($result_activity[0]['student_no'] == $result_activity[0]['student_no_min']) {
								$txt_activity_type = "ทีม " . $result_activity[0]['student_no'] . " คน";
							} else {
								$txt_activity_type = "ทีม " . $result_activity[0]['student_no_min'] . "-" . $result_activity[0]['student_no'] . " คน";
							}
						}
					}

					echo '<td class="text-center">' . $txt_activity_type . '</td>';

					echo '</tr>';
				}

				?>

			</tbody>
		</table>






	<?php


	}
	?>

</div>

<?php
include("footer.php");
?>