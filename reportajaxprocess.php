<?php
include_once("includes/functions.php");
include_once("includes/report_functions.php");
$calltype = $_POST['calltype'];
$result = array();


//Executed Works Section

if ($calltype == 'summaryofexecutedworkslist'){
    $total=getsummaryexecutedworkspgtotal($_POST['areaname'],$_POST['exchange'],$_POST['feeder'],$_POST['invoice']);
    $html=getsummaryexecutedworkshtml($_POST['areaname'],$_POST['exchange'],$_POST['feeder'],$_POST['type'],$_POST['invoice']);
    $result['html'] = $html;
    $result['total'] = $total;
    $result['status'] = '1';
    echo json_encode($result);
}
else if ($calltype == 'billofquantity'){
    $invoicetotal=getbillofquantityinvoicetotal($_POST['areaname'],$_POST['exchange'],$_POST['feeder'],$_POST['invoice']);
    $total=getbillofquantitytotal($_POST['areaname'],$_POST['exchange'],$_POST['feeder'],$_POST['invoice']);
    $html=getbillofquantityhtml($_POST['areaname'],$_POST['exchange'],$_POST['feeder'],$_POST['invoice']);
    $result['html'] = $html;
    $result['invoicetotal'] = $invoicetotal;
    $result['total'] = $total;
    $result['status'] = '1';
    echo json_encode($result);
}
else if ($calltype == 'generateinvoices'){
    $html=generateinvoices($_POST['areaname'],$_POST['exchange'],$_POST['feeder'],$_POST['invoiceid'],$_POST['invoicedate']);
    $result['status'] = '1';
    echo json_encode($result);
}
else if ($calltype == 'exchangesummarylist'){
    $total=getexchangesummarytotal($_POST['areaname'],$_POST['exchange'],$_POST['feeder'],$_POST['invoice']);
    $html=getexchangesummaryhtml($_POST['areaname'],$_POST['exchange'],$_POST['feeder'],$_POST['invoice']);
    $result['html'] = $html;
    $result['total'] = $total;
    $result['status'] = '1';
    echo json_encode($result);
}
else if ($calltype == 'allinvoicelist'){
    $html=getallinvoices($_POST['pageno']);
    $total=getallinvoicetotal();
     $result['html'] = $html;
    $result['total'] = $total;
    $result['status'] = '1';
    echo json_encode($result);
}

else if ($calltype == 'saveinvoices'){
    $availabletot  = needtocreateinvoicetotal($_POST['cabletype'],$_POST['exchange']);

    if($availabletot > 0){
    $invoiceexist = checkinvoiceidexist($_POST['invoiceid']);

    if($invoiceexist == 0){
    $html=generateinvoiceid($_POST['invoiceid'],$_POST['invoicedate'],$_POST['cabletype'],$_POST['exchange']);
    $result['status'] = 1;
    $result['success'] = "Invoice Created";
    }else{
    $result['status'] = 0;
    $result['message'] = "Same Invoice already exists!";
    }
    }
    else{
    $result['status'] = 0;
    $result['message'] = "Executed Items not exists for Invoice creation!";
    }
    echo json_encode($result);
}




?>