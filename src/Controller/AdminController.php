<?php
declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Util\Csv;

final class AdminController
{
    public function exporterTout(): void
    {
        $lignes = Database::connexion()->query('SELECT * FROM adherents')->fetchAll();
        header('Content-Type: text/csv');
        echo Csv::encoder($lignes);
    }
}
