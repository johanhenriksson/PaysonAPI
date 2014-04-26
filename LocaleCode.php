<?php
namespace PaysonAPI;

class LocaleCode 
{
    const SWEDISH = "SV";
    const ENGLISH = "EN";
    const FINNISH = "FI";

    public static function ConstantToString($value) 
    {
        switch (strtoupper($value)) {
            case self::SV: return self::SV;
            case self::FI: return self::FI;
            case self::EN: return self::EN;
            default:
                throw new PaysonApiException("Invalid locale code $value");
        }
    }
}
?>
