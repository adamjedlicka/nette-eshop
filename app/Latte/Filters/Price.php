<?php

namespace App\Latte\Filters;

class Price
{
    public function __invoke($price)
    {
        return '$' . number_format($price / 100, 2, '.', ' ');
    }
}
