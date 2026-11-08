<?php
declare(strict_types=1);

namespace App\Util;

final class Csv
{
    /** @param array<int, array<string, mixed>> $lignes */
    public static function encoder(array $lignes): string
    {
        if ($lignes === []) {
            return '';
        }
        $flux = fopen('php://temp', 'r+');
        fputcsv($flux, array_keys($lignes[0]));
        foreach ($lignes as $ligne) {
            fputcsv($flux, $ligne);
        }
        rewind($flux);
        $texte = stream_get_contents($flux);
        fclose($flux);
        return (string) $texte;
    }
}
