<?php
include "config.php";
include "functions.php";
include "dbconnect.php";

/* Database connection end */


// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;


$columns = array('ID','group_name','activity_name','class_name');

// getting total number records without any search
$sql = "SELECT * FROM groupsara ";
$result = mysqli_query($conn, $sql) or die("error : " . $sql );
$totalData = mysqli_num_rows($result);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" WHERE ( groupsara.group_name LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR groupsara.activity_name LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR groupsara.class_name LIKE '%".$requestData['search']['value']."%' )";
}
$result=mysqli_query($conn, $sql) or die("error : " . $sql );
$totalFiltered = mysqli_num_rows($result); // when there is a search parameter then we have to modify total number filtered rows as per search result.
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$result = mysqli_query($conn, $sql) or die("error : " . $sql );

if (mysqli_num_rows($result) > 0) {
while( $row=mysqli_fetch_array($result) ) {  // preparing an array
	$tmpData=array();

	$tmpData[] = $row['ID'];
	$tmpData[] = $row['group_name'];
	$tmpData[] = $row['activity_name'];
	$tmpData[] = $row['class_name'];
	$data[] = $tmpData;

}
} else {
	$data[] = array('','','','');
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
