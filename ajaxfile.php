<?php 

include "config.php";

$request = "";
if(isset($_POST['request'])){
	$request = $_POST['request'];
}



// Fetch record by id
if($request)

	$userid ='21-2112-0-00000000032' ;
	// if(isset($_POST['userid']) ){ 
	//     $userid = $_POST['userid']; 
	    
	// }

	// $query = 'SELECT * FROM print_sh ';
	$query = "SELECT  id , requestnumber, name ,phone ,addr FROM print_sh WHERE requestnumber LIKE '%$userid%'";
	$result = pg_query($con, $query);

	$response = array();
	if (pg_numrows($result) > 0) {

		// $row = pg_fetch_assoc($result);
		while ($row = pg_fetch_assoc($result) ) {
			
		

		$id = $row['id'];
		$requestnumber = $row['requestnumber'];
		$name=$row['name'];
		$phone = $row['phone'];
		$addr = $row['addr'];
	    $response[] = array(
					"id" => $id,
					"requestnumber" => $requestnumber,
					"name" =>$name,
					"phone" => $phone,
					"addr" => $addr,
				);
	} 
	}
	echo json_encode($response);
	die;

