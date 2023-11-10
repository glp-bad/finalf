<?php


namespace App\allClass\helpers\param;


class InvoiceElectronic
{

    private $antetFactura;
    private $detaliuFactura;

    private $invoiceTypeCode = '380';
    private $documentCurrencyCode = 'RON';
    private $countryCode = 'RO';
    private $taxSchemeId = 'VAT';

    
    public function __construct($antetFActura, $detaliuFactura){
        $this->antetFactura = $antetFActura[0];
        $this->detaliuFactura = $detaliuFactura;        
    }

    public function getAntet(){

        $param=[
            'id'                    =>$this->antetFactura->cNr, 
            'issueDate'             =>$this->antetFactura->data_f,
            'dueDate'               =>null,
		    'invoiceTypeCode'       =>$this->invoiceTypeCode,
		    'note'                  =>null,
		    'documentCurrencyCode'  =>$this->documentCurrencyCode,
            'taxPointDate'          =>null
        ];
           
        return $param; 
    }

    public function getSupplier(){


        $countrySubentity = $this->countryCode . '-' . $this->antetFactura->judet_abrev_av;

        $param=[
            'streetName'                =>$this->antetFactura->cAdresa_av, 
            'cityName'                  =>$this->antetFactura->cOras_av,
            'postalZone'                =>null,
            'countrySubentity'          =>$countrySubentity, 
            'countryCode'               =>$this->countryCode,
            'contactElectronicMail'     =>$this->antetFactura->contact_email_av,
            'contactName'               =>$this->antetFactura->contact_name_av,
            'contactTelephone'          =>$this->antetFactura->contact_phone_av
            
        ];

        return $param;
    }

    public function getSupplierTax(){
        $param=[
            'companyID'=>  $this->antetFactura->ro_av . $this->antetFactura->cui_av, 
            'taxSchemeId' => $this->taxSchemeId,
			'partyLegalEntity'=>[
                                 'registrationName'=>$this->antetFactura->cNumeCabinet, 
                                 'companyLegalForm'=>$this->antetFactura->cDecizia
                                ]
        ];

        return $param;
    }

}
