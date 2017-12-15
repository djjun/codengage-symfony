<?php

namespace AppBundle\Traits;

trait MoneyFormatter
{
    public function BRLToDouble($value)
    {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);
        $value = doubleval($value);

        return $value;
    }

    public function DoubleToBRL($value)
    {
        $value = number_format($value, 2, ',', '.');

        return $value;
    }
}