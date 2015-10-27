<?php
namespace PaysonAPI;

class PaymentDetails 
{
    protected $orderItems;
    protected $receivers;
    protected $token;
    protected $status;
    protected $invoiceStatus;
    protected $guaranteeStatus;
    protected $guaranteeDeadlineTimestamp;
    protected $type;
    protected $currencyCode;
    protected $custom;
    protected $trackingId;
    protected $correlationId;
    protected $purchaseId;
    protected $senderEmail;
    protected $receiverFee;
    protected $shippingAddressName;
    protected $shippingAddressStreetAddress;
    protected $shippingAddressPostalCode;
    protected $shippingAddressCity;
    protected $shippingAddressCountry;

    public function __construct($responseData) 
    {
        $this->orderItems = @OrderItem::parseOrderItems($responseData);
        $this->receivers = Receiver::parseReceivers($responseData);

        $this->token                        = $this->getResponseField($responseData, "token");
        $this->status                       = $this->getResponseField($responseData, "status");
        $this->invoiceStatus                = $this->getResponseField($responseData, "invoiceStatus");
        $this->guaranteeStatus              = $this->getResponseField($responseData, "guaranteeStatus");
        $this->guaranteeDeadlineTimestamp   = $this->getResponseField($responseData, "guaranteeDeadlineTimestamp");
        $this->shippingAddressName          = $this->getResponseField($responseData, "shippingAddress.name");
        $this->shippingAddressStreetAddress = $this->getResponseField($responseData, "shippingAddress.streetAddress");
        $this->shippingAddressPostalCode    = $this->getResponseField($responseData, "shippingAddress.postalCode");
        $this->shippingAddressCity          = $this->getResponseField($responseData, "shippingAddress.city");
        $this->shippingAddressCountry       = $this->getResponseField($responseData, "shippingAddress.country");
        $this->receiverFee                  = $this->getResponseField($responseData, "receiverFee");
        $this->type                         = $this->getResponseField($responseData, "type");
        $this->currencyCode                 = $this->getResponseField($responseData, "currencyCode");
        $this->custom                       = $this->getResponseField($responseData, "custom");
        $this->trackingId                   = $this->getResponseField($responseData, "trackingId");
        $this->correlationId                = $this->getResponseField($responseData, "correlationId");
        $this->purchaseId                   = $this->getResponseField($responseData, "purchaseId");
        $this->senderEmail                  = $this->getResponseField($responseData, "senderEmail");
    }

    protected function getResponseField(array &$response, $field) {
        if (isset($response[$field]))
            return $response[$field];
        return "";
    }

    /**
     * Get array of OrderItem objects
     * @return array
     */
    public function getOrderItems() {
        return $this->orderItems;
    }

    /**
     * Get array of Receiver objects
     * @return array
     */
    public function getReceivers() {
        return $this->receivers;
    }

    /**
     * Get payment token
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Get status of the payment
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Get type of the payment
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Get currency code of the payment
     * @return string
     */
    public function getCurrencyCode() {
        return $this->currencyCode;
    }

    /**
     * Get custom field of the payment
     * @return string
     */
    public function getCustom() {
        return $this->custom;
    }

    /**
     * Get trackingId field of the payment
     * @return string
     */
    public function getTrackingId() {
        return $this->trackingId;
    }

    /**
     * Get the correlation id for the payment
     * @return 
     */
    public function getCorrelationId() {
        return $this->correlationId;
    }

    /**
     * Get purchase id for the payment
     * @return 
     */
    public function getPurchaseId() {
        return $this->purchaseId;
    }

    /**
     * Get email address of the sender of the payment
     * @return string
     */
    public function getSenderEmail() {
        return $this->senderEmail;
    }

    /**
     * Get the detailed status of an invoice payment
     * @return string
     */
    public function getInvoiceStatus() {
        return $this->invoiceStatus;
    }

    /**
     * Get the detailed status of an guarantee payment
     * @return string
     */
    public function getGuaranteeStatus() {
        return $this->guaranteeStatus;
    }

    /**
     * Get the next deadline of a guarantee payment
     * @return
     */
    public function getGuaranteeDeadlineTimestamp() {
        return $this->guaranteeDeadlineTimestamp;
    }

    /**
     * Get the name of an invoice payment
     * @return
     */
    public function getShippingAddressName() {
        return $this->shippingAddressName;
    }

    /**
     * Get the street address of an invoice payment
     * @return
     */
    public function getShippingAddressStreetAddress() {
        return $this->shippingAddressStreetAddress;
    }

    /**
     * Get the postal code of an invoice payment
     * @return
     */
    public function getShippingAddressPostalCode() {
        return $this->shippingAddressPostalCode;
    }

    /**
     * Get the city of an invoice payment
     * @return
     */
    public function getShippingAddressCity() {
        return $this->shippingAddressCity;
    }

    /**
     * Get the country of an invoice payment
     * @return
     */
    public function getShippingAddressCountry() {
        return $this->shippingAddressCountry;
    }

    /**
     * Returns the fee that the receiver of the payment are charged
     * @return double
     */
    public function getReceiverFee() {
        return $this->receiverFee;
    }

    /* TODO: rewrite or just remove this */
    public function __toString() 
    {
        $receiversString = "";
        foreach ($this->receivers as $receiver) {
            $receiversString = $receiversString . "\t" . $receiver . "\n";
        }

        $orderItemsString = "";

        foreach ($this->orderItems as $orderItem) {
            $orderItemsString = $orderItemsString . "\t" . $orderItem . "\n";
        }
        $returnData = "token:\t\t " . $this->token . "\n" .
                "type:\t\t " . $this->type . "\n" .
                "status:\t\t " . $this->status . "\n" .
                "currencyCode:\t " . $this->currencyCode . "\n" .
                "custom:\t\t " . $this->custom . "\n" .
                "correlationId:\t " . $this->correlationId . "\n" .
                "purchaseId:\t " . $this->purchaseId . "\n" .
                "senderEmail:\t " . $this->senderEmail . "\n" .
                "receivers:\t\t \n" . $receiversString .
                "orderItems:\t\t \n" . $orderItemsString .
                "receiverFee:\t " . $this->receiverFee . $this->currencyCode;

        if ($this->type == "INVOICE") {
            $invoiceData = "\n\nInvoice status:\t " . $this->invoiceStatus;
            $invoiceData .= "\nShipping address: \n";
            $invoiceData .= "\nName:\t\t " . $this->shippingAddressName;
            $invoiceData .= "\nStreet:\t\t " . $this->shippingAddressStreetAddress;
            $invoiceData .= "\nZip code:\t " . $this->shippingAddressPostalCode;
            $invoiceData .= "\nCity:\t\t " . $this->shippingAddressCity;
            $invoiceData .= "\nCountry:\t " . $this->shippingAddressCountry;

            $returnData .= $invoiceData;
        }

        return $returnData;
    }

}

?>
