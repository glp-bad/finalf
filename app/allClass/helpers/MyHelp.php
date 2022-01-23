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
	 * @param      $dataString      "d/m/Y"
	 * @param      null $time
	 * @return     string
	 */
	public static function getSqlDateFormat($dataString, $time = null){
		$date = DateTime::createFromFormat('d/m/Y', $dataString);

		if($time == null){
			$frm = "Y-m-d 00:00:00";

		}else{
			$frm = "Y-m-d " . $time;

		}

		return $date->format($frm);
	}

}
