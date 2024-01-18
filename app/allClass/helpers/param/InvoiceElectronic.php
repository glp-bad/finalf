<?php


namespace App\allClass\helpers\param;


class InvoiceElectronic
{

    private $antetFactura;
    private $detaliuFactura;
    private $eParam = array();

    private $documentCurrencyCode = 'RON';
    private $countryCode = 'RO';
    private $taxSchemeId = 'VAT';

    
    public function __construct($antetFActura, $detaliuFactura, $eParam){
        $this->antetFactura = $antetFActura[0];
        $this->detaliuFactura = $detaliuFactura;        

        if(!empty($eParam)){
            $this->eParam = $eParam;
        }
    }


    public static function getParamInsert($idInvoice, $strInvoice, $cif){
        return ['id_factura'=>$idInvoice, 'eFactura'=>$strInvoice, 'cif'=>$cif];
    }


    public function getTaxTotalAndTotal(){

        $param = array();

        $taxAmount = 0.00;
        $lineExtensionAmount = 0.00;
        $taxInclusiveAmount = 0.00;

        $subTotal = array();

        

        foreach($this->detaliuFactura as $k => $v ){
            $taxAmount += $v->nTVA;
            $lineExtensionAmount +=  $v->nSuma; 
            $taxInclusiveAmount += $v->nSuma+$v->nTVA;

            $subTotal[]=[
                'taxableAmount'         => $v->nSuma,
                'taxAmount'             => $v->nTVA,
                'taxCategoryId'         => $v->e_categ_tva,
                'taxCategoryIdPercent'  => $this->antetFactura->nProcTva,
                'taxSchemeId'           => $this->taxSchemeId,
                'currency'              => $this->documentCurrencyCode,
            ];
        }

        $param=[
            'taxAmount'             => $taxAmount,
            'lineExtensionAmount'   => $lineExtensionAmount,
            // 'taxExclusiveAmount'    => $taxAmount,
            'taxExclusiveAmount'    => $lineExtensionAmount,
            'taxInclusiveAmount'    => $taxInclusiveAmount,
            'payableAmount'         => $taxInclusiveAmount,
            'currency'              => $this->documentCurrencyCode,
            'subTotal'              => $subTotal
        ];

        return $param;

    }

    public function getInvoicesLines(){

        $param = array();

        foreach($this->detaliuFactura as $k => $v ){

            $name = trim(substr($v->cExplicf, 0, 100));            // max 100

            $param[]=[
                    'id'                        => $v->id,
                    'invoicedQuantity'          => $v->quantity,                       
                    'invoicedQuantityUnitCode'  => $v->e_unit_code,
                    'lineExtensionAmount'       => $v->line_extension_amount,
                    'priceAmount'               => $v->nSuma, 
                    'name'                      => $name,
                    'classifiedTaxCategoryID'   => $v->e_categ_tva,
                    'taxCategoryIdPercent'      => $this->antetFactura->nProcTva,
                    'currency'                  => $this->documentCurrencyCode,
                    'taxCategoryId'             => $this->eParam['taxSchemeId']
                ];
        }

        return $param;

    }

    public function getAntet(){


        $dueDate = $this->antetFactura->e_due_date;
        if(empty($dueDate) && isset($this->eParam['dueDate'])){
            $invoiceDate = date($this->antetFactura->data_f);
            $dueDate = date ("Y-m-d", strtotime ($invoiceDate ."+" .$this->eParam['dueDate'] . " days"));   
        }


        $param=[
            'id'                    =>$this->antetFactura->cNr, 
            'issueDate'             =>$this->antetFactura->data_f,
            'dueDate'               =>$dueDate,
		    'invoiceTypeCode'       =>$this->antetFactura->e_invoice_type_code,
		    'note'                  =>null,
		    'documentCurrencyCode'  =>$this->documentCurrencyCode,
            'paymentMeansCode'     =>$this->antetFactura->payment_means_code,
            'taxPointDate'          =>null
        ];
         
        return $param; 
    }

    private function translateCountrySubentity($adress, $judet, $localitate){
        $countrySubentity = $countrySubentity = $this->eParam['countryCode'] . '-' . $judet;
        $translateLocalitate = $localitate;

        $splitAdrees = explode(',', $adress);
        $sector = strtolower(trim(end($splitAdrees)));

        if(isset($this->eParam[$sector])){
            // $translateLocalitate = $this->eParam[$sector] . '-' . $this->eParam['countryCode'];
            $translateLocalitate = $this->eParam[$sector];
        }

        return ['countrySubentity' => $countrySubentity, 'localitate'=> $translateLocalitate]; 
    }

    public function getSupplier(){

        $citys = $this->translateCountrySubentity($this->antetFactura->cAdresa_av, $this->antetFactura->judet_abrev_av, $this->antetFactura->cOras_av);

        $param=[
            'streetName'                =>$this->antetFactura->cAdresa_av, 
            'cityName'                  =>$citys['localitate'],
            'postalZone'                =>null,
            'countrySubentity'          =>$citys['countrySubentity'], 
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


    public function getCustomer(){

        $citys = $this->translateCountrySubentity($this->antetFactura->cAdresa_pa, $this->antetFactura->judet_abrev_pa, $this->antetFactura->cOras_pa);

        $param=[
            'streetName'                =>$this->antetFactura->cAdresa_pa, 
            'cityName'                  =>$citys['localitate'],
            'postalZone'                =>null,
            'countrySubentity'          =>$citys['countrySubentity'], 
            'countryCode'               =>$this->countryCode,
            'contactElectronicMail'     =>null,
            'contactName'               =>null,
            'contactTelephone'          =>null
            
        ];

        return $param;
    }


    public function getCustomerTax(){


        $param=[
            'companyID'=>  $this->antetFactura->ro_ . $this->antetFactura->cui, 
            'taxSchemeId' => $this->taxSchemeId,
			'partyLegalEntity'=>[
                                 'registrationName'=>$this->antetFactura->cClient, 
                                 'companyLegalForm'=>$this->antetFactura->regcom
                                ]
        ];

        return $param;
    }

}
