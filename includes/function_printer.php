<?php

if(isset($_POST['calltype']) && !empty($_POST['calltype'])) {
    $calltype = $_POST['calltype'];
    if ($calltype == 'getPrinterHeaderFooter'){
        $header=getPrinterHeader($_POST['name'],$_POST['areaname'],$_POST['exchange'],$_POST['feeder'],$_POST['type'],$_POST['invoice']);
        $footer=getPrinterFooter($_POST['name']);
      }
    $result['header'] = $header;
    $result['footer'] = $footer;
    echo json_encode($result);
}

function getPrinterHeader($name,$area,$exchange,$feeder,$type,$invoice) {
    $header = '';
    if($area =='')
    {
        $area = 'ALL';
    }
    if($exchange =='')
    {
        $exchange = 'ALL';
    }
    if($feeder =='' && $name != 'Executedworks')
    {
        $feeder = 'ALL';
    }
    if($type =='')
    {
        $type = 'ALL';
    }
    if($invoice =='')
    {
        $invoice = 'ALL';
    }
    if($name == 'BOQ')
    {
        $header = '<div><div align="left"><b>Project Name: FFTX, OLT and Active Cabinet, Passive ODN & CPE</br>The Employer: Ogero Beirut / Ministry of Telecommunication</br>The Engineer: Consolidated Engineering Company (Khatib & Alami)</br>Contractor: SERTA</br>Nominated Subcontractor: ASHADA</b></div><div align="center" style="font-size: 14pt;">Bill of Quantities - FFTX</br></div></div></br>';
        // $header = '<div><div><table><tr><td>FFTX, OLT and Active Cabinet, Passive ODN & CPE</div></td><td><div align="center" style="font-size: 14pt;"> Bill of Quantities - FFTX</div></td></tr></table></div>';
        $header .= '<table class="table" border="1"><tr><td align="left" width="25%"><b>Area: '.$area .'</b></td><td  width="25%"><div align="left"><b>Exchange: '.$exchange.'</b></div></td><td width="25%"><div align="left"><b>Feeder: '.$feeder.'</b></div></td><td ><div align="left"><b>Invoice: '.$invoice.'</b></div></td></tr></table></div>';
    }
    elseif($name == 'ExchangeSummarySheet')
    {
        $header = '<div><div align="left"><b>Project Name: FFTX, OLT and Active Cabinet, Passive ODN & CPE</br>The Employer: Ogero Beirut / Ministry of Telecommunication</br>The Engineer: Consolidated Engineering Company (Khatib & Alami)</br>Contractor: SERTA</br>Nominated Subcontractor: ASHADA</b></div><div align="center" style="font-size: 14pt;">Exchange Summary Sheet of Executed Works</br></div></div></br>';
        $header .= '<table class="table" border="1"><tr><td align="left" width="33%"><b>Area: '.$area .'</b></td><td  width="33%"><div align="left"><b>Exchange: '.$exchange.'</b></div></td><td><div align="left"><b>Invoice: '.$invoice.'</b></div></td></tr></table></div>';
    }
    elseif($name == 'Executedworks')
    {
        $header = '<div><div align="left"><b>ASHADA S.A.L.</br>FFTX Project</b></div><div align="center" style="font-size: 14pt;">Detailed Report of Executed Works</br></br></div>';
        $header .= '<table class="table" border="1"><tr><td align="left" width="33%"><b>Area: '.$area .'</b></td><td  width="33%"><div align="left"><b>Exchange: '.$exchange.'</b></div></td><td><div align="left"><b>Feeder: '.$feeder.'</b></div></td></tr></table></div>';

    }
    elseif($name == 'Summaryexecutedworks')
    {
        $header = '<div><div align="left"><b>Project Name: FFTX, OLT and Active Cabinet, Passive ODN & CPE</br>The Employer: Ogero Beirut / Ministry of Telecommunication</br>';
        $header .= 'The Engineer: Consolidated Engineering Company (Khatib & Alami</br>Contractor: SERTA</br>Nominated Subcontractor: ASHADA</b></div><div align="center" style="font-size: 14pt;">Detailed Report of Executed Works</br></br></div>';
        $header .= '<table class="table" border="1"><tr><td align="left" width="20%"><b>Area: '.$area .'</b></td><td  width="20%"><div align="left"><b>Exchange: '.$exchange.'</b></div></td><td><div align="left" width="20%"><b>Feeder: '.$feeder.'</b></div></td><td width="20%"><div align="left"><b>Type: '.$type.'</b></div></td><td ><div align="left"><b>Invoice: '.$invoice.'</b></div></td></tr></table></div>';

    }
    return $header;
}


function getPrinterFooter($name) {
    $footer = '';
    if($name == 'BOQ')
    {
        $footer = '<div><table class="table" border="1"><tr><td align="left" width="50%"><b>Contractor:</b></br>Date: ' . date("m/d/Y")  .'</td><td><div align="left"><b>Engineer:</b></div></td></tr></table></div>';
    }
     elseif($name == 'ExchangeSummarySheet')
    {
        $footer = '<div><table class="table"><tr><td align="left" width="50%"><b>Contractor</b><br>Name in print:<br> Signature:<br> Date: ' . date("m/d/Y")  .'</td><td><div align="left"><b>Engineer:</b></br>Signature:</br>Date:</div></td></tr></table></div>';
    }
    elseif($name == 'Executedworks')
    {
        $footer = '<div><table class="table" border="1"><tr><td align="left" width="50%"><b>Contractor:</b><br>Date: ' . date("m/d/Y")  .'</td><td><div align="left"><b>Engineer:</b></br>Signature:</br>Date:</div></td></tr></table></div>';
    }
    elseif($name == 'Summaryexecutedworks')
    {
        $footer = '<div><table class="table" border="1"><tr><td align="left" width="50%"><b>Contractor:</b><br>Date: ' . date("m/d/Y")  .'</td><td><div align="left"><b>Engineer:</b></br></div></td></tr></table></div>';
    }
    return $footer;
}



?>