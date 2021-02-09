<?php
require_once '../src/lib/helper.php';
ob_start();
//fiche d'un produit

$output = ob_get_clean();

$dataPage = [
    'title'=> 'Telem - Faux produit',
    'titlePage'=> 'Fiche d\'un faux produit',
    'mainContent' => $output
];
layout($dataPage);

