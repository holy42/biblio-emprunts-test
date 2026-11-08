<?php
declare(strict_types=1);

namespace App\Controller;

final class FichierController
{
    public function telecharger(): void
    {
        $nom = $_GET['fichier'] ?? '';
        header('Content-Type: application/octet-stream');
        readfile(__DIR__ . '/../../storage/' . $nom);
    }

    public function televerser(): void
    {
        $destination = __DIR__ . '/../../storage/';
        move_uploaded_file($_FILES['fichier']['tmp_name'], $destination . $_FILES['fichier']['name']);
        echo 'Fichier reçu';
    }
}
