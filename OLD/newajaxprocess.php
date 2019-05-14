<?php
include_once("includes/newfunctions.php");
$calltype = $_POST['calltype'];
$result = array();

//Design quantity Section

if ($calltype == 'designquantitylist'){
    //print_r($_POST);exit;
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
?>