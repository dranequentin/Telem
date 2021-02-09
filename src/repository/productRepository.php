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
        'designation' => 'Faux produit',
        'fichierImage' => 'ecran-tactile-mal.png',
        'description' => 'Magnifique machine à laver avec un écran 4K !!!',
        'prix' => 9999.99,

    ];

    return $product;
}

/**
 * Sert le produit 10
 *
 * @param PDO $connexion connexion à la bdd
 *
 * @return array tableau associatif contenant les données du produit 10
 */
function getProduct10($connexion)
{
    //$query contient soit un objet PDOStatement, soit false (voir documentation)
    $query = $connexion->query('SELECT * FROM produit WHERE idProduit = 10');

    //gestion du cas où la requête soulève un problème
    if ($query === false) {
        //throw = jeter / lancer.
        //Une exception est un "problème" que l'on décide de "lancer" dans certains cas (ici, lorsque la requête rencontre un pb)
        throw new Exception('Il y a un problème dans la requête');
    }
    //je récupère le résultat de la requête sous forme de tableau associatif
    $product = $query->fetch(PDO::FETCH_ASSOC);

    if ($product === false) {
        throw new Exception(
            'Il y a un problème pour récupérer le résultat de la requête'
        );
    }
    
    return $product;

}

function getProductById($connexion, $id)
{

}