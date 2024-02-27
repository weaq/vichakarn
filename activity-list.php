<?php
include("header.php");
include("dbconnect.php");
?>

<div class="container mt-3 mb-5">
	<?php
	// group
	$sql = "SELECT DISTINCT(group_id) as group_id, group_name FROM groupsara ORDER BY group_id ASC";
	$result = mysqli_query($conn, $sql);

	echo '<div class="col-md-8">';
	echo '<strong>กลุ่มสาระการเรียนรู้ : </strong>';
	echo '<select name="group" onchange="location = this.value;">';
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
		$sql = "SELECT DISTINCT(class_id) as count_class_id ,class_name FROM `groupsara` WHERE group_id = '{$_GET['group_id']}' ORDER BY class_id ASC ";
		$arr_class = mysqli_query($conn, $sql);
		if (mysqli_num_rows($arr_class) > 0) {
			// output data of each row
			while ($row = mysqli_fetch_assoc($arr_class)) {
				echo $row['class_name'] . ' ' . $row['count_class_id'] . "<br>";
			}
		}


		$sql = "SELECT COUNT(activity_name) as count_activity_name, activity_name FROM groupsara WHERE group_id = '{$_GET['group_id']}' GROUP BY activity_name ORDER BY `groupsara`.`activity_name` ASC";
		$arr_activity_name = mysqli_query($conn, $sql);
		if (mysqli_num_rows($arr_activity_name) > 0) {
			// output data of each row
			while ($row = mysqli_fetch_assoc($arr_activity_name)) {
				echo $row['count_activity_name'] . ' ' . $row['activity_name'] . "<br>";

			}
		}



	}
	?>

</div>

<?php
include("footer.php");
?>