<?php if ($lignes !== []): ?>
<ul>
<?php foreach ($lignes as $ligne): ?>
    <li><?= htmlspecialchars($ligne['nom']) ?></li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p>Aucun résultat</p>
