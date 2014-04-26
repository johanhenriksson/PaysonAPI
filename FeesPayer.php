<?php
namespace PaysonAPI;

class FeesPayer 
{
    const SENDER = "SENDER";
    const PRIMARYRECEIVER = "PRIMARYRECEIVER";
    const EACHRECEIVER = "EACHRECEIVER";
    const SECONDARYONLY = "SECONDARYONLY";

    public static function ConstantToString($value) {
        switch (strtoupper($value)) {
            case "SENDER":
                return "SENDER";
            case "PRIMARYRECEIVER":
                return "PRIMARYRECEIVER";
            case "EACHRECEIVER":
                return "EACHRECEIVER";
            case "SECONDARYONLY":
                return "SECONDARYONLY";
            default:
                throw new PaysonApiException("Invalid constant");
        }
    }
}
?>
