<?php
namespace PaysonAPI;

class CurrencyCode 
{
    const SEK = "SEK";
    const EUR = "EUR";

    public static function ConstantToString($value) {
        switch (strtoupper($value)) {
            case "SEK":
                return "SEK";
            case "EUR":
                return "EUR";
            default:
                throw new PaysonApiException("Invalid constant");
        }
    }
}
?>
