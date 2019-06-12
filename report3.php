<?php
include_once("includes/functions.php");
include_once("includes/report_functions.php");
require_once('PHPExcel.php');
$area = isset($_POST['area'])?$_POST['area']:'';
$exchange = "";
$feeder = "";
$invoice = isset($_POST['invoice'])?$_POST['invoice']:'';
$filename='exchangesummarysheet'.date("YmdGis");

$products_data = array();
						$filename='Entity Sumary Sheet';
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
						 //   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
						 //       ->setAutoSize(true);
						}
						$objPHPExcel->getActiveSheet()->setTitle("Entity Sumary Sheet");
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
						$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Exchange Summary Sheet')->getStyle('A7')->getFont()->setBold( false )->setSize(18);
						$html = "<b>Area:</b> ".($area==''?'ALL':$area);
						$rich_text = $htmlHelper->toRichTextObject($html);
						$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->getCell('A9')->setValue($rich_text);
						$objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('B10', 'Civil works (Type=1)')->getStyle('B10:E10')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->mergeCells('B10:E10');
						$objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F10', 'Cable works (Type=2)')->getStyle('F10:I10')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->mergeCells('F10:I10');
						$objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('J10', 'TOTAL')->getStyle('J10:M10')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->mergeCells('J10:M10');
						$objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('B11', 'Design')->getStyle('B11')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('C11', 'Executed values')->getStyle('C11:E11')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->mergeCells('C11:E11');
						$objPHPExcel->getActiveSheet()->setCellValue('F11', 'Design')->getStyle('F11')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('G11', 'Executed values')->getStyle('G11:I11')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->mergeCells('G11:I11');
						$objPHPExcel->getActiveSheet()->setCellValue('J11', 'Design')->getStyle('J11')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('K11', 'Executed values')->getStyle('K11:M11')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->mergeCells('K11:M11');
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Exchange')->getStyle('A12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('B12', 'values ($)')->getStyle('B12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('C12', 'Billed ($)')->getStyle('C12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('D12', 'Unbilled ($)')->getStyle('D12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('E12', 'Total ($)')->getStyle('E12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('F12', 'values ($)')->getStyle('F12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('G12', 'Billed ($)')->getStyle('G12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('H12', 'Unbilled ($)')->getStyle('H12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('I12', 'Total ($)')->getStyle('I12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('J12', 'values ($)')->getStyle('J12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('K12', 'Billed ($)')->getStyle('K12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('L12', 'Unbilled ($)')->getStyle('L12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('M12', 'Total ($)')->getStyle('M12')->applyFromArray($style_center)->getFont()->setBold( true );
						$users=array(
							array('id'=>'Joub jannine','id1'=>'1002','id2'=>'12','id3'=>'56','id4'=>'231','id5'=>'1','id6'=>'1','id7'=>'3','id8'=>'4','id9'=>'5','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7','id12'=>'89'),
							array('id'=>'sam','id1'=>'1002','id2'=>'12','id3'=>'65','id4'=>'231','id5'=>'1','id6'=>'2','id7'=>'3','id8'=>'4','id9'=>'5','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7','id12'=>'12.890'),
							array('id'=>'jam','id1'=>'1002','id2'=>'13','id3'=>'78','id4'=>'231','id5'=>'1','id6'=>'3','id7'=>'3','id8'=>'4','id9'=>'6','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7','id12'=>'34.8'),
							array('id'=>'Tom','id1'=>'1002','id2'=>'85','id3'=>'76','id4'=>'231','id5'=>'1','id6'=>'2','id7'=>'3','id8'=>'4','id9'=>'5','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7','id12'=>'7'),
							array('id'=>'Jerry','id1'=>'1002','id2'=>'653.2','id3'=>'67','id4'=>'231','id5'=>'1','id6'=>'3','id7'=>'3','id8'=>'4','id9'=>'6','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7','id12'=>'7.6'),
						);
						$row_num=13;
						$testvalue1=0;
						$testvalue2=0;
						$testvalue3=0;
						$testvalue4=0;
						$testvalue5=0;
						$testvalue6=0;
						$testvalue7=0;
						$testvalue8=0;
						$testvalue9=0;
						$testvalue10=0;
						$testvalue11=0;
						$testvalue12=0;

						$items = getexchangesummaryexport($area,$exchange,$feeder,$invoice);
					//	foreach ($users as $testvalue ) {
						foreach ($items['itemrow'] as $testvalue ) {
						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$row_num, $testvalue['exchange'])->getStyle('A'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_num, $testvalue['civildesignvalue'])->getStyle('B'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_num, $testvalue['civilexecbilled'])->getStyle('C'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$row_num, $testvalue['civilexecunbilled'])->getStyle('D'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_num, $testvalue['civilexetotal'])->getStyle('E'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_num, $testvalue['cabledesignvalue'])->getStyle('F'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_num, $testvalue['cableexecbilled'])->getStyle('G'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_num, $testvalue['cableexecunbilled'])->getStyle('H'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_num, $testvalue['cableexetotal'])->getStyle('I'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_num, $testvalue['totaldesignvalue'])->getStyle('J'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('K'.$row_num, $testvalue['totalexecbilled'])->getStyle('K'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('L'.$row_num, $testvalue['totalexecunbilled'])->getStyle('L'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');
							$objPHPExcel->getActiveSheet()->setCellValue('M'.$row_num, $testvalue['totalexetotal'])->getStyle('M'.$row_num)->applyFromArray($style_center)->getNumberFormat()->setFormatCode('0.000');

							// $testvalue1=$testvalue1+$testvalue['id1'];
							// $testvalue2=$testvalue2+$testvalue['id2'];
							// $testvalue3=$testvalue3+$testvalue['id3'];
							// $testvalue4=$testvalue4+$testvalue['id4'];
							// $testvalue5=$testvalue5+$testvalue['id5'];
							// $testvalue6=$testvalue6+$testvalue['id6'];
							// $testvalue7=$testvalue7+$testvalue['id7'];
							// $testvalue8=$testvalue8+$testvalue['id8'];
							// $testvalue9=$testvalue9+$testvalue['id9'];
							// $testvalue10=$testvalue10+$testvalue['id10'];
							// $testvalue11=$testvalue11+$testvalue['id11'];
							// $testvalue12=$testvalue11+$testvalue['id12'];

							$objPHPExcel->getActiveSheet()->getStyle('A'.$row_num)->applyFromArray($style_left);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('D'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('E'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('F'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('G'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('H'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('I'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('J'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('K'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('L'.$row_num)->applyFromArray($style_right);
							$objPHPExcel->getActiveSheet()->getStyle('M'.$row_num)->applyFromArray($style_right);
							$row_num++;
						}

						$row_num=$row_num+3;
							$testvalue1=$items['totalrow']['subtotalcivildesignvalue'];
							$testvalue2=$items['totalrow']['subtotalcivilexecbilled'];
							$testvalue3=$items['totalrow']['subtotalcivilexecunbilled'];
							$testvalue4=$items['totalrow']['subtotalcivilexetotal'];
							$testvalue5=$items['totalrow']['subtotalcabledesignvalue'];
							$testvalue6=$items['totalrow']['subtotalcableexecbilled'];
							$testvalue7=$items['totalrow']['subtotalcableexecunbilled'];
							$testvalue8=$items['totalrow']['subtotalcableexetotal'];
							$testvalue9=$items['totalrow']['subtotalmiddesignvalue'];
							$testvalue10=$items['totalrow']['subtotalmidexecbilled'];
							$testvalue11=$items['totalrow']['subtotalmidexecunbilled'];
							$testvalue12=$items['totalrow']['subtotalmidexetotal'];
						
						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
						/*
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$row_num, 'Total')->getStyle('A'.$row_num)->applyFromArray($style_left)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_num, $testvalue1)->getStyle('B'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_num, $testvalue2)->getStyle('C'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$row_num, $testvalue3)->getStyle('D'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_num, $testvalue4)->getStyle('E'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_num, $testvalue5)->getStyle('F'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_num, $testvalue6)->getStyle('G'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_num, $testvalue7)->getStyle('H'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_num, $testvalue8)->getStyle('I'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_num, $testvalue9)->getStyle('J'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('K'.$row_num, $testvalue10)->getStyle('K'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('L'.$row_num, $testvalue11)->getStyle('L'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('M'.$row_num, $testvalue12)->getStyle('M'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						*/


						$objPHPExcel->getActiveSheet()->setCellValue('A'.$row_num, 'Total')->getStyle('A'.$row_num)->applyFromArray($style_left)->getFont()->setBold( true );

						$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_num, $testvalue1)->getStyle('B'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );

						$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_num, $testvalue1)->getStyle('B'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('B'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );

						$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_num, $testvalue2)->getStyle('C'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('C'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$row_num, $testvalue3)->getStyle('D'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('D'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_num, $testvalue4)->getStyle('E'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('E'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_num, $testvalue5)->getStyle('F'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('F'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('G'.$row_num, $testvalue6)->getStyle('G'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('G'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('H'.$row_num, $testvalue7)->getStyle('H'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('H'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('I'.$row_num, $testvalue8)->getStyle('I'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('I'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('J'.$row_num, $testvalue9)->getStyle('J'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('K'.$row_num, $testvalue10)->getStyle('K'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('K'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('L'.$row_num, $testvalue11)->getStyle('L'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('L'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->setCellValue('M'.$row_num, $testvalue12)->getStyle('M'.$row_num)->applyFromArray($style_right)->getNumberFormat()->setFormatCode('0.000');
						$objPHPExcel->getActiveSheet()->getStyle('M'.$row_num)->applyFromArray($style_right)->getFont()->setBold( true );

						$objPHPExcel->getActiveSheet()->getStyle("A10:M".$row_num)->applyFromArray(
					    	array(
						        'borders' => array(
						            'allborders' => array(
						                'style' => PHPExcel_Style_Border::BORDER_THIN,
						                'color' => array('rgb' => '000000')
						            )
						        )
						    )
						);



						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
						$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
						$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
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