<?php
include_once("includes/functions.php");
include_once("includes/report_functions.php");


require_once('PHPExcel.php');
$area = isset($_POST['area'])?$_POST['area']:'';
$exchange = isset($_POST['exchange'])?$_POST['exchange']:'';
$feeder = isset($_POST['feeder'])?$_POST['feeder']:'';
$invoice = isset($_POST['invoice'])?$_POST['invoice']:'';
$filename='billofquantityreport'.date("YmdGis");


$products_data = array();
						$filename='Bill of Quantities';
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
						    //     ->setAutoSize(true);
						}
						$objPHPExcel->getActiveSheet()->setTitle("Bill of Quantities");
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
						$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Bill of Quantities')->getStyle('A7')->getFont()->setBold( false )->setSize(18);

						//$html = "<b>Area:</b> BA<b>Exchange:</b> Achrafieh<b>Feeder:</b> 36";
						// Add Area, Exchange and Feeder
						/*$html = "<b>Area:</b> ".$area."&nbsp;&nbsp;&nbsp; <b>Exchange:</b> ".$exchange."&nbsp;&nbsp;&nbsp;<b>Feeder:</b> ".$feeder;
						echo "<b>Area:</b> ".$area."&nbsp;&nbsp;&nbsp; <b>Exchange:</b> ".$exchange."&nbsp;&nbsp;&nbsp;<b>Feeder:</b> ".$feeder; exit;
						$rich_text = $htmlHelper->toRichTextObject($html);
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

						$objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('D11', 'Design')->getStyle('D11:F11')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->mergeCells('D11:F11');
						$objPHPExcel->getActiveSheet()->setCellValue('G11', 'Executed qty')->getStyle('G11:I11')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->mergeCells('G11:I11');
						$objPHPExcel->getActiveSheet()->setCellValue('J11', 'Executed value')->getStyle('J11:L11')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->mergeCells('J11:L11');
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A12', 'PU item')->getStyle('A12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('B12', 'Description')->getStyle('B12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('C12', 'Unit')->getStyle('C12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('D12', 'Unit price ($)')->getStyle('D12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('E12', 'Qty')->getStyle('E12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F12', 'Value ($)')->getStyle('F12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('G12', 'Billed')->getStyle('G12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('H12', 'Unbilled')->getStyle('H12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('I12', 'Total')->getStyle('I12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('J12', 'Billed ($)')->getStyle('J12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);

						$objPHPExcel->getActiveSheet()->setCellValue('K12', 'Unbilled ($)')->getStyle('K12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('L12', 'Total ($)')->getStyle('L12')->applyFromArray($style_center)->getFont()->setBold( true );
						// $users=array(
						// 	array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231','id5'=>'1','id6'=>'1','id7'=>'3','id8'=>'4','id9'=>'5','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7'),
						// 	array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231','id5'=>'1','id6'=>'2','id7'=>'3','id8'=>'4','id9'=>'5','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7'),
						// 	array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231','id5'=>'1','id6'=>'3','id7'=>'3','id8'=>'4','id9'=>'6','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7'),
						// 	array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231','id5'=>'1','id6'=>'2','id7'=>'3','id8'=>'4','id9'=>'5','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7'),
						// 	array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231','id5'=>'1','id6'=>'3','id7'=>'3','id8'=>'4','id9'=>'6','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7'),
						// );

						$items = getbillofquantityexport(1,$area,$exchange,$feeder,$invoice);
					//	print_r($items); exit;
						$row_num=13;
						$testvalue1=0;
						$testvalue2=0;
						$testvalue3=0;
						$testvalue4=0;
						$testvalue5=0;
						$testvalue6=0;
						foreach ($items['itemrow'] as $testvalue ) {
/*
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$row_num, $testvalue['id'])->getStyle('A'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_num, $testvalue['id1'])->getStyle('B'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_num, $testvalue['id2'])->getStyle('C'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$row_num, $testvalue['id3'])->getStyle('D'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_num, $testvalue['id4'])->getStyle('E'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_num, $testvalue['id5'])->getStyle('F'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_num, $testvalue['id6'])->getStyle('G'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_num, $testvalue['id7'])->getStyle('H'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_num, $testvalue['id8'])->getStyle('I'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_num, $testvalue['id9'])->getStyle('J'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('K'.$row_num, $testvalue['id10'])->getStyle('K'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('L'.$row_num, $testvalue['id11'])->getStyle('L'.$row_num)->applyFromArray($style_center);
							$testvalue1=$testvalue1+$testvalue['id6'];
							$testvalue2=$testvalue2+$testvalue['id7'];
							$testvalue3=$testvalue3+$testvalue['id8'];
							$testvalue4=$testvalue4+$testvalue['id9'];
							$testvalue5=$testvalue5+$testvalue['id10'];
							$testvalue6=$testvalue6+$testvalue['id11'];
*/
						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$row_num, $testvalue['item'])->getStyle('A'.$row_num)->applyFromArray($style_center);

						 $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);

							$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_num, $testvalue['description'])->getStyle('B'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_num, $testvalue['unit'])->getStyle('C'.$row_num)->applyFromArray($style_center);
						 $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$row_num, $testvalue['unitprice'])->getStyle('D'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
						 $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
							$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_num, $testvalue['designqty'])->getStyle('E'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');

						 $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
							$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_num, $testvalue['designtotal'])->getStyle('F'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');

						 $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
							$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_num, $testvalue['itembillqty'])->getStyle('G'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');

						 $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
							$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_num, $testvalue['itemunbillqty'])->getStyle('H'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
						 $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
							$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_num, $testvalue['itemqtytotal'])->getStyle('I'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
						 $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
							$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_num, $testvalue['itembillexe'])->getStyle('J'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
						 $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
							$objPHPExcel->getActiveSheet()->setCellValue('K'.$row_num, $testvalue['itemunbillexe'])->getStyle('K'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
						 $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
							$objPHPExcel->getActiveSheet()->setCellValue('L'.$row_num, $testvalue['itemexetotal'])->getStyle('L'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');


							$objPHPExcel->getActiveSheet()->getStyle('A'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$row_num)->applyFromArray($style_left);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('E'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('F'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('G'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('H'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('I'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('J'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('K'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('L'.$row_num)->applyFromArray($style_right);
							//$objPHPExcel->getActiveSheet()->getStyle('M'.$row_num)->applyFromArray($style_right);
							$row_num++;
						}

						$row_num=$row_num+3;

						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_num, 'Total')->getStyle('F'.$row_num)->applyFromArray($style_left)->getFont()->setBold( true );
						/*
						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_num, $testvalue1)->getStyle('G'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_num, $testvalue2)->getStyle('H'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_num, $testvalue3)->getStyle('I'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_num, $testvalue4)->getStyle('J'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('K'.$row_num, $testvalue5)->getStyle('K'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('L'.$row_num, $testvalue6)->getStyle('L'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						*/

						//PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);

						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_num, $items['totalrow']['itembillqty'])->getStyle('G'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->getStyle('G'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );


						$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_num, $items['totalrow']['itemunbillqty'])->getStyle('H'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');

							$objPHPExcel->getActiveSheet()->getStyle('H'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );

						$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_num, $items['totalrow']['itemqtytotal'])->getStyle('I'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->getStyle('I'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );

						$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_num, $items['totalrow']['itembillexe'])->getStyle('J'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');

							$objPHPExcel->getActiveSheet()->getStyle('J'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );


						$objPHPExcel->getActiveSheet()->setCellValue('K'.$row_num, $items['totalrow']['itemunbillexe'])->getStyle('K'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');

							$objPHPExcel->getActiveSheet()->getStyle('K'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );

						$objPHPExcel->getActiveSheet()->setCellValue('L'.$row_num, $items['totalrow']['itemexetotal'])->getStyle('L'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');

							$objPHPExcel->getActiveSheet()->getStyle('L'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );

						
						$objPHPExcel->getActiveSheet()->getStyle("A11:L".$row_num)->applyFromArray(
					    	array(
						        'borders' => array(
						            'allborders' => array(
						                'style' => PHPExcel_Style_Border::BORDER_THIN,
						                'color' => array('rgb' => '000000')
						            )
						        )
						    )
						);

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