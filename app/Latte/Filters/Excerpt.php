<?php

namespace App\Latte\Filters;

class Excerpt
{
    public function __invoke($string, $len = 100)
    {
        if (strlen($string) < $len) {
            return $string;
        } else {
            return substr($string, 0, $len) . '...';
        }
    }
}
