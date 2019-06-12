<?php
require("constants.php");

$mysqli_conn=new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(!$mysqli_conn){
	echo mysqli_connect_error()."Check ServerHost,Username,Password Of the DataBase ".mysqli_connect_errorno()."<br/>";
}

$searchTerm = $_GET['term'];

//$select = mysqli_query($mysqli_conn, "SELECT * FROM puitems WHERE puitem LIKE '%".$searchTerm."%'");
$select = mysqli_query($mysqli_conn, "SELECT puitem as label, id as value FROM puitems WHERE puitem LIKE '%".$searchTerm."%'");
while ($row = mysqli_fetch_array($select)) 
{
 $data[] = $row;
}
//return json data
echo json_encode($data);
?>