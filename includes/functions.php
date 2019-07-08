<?php
require("constants.php");

$mysqli_conn=new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(!$mysqli_conn){
	echo mysqli_connect_error()."Check ServerHost,Username,Password Of the DataBase ".mysqli_connect_errorno()."<br/>";
}

//Exchange Division Section
function getexchangedivisionspgtotal($areaname='') {
	global $mysqli_conn;
	$wherecondition = "WHERE 1";
//	if ($areaname != ""){
        $wherecondition .= " AND areaname= '$areaname'";
//    }
	$sql = "SELECT COUNT(id) AS total FROM countrydivisions $wherecondition";
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

function getexchangedivisionshtml($current_pgno,$areaname='') {
	global $mysqli_conn;
	$totalrow = getexchangedivisionspgtotal($areaname);
	$rows_page = PAGINATION; //10
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
	$wherecondition = "WHERE 1";
//	if ($areaname != ""){
    $wherecondition .= " AND areaname= '$areaname'";
	$sql = "SELECT DISTINCT(exchange) FROM countrydivisions $wherecondition $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
    $html .= '<tr><td>' . $row["exchange"] . '</td><td>
    <a class="add" title="Add" itemid="' . $row["exchange"] . '" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
    <a class="edit" title="Edit" itemid="' . $row["exchange"] . '" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
    <a class="delete" title="Delete" itemid="' . $row["exchange"] . '" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
</td>
</tr>';
	}
//}
	return $html;
}

function getexchangedivisionspag($current_pgno,$areaname='') {
	$totalrow = getexchangedivisionspgtotal($areaname);
	$rows_page = PAGINATION; //10
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
	$paginationCtrls .= '<a class="btn btn-default exchangedivision" pagenum="'.$previous.'">Previous</a> &nbsp; &nbsp; ';

	for($i = $pagenum-4; $i < $pagenum; $i++){
		if($i > 0){
			$paginationCtrls .= '<a class="btn btn-default exchangedivision" pagenum="'.$i.'">'.$i.'</a> &nbsp; ';
		}
	}
	}
	
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	
    for($i = $pagenum+1; $i <= $last; $i++)
    {
		$paginationCtrls .= '<a class="btn btn-default exchangedivision" pagenum="'.$i.'">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}

    if ($pagenum != $last) 
    {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a class="btn btn-default exchangedivision" pagenum="'.$next.'">Next</a> ';
    }
	}
	return $paginationCtrls;
}

function insertexchangedivisions($data) {
	global $mysqli_conn;
	$sql = "INSERT INTO countrydivisions(areaname, exchange) VALUES ('". $data['areaname'] ."','". $data['exchange']."')";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to insert data");
	return mysqli_insert_id($mysqli_conn);
}

