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
		

			$this->invoice->appendChild($invoiceLine);
		}
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
		$invoiceLine = $this->doc->createElement('cac:InvoiceLine');

		$id = $this->doc->createElement("cbc:ID", $param['id']);
		$invoiceLine->appendChild($id);

		$invoicedQuantity = $this->doc->createElement("cbc:InvoicedQuantity", $param['invoicedQuantity']);
		$invoicedQuantity->setAttribute('unitCode', $param['invoicedQuantityUnitCode']);
		$invoiceLine->appendChild($invoicedQuantity);
		
		$lineExtensionAmount = $this->doc->createElement("cbc:LineExtensionAmount", $param['lineExtensionAmount']);
		$lineExtensionAmount->setAttribute('currencyID', $param['currency']);

		$invoiceLine->appendChild($lineExtensionAmount);


		// line
		$elItem = $this->doc->createElement('cac:Item');
			$name = $this->doc->createElement("cbc:Name", $param['name']);
			$elItem->appendChild($name);

			$elClassifiedTaxCategory = $this->doc->createElement('cac:ClassifiedTaxCategory');
				$elId = $this->doc->createElement("cbc:ID", $param['classifiedTaxCategoryID']);
				$elClassifiedTaxCategory->appendChild($elId);				

		$elItem->appendChild($elClassifiedTaxCategory);

		$invoiceLine->appendChild($elItem);


			// price
			$elPrice = $this->doc->createElement('cac:Price');
				$elPriceAmount = $this->doc->createElement("cbc:PriceAmount", $param['priceAmount']);
			$elPrice->appendChild($elPriceAmount);				
	

		$invoiceLine->appendChild($elPrice);
		
		return $invoiceLine;
	}

	public function createLegalMonetaryTotal($total) {
		$legalMonetaryTotal = $this->doc->createElement('cac:LegalMonetaryTotal');

		$lineExtensionAmount = $this->doc->createElement("cbc:LineExtensionAmount", $total['lineExtensionAmount']);
		$lineExtensionAmount->setAttribute('currencyID',$total['currency']);

		$taxExclusiveAmount = $this->doc->createElement("cbc:TaxExclusiveAmount", $total['taxExclusiveAmount']);
		$taxExclusiveAmount->setAttribute('currencyID', $total['currency']);

		$taxInclusiveAmount = $this->doc->createElement("cbc:TaxInclusiveAmount", $total['taxInclusiveAmount']);
		$taxInclusiveAmount->setAttribute('currencyID', $total['currency']);

		$payableAmount = $this->doc->createElement("cbc:PayableAmount", $total['payableAmount']);
		$payableAmount->setAttribute('currencyID', 		$total['currency']);

		$legalMonetaryTotal->appendChild($lineExtensionAmount);
		$legalMonetaryTotal->appendChild($taxExclusiveAmount);
		$legalMonetaryTotal->appendChild($taxInclusiveAmount);
		$legalMonetaryTotal->appendChild($payableAmount);

		$this->invoice->appendChild($legalMonetaryTotal);
	}

	public function createTaxTotal($param) {

		$taxTotal = $this->doc->createElement('cac:TaxTotal');

		$taxAmount = $this->doc->createElement("cbc:TaxAmount", $param['taxAmount']);
		$taxAmount->setAttribute('currencyID', $param['currency']);

		foreach ($param['subTotal'] as $subtotal) {
			$taxSubtotal = $this->createTaxSubtotal($subtotal);	
			$taxTotal->appendChild($taxSubtotal);
		}
		
		$taxTotal->appendChild($taxAmount);
	

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
		$percent = $this->doc->createElement("cbc:Percent", $param['taxCategoryIdPercent']);

		$taxCategory->appendChild($id);
		$taxCategory->appendChild($percent);
		$taxScheme = $this->createTaxScheme($param['taxCategoryId']);
		$taxCategory->appendChild($taxScheme);

		$taxSubtotal->appendChild($taxCategory);
		return $taxSubtotal;
	}

	public function createPaymentMeans($param) {
		$paymentMeans = $this->doc->createElement('cac:PaymentMeans');
			$paymentMeansCode = $this->doc->createElement("cbc:PaymentMeansCode", $param['paymentMeansCode']);

		$paymentMeans->appendChild($paymentMeansCode);

		/*
			$payeeFinancialAccount = $this->doc->createElement('cac:PayeeFinancialAccount');
				$id = $this->doc->createElement("cbc:ID", $param['ibanId']);
				$payeeFinancialAccount->appendChild($id);
			$paymentMeans->appendChild($payeeFinancialAccount);
		*/

		$this->invoice->appendChild($paymentMeans);
	}

	public function createAccountingCustomerParty($paramCustomer, $paramTax) {
		$accountingCustomerParty = $this->doc->createElement('cac:AccountingCustomerParty');
		$party = $this->doc->createElement('cac:Party');

		/*
				$partyIdentification = $this->doc->createElement('cac:PartyIdentification');
				$id = $this->doc->createElement("cbc:ID", $paramCustomer['partyId']);
				$partyIdentification->appendChild($id);
				$party->appendChild($partyIdentification);

				$partyName = $this->doc->createElement('cac:PartyName');
				$name = $this->doc->createElement("cbc:Name", $paramCustomer['name']);
				$partyName->appendChild($name);
			$party->appendChild($partyName);
		*/

		

		$postalAddress = $this->doc->createElement('cac:PostalAddress');
			$streetName = $this->doc->createElement("cbc:StreetName", $paramCustomer['streetName']);
			$postalAddress->appendChild($streetName);

			$cityName = $this->doc->createElement("cbc:CityName", $paramCustomer['cityName']);
			$postalAddress->appendChild($cityName);

			if(!empty($paramSuplier['postalZone'])){
				$postalZone = $this->doc->createElement("cbc:PostalZone", $paramCustomer['postalZone']);
				$postalAddress->appendChild($postalZone);
			}

			$countrySubentity = $this->doc->createElement("cbc:CountrySubentity", $paramCustomer['countrySubentity']);
			$postalAddress->appendChild($countrySubentity);

			$country = $this->doc->createElement('cac:Country');
				$postalAddress->appendChild($country);
				$identificationCode = $this->doc->createElement("cbc:IdentificationCode", $paramCustomer['countryCode']);
			$country->appendChild($identificationCode);

		$party->appendChild($postalAddress);



		$party->appendChild($this->createPartyTax($paramTax));

		$partyLegalEntity = $this->doc->createElement('cac:PartyLegalEntity');
		$registrationName = $this->doc->createElement("cbc:RegistrationName", $paramTax['partyLegalEntity']['registrationName']);
		$companyID = $this->doc->createElement("cbc:CompanyID", $paramTax['companyID']);
		$partyLegalEntity->appendChild($registrationName);
		$partyLegalEntity->appendChild($companyID);

		$party->appendChild($partyLegalEntity);


		$party->appendChild($this->createPartyContact( $paramCustomer['contactName'], $paramCustomer['contactTelephone'],  $paramCustomer['contactElectronicMail'] ));


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

			if(!empty($paramSuplier['postalZone'])){
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

		// $party->appendChild($this->createPartyContact( $paramSuplier['contactName'], $paramSuplier['contactTelephone'],  $paramSuplier['contactElectronicMail']));
		// $accountingSupplierParty->appendChild($party);

		$this->invoice->appendChild($accountingSupplierParty);
	}

	private function createPartyContact($name, $tel, $email) {
		$contact = $this->doc->createElement('cac:Contact');

			if(!empty($name)){
				$elName = $this->doc->createElement("cbc:Name", $name);
				$contact->appendChild($elName);	
			}

			if(!empty($tel)){
				$elTel = $this->doc->createElement("cbc:Telephone", $tel);
				$contact->appendChild($elTel);		
			}

			if(!empty($email)){
				$electronicMail = $this->doc->createElement("cbc:ElectronicMail", $email);
				$contact->appendChild($electronicMail);
			}

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
