<?php
include_once("includes/functions.php");
include_once("includes/report_functions.php");


require_once('PHPExcel.php');
$area = isset($_POST['area'])?$_POST['area']:'';
$exchange = isset($_POST['exchange'])?$_POST['exchange']:'';
$feeder = isset($_POST['feeder'])?$_POST['feeder']:'';
$type = isset($_POST['type'])?$_POST['type']:'';
$invoice = isset($_POST['invoice'])?$_POST['invoice']:'';
$filename='summaryofexecutedworks'.date("YmdGis");
$products_data = array();
						$objPHPExcel = new PHPExcel();
						$htmlHelper = new \PHPExcel_Helper_HTML();
						$style_center = array(
					        'alignment' => array(
					            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					        )
    					);
    					$style_right = array(
					        'alignment' => array(
					            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					        )
    					);
    					$style_left = array(
					        'alignment' => array(
					            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					        )
    					);
    					foreach(range('A','E') as $columnID) {
						   // $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
						  //      ->setAutoSize(true);
						}
						$objPHPExcel->getActiveSheet()->setTitle("Summary of Executed Works");
						$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Project Name: FFTX, OLT and Active Cabinet, Passive ODN & CPE')->getStyle('A2')->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A3', 'The Employer: Ogero Beirut / Ministry of Telecommunication')->getStyle('A3')->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A4', 'The Engineer: Consolidated Engineering Company (Khatib & Alami)')->getStyle('A4')->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Contractor: SERTA')->getStyle('A5')->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Nominated Subcontractor: ASHADA')->getStyle('A6')->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(30);
						$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Summary of Executed Works')->getStyle('A7')->getFont()->setBold( false )->setSize(18);
						$objPHPExcel->getActiveSheet()->mergeCells('A9:E9');

						// Add Area, Exchange and Feeder
						/*
						$html = "<b>Area:</b> ".(empty($area)?"ALL":$area)."<b style='left:100px;'>Exchange:</b> ".$exchange."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Feeder:</b> ".$feeder;
						$html = "<b>Area:</b> ".(empty($area)?"ALL":$area).                "<b>Exchange:</b> ".$exchange."              <b>Feeder:</b> ".$feeder;
						$rich_text = $htmlHelper->toRichTextObject($html);
						//$rich_text = $html;
						$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->getCell('A9')->setValue($rich_text);

						*/
						$objRichText = new PHPExcel_RichText();
$run1 = $objRichText->createTextRun('Area:');
$run1->getFont()->applyFromArray(array( "bold" => true, "size" => 12, "name" => "Calibri"));

$run2 = $objRichText->createTextRun(empty($area)?"ALL":$area);
$run2->getFont()->applyFromArray(array( "bold" => false, "size" => 10, "name" => "Calibri"));

$run3 = $objRichText->createTextRun('   Exchange:');
$run3->getFont()->applyFromArray(array( "bold" => true, "size" => 12, "name" => "Calibri"));

$run4 = $objRichText->createTextRun($exchange);
$run4->getFont()->applyFromArray(array( "bold" => false, "size" => 10, "name" => "Calibri"));

$run5 = $objRichText->createTextRun('    Feeder:');
$run5->getFont()->applyFromArray(array( "bold" => true, "size" => 12, "name" => "Calibri"));

$run6 = $objRichText->createTextRun($feeder);
$run6->getFont()->applyFromArray(array( "bold" => false, "size" => 10, "name" => "Calibri"));


						$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue("A9", $objRichText);


						$objPHPExcel->getActiveSheet()->mergeCells('A11:D11');
						$objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A11', 'Plant unit')->getStyle('A11:D11')->applyFromArray($style_center)->getFont()->setBold( true );

						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Type')->getStyle('A12')->applyFromArray($style_center)->getFont()->setBold( true );

						$objPHPExcel->getActiveSheet()->setCellValue('B12', 'PU item')->getStyle('B12')->applyFromArray($style_left)->getFont()->setBold( true );

						 $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
						$objPHPExcel->getActiveSheet()->setCellValue('C12', 'Description')->getStyle('C12')->applyFromArray($style_left)->getFont()->setBold( true );

						$objPHPExcel->getActiveSheet()->setCellValue('D12', 'Unit')->getStyle('D12')->applyFromArray($style_center)->getFont()->setBold( true );

						 $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('E12', 'Measured qty')->getStyle('E12')->applyFromArray($style_center)->getFont()->setBold( true );


						
						$items = getsummaryexecutedworksexport($area,$exchange,$feeder,$type,$invoice);

						$row_num=13;
						foreach ($items as $item ) {
						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$row_num, $item['type'])->getStyle('A'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_num, $item['puitem'])->getStyle('B'.$row_num)->applyFromArray($style_left);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_num, $item['description'])->getStyle('C'.$row_num)->applyFromArray($style_left);
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$row_num, $item['unit'])->getStyle('D'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_num, $item['measuredqty'])->getStyle('E'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
							
							$objPHPExcel->getActiveSheet()->getStyle('B'.$row_num)->applyFromArray($style_left);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->getStyle('E'.$row_num)->applyFromArray($style_right);

							$row_num++;
						}

						$objPHPExcel->getActiveSheet()->getStyle("A9:E9")->applyFromArray(
					    	array(
						        'borders' => array(
						            'allborders' => array(
						                'style' => PHPExcel_Style_Border::BORDER_THIN,
						                'color' => array('rgb' => '000000')
						            )
						        )
						    )
						);
						// $objPHPExcel->getActiveSheet()->getStyle("A11:E".$row_num)->applyFromArray(
					 //    	array(
						//         'borders' => array(
						//             'allborders' => array(
						//                 'style' => PHPExcel_Style_Border::BORDER_THIN,
						//                 'color' => array('rgb' => '000000')
						//             )
						//         )
						//     )
						// );
					

						//PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
						
						

						// Set active sheet index to the first sheet, so Excel opens this as the first sheet
						$objPHPExcel->setActiveSheetIndex(0);

						// Save Excel 95 file

						$callStartTime = microtime(true);
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						
						//Setting the header type
						header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
						header("Content-Disposition: attachment; filename=\"" . $filename . ".xls\"");
						
						header('Cache-Control: max-age=0');

						$objWriter->save('php://output');