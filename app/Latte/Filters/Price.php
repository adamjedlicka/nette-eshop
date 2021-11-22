<?php

namespace App\Latte\Filters;

class Price
{
    public function __invoke($price, $currency = 'CZK')
    {
        switch ($currency) {
            case 'CZK':
                return number_format($price / 100, 0, '.', ' ') . ',-';
                break;

            default:
                return number_format($price / 100, 0, '.', ' ') . ',-';
                break;
        }
    }
}