function updateexchangedivisions($data) {
	global $mysqli_conn;
	$sql = "UPDATE countrydivisions SET areaname = '" . $data["areaname"] . "', exchange='" . $data["exchange"]."' WHERE exchange='".$data["id"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to update data");
	return mysqli_insert_id($mysqli_conn);
}	

function deleteexchangedivisions($data) {
	global $mysqli_conn;
	$sql="SELECT COUNT(*) FROM executedworks WHERE exchange = '".$data["exchange"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to delete data");
	$result = mysqli_fetch_row($result);
	if($result[0] != 0){
		return $result[0];
	}
	else{
	$sql1 = "DELETE FROM countrydivisions WHERE areaname='".$data["areaname"]."' AND exchange='".$data["id"]."'";
	$result1 = mysqli_query($mysqli_conn, $sql1) or die("error to delete data");
	return mysqli_insert_id($mysqli_conn);
	}
}

function exchangedivisionareaselect() {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT areaname FROM areas";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['areaname'];
	}
	return $options;
}

function checkexchangedivisionexists($data){
	global $mysqli_conn;
	$condition = '';
	if (isset($data['id']) && !empty($data['id']))
	{
		$condition = " AND exchange != '". $data["id"] ."'";
	}
	$sql = "SELECT * FROM countrydivisions WHERE areaname = '" . $data["areaname"] . "' AND exchange='" . $data["exchange"]."' $condition";
	$result = mysqli_query($mysqli_conn, $sql);
	return mysqli_num_rows($result);
}

//Feeder Division Section
function getfeederdivisionspgtotal($areaname='',$exchange='') {
	global $mysqli_conn;
	$wherecondition = "WHERE 1 AND feeder IS NOT NULL";
	//if ($areaname != ""){
        $wherecondition .= " AND areaname= '$areaname'";
   // }
    //if ($exchange != ""){
	$wherecondition .= " AND exchange= '$exchange'";
	//}
	$sql = "SELECT COUNT(id) AS total FROM countrydivisions $wherecondition";
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

function getfeederdivisionshtml($current_pgno,$areaname='',$exchange='') {
	global $mysqli_conn;
	$totalrow = getfeederdivisionspgtotal($areaname,$exchange);
	$rows_page = PAGINATION; //10
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
	$wherecondition = "WHERE 1 AND feeder IS NOT NULL";
	//if ($areaname != ""){
        $wherecondition .= " AND areaname= '$areaname'";
    //}
    //if ($exchange != ""){
	$wherecondition .= " AND exchange= '$exchange'";
	//}
	$sql = "SELECT DISTINCT * FROM countrydivisions $wherecondition $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
    $html .= '<tr><td>' . $row["feeder"] . '</td><td>
    <a class="add" title="Add" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
    <a class="edit" title="Edit" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
    <a class="delete" title="Delete" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
</td>
</tr>';
    }
	return $html;
}

function getfeederdivisionspag($current_pgno,$areaname='',$exchange='') {
	$totalrow = getfeederdivisionspgtotal($areaname,$exchange);
	$rows_page = PAGINATION; //10
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
		$paginationCtrls .= '<a class="btn btn-default feederdivision" pagenum="'.$previous.'">Previous</a> &nbsp; &nbsp; ';
	
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
				$paginationCtrls .= '<a class="btn btn-default feederdivision" pagenum="'.$i.'">'.$i.'</a> &nbsp; ';
			}
		}
		}
		
		$paginationCtrls .= ''.$pagenum.' &nbsp; ';
		
		for($i = $pagenum+1; $i <= $last; $i++)
		{
			$paginationCtrls .= '<a class="btn btn-default feederdivision" pagenum="'.$i.'">'.$i.'</a> &nbsp; ';
			if($i >= $pagenum+4){
				break;
			}
		}
	
	if ($pagenum != $last) 
	{
		$next = $pagenum + 1;
		$paginationCtrls .= ' &nbsp; &nbsp; <a class="btn btn-default feederdivision" pagenum="'.$next.'">Next</a> ';
	}

    if ($pagenum != $last) 
    {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a class="btn btn-default" onclick="getallfeederdivision('.$next.')">Next</a> ';
    }
	}
	return $paginationCtrls;
}

function insertfeederdivisions($data) {
	global $mysqli_conn;
	$sql = "INSERT INTO countrydivisions(areaname, exchange, feeder) VALUES ('". $data['areaname'] ."','". $data['exchange']."','". $data['feeder']."')";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to insert data");
	return mysqli_insert_id($mysqli_conn);
}

function updatefeederdivisions($data) {
	global $mysqli_conn;
	$sql = "UPDATE countrydivisions SET areaname = '" . $data["areaname"] . "', exchange='" . $data["exchange"]."', feeder='" . $data["feeder"] . "' WHERE id='".$data["id"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to update data");
	return mysqli_insert_id($mysqli_conn);
}	

function deletefeederdivisions($data) {
	global $mysqli_conn;
	$sql="SELECT COUNT(*) FROM executedworks WHERE feeder = '".$data["feeder"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to delete data");
	$result = mysqli_fetch_row($result);
	if($result[0] != 0){
		return $result[0];
	}
	else{
	$sql1 = "DELETE FROM countrydivisions WHERE id='".$data["id"]."'";
	$result1 = mysqli_query($mysqli_conn, $sql1) or die("error to delete data");
	return mysqli_insert_id($mysqli_conn);
	}
}

function feederdivisionareaselect() {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT areaname FROM areas";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['areaname'];
	}
	return $options;
}

function feederdivisionexchangeselect($areaname) {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT exchange FROM countrydivisions WHERE areaname = '$areaname'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['exchange'];
	}
	return $options;
}

