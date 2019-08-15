<?php

namespace Atournayre\ToolboxBundle\Service\Excel;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Exception as PhpOfficePhpSpreadsheetWriterException;

class Excel
{
    /**
     * @param string $worksheetName
     *
     * @return Spreadsheet
     * @throws Exception
     */
    public function create(string $worksheetName): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()
            ->setTitle($worksheetName);
        return $spreadsheet;
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param string      $worksheetName
     *
     * @return Spreadsheet
     * @throws Exception
     */
    public function createWorksheet(Spreadsheet $spreadsheet, string $worksheetName): Spreadsheet
    {
        $worksheet = new Worksheet($spreadsheet, $worksheetName);
        $spreadsheet->addSheet($worksheet);
        return $spreadsheet;
    }

    /**
     * @param Spreadsheet $spreadsheet
     *
     * @return Xlsx
     */
    public function convertToXlsx(Spreadsheet $spreadsheet): Xlsx
    {
        return new Xlsx($spreadsheet);
    }

    /**
     * @param Xlsx   $xlsx
     * @param string $fileName
     *
     * @return bool|string
     * @throws PhpOfficePhpSpreadsheetWriterException
     */
    public function createTemporaryFile(Xlsx $xlsx, string $fileName)
    {
        $temporaryFile = tempnam(sys_get_temp_dir(), $fileName);
        $xlsx->save($temporaryFile);
        return $temporaryFile;
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param string      $cell
     * @param array       $rangeDatas
     *
     * @return Worksheet
     * @throws Exception
     */
    public function insertRange(Spreadsheet $spreadsheet, string $cell, array $rangeDatas): Worksheet
    {
        return $spreadsheet
            ->getActiveSheet()
            ->fromArray($rangeDatas, null, $cell);
    }
}
