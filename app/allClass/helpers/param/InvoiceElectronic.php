<?php


namespace App\allClass\helpers\param;


class InvoiceElectronic
{

    private $antetFactura;
    private $detaliuFactura;

    private $documentCurrencyCode = 'RON';
    private $countryCode = 'RO';
    private $taxSchemeId = 'VAT';

    
    public function __construct($antetFActura, $detaliuFactura){
        $this->antetFactura = $antetFActura[0];
        $this->detaliuFactura = $detaliuFactura;        
    }


    public function getTaxTotalAndTotal(){

        $param = array();

        $taxAmount = 0;
        $lineExtensionAmount = 0;
        $taxInclusiveAmount = 0;

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
            'taxExclusiveAmount'    => $taxAmount,
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
            $param[]=[
                    'id'                        => $v->id,
                    'invoicedQuantity'          => $v->quantity,                       
                    'invoicedQuantityUnitCode'  => $v->e_unit_code,
                    'lineExtensionAmount'       => $v->line_extension_amount,
                    'priceAmount'               => $v->nSuma, 
                    'name'                      => $v->cExplicf,
                    'classifiedTaxCategoryID'   => $v->e_categ_tva,
                    'currency'                  => $this->documentCurrencyCode
                ];
        }

        return $param;

    }

    public function getAntet(){

        $param=[
            'id'                    =>$this->antetFactura->cNr, 
            'issueDate'             =>$this->antetFactura->data_f,
            'dueDate'               =>null,
		    'invoiceTypeCode'       =>$this->antetFactura->e_invoice_type_code,
		    'note'                  =>null,
		    'documentCurrencyCode'  =>$this->documentCurrencyCode,
            'paymentMeansCode'     =>$this->antetFactura->payment_means_code,
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


    public function getCustomer(){


        $countrySubentity = $this->countryCode . '-' . $this->antetFactura->judet_abrev_pa;

        $param=[
            'streetName'                =>$this->antetFactura->cAdresa_pa, 
            'cityName'                  =>$this->antetFactura->cOras_pa,
            'postalZone'                =>null,
            'countrySubentity'          =>$countrySubentity, 
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
