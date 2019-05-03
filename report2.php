<?php
require_once('PHPExcel.php');
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
						    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
						        ->setAutoSize(true);
						}
						$objPHPExcel->getActiveSheet()->setTitle("Bill of Quantities");
						$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Project name: Fiber optic etc etc')->getStyle('A2')->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Employeer: Ministry of telecommunications')->getStyle('A3')->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Engineer: K&A ……..')->getStyle('A4')->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Contractor: ASHADA S.A.L.')->getStyle('A5')->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(80);
						$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Summary of Executed Works
						')->getStyle('A7')->getFont()->setBold( true )->setSize(18);

						$html = "<b>Area:</b> BA<b>Exchange:</b> Achrafieh<b>Feeder:</b> 36";
						$rich_text = $htmlHelper->toRichTextObject($html);
						$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->getCell('A9')->setValue($rich_text);
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
						$objPHPExcel->getActiveSheet()->setCellValue('D12', 'Unit price')->getStyle('D12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('E12', 'Qty')->getStyle('E12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F12', 'Value')->getStyle('F12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('G12', 'Billed')->getStyle('G12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('H12', 'Unbilled')->getStyle('H12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('I12', 'Total')->getStyle('I12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('J12', 'Billed')->getStyle('J12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('K12', 'Unbilled')->getStyle('K12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('L12', 'Total')->getStyle('L12')->applyFromArray($style_center)->getFont()->setBold( true );
						$users=array(
							array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231','id5'=>'1','id6'=>'1','id7'=>'3','id8'=>'4','id9'=>'5','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7'),
							array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231','id5'=>'1','id6'=>'2','id7'=>'3','id8'=>'4','id9'=>'5','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7'),
							array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231','id5'=>'1','id6'=>'3','id7'=>'3','id8'=>'4','id9'=>'6','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7'),
							array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231','id5'=>'1','id6'=>'2','id7'=>'3','id8'=>'4','id9'=>'5','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7'),
							array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231','id5'=>'1','id6'=>'3','id7'=>'3','id8'=>'4','id9'=>'6','id8'=>'6','id9'=>'7','id10'=>'6','id11'=>'7'),
						);
						$row_num=13;
						$testvalue1=0;
						$testvalue2=0;
						$testvalue3=0;
						$testvalue4=0;
						$testvalue5=0;
						$testvalue6=0;
						foreach ($users as $testvalue ) {
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
							$objPHPExcel->getActiveSheet()->getStyle('A'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$row_num)->applyFromArray($style_left);
							$objPHPExcel->getActiveSheet()->getStyle('C'.$row_num)->applyFromArray($style_left);
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

						$objPHPExcel->getActiveSheet()->getRowDimension($row_num)->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_num, 'Total')->getStyle('F'.$row_num)->applyFromArray($style_left)->getFont()->setBold( true );
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

						//PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
						
						$objPHPExcel->getActiveSheet()->getStyle("A11:M".$row_num)->applyFromArray(
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