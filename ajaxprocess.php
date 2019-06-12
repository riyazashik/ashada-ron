<?php
include_once("includes/functions.php");
$calltype = $_POST['calltype'];
$result = array();
//Exchange Division Section

if ($calltype == 'exchangedivisionlist'){
    $total=getexchangedivisionspgtotal($_POST['areaname']);
    $html=getexchangedivisionshtml($_POST['pageno'],$_POST['areaname']);
    $pagination=getexchangedivisionspag($_POST['pageno'],$_POST['areaname']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    echo json_encode($result);
}

else if ($calltype == 'exchangedivisionadd'){
    if (checkexchangedivisionexists($_POST) == 0)
    {
    $sql = insertexchangedivisions($_POST);
    $html=getexchangedivisionshtml(1,$_POST['areaname']);
    $pagination=getexchangedivisionspag(1,$_POST['areaname']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully added';
    }
    else
    {
        $result['errormsg'] = 'Exchange should be unique';
        $result['status'] = 0;
    }
    echo json_encode($result);
}

else if ($calltype == 'exchangedivisionedit'){
    if (checkexchangedivisionexists($_POST) == 0)
    {
    $sql = updateexchangedivisions($_POST);
    $html=getexchangedivisionshtml(1,$_POST['areaname']);
    $pagination=getexchangedivisionspag(1,$_POST['areaname']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Updated';
    }
    else
    {
        $result['errormsg'] = 'Exchange should be unique';
        $result['status'] = 0;
    }
    echo json_encode($result);
}

else if ($calltype == 'exchangedivisiondlt'){
    $sql = deleteexchangedivisions($_POST);
    $html=getexchangedivisionshtml(1,$_POST['areaname']);
    $pagination=getexchangedivisionspag(1,$_POST['areaname']);
    if ($sql != 0){
    $result['status'] = '0';
    $result['errormsg'] = 'Exchange mapped in the Executed works could not be deleted';
    }
    else{
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Deleted';
    }
    echo json_encode($result);
}

else if ($calltype == 'exchangearealist'){
    $html=exchangedivisionareaselect();
    $options = "<option value=''>Select Area</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

//Feeder Division Section

if ($calltype == 'feederdivisionlist'){
    $total=getfeederdivisionspgtotal($_POST['areaname'],$_POST['exchange']);$html=getfeederdivisionshtml($_POST['pageno'],$_POST['areaname'],$_POST['exchange']);
    $pagination=getfeederdivisionspag($_POST['pageno'],$_POST['areaname'],$_POST['exchange']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    echo json_encode($result);
}

else if ($calltype == 'feederdivisionadd'){
    if (checkfeederdivisionexists($_POST) == 0)
    {
    $sql = insertfeederdivisions($_POST);
    $html=getfeederdivisionshtml(1,$_POST['areaname'],$_POST['exchange']);
    $pagination=getfeederdivisionspag(1,$_POST['areaname'],$_POST['exchange']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully added';
    }
    else
    {
        $result['errormsg'] = 'Feeders should be unique';
        $result['status'] = 0;
    }
    echo json_encode($result);
}

else if ($calltype == 'feederdivisionedit'){
    if (checkfeederdivisionexists($_POST) == 0)
    {
    $sql = updatefeederdivisions($_POST);
    $html=getfeederdivisionshtml(1,$_POST['areaname'],$_POST['exchange']);
    $pagination=getfeederdivisionspag(1,$_POST['areaname'],$_POST['exchange']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Updated';
    }
    else
    {
        $result['errormsg'] = 'Feeders should be unique';
        $result['status'] = 0;
    }
    echo json_encode($result);
}

else if ($calltype == 'feederdivisiondlt'){
    $sql = deletefeederdivisions($_POST);
    $html=getfeederdivisionshtml(1,$_POST['areaname'],$_POST['exchange'],$_POST['feeder']);
    $pagination=getfeederdivisionspag(1,$_POST['areaname'],$_POST['exchange'],$_POST['feeder']);
    if ($sql != 0){
        $result['status'] = '0';
        $result['errormsg'] = 'Feeder mapped in the Executed works could not be deleted';
    }
    else{
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Deleted';
    }
    echo json_encode($result);
}

else if ($calltype == 'feederdivisionarealist'){
    $html=feederdivisionareaselect();
    $options = "<option value=''>Select Area</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'feederdivisionexchangelist'){
    $html=feederdivisionexchangeselect($_POST['areaname']);
    $options = "<option value=''>Select Exchange</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'feederdivisionfeederlist'){
    $html=feederdivisionfeederselect($_POST['exchange']);
    echo json_encode($html);
}


//PUI Items Section

if ($calltype == 'puitemslist'){
    $html=getpuitemshtml($_POST['pageno']);
    $pagination=getpuitemspag($_POST['pageno']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    echo json_encode($result);
}

else if ($calltype == 'puitemsadd'){
    if (checkpuitemsexists($_POST) == 0)
    {
    $sql = insertpuitems($_POST);
    $html=getpuitemshtml(1);
    $pagination=getpuitemspag(1);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully added';
    }
    else
    {
        $result['errormsg'] = 'Combination of Type and PU item should be unique';
        $result['status'] = 0;
    }
    echo json_encode($result);
}

else if ($calltype == 'puitemsedit'){
    if (checkpuitemsexists($_POST) == 0)
    {
    $sql = updatepuitems($_POST);
    $html=getpuitemshtml(1);
    $pagination=getpuitemspag(1);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Updated';
    }
    else
    {
        $result['errormsg'] = 'Combination of Type and PU item should be unique';
        $result['status'] = 0;
    }
    echo json_encode($result);
}

else if ($calltype == 'puitemsdlt'){
    $sql = deletepuitems($_POST);
    $html=getpuitemshtml(1);
    $pagination=getpuitemspag(1);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Deleted';
    echo json_encode($result);
}

else if ($calltype == 'unitslist'){
    $html=getunitsselect($_POST['units']);
    echo json_encode($html);
}

//Design quantity Section

if ($calltype == 'designquantitylist'){
    $total=getdesignquantitypgtotal($_POST['exchange'],$_POST['feeder']);
    $html=getdesignquantityhtml($_POST['pageno'],$_POST['exchange'],$_POST['feeder']);
    $pagination=getdesignquantitypag($_POST['pageno'],$_POST['exchange'],$_POST['feeder']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    echo json_encode($result);
}

else if ($calltype == 'designquantityadd'){
    if (checkdesignquantityexists($_POST) == 0)
    {
    $sql = insertdesignquantity($_POST);
    $html=getdesignquantityhtml(1,$_POST['exchange'],$_POST['feeder']);
    $pagination=getdesignquantitypag(1,$_POST['exchange'],$_POST['feeder']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully added';
    }
    else
    {
        $result['errormsg'] = 'Exchanges and Feeders should be unique';
        $result['status'] = 0;
    }
    echo json_encode($result);
}

else if ($calltype == 'designquantityedit'){
    if (checkdesignquantityexists($_POST) == 0)
    {
    $sql = updatedesignquantity($_POST);
    $html=getdesignquantityhtml(1,$_POST['exchange'],$_POST['feeder']);
    $pagination=getdesignquantitypag(1,$_POST['exchange'],$_POST['feeder']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Updated';
    }
    else
    {
        $result['errormsg'] = 'Exchanges and Feeders should be unique';
        $result['status'] = 0;
    }
    echo json_encode($result);
}

else if ($calltype == 'designquantitydlt'){
    $sql = deletedesignquantity($_POST);
    $html=getdesignquantityhtml(1);
    $pagination=getdesignquantitypag(1);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Deleted';
    echo json_encode($result);
}

else if ($calltype == 'exchangelist'){
    $html=getexchangeselect();
    $options = "<option value=''>Select Exchange</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'exchangelistwitharea'){
    $html=getexchangewithareaselect();
    $options = "<option value=''>Select Exchange</option>";
    foreach($html as $row){
    $options .= "<option value='".$row['exchange']."'>".$row['areaname']. " : " .$row['exchange']."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'feederlist'){
    $html=getfeederselect($_POST['exchange']);
    $options = "<option value=''>Select Feeder</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'puitemlist'){
    $html=getpuitemsselect($_POST['puitem']);
    echo json_encode($html);
}
else if ($calltype == 'getcurrentitem'){
    $html=getcurrentitem($_POST['puitem']);
    echo json_encode($html);
}


//Executed Works Section

if ($calltype == 'executedworkslist'){
    $total=getexecutedworkspgtotal($_POST['areaname'],$_POST['exchange'],$_POST['feeder']);
    $html=getexecutedworkshtml($_POST['pageno'],$_POST['areaname'],$_POST['exchange'],$_POST['feeder']);
    $pagination=getexecutedworkspag($_POST['pageno'],$_POST['areaname'],$_POST['exchange'],$_POST['feeder']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    echo json_encode($result);
}

else if ($calltype == 'executedworksadd'){
    $sql = insertexecutedworks($_POST);
    $html=getexecutedworkshtml(1,$_POST['areaname'],$_POST['exchange'],$_POST['feeder']);
    $pagination=getexecutedworkspag(1,$_POST['areaname'],$_POST['exchange'],$_POST['feeder']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully added';
    echo json_encode($result);
}

else if ($calltype == 'executedworksedit'){    
    $sql = updateexecutedworks($_POST); 
    $html=getexecutedworkshtml(1,$_POST['areaname'],$_POST['exchange'],$_POST['feeder']);
    $pagination=getexecutedworkspag(1,$_POST['areaname'],$_POST['exchange'],$_POST['feeder']);    
    if ($sql == "not"){
        $result['status'] = '0';
        $result['errormsg'] = 'Please enter the valid Invoice number';
    }
    else{
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Updated';
    }
    echo json_encode($result);
}

else if ($calltype == 'executedworksdlt'){
    $sql = deleteexecutedworks($_POST);
    $html=getexecutedworkshtml(1);
    $pagination=getexecutedworkspag(1);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Deleted';
    echo json_encode($result);
}

else if ($calltype == 'executedworksarealist'){
    $html=getexecutedworksareaselect();
    $options = "<option value=''>Select Area</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'executedworksarealistwithall'){
    $html=getexecutedworksareaselect();
    $options = "<option value=''>ALL</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'executedworksexchangelist'){
    $html=getexecutedworksexchangeselect($_POST['areaname']);
    $options = "<option value=''>Select Exchange</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'executedworksfeederlist'){
    $html=getexecutedworksfeederselect($_POST['exchange']);
    $options = "<option value=''>Select Feeder</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'executedworksexchangelistreport'){
    $html=getexecutedworksexchangeselect($_POST['areaname']);
    $options = "<option value=''>ALL</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'executedworksfeederlistreport'){
    $html=getexecutedworksfeederselect($_POST['exchange']);
    $options = "<option value=''>ALL</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'executedworksinvoicelist'){
    $html=getexecutedworksinvoiceselect($_POST['areaname'],$_POST['exchange'],$_POST['feeder']);
    $options = "<option value=''>ALL</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'executedworkspuitemlist'){
    $html=getpuitemsselect($_POST['puitem']);
    echo json_encode($html);
}
else if ($calltype == 'getexecutedworkscurrentitem'){
    $html=getcurrentitem($_POST['puitem']);
    echo json_encode($html);
}

else if ($calltype == 'invoicepageexchangelist'){
    $html=getinvoicepageexchangelistselect();
     //$options = "<input type='checkbox' name='exchange[]' value='' /> ALL<br/><br/><br/><br/>";
     $options = '<label class="checkbox-inline"><input type="checkbox" id="ckbCheckAll" class="exchangealloption" name="exchange" value="">ALL</label><br/><br/><br/><br/>';
    foreach($html as $row=>$rowvalue){
    //$options .= "<option value='".$row."'>".$rowvalue."</option>";
   //  $options .= "<input type='checkbox' name='exchange[]' value='".$row."' /> ".$rowvalue."<br/><br/><br/><br/>";
     $options .= '<label class="checkbox-inline"><input type="checkbox" class="exchange" name="exchange" value="'.$row.'">'.$rowvalue.'</label><br/><br/><br/><br/>';
    }
    echo json_encode($options);
}
?>