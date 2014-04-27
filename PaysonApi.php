<?php
namespace PaysonAPI;

class PaysonApi 
{
    const PAYSON_WWW_HOST            = "www.payson.se";
    const PAYSON_WWW_PAY_FORWARD_URL = "/paysecure/?token=%s";

    const PAYSON_API_ENDPOINT = "api.payson.se";
    const PAYSON_API_VERSION  = "1.0";

    const PAYSON_API_PAY_ACTION             = "Pay";
    const PAYSON_API_PAYMENT_DETAILS_ACTION = "PaymentDetails";
    const PAYSON_API_PAYMENT_UPDATE_ACTION  = "PaymentUpdate";
    const PAYSON_API_VALIDATE_ACTION        = "Validate";
    
    protected $credentials;
    protected $protocol; 

    /**
     * Sets up the PaysonAPI with credentials
     * @param PaysonCredentials $credentials
     */
    public function __construct(PaysonCredentials $credentials) 
    {
        $this->credentials = $credentials;
        $this->protocol    = "https://%s";
    }

    /**
     * Initializes a payment
     * @param  PayData $payData PayData-object set up with all necessary parameters
     * @return PayResponse
     */
    public function pay(PayData $payData) 
    {
        $input = $payData->getOutput();
        $postData = NVPCodec::Encode($input);

        $action = sprintf("/%s/%s/", self::PAYSON_API_VERSION, self::PAYSON_API_PAY_ACTION);
        $returnData = $this->doRequest($action, $this->credentials, $postData);

        $decoded = NVPCodec::Decode($returnData);
        return new PayResponse($decoded);
    }

    /**
     * Validate an IPN request
     * @param  string $data The complete unaltered POST data from the IPN request by Payson.
     * @return ValidateResponse object
     */
    public function validate($data) 
    {
        $action = sprintf("/%s/%s/", self::PAYSON_API_VERSION, self::PAYSON_API_VALIDATE_ACTION);
        $returnData = $this->doRequest($action, $this->credentials, $data);

        $decoded = NVPCodec::Decode($data);
        return new ValidateResponse($decoded, $returnData);
    }

    /**
     * Gets details about a payment
     * @param  PaymentDetailsData $paymentDetailsData PaymentDetailsData-object set up with all necessary parameters
     * @return PaymentDetailsResponse object
     */
    public function paymentDetails(PaymentDetailsData $paymentDetailsData) 
    {
        $input = $paymentDetailsData->getOutput();
        $postData = NVPCodec::Encode($input);

        $action = sprintf("/%s/%s/", self::PAYSON_API_VERSION, self::PAYSON_API_PAYMENT_DETAILS_ACTION);
        $returnData = $this->doRequest($action, $this->credentials, $postData);

        $decoded = NVPCodec::Decode($returnData);
        return new PaymentDetailsResponse($decoded);
    }

    /**
     * Take an action on a payment such as ship an order etc.
     * @param  PaymentUpdateData $paymentUpdateData PaymentUpdateData-object set up with all necessary parameters
     * @return PaymentUpdateResponse object
     */
    public function paymentUpdate(PaymentUpdateData $paymentUpdateData) 
    {
        $input = $paymentUpdateData->getOutput();
        $postData = NVPCodec::Encode($input);

        $action = sprintf("/%s/%s/", self::PAYSON_API_VERSION, self::PAYSON_API_PAYMENT_UPDATE_ACTION);
        $returnData = $this->doRequest($action, $this->credentials, $postData);

        $decoded = NVPCodec::Decode($returnData);
        return new PaymentUpdateResponse($decoded);
    }

    /* What does it do? */
    public function sendIpn($token) {
        $input["token"] = $token;
        $postData = NVPCodec::Encode($input);
        $action = "/1.0/SendIPN/";

        $this->doRequest($action, $this->credentials, $postData);
    }

    /**
     * Get the url to forward the customer to for completion of payment
     * @param  PayResponse $payResponse
     * @return string The URL to forward to
     */
    public function getForwardPayUrl(PayResponse $payResponse) {
        return sprintf($this->protocol, static::PAYSON_WWW_HOST . sprintf(self::PAYSON_WWW_PAY_FORWARD_URL, $payResponse->getToken()));
    }

    private function doRequest($url, PaysonCredentials $credentials, $postData) 
    {
        if (!function_exists('curl_exec'))
            throw new PaysonApiException("Curl not installed.");
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $credentials->toHeader());
        curl_setopt($ch, CURLOPT_URL, sprintf($this->protocol, static::PAYSON_API_ENDPOINT . $url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $result = curl_exec($ch);
        if ($result === false) 
            throw new PaysonApiException('Curl error: ' . curl_error($ch));

        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($response_code != 200) 
            throw new PaysonApiException("Remote host responded with HTTP response code: " . $response_code);
        
        return $result;
    }
}
?>
