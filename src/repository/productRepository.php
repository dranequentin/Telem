<?php
//ici, toutes les requêtes SQL (dans des fonctions)

/**
 * Obtient un faux produit
 *
 * @return array tableau associatif des informations d'un faux produit
 */
function getFakeProduct()
{
    $product = [
        'title'       => 'Faux produit',
        'image'       => 'ecran-tactile-mal.png',
        'description' => 'Magnifique machine à laver avec un écran 4K !!!',
        'price'       => 9999.99,

    ];

    return $product;
}


function getProduct10($connexion)
{



}

function getProductById($connexion, $id)
{

}