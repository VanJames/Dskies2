<?php

class CSV
{
    public static function download($head, $body, $name = '') {
        Yii::import('ext.phpexcel.XPHPExcel');
        $phpExcel = XPHPExcel::createPHPExcel();

        $phpExcel->getProperties()->setCreator("Nint");
        $phpExcel->getProperties()->setLastModifiedBy("Nint");
        $phpExcel->getProperties()->setTitle("Nint");
        $phpExcel->getProperties()->setSubject("Nint");
        $phpExcel->getProperties()->setDescription("Nint");

        $phpExcel->setActiveSheetIndex(0);
        $i = 1;
        foreach($head as $key => $value) {
            $phpExcel->getActiveSheet()->setCellValueExplicit(Util::getColumnForXls($i) . '1', $value, PHPExcel_Cell_DataType::TYPE_STRING);
            $objStyle = $phpExcel->getActiveSheet()->getStyle(Util::getColumnForXls($i++) . '1');
            $objBorder = $objStyle->getBorders();
            $objBorder->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objBorder->getTop()->getColor()->setARGB('FFDDDDDD');
            $objBorder->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objBorder->getBottom()->getColor()->setARGB('FFDDDDDD');
            $objBorder->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objBorder->getLeft()->getColor()->setARGB('FFDDDDDD');
            $objBorder->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objBorder->getRight()->getColor()->setARGB('FFDDDDDD');

            $objFill = $objStyle->getFill();
            $objFill->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objFill->getStartColor()->setRGB('03a3e3');
        }

        $i = 1;
        foreach($body as $row) {
            $i ++;
            $j = 1;
            foreach($head as $key => $value) {
                $phpExcel->getActiveSheet()->setCellValueExplicit(Util::getColumnForXls($j++).$i, $row[$key], PHPExcel_Cell_DataType::TYPE_STRING);
            }
        }

        $phpExcel->getActiveSheet()->setTitle('Nint');

        $fileName = ($name ? $name : time()) . '.xls';
        $xlsWriter = new PHPExcel_Writer_Excel5($phpExcel);
        ob_end_clean();
        header("Content-Type:application/octet-stream");
        header('Accept-Ranges:bytes');
        header("Content-Disposition:attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');
        header("Pragma: no-cache");
        ob_clean();
        $xlsWriter->save('php://output');
        Yii::app()->end();
    }

}
