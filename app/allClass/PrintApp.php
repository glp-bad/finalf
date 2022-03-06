<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 08.11.2021
 * Time: 14:43
 */

namespace App\allClass;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class PrintApp {


	private $localFile;
	private $dompdf;
	private $pageFormat;
	private $pageOrientation;

	public function __construct($pageFormat, $pageOrientation)
	{

		$this->pageFormat = $pageFormat;
		$this->pageOrientation = $pageOrientation;
		$this->localFile = "invoiceForPrint.pdf";

	}

	public function print($htmlView) {
		$this->dompdf = new Dompdf();
		$this->dompdf->setPaper($this->pageFormat, $this->pageOrientation);
        $this->dompdf->loadHtml($htmlView);
        $this->dompdf->render();
		$output = $this->dompdf->output();
		Storage::disk('local')->put($this->localFile, $output);

		return storage_path() . '/app/' . $this->localFile;     // Path of storage              => /opt/lampp/htdocs/finalf/storage;
	}
}
