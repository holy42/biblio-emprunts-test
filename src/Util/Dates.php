<?php
declare(strict_types=1);

namespace App\Util;

final class Dates
{
    public static function formater(int $timestamp): string
    {
        return strftime('%d/%m/%Y', $timestamp);
    }

    public static function aujourdhui(): string
    {
        return date('Y-m-d');
    }
}
