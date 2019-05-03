<?php
require_once('PHPExcel.php');
$products_data = array();
						$filename='Summary of Executed Works';
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
    					foreach(range('A','E') as $columnID) {
						    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
						        ->setAutoSize(true);
						}
						$objPHPExcel->getActiveSheet()->setTitle("Summary of Executed Works");
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
						$objPHPExcel->getActiveSheet()->mergeCells('A9:E9');
						$html = "<b>Area:</b> BA<b>Exchange:</b> Achrafieh<b>Feeder:</b> 36";
						$rich_text = $htmlHelper->toRichTextObject($html);
						$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->getCell('A9')->setValue($rich_text);
						$objPHPExcel->getActiveSheet()->mergeCells('A11:D11');
						$objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A11', 'Plant unit')->getStyle('A11:D11')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Type')->getStyle('A12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('B12', 'PU item')->getStyle('B12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('C12', 'Description')->getStyle('C12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('D12', 'Unit')->getStyle('D12')->applyFromArray($style_center)->getFont()->setBold( true );
						$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
						$objPHPExcel->getActiveSheet()->setCellValue('E12', 'Measured qty')->getStyle('E12')->applyFromArray($style_center)->getFont()->setBold( true );

						$testArray = array('testcelltext1', 'testcelltext2', 'testcelltext3', 'testcelltext4', 'testcelltext5');
						$users=array(
							array('id'=>'1','id1'=>'1002','id2'=>'tes','id3'=>'test','id4'=>'231'),
							array('id'=>'2','id1'=>'1455','id2'=>'fsdf','id3'=>'fdsf','id4'=>'143'),
							array('id'=>'3','id1'=>'154353','id2'=>'sdadad','id3'=>'dasdas','id4'=>'1'),
						);
						$row_num=13;
						foreach ($users as $testvalue ) {
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$row_num, $testvalue['id'])->getStyle('A'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.$row_num, $testvalue['id1'])->getStyle('B'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.$row_num, $testvalue['id2'])->getStyle('C'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('D'.$row_num, $testvalue['id3'])->getStyle('D'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->setCellValue('E'.$row_num, $testvalue['id4'])->getStyle('E'.$row_num)->applyFromArray($style_center);
							$objPHPExcel->getActiveSheet()->getStyle('B'.$row_num)->applyFromArray($style_center);
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
						$objPHPExcel->getActiveSheet()->getStyle("A11:E".$row_num)->applyFromArray(
					    	array(
						        'borders' => array(
						            'allborders' => array(
						                'style' => PHPExcel_Style_Border::BORDER_THIN,
						                'color' => array('rgb' => '000000')
						            )
						        )
						    )
						);
					

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