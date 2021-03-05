<?php
/*
 * fichier partiel : fichier appelé par un autre template mais pas directement depuis un contrôleur
 * un fichier partiel est préfixé par un underscore afin de mieux le repérer
 *
 * Bloc permettant de proposer la modification du produit courant
 *
 */

?>
<?php if (!isset($viewData['isCatalog'])) { ?>
    <p class="productCard_actions">
        <a href="demande-de-mise-a-jour-d-un-produit.php?id=<?php echo $product['idProduit']; ?>" class="button --alert">Modifier</a>
    </p>
<?php } ?>


