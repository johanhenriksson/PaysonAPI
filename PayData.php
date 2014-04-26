<?php
namespace PaysonAPI;

class PayData 
{
    /* Required fields */
    protected $returnUrl;
    protected $cancelUrl;
    protected $ipnUrl;
    protected $memo;
    protected $sender;
    protected $receivers;

    /* Optional fields */
    protected $localeCode;
    protected $currencyCode;
    protected $orderItems;
    protected $fundingConstraints;
    protected $invoiceFee;
    protected $custom;
    protected $trackingId;
    protected $guaranteeOffered;
    protected $feesPayer;
    protected $showReceiptPage;
    
    public function __construct($returnUrl, $cancelUrl, $ipnUrl, $memo, $sender, $receivers) 
    {
        $this->setReturnUrl($returnUrl);
        $this->setCancelUrl($cancelUrl);
        $this->setIpnUrl($ipnUrl);
        $this->setMemo($memo);
        $this->setSender($sender);
        $this->setReceivers($receivers);
    }
    
    /** Show a custom receipt page: True/False. Default: True */
    public function setShowReceiptPage($flag) {
        $this->showReceiptPage = $flag;
    }

    public function setReturnUrl($url) {
        $this->returnUrl = $url;
    }

    public function setCancelUrl($url) {
        $this->cancelUrl = $url;
    }

    public function setIpnUrl($url) {
        $this->ipnUrl = $url;
    }

    public function setMemo($memo) {
        $this->memo = $memo;
    }

    public function setSender(Sender $sender) {
        $this->sender = $sender;
    }

    public function setReceivers(array $receivers) 
    {
        foreach ($receivers as $receiver) {
            if (get_class($receiver) != 'PaysonAPI\Receiver')
                throw new PaysonApiException("Parameter must be an array of Receivers");
        }
        $this->receivers = $receivers;
    }

    public function setLocaleCode($localeCode) {
        $this->localeCode = $localeCode;
    }

    public function setCurrencyCode($currencyCode) {
        $this->currencyCode = $currencyCode;
    }

    public function setFeesPayer(FeesPayer $feesPayer) {
        $this->feesPayer = $feesPayer;
    }

    public function setOrderItems(array $items) 
    {
        foreach ($items as $item) {
            if (get_class($item) != 'PaysonAPI\OrderItem')
                throw new PaysonApiException("Parameter must be an array of OrderItems");
        }
        $this->orderItems = $items;
    }

    public function setFundingConstraints(array $constraints) {
        $this->fundingConstraints = $constraints;
    }

    /**
     * (Optional) Invoice fee to charge customer 
     * @param type $invoiceFee
     */
    public function setInvoiceFee($invoiceFee) {
        $this->invoiceFee = $invoiceFee;
    }

    /**
     * Can be any string value. This value will be returned in calls to PaymentDetails.
     * @param string $custom
     */
    public function setCustom($custom) {
        $this->custom = $custom;
    }

    /**
     * (Optional) Your own tracking number.
     * @param string $trackingId
     */
    public function setTrackingId($trackingId) {
        $this->trackingId = $trackingId;
    }

    /**
     * (Optional) Indicates whether Payson Guarantee is offered or not.
     * Can be one of the following values; OPTIONAL (default), REQUIRED, NO
     * @param string $guaranteeOffered
     */
    public function setGuaranteeOffered($guaranteeOffered) {
        $this->guaranteeOffered = $guaranteeOffered;
    }

    /**
     * Prepares PayData object for sending by creating an array
     * @return array
     */
    public function getOutput() {
        $output = array();

        $output["returnUrl"] = $this->returnUrl;
        $output["cancelUrl"] = $this->cancelUrl;
        $output["ipnNotificationUrl"] = $this->ipnUrl;
        $output["memo"] = $this->memo;

        if (isset($this->localeCode)) {
            $output["localeCode"] = LocaleCode::ConstantToString($this->localeCode);
        }

        if (isset($this->currencyCode)) {
            $output["currencyCode"] = CurrencyCode::ConstantToString($this->currencyCode);
        }

        $this->sender->addSenderToOutput($output);
        Receiver::addReceiversToOutput($this->receivers, $output);

        OrderItem::addOrderItemsToOutput($this->orderItems, $output);

        if (isset($this->fundingConstraints)) {
            FundingConstraint::addConstraintsToOutput($this->fundingConstraints, $output);

            if (in_array(FundingConstraint::INVOICE, $this->fundingConstraints) and
                    isset($this->invoiceFee)) {
                $output["invoiceFee"] = $this->invoiceFee;
            }
        }

        if (isset($this->custom)) {
            $output["custom"] = $this->custom;
        }

        if (isset($this->trackingId)) {
            $output["trackingId"] = $this->trackingId;
        }

        if (isset($this->feesPayer)) {
            $output["feesPayer"] = FeesPayer::ConstantToString($this->feesPayer);
        }

        if (isset($this->guaranteeOffered)) {
            $output["guaranteeOffered"] = GuaranteeOffered::ConstantToString($this->guaranteeOffered);
        }

        
        if (isset($this->showReceiptPage)) {
            $output["ShowReceiptPage"] = $this->showReceiptPage ? 'true' : 'false';
        }
        
        return $output;
    }
}
?>
