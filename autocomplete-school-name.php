<?php
include "dbconnect.php";

if (isset($_GET['term'])) {
 $query = "SELECT school_name FROM schools WHERE school_name LIKE '%{$_GET['term']}%' GROUP BY school_name ORDER BY school_name LIMIT 30";
 $result = mysqli_query($conn, $query);
 if (mysqli_num_rows($result) > 0) {
   while ($row = mysqli_fetch_array($result)) {
     $arr[] = $row['school_name'];
   }
 } else {
   $arr = array();
 }
 echo json_encode($arr);
}
?>