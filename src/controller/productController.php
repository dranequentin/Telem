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

    //valeurs par défaut de la page
    $dataPage = [
        'title'     => 'Telem - fiche produit 10',
        'titlePage' => 'fiche-produit-10',
    ];

    $output = 'aucun problème';
    try {
        $connexionBdd = connectionBdd();
        $product = getProduct10($connexionBdd);
        ob_start();
        require '../templates/product/productCard.php';
        $output = ob_get_clean();

        $dataPage = [
            'title'       => 'Telem - '.$product['designation'],
            'titlePage'   => $product['designation'],
            'mainContent' => $output,
        ];

    } catch (Exception $e) {
        $output = $e->getMessage();
        $dataPage = [
            'mainContent' => $output,
        ];
    }

    renderView($dataPage);
}