function checkfeederdivisionexists($data){
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
	$limit = '';
	if($current_pgno != 0)
	{
		$totalrow = getpuitemspgtotal();
		$rows_page = PAGINATION; //10
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

	}
	$sql = "SELECT * FROM puitems ORDER BY type, puitem $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
	$html .= '<tr><td>' . $row["type"] . '</td><td>' . $row["puitem"] . '</td><td>' . $row["description"] . '</td><td>' . $row["unit"] . '</td><td class="righttd">' . $row["unitprice"] . '</td><td class="righttd">' . $row["designqty"] . '</td>';
	if($current_pgno != 0)
	{
		$html .='<td id="actions">
    <a class="add" title="Add" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
    <a class="edit" title="Edit" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
    <a class="delete" title="Delete" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
</td>';
	}
	}
	$html .= '</tr>';
	return $html;
}

function getpuitemspag($current_pgno) {
	$totalrow = getpuitemspgtotal();
	$rows_page = PAGINATION; //10
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
	$name = array("each", "m", "km", "sqm", "cbm", "ls", "pair");
	$html = "<select class='form-control' name='units'>";
	foreach($name as $row){
	if ($units == $row){
		$html .= "<option value='" . $row . "' selected >" . $row . "</option>";	
	}
	else{
		$html .= "<option value='" . $row . "'>" . $row . "</option>";
	}
	}
	$html .= "</select>";
	return $html;
}

//Design quantity Section

function getdesignquantitypgtotal($exchange='',$feeder='') {
	global $mysqli_conn;
	$wherecondition = "WHERE 1";
	//if ($exchange != ""){
	$wherecondition .= " AND dq.exchange= '$exchange'";
	//}
	//if ($feeder != ""){
	$wherecondition .= " AND dq.feeder= '$feeder'";
	//}
	$sql = "SELECT COUNT(dq.id) as total FROM designquantity dq INNER JOIN puitems pu ON dq.puitemid = pu.id $wherecondition";
	
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

function getdesignquantityhtml($current_pgno,$exchange='',$feeder='') {
	global $mysqli_conn;
	$totalrow = getdesignquantitypgtotal($exchange,$feeder);
	$rows_page = PAGINATION; //10
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

	$wherecondition = "WHERE 1";
	//if ($exchange != ""){
	$wherecondition .= " AND dq.exchange= '$exchange'";
	//}
	//if ($feeder != ""){
	$wherecondition .= " AND dq.feeder= '$feeder'";
	//}
	$sql = "SELECT dq.id, dq.exchange, dq.feeder, dq.puitemid, dq.designqty, pu.puitem, pu.description, pu.unit FROM designquantity dq INNER JOIN puitems pu ON dq.puitemid = pu.id $wherecondition $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
    $html .= '<tr><td currentid="'.$row["puitemid"].'">' . $row["puitem"] . '</td><td>' . $row["description"] . '</td><td>' . $row["unit"] . '</td><td class="righttd">' . $row["designqty"] . '</td><td>
    <a class="add" title="Add" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
    <a class="edit" title="Edit" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
    <a class="delete" title="Delete" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
</td>
</tr>';
    }
	return $html;
}

