<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 08.11.2021
 * Time: 14:43
 */

namespace App\allClass;

use App\allClass\XLSXWriter;
use Illuminate\Support\Facades\Storage;

class ToXLSX {


	private $localFile;
    private $xlsHeader;
    private $dataXlsArray;
    private $xls_base64_encode;

	public function __construct($xlsHeader, $dataXlsArray)
	{
		$this->xlsHeader = $xlsHeader;
		$this->dataXlsArray = $dataXlsArray;
		$this->localFile = "report_to_excel.pdf";

		$this->toXml();
	}

	public function getBase6fFile(){
	    return $this->xls_base64_encode;
    }

	private function toXml(){
        $writer = new XLSXWriter();
        $writer->writeSheetHeader('Sheet1', $this->xlsHeader);
        foreach($this->dataXlsArray as $row) {
            $writer->writeSheetRow('Sheet1', $row);
        }

        $path = storage_path() . '/app/' . $this->localFile;
        $writer->writeToFile($path);
        $this->xls_base64_encode = base64_encode(file_get_contents($path));
    }


}
