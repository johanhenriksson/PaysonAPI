<?php
namespace PaysonAPI;

class PaymentUpdateMethod 
{
    const CancelOrder = 0;
    const ShipOrder = 1;
    const CreditOrder = 2;
    const Refund = 3;

    public static function ConstantToString($value) {
        switch ($value) {
            case self::CancelOrder:
                return "CANCELORDER";
            case self::ShipOrder:
                return "SHIPORDER";
            case self::CreditOrder:
                return "CREDITORDER";
            case self::Refund:
                return "REFUND";
            default:
                throw new PaysonApiException("Invalid constant");
        }
    }
}
?>
