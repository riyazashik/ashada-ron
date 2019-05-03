<?php
require("constants.php");

$mysqli_conn=new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(!$mysqli_conn){
	echo mysqli_connect_error()."Check ServerHost,Username,Password Of the DataBase ".mysqli_connect_errorno()."<br/>";
}

//Country Division Section
function getcountrydivisionspgtotal() {
	global $mysqli_conn;
	$sql = "SELECT COUNT(id) AS total FROM countrydivisions";
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

function getcountrydivisionshtml($current_pgno) {
	global $mysqli_conn;
	$totalrow = getcountrydivisionspgtotal();
	$rows_page = 2; //10
	$last = ceil($totalrow/$rows_page);
	if($last < 1){
		$last = 1;
	}	
	$pagenum = 1;
	if(isset($current_pgno)){
		$pagenum = preg_replace('#[^0-9]#', '', $current_pgno);
	}
	if ($pagenum < 1){ 
		$pagenum = 1; 
	}
	else if ($pagenum > $last){ 
		$pagenum = $last; 
	}
	$limit = 'LIMIT ' .($pagenum - 1) * $rows_page .',' .$rows_page;

	$sql = "SELECT * FROM countrydivisions $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
    $html .= '<tr><td>' . $row["id"] . '</td><td>' . $row["areaname"] . '</td><td>' . $row["exchange"] . '</td><td>' . $row["feeder"] . '</td><td>
    <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
    <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
    <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
</td>
</tr>';
    }
	return $html;
}

