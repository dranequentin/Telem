<?php
//ici toutes les fonctions qui permettent d'agir sur les produits

//inclusions des fichiers utiles aux contrôleurs
require_once '../src/lib/helper.php';
require_once '../src/repository/productRepository.php';
/**
 * Récupère les données d'un faux produit et communique celles-ci aux templates
 * utilisés
 */
function productFakeAction()
{
    $product = getFakeProduct();
    ob_start();

    require_once '../templates/product/productCard.php';

    $output = ob_get_clean();

    $dataPage = [
        'title'       => 'Telem - Faux produit',
        'titlePage'   => 'Fiche d\'un faux produit',
        'mainContent' => $output,
    ];

    renderView($dataPage);

}

/**
 * Récupère les données du produit 10 et construit la page à servir
 */
function product10Action()
{

    $output = 'aucun problème';
    try {
        $connexionBdd = connectionBdd();

    } catch (Exception $e) {
        $output = $e->getMessage();
    }

    $dataPage = [
        'title'       => 'Telem - Produit 10',
        'titlePage'   => 'Fiche du produit 10',
        'mainContent' => $output,
    ];

    renderView($dataPage);

}
