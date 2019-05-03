<?php
include_once("includes/functions.php");
$calltype = $_POST['calltype'];
$result = array();

//Country Division Section

if ($calltype == 'countrydivisionlist'){
    $html=getcountrydivisionshtml($_POST['pageno']);
    $pagination=getcountrydivisionspag($_POST['pageno']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    echo json_encode($result);
}

else if ($calltype == 'countrydivisionadd'){
    if (checkcountrydivisionexists($_POST) == 0)
    {
    $sql = insertcountrydivisions($_POST);
    $html=getcountrydivisionshtml(1);
    $pagination=getcountrydivisionspag(1);
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
    $html=getcountrydivisionshtml(1);
    $pagination=getcountrydivisionspag(1);
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

else if ($calltype == 'areanameslist'){
    $html=getareanamesselect($_POST['area']);
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
    $html=getdesignquantityhtml($_POST['pageno']);
    $pagination=getdesignquantitypag($_POST['pageno']);
    $result['html'] = $html;
    $result['pagination'] = $pagination;
    $result['status'] = '1';
    echo json_encode($result);
}

else if ($calltype == 'designquantityadd'){
    if (checkdesignquantityexists($_POST) == 0)
    {
    $sql = insertdesignquantity($_POST);
    $html=getdesignquantityhtml(1);
    $pagination=getdesignquantitypag(1);
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
    $html=getdesignquantityhtml(1);
    $pagination=getdesignquantitypag(1);
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

else if ($calltype == 'unitslist'){
    $html=getunitsselect($_POST['units']);
    echo json_encode($html);
}
?>