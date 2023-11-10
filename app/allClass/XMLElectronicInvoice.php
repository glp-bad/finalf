<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 08.11.2021
 * Time: 14:43
 */

namespace App\allClass;

class XMLElectronicInvoice {

    private $doc;
	private $invoice;

	public function __construct() {
		$this->doc = new \DOMDocument('1.0');
		$this->doc->formatOutput = true;

		$this->invoice = $this->doc->createElement('Invoice');

		$this->invoice->setAttribute('xmlns', "urn:oasis:names:specification:ubl:schema:xsd:Invoice-2");
		$this->invoice->setAttribute('xmlns:cbc', "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2");
		$this->invoice->setAttribute('xmlns:cac', "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2");
		$this->invoice->setAttribute('xmlns:ns4', "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
		$this->invoice->setAttribute('xsi:schemaLocation', "urn:oasis:names:specification:ubl:schema:xsd:Invoice-2 http://docs.oasis-open.org/ubl/os-UBL-2.1/xsd/maindoc/UBL-Invoice-2.1.xsd");

		/*	
		$UBLVersionID = $this->doc->createElement("cbc:UBLVersionID", '2.1');
		$this->invoice->appendChild($UBLVersionID);
		*/

		$customizationID = $this->doc->createElement("cbc:CustomizationID", 'urn:cen.eu:en16931:2017#compliant#urn:efactura.mfinante.ro:CIUS-RO:1.0.1');
		$this->invoice->appendChild($customizationID);

		$this->doc->appendChild($this->invoice);
	}

	public function createAntet($param) {
		$id = $this->doc->createElement("cbc:ID", $param['id']);
		$this->invoice->appendChild($id);

		$issueDate = $this->doc->createElement("cbc:IssueDate", $param['issueDate']);
		$this->invoice->appendChild($issueDate);

		if(!empty($param['dueDate'])){
			$dueDate = $this->doc->createElement("cbc:DueDate", $param['dueDate']);
			$this->invoice->appendChild($dueDate);
		}

		$invoiceTypeCode = $this->doc->createElement("cbc:InvoiceTypeCode", $param['invoiceTypeCode']);
		$this->invoice->appendChild($invoiceTypeCode);

		if(!empty($param['note'])){
			$note = $this->doc->createElement("cbc:Note", $param['note']);
			$this->invoice->appendChild($note);
		}

		$documentCurrencyCode = $this->doc->createElement("cbc:DocumentCurrencyCode", $param['documentCurrencyCode']);
		$this->invoice->appendChild($documentCurrencyCode);

		if(!empty($param['taxPointDate'])){
			$taxPointDate = $this->doc->createElement("cbc:TaxPointDate", $param['taxPointDate']);
			$this->invoice->appendChild($taxPointDate);
		}

		/* 
		$invoicePeriod = $this->doc->createElement('cac:InvoicePeriod');
		$note = $this->doc->createElement("cbc:EndDate", $param['invoiceDate']);
		$invoicePeriod->appendChild($note);
		$this->invoice->appendChild($invoicePeriod);
		*/
	}

	public function createInvoiceLines($line) {
		foreach ($line as $l) {

			$invoiceLine = $this->createInvoiceLine($l);

			foreach ($l['allowanceCharge'] as $alc){
				$allowanceCharge = $this->createAllowanceCharge($alc);
				$invoiceLine->appendChild($allowanceCharge);
			}

				$item = $this->createItemLine($l['item']);
			$invoiceLine->appendChild($item);

				$priceLine = $this->createPriceLine($l['price']);
			$invoiceLine->appendChild($priceLine);

			$this->invoice->appendChild($invoiceLine);
		}
	}

	private function createPriceLine($param) {
		$price = $this->doc->createElement('cac:Price');
			$priceAmount = $this->doc->createElement("cbc:PriceAmount", $param['priceAmount']);
			$priceAmount->setAttribute('currencyID', $param['currencyID']);

			$baseQuantity = $this->doc->createElement("cbc:BaseQuantity", $param['baseQuantity']);
			$baseQuantity->setAttribute('unitCode', $param['unitCode'] );

		$price->appendChild($priceAmount);
		$price->appendChild($baseQuantity);

		return $price;
	}

	private function createItemLine($param) {
		$item = $this->doc->createElement('cac:Item');
			$name = $this->doc->createElement("cbc:Name", $param['name']);

			$sellersItemIdentification = $this->doc->createElement('cac:SellersItemIdentification');
				$id = $this->doc->createElement("cbc:ID", $param['idSellersItemIdentification']);
		    $sellersItemIdentification->appendChild($id);

			$commodityClassification = $this->doc->createElement('cac:CommodityClassification');
				$itemClassificationCode = $this->doc->createElement("cbc:ItemClassificationCode", $param['itemClassificationCode']);
				$itemClassificationCode->setAttribute('listID', $param['listID']);
			$commodityClassification->appendChild($itemClassificationCode);

			$classifiedTaxCategory = $this->doc->createElement('cac:ClassifiedTaxCategory');
				$id = $this->doc->createElement("cbc:ID", $param['taxId']);
				$percent = $this->doc->createElement("cbc:Percent", $param['taxPercent']);
				$taxScheme = $this->createTaxScheme($param['vatId']);

			$classifiedTaxCategory->appendChild($id);
			$classifiedTaxCategory->appendChild($percent);
			$classifiedTaxCategory->appendChild($taxScheme);


		$item->appendChild($name);
		$item->appendChild($sellersItemIdentification);
		$item->appendChild($commodityClassification);
		$item->appendChild($classifiedTaxCategory);

		return $item;
	}

	private function createAllowanceCharge($param) {
		$allowanceCharge = $this->doc->createElement('cac:AllowanceCharge');
		$chargeIndicator = $this->doc->createElement("cbc:ChargeIndicator", $param['chargeIndicator']);
		$allowanceChargeReasonCode = $this->doc->createElement("cbc:AllowanceChargeReasonCode", $param['allowanceChargeReasonCode']);
		$allowanceChargeReason = $this->doc->createElement("cbc:AllowanceChargeReason", $param['allowanceChargeReason']);
		$amount = $this->doc->createElement("cbc:Amount", $param['amount']);
		$amount->setAttribute('currencyID', $param['currency']);

		$allowanceCharge->appendChild($chargeIndicator);
		$allowanceCharge->appendChild($allowanceChargeReasonCode);
		$allowanceCharge->appendChild($allowanceChargeReason);
		$allowanceCharge->appendChild($amount);

		if (isset($param['baseAmount'])) {
			$baseAmount = $this->doc->createElement("cbc:BaseAmount", $param['baseAmount']);
			$baseAmount->setAttribute('currencyID', $param['currency']);
			$allowanceCharge->appendChild($baseAmount);
		}

		return $allowanceCharge;
	}

	private function createInvoiceLine($param) {

		if (!isset($param['id'])) {
			debug($param);
		}

		$invoiceLine = $this->doc->createElement('cac:InvoiceLine');

		$id = $this->doc->createElement("cbc:ID", $param['id']);
		$invoicedQuantity = $this->doc->createElement("cbc:InvoicedQuantity", $param['invoicedQuantity']);
		$invoicedQuantity->setAttribute('unitCode', $param['unitCode']);
		$lineExtensionAmount = $this->doc->createElement("cbc:LineExtensionAmount", $param['lineExtensionAmount']);
		$lineExtensionAmount->setAttribute('currencyID', $param['currency']);

		$invoiceLine->appendChild($id);
		$invoiceLine->appendChild($invoicedQuantity);
		$invoiceLine->appendChild($lineExtensionAmount);

		return $invoiceLine;
	}

	public function createLegalMonetaryTotal($pLineExtensionAmount, $pTaxExclusiveAmount, $pTaxInclusiveAmount, $pPayableAmount, $currency) {
		$legalMonetaryTotal = $this->doc->createElement('cac:LegalMonetaryTotal');

		$lineExtensionAmount = $this->doc->createElement("cbc:LineExtensionAmount", $pLineExtensionAmount);
		$taxExclusiveAmount = $this->doc->createElement("cbc:TaxExclusiveAmount", $pTaxExclusiveAmount);
		$taxInclusiveAmount = $this->doc->createElement("cbc:TaxInclusiveAmount", $pTaxInclusiveAmount);
		$payableAmount = $this->doc->createElement("cbc:PayableAmount", $pPayableAmount);

		$lineExtensionAmount->setAttribute('currencyID', $currency);
		$taxExclusiveAmount->setAttribute('currencyID', $currency);
		$taxInclusiveAmount->setAttribute('currencyID', $currency);
		$payableAmount->setAttribute('currencyID', $currency);

		$legalMonetaryTotal->appendChild($lineExtensionAmount);
		$legalMonetaryTotal->appendChild($taxExclusiveAmount);
		$legalMonetaryTotal->appendChild($taxInclusiveAmount);
		$legalMonetaryTotal->appendChild($payableAmount);

		$this->invoice->appendChild($legalMonetaryTotal);
	}

	public function createTaxTotal($taxAmount, $curreency, $taxSubTotal) {
		$taxTotal = $this->doc->createElement('cac:TaxTotal');
		$taxAmount = $this->doc->createElement("cbc:TaxAmount", $taxAmount);
		$taxAmount->setAttribute('currencyID', $curreency);

		$taxTotal->appendChild($taxAmount);

		foreach ($taxSubTotal as $sTax) {
			$tst = $this->createTaxSubtotal($sTax);

			$taxTotal->appendChild($tst);
		}

		$this->invoice->appendChild($taxTotal);
	}

	private function createTaxSubtotal($param) {
		$taxSubtotal = $this->doc->createElement('cac:TaxSubtotal');
		$taxableAmount = $this->doc->createElement("cbc:TaxableAmount", $param['taxableAmount']);
		$taxableAmount->setAttribute('currencyID', $param['currency']);

		$taxAmount = $this->doc->createElement("cbc:TaxAmount", $param['taxAmount']);
		$taxAmount->setAttribute('currencyID', $param['currency']);

		$taxSubtotal->appendChild($taxableAmount);
		$taxSubtotal->appendChild($taxAmount);

		$taxCategory = $this->doc->createElement('cac:TaxCategory');
		$id = $this->doc->createElement("cbc:ID", $param['taxCategoryId']);
		$percent = $this->doc->createElement("cbc:Percent", $param['percent']);

		$taxCategory->appendChild($id);
		$taxCategory->appendChild($percent);
		$taxScheme = $this->createTaxScheme($param['vatID']);
		$taxCategory->appendChild($taxScheme);

		$taxSubtotal->appendChild($taxCategory);
		return $taxSubtotal;
	}

	public function createPaymentMeans($param) {
		$paymentMeans = $this->doc->createElement('cac:PaymentMeans');
		$paymentMeansCode = $this->doc->createElement("cbc:PaymentMeansCode", $param['paymentMeansCode']);

		$paymentMeans->appendChild($paymentMeansCode);

		$payeeFinancialAccount = $this->doc->createElement('cac:PayeeFinancialAccount');
		$id = $this->doc->createElement("cbc:ID", $param['ibanId']);
		$payeeFinancialAccount->appendChild($id);

		$paymentMeans->appendChild($payeeFinancialAccount);

		$this->invoice->appendChild($paymentMeans);
	}

	public function createAccountingCustomerParty($paramCustomer, $paramTax) {
		$accountingCustomerParty = $this->doc->createElement('cac:AccountingCustomerParty');
		$party = $this->doc->createElement('cac:Party');

		$partyIdentification = $this->doc->createElement('cac:PartyIdentification');
		$id = $this->doc->createElement("cbc:ID", $paramCustomer['partyId']);
		$partyIdentification->appendChild($id);

		$party->appendChild($partyIdentification);

		$partyName = $this->doc->createElement('cac:PartyName');
		$name = $this->doc->createElement("cbc:Name", $paramCustomer['name']);
		$partyName->appendChild($name);

		$party->appendChild($partyName);

		$postalAddress = $this->doc->createElement('cac:PostalAddress');
		$streetName = $this->doc->createElement("cbc:StreetName", $paramCustomer['streetName']);
		$cityName = $this->doc->createElement("cbc:CityName", $paramCustomer['cityName']);
		$postalZone = $this->doc->createElement("cbc:PostalZone", $paramCustomer['postalZone']);
		$countrySubentity = $this->doc->createElement("cbc:CountrySubentity", $paramCustomer['countrySubentity']);

		$country = $this->doc->createElement('cac:Country');
		$identificationCode = $this->doc->createElement("cbc:IdentificationCode", $paramCustomer['countryCode']);
		$country->appendChild($identificationCode);

		$postalAddress->appendChild($streetName);
		$postalAddress->appendChild($cityName);
		$postalAddress->appendChild($postalZone);
		$postalAddress->appendChild($countrySubentity);
		$postalAddress->appendChild($country);

		$party->appendChild($postalAddress);
		$party->appendChild($this->createPartyTax($paramTax));

		$partyLegalEntity = $this->doc->createElement('cac:PartyLegalEntity');
		$registrationName = $this->doc->createElement("cbc:RegistrationName", $paramTax['partyLegalEntity']['registrationName']);
		$companyID = $this->doc->createElement("cbc:CompanyID", $paramTax['partyLegalEntity']['companyID']);
		$partyLegalEntity->appendChild($registrationName);
		$partyLegalEntity->appendChild($companyID);

		$party->appendChild($partyLegalEntity);

		$accountingCustomerParty->appendChild($party);
		$this->invoice->appendChild($accountingCustomerParty);
	}

	public function createAccountingSupplierParty($paramSuplier, $paramTax) {

		$accountingSupplierParty = $this->doc->createElement('cac:AccountingSupplierParty');
		$party = $this->doc->createElement('cac:Party');

		/*
			$partyName = $this->doc->createElement('cac:PartyName');
			$name = $this->doc->createElement("cbc:Name", $paramSuplier['name']);
			$partyName->appendChild($name);
			$party->appendChild($partyName);
		*/

		$postalAddress = $this->doc->createElement('cac:PostalAddress');
			$streetName = $this->doc->createElement("cbc:StreetName", $paramSuplier['streetName']);
			$postalAddress->appendChild($streetName);

			$cityName = $this->doc->createElement("cbc:CityName", $paramSuplier['cityName']);
			$postalAddress->appendChild($cityName);

			if(empty($paramSuplier['postalZone'])){
				$postalZone = $this->doc->createElement("cbc:PostalZone", $paramSuplier['postalZone']);
				$postalAddress->appendChild($postalZone);
			}

			$countrySubentity = $this->doc->createElement("cbc:CountrySubentity", $paramSuplier['countrySubentity']);
			$postalAddress->appendChild($countrySubentity);

			$country = $this->doc->createElement('cac:Country');
				$identificationCode = $this->doc->createElement("cbc:IdentificationCode", $paramSuplier['countryCode']);
			$country->appendChild($identificationCode);
			$postalAddress->appendChild($country);

		$party->appendChild($postalAddress);


		$party->appendChild($this->createPartyTax($paramTax));

		$partyLegalEntity = $this->doc->createElement('cac:PartyLegalEntity');
			$registrationName = $this->doc->createElement("cbc:RegistrationName", $paramTax['partyLegalEntity']['registrationName']);
			$partyLegalEntity->appendChild($registrationName);

			$elCompanyId = $this->doc->createElement("cbc:CompanyID", $paramTax['companyID']);
			$partyLegalEntity->appendChild($elCompanyId);

			$companyLegalForm = $this->doc->createElement("cbc:CompanyLegalForm", $paramTax['partyLegalEntity']['companyLegalForm']);
			$partyLegalEntity->appendChild($companyLegalForm);
			
		$party->appendChild($partyLegalEntity);

		$party->appendChild($this->createPartyContact( $paramSuplier['contactName'], $paramSuplier['contactTelephone'],  $paramSuplier['contactElectronicMail']));

		$accountingSupplierParty->appendChild($party);

		$this->invoice->appendChild($accountingSupplierParty);
	}

	private function createPartyContact($name, $tel, $email) {
		$contact = $this->doc->createElement('cac:Contact');
			$elName = $this->doc->createElement("cbc:Name", $name);
		$contact->appendChild($elName);	
			$elTel = $this->doc->createElement("cbc:Telephone", $tel);
		$contact->appendChild($elTel);		
			$electronicMail = $this->doc->createElement("cbc:ElectronicMail", $email);
		$contact->appendChild($electronicMail);

		return $contact;
	}

	private function createTaxScheme($vatId) {
		$taxScheme = $this->doc->createElement('cac:TaxScheme');
		$taxSchemeID = $this->doc->createElement("cbc:ID", $vatId);
		$taxScheme->appendChild($taxSchemeID);

		return $taxScheme;
	}

	private function createPartyTax($paramTax) {

		$partyTaxScheme = $this->doc->createElement('cac:PartyTaxScheme');

		$companyID = $this->doc->createElement("cbc:CompanyID", $paramTax['companyID']);
		$taxScheme = $this->createTaxScheme($paramTax['taxSchemeId']);

		$partyTaxScheme->appendChild($companyID);
		$partyTaxScheme->appendChild($taxScheme);

		return $partyTaxScheme;
	}

	public function printXml() {
		$xml_string = $this->doc->saveXML();
		return $xml_string;

	}
	


}
