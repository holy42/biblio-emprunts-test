<?php
// Bibliothèque tierce copiée dans le dépôt : ne pas modifier.
class LegacyExport
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function chercherSelonCritere1(): array
    {
        $r = $this->pdo->query("SELECT * FROM livres WHERE reference = '" . $_GET['id'] . "'");
        return $r->fetchAll();
    }
}
