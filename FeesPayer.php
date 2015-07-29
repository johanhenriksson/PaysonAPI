<?php
namespace PaysonAPI;

class FeesPayer 
{
    const SENDER          = "SENDER";
    const PRIMARYRECEIVER = "PRIMARYRECEIVER";
    const EACHRECEIVER    = "EACHRECEIVER";
    const SECONDARYONLY   = "SECONDARYONLY";

    public static function ConstantToString($value) 
    {
        switch (strtoupper($value)) {
            case self::SENDER:          return self::SENDER;
            case self::PRIMARYRECEIVER: return self::PRIMARYRECEIVER;
            case self::EACHRECEIVER:    return self::EACHRECEIVER;
            case self::SECONDARYONLY:   return self::SECONDARYONLY;
            default:
                throw new PaysonApiException("Invalid fee's payer $value");
        }
    }
}
?>
