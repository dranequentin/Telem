<?php
if (!isset($viewData['isDelete'])){?>
    <p class="productCard_actions">
        <a href="suppression-produit.php?id=<?php echo $product['idProduit']; ?>" class="button --danger --confirm">Supprimer</a>
    </p>
<?php } ?>