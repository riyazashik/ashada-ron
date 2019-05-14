<?php
require("constants.php");

$mysqli_conn=new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(!$mysqli_conn){
	echo mysqli_connect_error()."Check ServerHost,Username,Password Of the DataBase ".mysqli_connect_errorno()."<br/>";
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
?>