function getdesignquantitypag($current_pgno,$exchange='',$feeder='') {
	$totalrow = getdesignquantitypgtotal($exchange,$feeder);
	$rows_page = PAGINATION; //10
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
	$paginationCtrls .= '<a class="btn btn-default designqntypag" pagenum="'.$previous.'">Previous</a> &nbsp; &nbsp; ';

	for($i = $pagenum-4; $i < $pagenum; $i++){
		if($i > 0){
			$paginationCtrls .= '<a class="btn btn-default designqntypag" pagenum="'.$i.'">'.$i.'</a> &nbsp; ';
		}
	}
	}
	
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	
    for($i = $pagenum+1; $i <= $last; $i++)
    {
		$paginationCtrls .= '<a class="btn btn-default designqntypag" pagenum="'.$i.'">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}

    if ($pagenum != $last) 
    {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a class="btn btn-default designqntypag" pagenum="'.$next.'">Next</a> ';
    }
	}
	return $paginationCtrls;
}

function insertdesignquantity($data) {
	global $mysqli_conn;
	$sql = "INSERT INTO designquantity(exchange, feeder, puitemid, designqty) VALUES ('". $data['exchange'] ."','". $data['feeder']."','". $data['puitemid']."','". $data['designqty']."')";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to insert data");
	return mysqli_insert_id($mysqli_conn);
}

function updatedesignquantity($data) {
	global $mysqli_conn;
	$sql = "UPDATE designquantity SET exchange = '" . $data["exchange"] . "', feeder = '" . $data["feeder"] . "', puitemid='" . $data["puitemid"]."', designqty='" . $data["designqty"] . "' WHERE id='".$data["id"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to update data");
	return mysqli_insert_id($mysqli_conn);
}	

function deletedesignquantity($data) {
	global $mysqli_conn;
	$sql = "DELETE FROM designquantity WHERE id='".$data["id"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to delete data");
	return mysqli_insert_id($mysqli_conn);
}

function checkdesignquantityexists($data){
	global $mysqli_conn;
	$condition = '';
	if (isset($data['id']) && is_numeric($data['id']))
	{
		$condition = " AND id != '". $data["id"] ."'";
	}
	$sql = "SELECT * FROM designquantity WHERE exchange = '" . $data["exchange"] . "' AND feeder='" . $data["feeder"]."' AND puitemid = '" . $data["puitemid"] . "' $condition";
	$result = mysqli_query($mysqli_conn, $sql);
	return mysqli_num_rows($result);
}

function getexchangeselect() {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT exchange FROM countrydivisions";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['exchange'];
	}
	return $options;
}

function getexchangewithareaselect() {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT exchange, areaname FROM countrydivisions";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = array('exchange'=> $row['exchange'],'areaname'=>$row['areaname']);
	}
	return $options;
}

function getfeederselect($exchange) {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT feeder FROM countrydivisions WHERE exchange = '$exchange' && feeder IS NOT NULL";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['feeder'];
	}
	return $options;
}

function getpuitemsselect($puitem) {
	global $mysqli_conn;
	$sql = "SELECT * FROM puitems";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "<select class='form-control puitems' name='puitems'>";
	$html .="<option value=''>Select PU items</option>";
    while($row = mysqli_fetch_array($result)){
	$selected = ($row['puitem'] == $puitem) ? 'selected' : '';
	$html .= "<option value='" . $row['id'] . "' $selected>" . $row['puitem'] . "</option>";
	}
	$html .= "</select>";
	return $html;
}

function getcurrentitem($puitem) {
	global $mysqli_conn;
	$sql = "SELECT id, description, unit FROM puitems WHERE id = '$puitem'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$items = mysqli_fetch_array($result);
	return $items;
}

//Executed works section

