<?php
//require("constants.php");

$mysqli_conn=new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(!$mysqli_conn){
	echo mysqli_connect_error()."Check ServerHost,Username,Password Of the DataBase ".mysqli_connect_errorno()."<br/>";
}

//Executed works section

function getsummaryexecutedworkspgtotal($areaname='',$exchange='',$feeder='',$invoice='') {
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
	if ($invoice != ""){
	$wherecondition .= " AND ew.invoiceid= '$invoice'";
	}
	$sql = "SELECT COUNT(ew.id) as total FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id $wherecondition GROUP BY pu.type, pu.puitem";
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

function getsummaryexecutedworkshtml($areaname='',$exchange='',$feeder='',$type="",$invoice='') {
	global $mysqli_conn;
	$limit = ' ';
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
	if ($type != ""){
	$wherecondition .= " AND pu.type= '$type'";
	}
	if ($invoice != ""){
		$wherecondition .= " AND ew.invoiceid= '$invoice'";
	}
	$sql = "SELECT ew.id, ew.from, ew.to, ew.areaname, ew.exchange, ew.feeder, ew.puitemid, sum(ew.measuredqty) as measuredqty, pu.type, pu.puitem, pu.description, pu.unit FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id $wherecondition GROUP BY pu.type, pu.puitem ORDER BY pu.type, pu.puitem $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
    while($row = mysqli_fetch_array($result)){
    $html .= '<tr><td>' . $row["type"] . '</td><td>' . $row["puitem"] . '</td><td>' . $row["description"] . '</td><td>' . $row["unit"] . '</td><td class="righttd">' . $row["measuredqty"] . '</td>
</tr>';
    }
	return $html;
}

function getsummaryexecutedworkspag($current_pgno,$areaname='',$exchange='',$feeder='',$invoice='') {
	$totalrow = getsummaryexecutedworkspgtotal($areaname,$exchange,$feeder,$invoice);
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

function getsummaryexecutedworksexport($areaname='',$exchange='',$feeder='',$type="",$invoice='') {
	global $mysqli_conn;
	$limit = '';
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
	if ($type != ""){
	$wherecondition .= " AND pu.type= '$type'";
	}
	if ($invoice != ""){
		$wherecondition .= " AND ew.invoiceid= '$invoice'";
	}
	$sql = "SELECT ew.id, ew.from, ew.to, ew.areaname, ew.exchange, ew.feeder, ew.puitemid,  sum(ew.measuredqty) as measuredqty, pu.type ,pu.puitem, pu.description, pu.unit FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id $wherecondition GROUP BY pu.type, pu.puitem  ORDER BY pu.type, pu.puitem $limit";
	
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data2");
	$html = "";
	$reportarray = array();
    while($row = mysqli_fetch_array($result)){
	$reportarray[] = array(
						'type'=>$row["type"],
						'puitem'=>$row["puitem"],
						'description'=>$row["description"],
						'unit'=>$row["unit"],
						'measuredqty'=>$row["measuredqty"]
					);
    }
	return $reportarray;
}


//---------------------------------------
// BILL OF QUANTITY REPORT
//---------------------------------------
function getbillofquantityhtml($areaname='',$exchange='',$feeder='',$invoice='') {
	global $mysqli_conn;
	$limit = '';

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
	if ($invoice != ""){
		$wherecondition .= " AND ew.invoiceid= '$invoice'";
	}
	
	$sql = "SELECT ew.id, ew.measuredqty, ew.puitemid, pu.puitem, pu.description, pu.unit, pu.unitprice FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id $wherecondition GROUP BY pu.type, pu.puitem ORDER BY pu.type, pu.puitem  $limit";
	
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
	$subtotalqtybilled = 0;
	$subtotalqtyunbilled = 0;
	$subtotalqtytotal = 0;

	$subtotalvalbilled = 0;
	$subtotalvalunbilled = 0;
	$subtotalvaltotal = 0;
	if($result->num_rows > 0){
    while($row = mysqli_fetch_array($result)){
    //DESIGN
    	$itemdesignqtyrecord = getitemdesignqty($row["puitemid"],$exchange='',$feeder='');
    	$designqty = isset($itemdesignqtyrecord['designqty'])?$itemdesignqtyrecord['designqty']:0;
    	$designtotal = $designqty * $row["unitprice"];

    //EXE QTY
    	$itembilledqtyrecord = getitemexecutedqty($row["puitemid"],$exchange='',$feeder='',"Y",$areaname);
    	$itembilledqty = isset($itembilledqtyrecord['totalqty'])?$itembilledqtyrecord['totalqty']:0;

    	$itemunbilledqtyrecord = getitemexecutedqty($row["puitemid"],$exchange='',$feeder='',"N",$areaname);
    	$itemunbilledqty = isset($itemunbilledqtyrecord['totalqty'])?$itemunbilledqtyrecord['totalqty']:0;

    	$itemexetotal = $itembilledqty + $itemunbilledqty;

   // EXE VAL
    	$itembilledexeval = $itembilledqty * $row["unitprice"];
    	$itemunbilledexeval = $itemunbilledqty * $row["unitprice"];
    	$itemtotalexeval = $itembilledexeval + $itemunbilledexeval;

    	// Subtotals
	$subtotalqtybilled += $itembilledqty;
	$subtotalqtyunbilled += $itemunbilledqty;
	$subtotalqtytotal += $itemexetotal;

	$subtotalvalbilled += $itembilledexeval;
	$subtotalvalunbilled += $itemunbilledexeval;
	$subtotalvaltotal += $itemtotalexeval;


    $html .= '<tr><td>' . $row["puitem"] . '</td><td>' . $row["description"] . '</td><td class="text-center">' . $row["unit"] . '</td><td class="righttd">' . number_format($row["unitprice"],3) . '</td><td class="righttd">' . number_format($designqty,3) . '</td><td class="righttd">' . number_format($designtotal,3) . '</td><td class="righttd">' . number_format($itembilledqty,3) . '</td><td class="righttd">' . number_format($itemunbilledqty,3) . '</td><td class="righttd">' . number_format($itemexetotal,3) . '</td><td class="righttd">' . number_format($itembilledexeval,3) . '</td><td class="righttd">' . number_format($itemunbilledexeval,3) . '</td><td class="righttd">' . number_format($itemtotalexeval,3) . '</td>
</tr>';


    }
  //  $html .= '<tr><td colspan="5"></td><td class="tdcellbold righttd">Total</td><td class="tdcellbold righttd">' . number_format($subtotalqtybilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalqtyunbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalqtytotal,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalvalbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalvalunbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalvaltotal,3) . '</td></tr>';
  
    $html .= '<tr><td colspan="8"></td><td class="tdcellbold righttd">Total</td><td class="tdcellbold righttd">' . number_format($subtotalvalbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalvalunbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalvaltotal,3) . '</td>
</tr>';
}
else
{

    $html .= '<tr><td colspan="12">No Items Found</td></tr>';

}

	return $html;
}

function getbillofquantityexport($areaname='',$exchange='',$feeder='',$invoice='') {
	global $mysqli_conn;
	$limit = '';

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
	if ($invoice != ""){
		$wherecondition .= " AND ew.invoiceid= '$invoice'";
	}
	
	$sql = "SELECT ew.id, ew.measuredqty, ew.puitemid, pu.puitem, pu.description, pu.unit, pu.unitprice FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id $wherecondition GROUP BY pu.type, pu.puitem ORDER BY pu.type, pu.puitem $limit";
	
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	$html = "";
	$subtotalqtybilled = 0;
	$subtotalqtyunbilled = 0;
	$subtotalqtytotal = 0;

	$subtotalvalbilled = 0;
	$subtotalvalunbilled = 0;
	$subtotalvaltotal = 0;

	$reportitemarray = array();
	$reportitemfooterarray = array();


	if($result->num_rows > 0){
    while($row = mysqli_fetch_array($result)){
    //DESIGN
    	$itemdesignqtyrecord = getitemdesignqty($row["puitemid"],$exchange='',$feeder='');
    	$designqty = isset($itemdesignqtyrecord['designqty'])?$itemdesignqtyrecord['designqty']:0;
    	$designtotal = $designqty * $row["unitprice"];

    //EXE QTY
    	$itembilledqtyrecord = getitemexecutedqty($row["puitemid"],$exchange='',$feeder='',"Y");
    	$itembilledqty = isset($itembilledqtyrecord['totalqty'])?$itembilledqtyrecord['totalqty']:0;

    	$itemunbilledqtyrecord = getitemexecutedqty($row["puitemid"],$exchange='',$feeder='',"N");
    	$itemunbilledqty = isset($itemunbilledqtyrecord['totalqty'])?$itemunbilledqtyrecord['totalqty']:0;

    	$itemexetotal = $itembilledqty + $itemunbilledqty;

   // EXE VAL
    	$itembilledexeval = $itembilledqty * $row["unitprice"];
    	$itemunbilledexeval = $itemunbilledqty * $row["unitprice"];
    	$itemtotalexeval = $itembilledexeval + $itemunbilledexeval;

    	// Subtotals
	$subtotalqtybilled += $itembilledqty;
	$subtotalqtyunbilled += $itemunbilledqty;
	$subtotalqtytotal += $itemexetotal;

	$subtotalvalbilled += $itembilledexeval;
	$subtotalvalunbilled += $itemunbilledexeval;
	$subtotalvaltotal += $itemtotalexeval;

    $reportitemarray[] = array(
    							'item' => $row["puitem"],
    							'description' => $row["description"],
    							'unit' => $row["unit"],
    							'unitprice' => number_format($row["unitprice"],3),
    							'designqty' => $designqty,
    							'designtotal' => number_format($designtotal,3),
    							'itembillqty' => number_format($itembilledqty,3),
    							'itemunbillqty' => number_format($itemunbilledqty,3),
    							'itemqtytotal' => number_format($itemexetotal,3),
    							'itembillexe' => number_format($itembilledexeval,3),
    							'itemunbillexe' => number_format($itemunbilledexeval,3),
    							'itemexetotal' => number_format($itemtotalexeval,3)
    							);

    }

    $reportitemfooterarray = array(
    							'itembillqty' => $subtotalqtybilled,
    							'itemunbillqty' => number_format($subtotalqtyunbilled,3),
    							'itemqtytotal' => number_format($subtotalqtytotal,3),
    							'itembillexe' => number_format($subtotalvalbilled,3),
    							'itemunbillexe' => number_format($subtotalvalunbilled,3),
    							'itemexetotal' =>  number_format($subtotalvaltotal,3) 
    							);
}

	$resultarray['itemrow'] =  $reportitemarray;
	$resultarray['totalrow'] =  $reportitemfooterarray;
	return $resultarray;
}


function getbillofquantityinvoicetotal($areaname='',$exchange='',$feeder='',$invoice='') {
	global $mysqli_conn;
	$totalrow = getsummaryexecutedworkspgtotal($areaname,$exchange,$feeder,$invoice);
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
	$limit = "";//'LIMIT ' .($pagenum - 1) * $rows_page .',' .$rows_page;

    $wherecondition = "WHERE 1 AND (ew.invoiceid='' OR ew.invoiceid IS NULL)  ";
 //    if ($areaname != ""){
 //        $wherecondition .= " AND ew.areaname= '$areaname'";
 //    }
	// if ($exchange != ""){
	// $wherecondition .= " AND ew.exchange= '$exchange'";
	// }
	// if ($feeder != ""){
	// $wherecondition .= " AND ew.feeder= '$feeder'";
	// }
	
	$sql = "SELECT ew.id, ew.measuredqty, ew.puitemid, pu.puitem, pu.description, pu.unit, pu.unitprice FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id $wherecondition  GROUP BY pu.type, pu.puitem ORDER BY pu.type, pu.puitem  $limit";
	//echo $sql; echo "<br/><br/>";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	
	return $result->num_rows;
}

function getbillofquantitytotal($areaname='',$exchange='',$feeder='',$invoice='') {
	global $mysqli_conn;
	$totalrow = getsummaryexecutedworkspgtotal($areaname,$exchange,$feeder,$invoice='');
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
	$limit = "";//'LIMIT ' .($pagenum - 1) * $rows_page .',' .$rows_page;

    $wherecondition = "WHERE 1 ";
    if ($areaname != ""){
        $wherecondition .= " AND ew.areaname= '$areaname'";
    }
	if ($exchange != ""){
	$wherecondition .= " AND ew.exchange= '$exchange'";
	}
	if ($feeder != ""){
	$wherecondition .= " AND ew.feeder= '$feeder'";
	}
	if ($invoice != ""){
		$wherecondition .= " AND ew.invoiceid= '$invoice'";
	}
	
	$sql = "SELECT ew.id, ew.measuredqty, ew.puitemid, pu.puitem, pu.description, pu.unit, pu.unitprice FROM executedworks ew INNER JOIN puitems pu ON ew.puitemid = pu.id $wherecondition GROUP BY pu.type, pu.puitem ORDER BY pu.type, pu.puitem  $limit";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	
	return $result->num_rows;
}

function generateinvoices($areaname='',$exchange='',$feeder='',$invoiceid,$invoicedate) {		
	global $mysqli_conn;
	if(!empty($invoiceid) && !empty($invoicedate)){
	$sql = "INSERT INTO invoices (invoiceno,invoicedate,created_at) VALUES('".$invoiceid."','".$invoicedate."',now())";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to insert data");
	$returninvoiceid =  mysqli_insert_id($mysqli_conn);

	if($returninvoiceid){
    $wherecondition = "WHERE 1 AND invoiceid != '' AND invoiceid IS NOT NULL  ";
 //    if ($areaname != ""){
 //        $wherecondition .= " AND areaname= '$areaname'";
 //    }
	// if ($exchange != ""){
	// $wherecondition .= " AND exchange= '$exchange'";
	// }
	// if ($feeder != ""){
	// $wherecondition .= " AND feeder= '$feeder'";
	// }
	$sql = "UPDATE executedworks SET invoiceid = '" . $returninvoiceid . "' $wherecondition ";
	//echo $sql;exit;
	$result = mysqli_query($mysqli_conn, $sql) or die("error to update data");
	}

	}

}


function getitemdesignqty($itemid,$exchange='',$feeder=''){	

	global $mysqli_conn;

    $wherecondition = "WHERE 1";
    if ($itemid != ""){
        $wherecondition .= " AND puitemid= '$itemid'";
    }
	if ($exchange != ""){
	$wherecondition .= " AND exchange= '$exchange'";
	}
	if ($feeder != ""){
	$wherecondition .= " AND feeder= '$feeder'";
	}

	$sql = "SELECT puitemid, designqty FROM designquantity $wherecondition";
	$row = array();
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data1");
	if($result->num_rows > 0){
	$row = mysqli_fetch_array($result);
	}

	return $row;
	
}

function getitemexecutedqty($itemid,$exchange='',$feeder='',$billed='',$area =''){	

	global $mysqli_conn;

    $wherecondition = "WHERE 1";
    if ($itemid != ""){
        $wherecondition .= " AND puitemid= '$itemid'";
    }
    if ($area != ""){
	$wherecondition .= " AND areaname = '$area'";
	}
	if ($exchange != ""){
	$wherecondition .= " AND exchange= '$exchange'";
	}
	if ($feeder != ""){
	$wherecondition .= " AND feeder= '$feeder'";
	}

	if ($billed == "Y"){
    $wherecondition .= " AND invoiceid != '' AND invoiceid IS NOT NULL AND invoiceid != 0 ";
	}
	else if($billed == "N"){		
    $wherecondition .= " AND (invoiceid = '' OR invoiceid IS NULL OR invoiceid = 0)  ";
	}

	$sql = "SELECT SUM(measuredqty) AS totalqty FROM executedworks $wherecondition";
	//echo $sql; exit;
	$row = array();
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data2");
	if($result->num_rows > 0){
	$row = mysqli_fetch_array($result);
	}

	return $row;
	
}

//-----------------------------------------------------
// EXCHANGE SUMMARY SHEET
//-----------------------------------------------------

function getexchangesummaryhtml($areaname='',$exchange='',$feeder='', $invoice='') {
	global $mysqli_conn;
	$limit = '';
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
	if ($invoice != ""){
	$wherecondition .= " AND ew.invoiceid= '$invoice'";
	}
		
	$sql = "SELECT DISTINCT ew.areaname, ew.exchange FROM executedworks ew $wherecondition ORDER BY ew.areaname, ew.exchange  $limit";

	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");

	$html = "";
	$subtotalcivildesignvalue = 0;
	$subtotalcivilexecbilled = 0;
	$subtotalcivilexecunbilled = 0;
	$subtotalcivilexetotal = 0;

	$subtotalcabledesignvalue = 0;
	$subtotalcableexecbilled = 0;
	$subtotalcableexecunbilled = 0;
	$subtotalcableexetotal = 0;

	$subtotalmiddesignvalue = 0;
	$subtotalmidexecbilled = 0;
	$subtotalmidexecunbilled = 0;
	$subtotalmidexetotal = 0;

	if($result->num_rows > 0){
    while($row = mysqli_fetch_array($result)){

	$civildesignvalue =  getexchangesummarydata($row["areaname"],$row["exchange"],'designvalue','1');
	$civilexecbilled =  getexchangesummarydata($row["areaname"],$row["exchange"],'billed','1');
	$civilexecunbilled =  getexchangesummarydata($row["areaname"],$row["exchange"],'unbilled','1');
	$civilexetotal =  getexchangesummarydata($row["areaname"],$row["exchange"],'total','1');

	$cabledesignvalue = getexchangesummarydata($row["areaname"],$row["exchange"],'designvalue','2');
	$cableexecbilled =  getexchangesummarydata($row["areaname"],$row["exchange"],'billed','2');
	$cableexecunbilled =  getexchangesummarydata($row["areaname"],$row["exchange"],'unbilled','2');
	$cableexetotal =  getexchangesummarydata($row["areaname"],$row["exchange"],'total','2');

	$totaldesignvalue = $civildesignvalue + $cabledesignvalue;
	$totalexecbilled = $civilexecbilled + $cableexecbilled;
	$totalexecunbilled = $civilexecunbilled + $cableexecunbilled;
	$totalexetotal = $civilexetotal + $cableexetotal;

	$subtotalcivildesignvalue += $civildesignvalue;
	$subtotalcivilexecbilled += $civilexecbilled;
	$subtotalcivilexecunbilled += $civilexecunbilled;
	$subtotalcivilexetotal += $civilexetotal;

	$subtotalcabledesignvalue += $cabledesignvalue;
	$subtotalcableexecbilled += $cableexecbilled;
	$subtotalcableexecunbilled += $cableexecunbilled;
	$subtotalcableexetotal += $cableexetotal;


	$subtotalmiddesignvalue += $totaldesignvalue;
	$subtotalmidexecbilled += $totalexecbilled;
	$subtotalmidexecunbilled += $totalexecunbilled;
	$subtotalmidexetotal += $totalexetotal;


    $html .= '<tr><td>' . $row["exchange"] . '</td><td class="righttd">' . number_format($civildesignvalue,3) . '</td><td class="righttd">' . number_format($civilexecbilled,3) . '</td><td class="righttd">' . number_format($civilexecunbilled,3) . '</td><td class="righttd">' . number_format($civilexetotal,3) . '</td><td class="righttd">' . number_format($cabledesignvalue,3) . '</td><td class="righttd">' . number_format($cableexecbilled,3) . '</td><td class="righttd">' . number_format($cableexecunbilled,3) . '</td><td class="righttd">' . number_format($cableexetotal,3) . '</td><td class="righttd">' . number_format($totaldesignvalue,3) . '</td><td class="righttd">' . number_format($totalexecbilled,3) . '</td><td class="righttd">' . number_format($totalexecunbilled,3) . '</td><td class="righttd">' . number_format($totalexetotal,3) . '</td>
</tr>';


    }
    $html .= '<tr><td class="tdcellbold righttd">Total</td><td class="tdcellbold righttd">' . number_format($subtotalcivildesignvalue,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalcivilexecbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalcivilexecunbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalcivilexetotal,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalcabledesignvalue,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalcableexecbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalcableexecunbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalcableexetotal,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalmiddesignvalue,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalmidexecbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalmidexecunbilled,3) . '</td><td class="tdcellbold righttd">' . number_format($subtotalmidexetotal,3) . '</td>
</tr>';
}
else
{

    $html .= '<tr><td colspan="13">No Items Found</td></tr>';

}

	return $html;
}

function getexchangesummarytotal($areaname='',$exchange='',$feeder='',$invoice='') {
	global $mysqli_conn;

	$limit = "";//'LIMIT ' .($pagenum - 1) * $rows_page .',' .$rows_page;

    $wherecondition = "WHERE 1 ";
    if ($areaname != ""){
        $wherecondition .= " AND ew.areaname= '$areaname'";
    }
	if ($exchange != ""){
	$wherecondition .= " AND ew.exchange= '$exchange'";
	}
	if ($feeder != ""){
	$wherecondition .= " AND ew.feeder= '$feeder'";
	}

	if ($invoice != ""){
	$wherecondition .= " AND ew.invoiceid= '$invoice'";
	}
	
	$sql = "SELECT DISTINCT ew.areaname, ew.exchange FROM executedworks ew $wherecondition ORDER BY ew.areaname, ew.exchange  $limit";
	
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	
	return $result->num_rows;
}



function getexchangesummarydata($areaname='', $exchange='', $getdata='', $type=''){	

	global $mysqli_conn;

    $wherecondition = "WHERE 1";
	if ($exchange != ""){
	$wherecondition .= " AND ew.exchange= '$exchange'";
	}
	if ($areaname != ""){
	$wherecondition .= " AND ew.areaname= '$areaname'";
	}

	if($type != ''){
	$wherecondition .= " AND pu.type= '$type'";
	}

	$select = '';
	$returnval = '';
	if($getdata == 'designvalue'){
	$select = ' SUM(dq.designqty * pu.unitprice) AS designvalue ';
	$returnval = 'designvalue';
	}
	else if($getdata == 'billed'){
	$select = ' SUM(ew.measuredqty * pu.unitprice) AS billedvalue ';
	$wherecondition .= " AND (ew.invoiceid != '' AND ew.invoiceid IS NOT NULL) ";
	$returnval = 'billedvalue';
	}
	else if($getdata == 'unbilled'){
	$select = ' SUM(ew.measuredqty * pu.unitprice) AS ubilledvalue ';
	$wherecondition .= " AND (ew.invoiceid = '' OR ew.invoiceid IS NULL) ";
	$returnval = 'ubilledvalue';
	}
	else if($getdata == 'total'){
	$select = ' SUM(ew.measuredqty * pu.unitprice) AS totalvalue ';
	$returnval = 'totalvalue';
	}

	$sql = "SELECT $select  FROM `executedworks` ew 
			LEFT JOIN designquantity dq ON (dq.puitemid = ew.puitemid AND dq.exchange = ew.exchange) 
			LEFT JOIN puitems pu ON pu.id = ew.puitemid   $wherecondition";

	$row = array();
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data1");
	if($result->num_rows > 0){
	$row = mysqli_fetch_array($result);
	}

	return isset($row[$returnval])?$row[$returnval]:0;	
}

function getexchangesummaryexport($areaname='',$exchange='',$feeder='',$invoice='') {
	global $mysqli_conn;
	$limit = '';
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
	if ($invoice != ""){
	$wherecondition .= " AND ew.invoiceid= '$invoice'";
	}
		
	$sql = "SELECT DISTINCT ew.areaname, ew.exchange FROM executedworks ew $wherecondition ORDER BY ew.areaname, ew.exchange  $limit";

	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");

	$returndatalooparray = array();
	$returnfooterarray = array();
	$subtotalcivildesignvalue = 0;
	$subtotalcivilexecbilled = 0;
	$subtotalcivilexecunbilled = 0;
	$subtotalcivilexetotal = 0;

	$subtotalcabledesignvalue = 0;
	$subtotalcableexecbilled = 0;
	$subtotalcableexecunbilled = 0;
	$subtotalcableexetotal = 0;

	$subtotalmiddesignvalue = 0;
	$subtotalmidexecbilled = 0;
	$subtotalmidexecunbilled = 0;
	$subtotalmidexetotal = 0;

	if($result->num_rows > 0){
    while($row = mysqli_fetch_array($result)){

	$civildesignvalue =  getexchangesummarydata($row["areaname"],$row["exchange"],'designvalue','1');
	$civilexecbilled =  getexchangesummarydata($row["areaname"],$row["exchange"],'billed','1');
	$civilexecunbilled =  getexchangesummarydata($row["areaname"],$row["exchange"],'unbilled','1');
	$civilexetotal =  getexchangesummarydata($row["areaname"],$row["exchange"],'total','1');

	$cabledesignvalue = getexchangesummarydata($row["areaname"],$row["exchange"],'designvalue','2');
	$cableexecbilled =  getexchangesummarydata($row["areaname"],$row["exchange"],'billed','2');
	$cableexecunbilled =  getexchangesummarydata($row["areaname"],$row["exchange"],'unbilled','2');
	$cableexetotal =  getexchangesummarydata($row["areaname"],$row["exchange"],'total','2');

	$totaldesignvalue = $civildesignvalue + $cabledesignvalue;
	$totalexecbilled = $civilexecbilled + $cableexecbilled;
	$totalexecunbilled = $civilexecunbilled + $civilexecunbilled;
	$totalexetotal = $civilexetotal + $cableexetotal;

	$subtotalcivildesignvalue += $civildesignvalue;
	$subtotalcivilexecbilled += $civilexecbilled;
	$subtotalcivilexecunbilled += $civilexecunbilled;
	$subtotalcivilexetotal += $civilexetotal;

	$subtotalcabledesignvalue += $cabledesignvalue;
	$subtotalcableexecbilled += $cableexecbilled;
	$subtotalcableexecunbilled += $cableexecunbilled;
	$subtotalcableexetotal += $cableexetotal;


	$subtotalmiddesignvalue += $totaldesignvalue;
	$subtotalmidexecbilled += $totalexecbilled;
	$subtotalmidexecunbilled += $totalexecunbilled;
	$subtotalmidexetotal += $totalexetotal;


	$returndatalooparray[] = array( 'exchange' => $row["exchange"],
									'civildesignvalue' => number_format($civildesignvalue,3),
									'civilexecbilled' => number_format($civilexecbilled,3),
									'civilexecunbilled' => number_format($civilexecunbilled,3),
									'civilexetotal' =>number_format($civilexetotal,3),
									'cabledesignvalue' => number_format($civilexetotal,3),
									'cableexecbilled' => number_format($cableexecbilled,3),
									'cableexecunbilled' => number_format($cableexecunbilled,3),
									'cableexetotal' => number_format($cableexetotal,3),
									'totaldesignvalue' => number_format($totaldesignvalue,3),
									'totalexecbilled' => number_format($totalexecbilled,3),
									'totalexecunbilled' => number_format($totalexecunbilled,3),
									'totalexetotal' => number_format($totalexetotal,3)
									 );


    }
   
	$returnfooterarray = array(
									'subtotalcivildesignvalue' => number_format($subtotalcivildesignvalue,3),
									'subtotalcivilexecbilled' => number_format($subtotalcivilexecbilled,3),
									'subtotalcivilexecunbilled' => number_format($subtotalcivilexecunbilled,3),
									'subtotalcivilexetotal' =>number_format($subtotalcivilexetotal,3),
									'subtotalcabledesignvalue' => number_format($subtotalcabledesignvalue,3),
									'subtotalcableexecbilled' => number_format($subtotalcableexecbilled,3),
									'subtotalcableexecunbilled' => number_format($subtotalcableexecunbilled,3),
									'subtotalcableexetotal' => number_format($subtotalcableexetotal,3),
									'subtotalmiddesignvalue' => number_format($subtotalmiddesignvalue,3),
									'subtotalmidexecbilled' => number_format($subtotalmidexecbilled,3),
									'subtotalmidexecunbilled' => number_format($subtotalmidexecunbilled,3),
									'subtotalmidexetotal' => number_format($subtotalmidexetotal,3)
									 );
}
	$resultarray['itemrow'] =  $returndatalooparray;
	$resultarray['totalrow'] =  $returnfooterarray;
	return $resultarray;
}

function getallinvoicetotal() {
	global $mysqli_conn;
	$wherecondition = "";
	$sql = "SELECT COUNT(*) as total FROM invoices $wherecondition";
	//echo $sql; exit;
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

function getallinvoices($pageno) {
	global $mysqli_conn;
	$wherecondition = "";
	$sql = "SELECT invoiceno,invoicedate FROM invoices $wherecondition";
	$result = mysqli_query($mysqli_conn, $sql);
	$html = '';
    while($row = mysqli_fetch_array($result)){
    $html .= '<tr><td>' . $row["invoiceno"] . '</td><td>' . $row["invoicedate"] . '</td></tr>';
    }
	return $html;
}

function generateinvoiceid($invoiceid='',$invoicedate='',$cabletype='',$exchange='') {
	global $mysqli_conn;
	if(!empty($invoiceid) && !empty($invoicedate)){
	$sql = "INSERT INTO invoices (invoiceno,invoicedate,created_at) VALUES('".$invoiceid."','".$invoicedate."',now())";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to insert data");
	$returninvoiceid =  mysqli_insert_id($mysqli_conn);

	if($returninvoiceid){
    $wherecondition = "WHERE 1 AND (ew.invoiceid = '' OR ew.invoiceid IS NULL OR ew.invoiceid = 0)  ";
 //    if ($areaname != ""){
 //        $wherecondition .= " AND areaname= '$areaname'";
 //    }
	 if (!empty($exchange)){
	 $wherecondition .= " AND ew.exchange IN (\"".implode('","', $exchange)."\")";
	 }
	if ($cabletype != ""){
	$wherecondition .= " AND pu.type= '$cabletype'";
	}
	// if ($feeder != ""){
	// $wherecondition .= " AND feeder= '$feeder'";
	// }
	$sql = "UPDATE executedworks ew INNER JOIN puitems pu ON pu.id=ew.puitemid SET invoiceid = '" . $returninvoiceid . "' $wherecondition ";
	$result = mysqli_query($mysqli_conn, $sql) or die("error to update data");
	}

	}

}

function needtocreateinvoicetotal($cabletype='',$exchange='') {
	global $mysqli_conn;

	$limit = "";

   
    $wherecondition = "WHERE 1 AND (ew.invoiceid = '' OR ew.invoiceid IS NULL OR ew.invoiceid = 0)  ";

	 if (!empty($exchange)){
	 $wherecondition .= " AND ew.exchange IN (\"".implode('","', $exchange)."\")";
	 }
	if ($cabletype != ""){
	$wherecondition .= " AND pu.type= '$cabletype'";
	}
	
	$sql = "SELECT * FROM executedworks ew INNER JOIN puitems pu ON pu.id=ew.puitemid  $wherecondition";
//echo $sql; exit;
	$result = mysqli_query($mysqli_conn, $sql) or die("error to display data");
	
	return $result->num_rows;
}

function checkinvoiceidexist($invoiceid) {
	global $mysqli_conn;
	$wherecondition = " WHERE invoiceno = '".$invoiceid."'";
	$sql = "SELECT COUNT(*) as total FROM invoices $wherecondition";
	$result = mysqli_query($mysqli_conn, $sql);
	$totalrow = mysqli_fetch_array($result);
	return $totalrow['total'];
}

?>