<?php
namespace PaysonAPI;

class GuaranteeOffered 
{
    const OPTIONAL = "OPTIONAL";
    const REQUIRED = "REQUIRED";
    const NO = "NO";

    public static function ConstantToString($value) 
    {
        switch (strtoupper($value)) {
            case self::OPTIONAL: return self::OPTIONAL;
            case self::REQUIRED: return self::REQUIRED;
            case self::NO:       return self::NO;
        }
    }
}
?>