function getexecutedworkspgtotal($areaname='',$exchange='',$feeder='') {
	global $mysqli_conn;
	$wherecondition = "WHERE 1";
	if ($areaname != ""){
        $wherecondition .= " AND ew.areaname= '$areaname'";
    }
    if ($exchange != ""){
	$wherecondition .= " AND ew.exchange= '$exchange'";
	}
	if ($feeder != ""){
	$wherecondition .= " AND ew.feeder= '$feeder'";
	}
	$sql = "SELECT COUNT(ew.id) as total FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id LEFT JOIN invoices iv ON ew.invoiceid = iv.id $wherecondition";
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

function getexecutedworkshtml($current_pgno,$areaname='',$exchange='',$feeder='',$sort_order='') {
	global $mysqli_conn;
	$limit = '';
	if($current_pgno != 0)
	{
		$totalrow = getexecutedworkspgtotal($areaname,$exchange,$feeder);
		$rows_page = PAGINATION; //10
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
	}
    $wherecondition = "WHERE 1";
    //if ($areaname != ""){
    $wherecondition .= " AND ew.areaname= '$areaname'";
	// }
	// else{
	// 	return '';
	// }
	//if ($exchange != ""){
	$wherecondition .= " AND ew.exchange= '$exchange'";
	//}
	if ($feeder != ""){
		$wherecondition .= " AND ew.feeder= '$feeder'";
	}
	$orderby = '';
	if($sort_order=='puitemasc'){
	$order_by = ' ORDER BY pu.puitem ASC';    
	}
	else if($sort_order=='puitemdesc'){
	$order_by = ' ORDER BY pu.puitem DESC ';    
	}
	else{
	$order_by = ' ORDER BY ew.id ';  
	}
	
	$sql = "SELECT ew.id , ew.from, ew.to, ew.areaname, ew.exchange, ew.feeder, ew.puitemid, ew.measuredqty, ew.remark, pu.puitem, pu.description, pu.unit, iv.invoiceno FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id LEFT JOIN invoices iv ON ew.invoiceid = iv.id $wherecondition $order_by $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
	$html .= '<tr><td>' . $row["from"] . '</td><td>' . $row["to"] . '</td><td currentid="'.$row["puitemid"].'">' . $row["puitem"] . '</td><td>' . $row["description"] . '</td><td>' . $row["unit"] . '</td><td>' . $row["measuredqty"] . '</td><td>' . $row["remark"] . '</td><td>' . $row["invoiceno"] . '</td>';
	if($current_pgno != 0)
	{
		$html .='<td id="actions">
		<a class="add" title="Add" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		<a class="edit" title="Edit" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		<a class="delete" title="Delete" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
	</td>';
	
	}
	$html .='</tr>';
    }
	return $html;
}

