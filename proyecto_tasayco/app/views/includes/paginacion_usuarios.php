<div class="paginacion">
    <p>Página Nº <?= $pagina ?> de <?= $total_paginas ?></p>
    <?php if ($pagina > 1): ?>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="pagina" value="<?= $pagina - 1 ?>">
            <input type="hidden" name="buscar_id" value="<?= htmlspecialchars($buscar_id) ?>">
            <input type="hidden" name="buscar_nombre" value="<?= htmlspecialchars($buscar_nombre) ?>">
            <input type="hidden" name="filtro_stock" value="<?= htmlspecialchars($filtro_stock) ?>">
            <input type="hidden" name="fecha" value="<?= htmlspecialchars($fecha) ?>">
            <button type="submit">« Anterior</button>
        </form>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="pagina" value="<?= $i ?>">
            <input type="hidden" name="buscar_id" value="<?= htmlspecialchars($buscar_id) ?>">
            <input type="hidden" name="buscar_nombre" value="<?= htmlspecialchars($buscar_nombre) ?>">
            <input type="hidden" name="filtro_stock" value="<?= htmlspecialchars($filtro_stock) ?>">
            <input type="hidden" name="fecha" value="<?= htmlspecialchars($fecha) ?>">
            <button type="submit" <?= $i == $pagina ? 'style="font-weight:bold;"' : '' ?>><?= $i ?></button>
        </form>
    <?php endfor; ?>

    <?php if ($pagina < $total_paginas): ?>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="pagina" value="<?= $pagina + 1 ?>">
            <input type="hidden" name="buscar_id" value="<?= htmlspecialchars($buscar_id) ?>">
            <input type="hidden" name="buscar_nombre" value="<?= htmlspecialchars($buscar_nombre) ?>">
            <input type="hidden" name="filtro_stock" value="<?= htmlspecialchars($filtro_stock) ?>">
            <input type="hidden" name="fecha" value="<?= htmlspecialchars($fecha) ?>">
            <button type="submit">Siguiente »</button>
        </form>
    <?php endif; ?>
</div>