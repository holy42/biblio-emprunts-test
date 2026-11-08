<?php
declare(strict_types=1);

spl_autoload_register(static function (string $classe): void {
    $prefixe = 'App\\';
    if (strncmp($classe, $prefixe, strlen($prefixe)) !== 0) {
        return;
    }
    $chemin = __DIR__ . '/' . str_replace('\\', '/', substr($classe, strlen($prefixe))) . '.php';
    if (is_file($chemin)) {
        require $chemin;
    }
});
