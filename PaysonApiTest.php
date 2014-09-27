<?php
namespace PaysonAPI;

class PaysonApiTest extends PaysonApi
{
    public function getForwardPayUrl(PayResponse $payResponse) {
        return sprintf($this->protocol, 'test-' . static::PAYSON_WWW_HOST . sprintf(self::PAYSON_WWW_PAY_FORWARD_URL, $payResponse->getToken()));
    }

    protected function getCurlUrl($url) {
        return sprintf($this->protocol, 'test-' . static::PAYSON_API_ENDPOINT . $url);
    }
}
?>
