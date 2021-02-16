<p>Il y a <?php echo $viewData['nbProducts']; ?> produits au catalogue.</p>

<div class="catalog">
    <?php
    foreach ($viewData['products'] as $product) {
    ?>
    <a title="cliquez pour voir la fiche" class="wrapBlockLink" href="/public/fiche-produit.php?id=<?php echo $product['idProduit']; ?>">
        <?php

        require 'productCard.php';

        }
        ?>
    </a>
</div>




