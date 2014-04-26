<?php
namespace PaysonAPI;

class CurrencyCode 
{
    const SEK = "SEK";
    const EUR = "EUR";

    public static function ConstantToString($value) 
    {
        switch (strtoupper($value)) {
            case self::SEK:
                    return self::SEK;
            case self::EUR:
                return self::EUR;
            default:
                throw new PaysonApiException("Invalid currency: $value");
        }
    }
}
?>
