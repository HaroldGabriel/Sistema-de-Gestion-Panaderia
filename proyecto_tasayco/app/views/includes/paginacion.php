<div class="paginacion">
    <p>Pagina Nº <?= $pagina ?> de <?= $total_paginas ?></p>
    <?php if ($pagina > 1): ?>
        <form method="post" style="display:inline;">
            <input type="hidden" name="action" value='<?php echo $ruta; ?>'>
            <input type="hidden" name="pagina" value="<?= $pagina - 1 ?>">
            <button type="submit">« Anterior</button>
        </form>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
        <form method="post" style="display:inline;">
            <input type="hidden" name="action" value="<?php echo $ruta; ?>">
            <input type="hidden" name="pagina" value="<?= $i ?>">
            <button type="submit" <?= $i == $pagina ? 'style="font-weight:bold;"' : '' ?>><?= $i ?></button>
        </form>
    <?php endfor; ?>

    <?php if ($pagina < $total_paginas): ?>
        <form method="post" style="display:inline;">
            <input type="hidden" name="action" value="<?php echo $ruta; ?>">
            <input type="hidden" name="pagina" value="<?= $pagina + 1 ?>">
            <button type="submit">Siguiente »</button>
        </form>
    <?php endif; ?>           
</div>