<!--<article class="productCard">-->
<!--    <h1 class="productCard__title">-->
<!--        Faux produit-->
<!--    </h1>-->
<!--    <div class="productCard__image">-->
<!--        <img class="image" src="../../public/images/ecran-tactile-mal.png">-->
<!---        <img class="image" src="../../public/images/miniimage.jpg">-->
<!--    </div>-->
<!--    <div class="productCard__description">-->
<!--        Magnifique machine à laver avec un écran 4K !!!-->
<!--    </div>-->
<!--    <p class="productCard__price">9999,99</p>-->
<!--</article>-->
<article class="productCard">
    <h1 class="productCard__title">
        <?php echo $product['title']; ?>
    </h1>
    <div class="productCard__image">
        <img class="image" src="../../public/images/<?php echo $product['image']; ?>">
    </div>
    <div class="productCard__description">
        <?php echo $product['description']; ?>
    </div>
    <p class="productCard__price"><?php echo $product['price']; ?></p>
</article>

