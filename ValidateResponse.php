<?php
namespace PaysonAPI;

class ValidateResponse 
{
    const VERIFIED = "VERIFIED";

    protected $response;
    protected $paymentDetails;

    public function __construct($paymentDetails, $responseData) 
    {
        $this->paymentDetails = new PaymentDetails($paymentDetails);
        $this->response = $responseData;
    }

    /**
     * Returns true if the request was verified by Payson
     * @return bool
     */
    public function isVerified() {
        return strcmp($this->response, self::VERIFIED) == 0;
    }

    /**
     * Returns the details about the payments.
     * @return PaymentDetails
     */
    public function getPaymentDetails() {
        return $this->paymentDetails;
    }
}
?>
