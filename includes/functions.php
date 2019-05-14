<?php
require("constants.php");

$mysqli_conn=new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(!$mysqli_conn){
	echo mysqli_connect_error()."Check ServerHost,Username,Password Of the DataBase ".mysqli_connect_errorno()."<br/>";
}

//Country Division Section
function getcountrydivisionspgtotal($areaname='',$exchange='') {
	global $mysqli_conn;
	$wherecondition = "WHERE 1";
	if ($areaname != ""){
        $wherecondition .= " AND areaname= '$areaname'";
    }
    if ($exchange != ""){
	$wherecondition .= " AND exchange= '$exchange'";
	}
	$sql = "SELECT COUNT(id) AS total FROM countrydivisions $wherecondition";
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

function getcountrydivisionshtml($current_pgno,$areaname='',$exchange='') {
	global $mysqli_conn;
	$totalrow = getcountrydivisionspgtotal();
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
	if ($areaname != ""){
        $wherecondition .= " AND areaname= '$areaname'";
    }
    if ($exchange != ""){
	$wherecondition .= " AND exchange= '$exchange'";
	}
	$sql = "SELECT * FROM countrydivisions $wherecondition $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
    $html .= '<tr><td>' . $row["feeder"] . '</td><td>
    <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
    <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
    <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
</td>
</tr>';
    }
	return $html;
}

function getcountrydivisionspag($current_pgno,$areaname='',$exchange='') {
	$totalrow = getcountrydivisionspgtotal($areaname='',$exchange='');
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

// function getareanamesselect($areaname) {
// 	global $mysqli_conn;
// 	$sql = "SELECT Areaname as areaname FROM areas";
// 	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
// 	$html = "<select class='form-control' name='areaname'>";
//     while($row = mysqli_fetch_array($result)){
// 	if($areaname == $row['areaname']){
// 	$html .= "<option value='" . $row['areaname'] . "' selected >" . $row['areaname'] . "</option>";
// 	}
// 	else{
// 	$html .= "<option value='" . $row['areaname'] . "'>" . $row['areaname'] . "</option>";
// 	}
// 	}
// 	$html .= "</select>";
// 	return $html;
// }

function countrydivisionareaselect() {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT areaname FROM countrydivisions";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['areaname'];
	}
	return $options;
}

function countrydivisionexchangeselect($areaname) {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT exchange FROM countrydivisions WHERE areaname = '$areaname'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['exchange'];
	}
	return $options;
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
	$name = array("each", "m", "km", "sqm", "cbm");
	$html = "<select class='form-control' name='units'>";
    foreach($name as $row){
	$html .= "<option value='" . $row . "' selected >" . $row . "</option>";
	}
	$html .= "</select>";
	return $html;
}

//Design quantity Section

function getdesignquantitypgtotal($exchange='',$feeder='') {
	global $mysqli_conn;
	$wherecondition = "WHERE 1";
	if ($exchange != ""){
	$wherecondition .= " AND dq.exchange= '$exchange'";
	}
	if ($feeder != ""){
	$wherecondition .= " AND dq.feeder= '$feeder'";
	}
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
	if ($exchange != ""){
	$wherecondition .= " AND dq.exchange= '$exchange'";
	}
	if ($feeder != ""){
	$wherecondition .= " AND dq.feeder= '$feeder'";
	}
	
	$sql = "SELECT dq.id, dq.exchange, dq.feeder, dq.puitemid, dq.designqty, pu.puitem, pu.description, pu.unit FROM designquantity dq INNER JOIN puitems pu ON dq.puitemid = pu.id $wherecondition $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
    $html .= '<tr><td>' . $row["puitem"] . '</td><td>' . $row["description"] . '</td><td>' . $row["unit"] . '</td><td>' . $row["designqty"] . '</td><td>
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

function getfeederselect($exchange) {
	global $mysqli_conn;
	$options= array();
	$sql = "SELECT DISTINCT feeder FROM countrydivisions WHERE exchange = '$exchange'";
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
	$sql = "SELECT COUNT(ew.id) as total FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id $wherecondition";
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

function getexecutedworkshtml($current_pgno,$areaname='',$exchange='',$feeder='') {
	global $mysqli_conn;
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
	
	$sql = "SELECT ew.id, ew.from, ew.to, ew.areaname, ew.exchange, ew.feeder, ew.puitemid, ew.measuredqty, ew.remark, pu.puitem, pu.description, pu.unit FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id $wherecondition $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
    $html .= '<tr><td>' . $row["from"] . '</td><td>' . $row["to"] . '</td><td>' . $row["puitem"] . '</td><td>' . $row["description"] . '</td><td>' . $row["unit"] . '</td><td>' . $row["measuredqty"] . '</td><td>' . $row["remark"] . '</td><td>
    <a class="add" title="Add" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
    <a class="edit" title="Edit" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
    <a class="delete" title="Delete" itemid="' . $row["id"] . '" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
</td>
</tr>';
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
	return $paginationCtrls;
}

function insertexecutedworks($data) {
	global $mysqli_conn;
	$sql = "INSERT INTO executedworks (`from`, `to`, puitemid, measuredqty, remark, areaname, exchange, feeder) VALUES ('". $data['from'] ."','". $data['to']."','". $data['puitemid']."','". $data['measuredqty']."','". $data['remark']."','". $data['areaname']."','". $data['exchange']."','". $data['feeder']."')";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to insert data");
	return mysqli_insert_id($mysqli_conn);
}

function updateexecutedworks($data) {
	global $mysqli_conn;
	$sql = "UPDATE executedworks SET `from` = '" . $data["from"] . "', `to` = '" . $data["to"] . "', puitemid='" . $data["puitemid"]."', measuredqty='" . $data["measuredqty"] . "', remark='" . $data["remark"] . "', areaname = '" . $data["areaname"] . "', exchange = '" . $data["exchange"] . "', feeder = '" . $data["feeder"] . "' WHERE id='".$data["id"]."'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to update data");
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
	$sql = "SELECT DISTINCT areaname FROM countrydivisions";
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
	$sql = "SELECT DISTINCT feeder FROM countrydivisions WHERE exchange = '$exchange'";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	while($row = mysqli_fetch_array($result)){
	$options[] = $row['feeder'];
	}
	return $options;
}
?>