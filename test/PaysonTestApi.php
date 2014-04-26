<?php
namespace PaysonAPI\test;

class PaysonTestApi extends PaysonApi
{
    const PAYSON_WWW_HOST = "test-www.payson.se";
    
    public function __construct($credentials) {
        parent::__construct($credentials);
    }
}
?>
