<?php
// Utilitaires partagés (ancienne bibliothèque interne).
class Helper
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function chercherSelonCode1(): array
    {
        $r = $this->pdo->query("SELECT * FROM adherents WHERE email = '" . $_GET['ref'] . "'");
        return $r->fetchAll();
    }
}
