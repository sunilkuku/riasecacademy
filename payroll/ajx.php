<?php

include("php/dbconnect.php");

if($_GET['type'] == 'studentname'){
	$result = $conn->query("SELECT sname,rollno,contact FROM student where (sname LIKE '%".$_GET['name_startsWith']."%' or rollno= '%".$_GET['name_startsWith']."%' Or contact LIKE '%".$_GET['name_startsWith']."%')   ");	
	$data = array();
	while ($row = $result->fetch_assoc()) {
		//array_push($data, $row['sname'].'-'.$row['contact']);	
		array_push($data, $row['sname']);	
	}	
	echo json_encode($data);
}


if($_GET['type'] == 'report'){
	$result = $conn->query("SELECT sname,contact,rollno FROM student where (sname LIKE '%".$_GET['name_startsWith']."%' or contact LIKE '%".$_GET['name_startsWith']."%' or rollno = '%".$_GET['name_startsWith']."%')  ");	
	$data = array();
	while ($row = $result->fetch_assoc()) {
		//array_push($data, $row['sname'].'-'.$row['contact']);	
		array_push($data, $row['sname']);	
	}	
	echo json_encode($data);
}
if($_GET['type'] == 'monthlyreport'){
	$result = $conn->query("SELECT sname,contact,rollno FROM student where (sname LIKE '%".$_GET['name_startsWith']."%' or contact LIKE '%".$_GET['name_startsWith']."%' or rollno = '%".$_GET['name_startsWith']."%') ");	
	$data = array();
	while ($row = $result->fetch_assoc()) {
		//array_push($data, $row['sname'].'-'.$row['contact']);	
		array_push($data, $row['sname']);	
	}	
	echo json_encode($data);
}

?>