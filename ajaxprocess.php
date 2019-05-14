<?php
include_once("includes/functions.php");
$calltype = $_POST['calltype'];
$result = array();

//Country Division Section

if ($calltype == 'countrydivisionlist'){
    $total=getcountrydivisionspgtotal($_POST['areaname'],$_POST['exchange']);$html=getcountrydivisionshtml($_POST['pageno'],$_POST['areaname'],$_POST['exchange']);
    $pagination=getcountrydivisionspag($_POST['pageno'],$_POST['areaname'],$_POST['exchange']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    echo json_encode($result);
}

else if ($calltype == 'countrydivisionadd'){
    if (checkcountrydivisionexists($_POST) == 0)
    {
    $sql = insertcountrydivisions($_POST);
    $html=getcountrydivisionshtml(1,$_POST['areaname'],$_POST['exchange']);
    $pagination=getcountrydivisionspag(1,$_POST['areaname'],$_POST['exchange']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully added';
    }
    else
    {
        $result['errormsg'] = 'Combination of area, exchanges and feeders should be unique';
        $result['status'] = 0;
    }
    echo json_encode($result);
}

else if ($calltype == 'countrydivisionedit'){
    if (checkcountrydivisionexists($_POST) == 0)
    {
    $sql = updatecountrydivisions($_POST);
    $html=getcountrydivisionshtml(1,$_POST['areaname'],$_POST['exchange']);
    $pagination=getcountrydivisionspag(1,$_POST['areaname'],$_POST['exchange']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Updated';
    }
    else
    {
        $result['errormsg'] = 'Combination of area, exchanges and feeders should be unique';
        $result['status'] = 0;
    }
    echo json_encode($result);
}

else if ($calltype == 'countrydivisiondlt'){
    $sql = deletecountrydivisions($_POST);
    $html=getcountrydivisionshtml(1);
    $pagination=getcountrydivisionspag(1);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Deleted';
    echo json_encode($result);
}

else if ($calltype == 'countrydivisionarealist'){
    $html=countrydivisionareaselect();
    $options = "<option value=''>Select Area</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'countrydivisionexchangelist'){
    $html=countrydivisionexchangeselect($_POST['areaname']);
    $options = "<option value=''>Select Exchange</option>";
    foreach($html as $row){
    $options .= "<option value='".$row."'>".$row."</option>";
    }
    echo json_encode($options);
}

else if ($calltype == 'countrydivisionfeederlist'){
    $html=countrydivisionfeederselect($_POST['exchange']);
    // $options = "<option value=''>Select Feeder</option>";
    // foreach($html as $row){
    // $options .= "<option value='".$row."'>".$row."</option>";
    // }
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
        $result['errormsg'] = 'Combination of area, exchanges and feeders should be unique';
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
        $result['errormsg'] = 'Combination of area, exchanges and feeders should be unique';
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
        $result['errormsg'] = 'Combination of area, exchanges and feeders should be unique';
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
        $result['errormsg'] = 'Combination of area, exchanges and feeders should be unique';
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
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    $result['successmessage'] = 'Successfully Updated';
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

else if ($calltype == 'executedworkspuitemlist'){
    $html=getpuitemsselect($_POST['puitem']);
    echo json_encode($html);
}
else if ($calltype == 'getexecutedworkscurrentitem'){
    $html=getcurrentitem($_POST['puitem']);
    echo json_encode($html);
}
?>