function getexecutedworkspag($current_pgno,$areaname='',$exchange='',$feeder='') {
	$totalrow = getexecutedworkspgtotal($areaname,$exchange,$feeder);
	$rows_page = PAGINATION; //10
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
    if($areaname!='' && $exchange !='')
	{
	if($last != 1){
	
	if ($pagenum > 1) {
	$previous = $pagenum - 1;
	$paginationCtrls .= '<a class="btn btn-default executedworkspag" pagenum="'.$previous.'">Previous</a> &nbsp; &nbsp; ';

	for($i = $pagenum-4; $i < $pagenum; $i++){
		if($i > 0){
			$paginationCtrls .= '<a class="btn btn-default executedworkspag" pagenum="'.$i.'">'.$i.'</a> &nbsp; ';
		}
	}
	}
	
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	
    for($i = $pagenum+1; $i <= $last; $i++)
    {
		$paginationCtrls .= '<a class="btn btn-default executedworkspag" pagenum="'.$i.'">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}

    if ($pagenum != $last) 
    {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a class="btn btn-default executedworkspag" pagenum="'.$next.'">Next</a> ';
    }
	}
	}
	return $paginationCtrls;
}

function insertexecutedworks($data) {
	global $mysqli_conn;
	$sql = "INSERT INTO executedworks (`from`, `to`, puitemid, measuredqty, remark, areaname, exchange, feeder,created_at,lastedited_at) VALUES ('". $data['from'] ."','". $data['to']."','". $data['puitemid']."','". $data['measuredqty']."','". $data['remark']."','". $data['areaname']."','". $data['exchange']."','". $data['feeder']."',now(),now())";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to insert data");
	return mysqli_insert_id($mysqli_conn);
}

function updateexecutedworks($data) {
	global $mysqli_conn;
	// if ($data['invoice'] != ''){
	// 	$sql = "SELECT id FROM invoices WHERE invoiceno = '" .$data['invoice']. "'";
	// 	$result = mysqli_query($mysqli_conn, $sql);
	// 	$result = mysqli_fetch_array($result);
	// 	if ($result['id'] > 0){
	//$sql1 = "UPDATE executedworks SET `from` = '" . $data["from"] . "', `to` = '" . $data["to"] . "', puitemid='" . $data["puitemid"]."', measuredqty='" . $data["measuredqty"] . "', remark='" . $data["remark"] . "', invoiceid='" . $result["id"] . "', areaname = '" . $data["areaname"] . "', exchange = '" . $data["exchange"] . "', feeder = '" . $data["feeder"] . "' WHERE id='".$data["id"]."'";
	// 	}
	// 	else{
	// 		return 'not';
	// 	}
	// }
	// else{
	$sql = "UPDATE executedworks SET `from` = '" . $data["from"] . "', `to` = '" . $data["to"] . "', puitemid='" . $data["puitemid"]."', measuredqty='" . $data["measuredqty"] . "', remark='" . $data["remark"] . "', areaname = '" . $data["areaname"] . "', exchange = '" . $data["exchange"] . "', feeder = '" . $data["feeder"] . "', lastedited_at= now() WHERE id='".$data["id"]."'";
	//}
	$result = mysqli_query($mysqli_conn, $sql);
	return mysqli_insert_id($mysqli_conn);
}	

function deleteexecutedworks($data) {
	global $mysqli_conn;
	$sql = "DELETE FROM executedworks WHERE id='".$data["id"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to delete data");
	return mysqli_insert_id($mysqli_conn);
}

// function checkexecutedworksexists($data){
// 	global $mysqli_conn;
// 	$condition = '';
// 	if (isset($data['id']) && is_numeric($data['id']))
// 	{
// 		$condition = " AND id != '". $data["id"] ."'";
// 	}
// 	$sql = "SELECT * FROM executedworks WHERE exchange = '" . $data["exchange"] . "' AND feeder='" . $data["feeder"]."' AND puitemid = '" . $data["puitemid"] . "' $condition";
// 	$result = mysqli_query($mysqli_conn, $sql);
// 	return mysqli_num_rows($result);
// }

function getexecutedworksareaselect() {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT areaname FROM areas";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['areaname'];
	}
	return $options;
}

function getexecutedworksexchangeselect($areaname) {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT exchange FROM countrydivisions WHERE areaname = '$areaname'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['exchange'];
	}
	return $options;
}

function getexecutedworksfeederselect($exchange) {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT feeder FROM countrydivisions WHERE exchange = '$exchange'  && feeder IS NOT NULL";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['feeder'];
	}
	return $options;
}

function getexecutedworksinvoiceselect($areaname,$exchange,$feeder) {
	global $mysqli_conn;
	$options= array();
	$wherecondition = "WHERE 1 AND invoiceid IS NOT NULL AND invoiceid != '' ";
    if ($areaname != ""){
        $wherecondition .= " AND areaname= '$areaname'";
    }
	if ($exchange != ""){
	$wherecondition .= " AND exchange= '$exchange'";
	}
	if ($feeder != ""){
	$wherecondition .= " AND feeder= '$feeder'";
	}
	$wherecondition .= " AND invoiceid IS NOT NULL";
	$sql = "SELECT DISTINCT invoiceid FROM executedworks $wherecondition";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['invoiceid'];
	}
	return $options;
}

//getinvoicepageexchangelistselect
function getinvoicepageexchangelistselect() {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT CONCAT(areaname,' : ',exchange) AS value, exchange FROM executedworks ORDER BY areaname,exchange";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[$row['exchange']] = $row['value'];
	}
	return $options;
}

function getpuitemidbyname($itemname=''){
    global $mysqli_conn;
	$options= array();
	$sql = "SELECT id FROM puitems WHERE puitem='".$itemname."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	if($result->num_rows > 0){
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['id'];
	}
	else
	{
	    return '';
	    
	}
	
}


?>