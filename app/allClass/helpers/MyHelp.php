<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 26.02.2020
 * Time: 13:16
 */

namespace App\allClass\helpers;

use App\allClass\helpers\response\MessageResponse;
use DateTime;
use Illuminate\Support\Carbon;

class MyHelp {

    /**
     * https://ralphjsmit.com/carbon-laravel-manage-datetime/
     * @param $format
     * @param $strindDateFormat
     * @return \Carbon\Carbon|false
     */
    public static function getCarbonDate($format, $strindDateFormat){
        return Carbon::createFromFormat($format,  $strindDateFormat);;
    }

    public static function getCarbonDateNow(){
        return now();
    }

	/**
	 * @param $invoiceData              "yyyy-mm-dd"
	 * @param $invoiceClient            "client name"
	 * @param $type                     "pdf, txt ... "
	 * @return string
	*/
	public static function getInvoiceFileName($invoiceData, $invoiceClient, $type){
	 	return $invoiceClient . '_' .$invoiceData . $type ;
	}

	/**
	 * @param $succes
	 * @param $message              array
	 * @return MessageResponse
	*/
	public static function getMessageResponse($succes, $message){
		return new MessageResponse($succes, $message);
	}

    /**
     * @param $dataString
     * @param null $time
     * @return array
     */
	public static function getSqlDateFormat($dataString, $time = null){
		$date = DateTime::createFromFormat('d/m/Y', $dataString);

		if($time == null){
			$frm = "Y-m-d 00:00:00";
		}else{
			$frm = "Y-m-d " . $time;

		}

		return ['dataFormat'=>$date->format($frm), 'objDate'=>$date, 'year'=>$date->format('Y'), 'month'=>$date->format('n')];
	}

    /**
     * @param $sumaFaraTva
     * @param $procetTVA    (forma 19)
     * @return null
     */
    public static function getValueFromSumaFaraTva($sumaFaraTva, $procentTVA){

        if($procentTVA > 0) {
            $proc = ($procentTVA / 100) + 1;
            $total = $sumaFaraTva * $proc;
            $sumaTva = $total - $sumaFaraTva;

        }else{
            $total = $sumaFaraTva;
            $sumaTva = 0;
        }

        return ['sumaFaraTva'=>$sumaFaraTva, 'sumaTva'=>$sumaTva, 'total'=>$total];
    }

    /**
     * @param $sumaFaraTva
     * @param $procentTVA
     * @return array
     */
    public static function getValueFromSumaCuTva($suma, $procentTVA){

        $total       = $suma;

        if($procentTVA > 0) {
            $proc        = ($procentTVA / 100) + 1;
            $sumaFaraTva = round($suma/$proc,4);
            $sumaTva     = round($suma - $sumaFaraTva,2);

        }else{
            $sumaTva     = 0;
            $sumaFaraTva = 0;
        }

        return ['sumaFaraTva'=>$sumaFaraTva, 'sumaTva'=>$sumaTva, 'total'=>$total];
    }

	/**
	 * @param      $string
	 * @param      $replaceChar
	 * @param null $arraySpecial
	 * @return mixed
	 */
	public static function removeSpecialCharacter($string, $replaceChar, $arraySpecial = null){
		if(!$arraySpecial){
			$arraySpecial = array( "Ț", "Ă");
		}

		return str_replace($arraySpecial, $replaceChar, $string);
	}

	public  static function replaceROchars($str) {
		$search = array('ă', 'Ă', 'â', 'Â', 'î', 'Î', 'ș', 'Ș', 'ț', 'Ț');
		$replace = array('&#259;', '&#258;', '&#226;', '&#194;', '&#238;', '&#206;', '&#351;', '&#350;', '&#355;', '&#354;');

		return str_replace($search, $replace, $str);
	}

	public static function replaceROcharsToEN($str) {
		$search = array('ă', 'Ă', 'â', 'Â', 'î', 'Î', 'ș', 'Ș', 'ț', 'Ț', 'ş', 'ţ');
		$replace = array('a', 'A', 'a', 'A', 'i', 'I', 's', 'S', 't', 'T', 's', 't');

		return str_replace($search, $replace, $str);
	}

}
