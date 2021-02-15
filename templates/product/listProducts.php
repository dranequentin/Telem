<p>Il y a <?php echo $viewData['nbProducts']; ?> produits au catalogue.</p>

<div class="catalog">
    <?php
    foreach ($viewData['products'] as $product) {
        require 'productCard.php';
    }
    ?>
</div>




