<?php

namespace AppBundle\Traits;

trait MoneyFormatter
{
    public function BRLToDecimal($value)
    {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        $value = doubleval($value);

        return $value;
    }

    public function DecimalToBRL($value)
    {
        $value = number_format($value, 2, ',', '.');

        return $value;
    }
}