function getcountrydivisionspag($current_pgno) {
	$totalrow = getcountrydivisionspgtotal();
	$rows_page = 2; //10
	$last = ceil($totalrow/$rows_page);
	if($last < 1){
		$last = 1;
	}	
	$pagenum = 1;
	if(isset($current_pgno)){
		$pagenum = preg_replace('#[^0-9]#', '', $current_pgno);
	}
	if ($pagenum < 1){ 
		$pagenum = 1; 
	}
	else if ($pagenum > $last){ 
		$pagenum = $last; 
	}
	$limit = 'LIMIT ' .($pagenum - 1) * $rows_page .',' .$rows_page;

	$paginationCtrls = '';

	if($last != 1){
	
	if ($pagenum > 1) {
	$previous = $pagenum - 1;
	$paginationCtrls .= '<a class="btn btn-default" onclick="getallcountrydivision('.$previous.')">Previous</a> &nbsp; &nbsp; ';

	for($i = $pagenum-4; $i < $pagenum; $i++){
		if($i > 0){
			$paginationCtrls .= '<a class="btn btn-default" onclick="getallcountrydivision('.$i.')">'.$i.'</a> &nbsp; ';
		}
	}
	}
	
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	
    for($i = $pagenum+1; $i <= $last; $i++)
    {
		$paginationCtrls .= '<a class="btn btn-default" onclick="getallcountrydivision('.$i.')">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}

    if ($pagenum != $last) 
    {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a class="btn btn-default" onclick="getallcountrydivision('.$next.')">Next</a> ';
    }
	}
	return $paginationCtrls;
}

function insertcountrydivisions($data) {
	global $mysqli_conn;
	$sql = "INSERT INTO countrydivisions(areaname, exchange, feeder) VALUES ('". $data['areaname'] ."','". $data['exchange']."','". $data['feeder']."')";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to insert data");
	return mysqli_insert_id($mysqli_conn);
}

function updatecountrydivisions($data) {
	global $mysqli_conn;
	$sql = "UPDATE countrydivisions SET areaname = '" . $data["areaname"] . "', exchange='" . $data["exchange"]."', feeder='" . $data["feeder"] . "' WHERE id='".$data["id"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to update data");
	return mysqli_insert_id($mysqli_conn);
}	

function deletecountrydivisions($data) {
	global $mysqli_conn;
	$sql = "DELETE FROM countrydivisions WHERE id='".$data["id"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to delete data");
	return mysqli_insert_id($mysqli_conn);
}

function getareanamesselect($areaname) {
	global $mysqli_conn;
	$sql = "SELECT Areaname as areaname FROM areas";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "<select class='form-control' name='areaname'>";
    while($row = mysqli_fetch_array($result)){
	if($areaname == $row['areaname']){
	$html .= "<option value='" . $row['areaname'] . "' selected >" . $row['areaname'] . "</option>";
	}
	else{
	$html .= "<option value='" . $row['areaname'] . "'>" . $row['areaname'] . "</option>";
	}
	}
	$html .= "</select>";
	return $html;
}

function checkcountrydivisionexists($data){
	global $mysqli_conn;
	$condition = '';
	if (isset($data['id']) && is_numeric($data['id']))
	{
		$condition = " AND id != '". $data["id"] ."'";
	}
	$sql = "SELECT * FROM countrydivisions WHERE areaname = '" . $data["areaname"] . "' AND exchange='" . $data["exchange"]."' AND feeder='" . $data["feeder"] . "' $condition";
	$result = mysqli_query($mysqli_conn, $sql);
	return mysqli_num_rows($result);
}


//PUI Items Section
function getpuitemspgtotal() {
	global $mysqli_conn;
	$sql = "SELECT COUNT(id) AS total FROM puitems";
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

function getpuitemshtml($current_pgno) {
	global $mysqli_conn;
	$totalrow = getpuitemspgtotal();
	$rows_page = 2; //10
	$last = ceil($totalrow/$rows_page);
	if($last < 1){
		$last = 1;
	}	
	$pagenum = 1;
	if(isset($current_pgno)){
		$pagenum = preg_replace('#[^0-9]#', '', $current_pgno);
	}
	if ($pagenum < 1){ 
		$pagenum = 1; 
	}
	else if ($pagenum > $last){ 
		$pagenum = $last; 
	}
	$limit = 'LIMIT ' .($pagenum - 1) * $rows_page .',' .$rows_page;

	$sql = "SELECT * FROM puitems ORDER BY type, puitem $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
    $html .= '<tr><td>' . $row["type"] . '</td><td>' . $row["puitem"] . '</td><td>' . $row["description"] . '</td><td>' . $row["unit"] . '</td><td>' . $row["unitprice"] . '</td><td>' . $row["designqty"] . '</td><td>
    <a class="add" title="Add" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
    <a class="edit" title="Edit" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
    <a class="delete" title="Delete" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
</td>
</tr>';
    }
	return $html;
}

function getpuitemspag($current_pgno) {
	$totalrow = getpuitemspgtotal();
	$rows_page = 2; //10
	$last = ceil($totalrow/$rows_page);
	if($last < 1){
		$last = 1;
	}	
	$pagenum = 1;
	if(isset($current_pgno)){
		$pagenum = preg_replace('#[^0-9]#', '', $current_pgno);
	}
	if ($pagenum < 1){ 
		$pagenum = 1; 
	}
	else if ($pagenum > $last){ 
		$pagenum = $last; 
	}
	$limit = 'LIMIT ' .($pagenum - 1) * $rows_page .',' .$rows_page;

	$paginationCtrls = '';

	if($last != 1){
	
	if ($pagenum > 1) {
	$previous = $pagenum - 1;
	$paginationCtrls .= '<a class="btn btn-default" onclick="getallpuitems('.$previous.')">Previous</a> &nbsp; &nbsp; ';

	for($i = $pagenum-4; $i < $pagenum; $i++){
		if($i > 0){
			$paginationCtrls .= '<a class="btn btn-default" onclick="getallpuitems('.$i.')">'.$i.'</a> &nbsp; ';
		}
	}
	}
	
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	
    for($i = $pagenum+1; $i <= $last; $i++)
    {
		$paginationCtrls .= '<a class="btn btn-default" onclick="getallpuitems('.$i.')">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}

    if ($pagenum != $last) 
    {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a class="btn btn-default" onclick="getallpuitems('.$next.')">Next</a> ';
    }
	}
	return $paginationCtrls;
}

function insertpuitems($data) {
	global $mysqli_conn;
	$sql = "INSERT INTO puitems(type, puitem, description, unit, unitprice, designqty) VALUES ('". $data['type'] ."','". $data['puitem']."','". $data['description']."','". $data['unit']."','". $data['unitprice']."','". $data['designqty']."')";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to insert data");
	return mysqli_insert_id($mysqli_conn);
}

function updatepuitems($data) {
	global $mysqli_conn;
	$sql = "UPDATE puitems SET type = '" . $data["type"] . "', puitem = '" . $data["puitem"] . "', description='" . $data["description"]."', unit='" . $data["unit"] . "', unitprice='" . $data["unitprice"] . "', designqty='" . $data["designqty"] . "' WHERE id='".$data["id"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to update data");
	return mysqli_insert_id($mysqli_conn);
}	

function deletepuitems($data) {
	global $mysqli_conn;
	$sql = "DELETE FROM puitems WHERE id='".$data["id"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to delete data");
	return mysqli_insert_id($mysqli_conn);
}

function checkpuitemsexists($data){
	global $mysqli_conn;
	$condition = '';
	if (isset($data['id']) && is_numeric($data['id']))
	{
		$condition = " AND id != '". $data["id"] ."'";
	}
	$sql = "SELECT * FROM puitems WHERE type = '" . $data["type"] . "' AND puitem='" . $data["puitem"]."' $condition";
	$result = mysqli_query($mysqli_conn, $sql);
	return mysqli_num_rows($result);
}

function getunitsselect($units) {
	$name = array("each", "m", "km", "sqm", "cbm");
	$html = "<select class='form-control' name='units'>";
    foreach($name as $row){
	$html .= "<option value='" . $row . "' selected >" . $row . "</option>";
	}
	$html .= "</select>";
	return $html;
}
?>