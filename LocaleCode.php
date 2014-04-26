<?php
namespace PaysonAPI;

class LocaleCode 
{
    const SWEDISH = "SV";
    const ENGLISH = "EN";
    const FINNISH = "FI";

    public static function ConstantToString($value) {
        switch (strtoupper($value)) {
            case "SV":
                return "SV";
            case "FI":
                return "FI";
            case "EN":
                return "EN";
            default:
                throw new PaysonApiException("Invalid constant");
        }
    }
}
?>
