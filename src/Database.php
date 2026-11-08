<?php
declare(strict_types=1);

namespace App;

final class Database
{
    private static ?\PDO $pdo = null;

    public static function connexion(): \PDO
    {
        if (self::$pdo === null) {
            $cfg = require __DIR__ . '/../config/config.php';
            self::$pdo = new \PDO($cfg['dsn'], $cfg['utilisateur'], $cfg['mot_de_passe'], [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
        }
        return self::$pdo;
    }
}
