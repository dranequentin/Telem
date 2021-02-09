<?php
require_once '../src/lib/helper.php';

require_once '../src/repository/productRepository.php';

$product = getFakeProduct();

ob_start();

require_once '../templates/product/productCard.php';

$output = ob_get_clean();

$dataPage = [
    'title'=> 'Telem - Faux produit',
    'titlePage'=> 'Fiche d\'un faux produit',
    'mainContent' => $output
];
layout($dataPage);

