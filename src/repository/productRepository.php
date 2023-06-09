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
        'designation'  => 'Faux produit',
        'fichierImage' => 'ecran-tactile-mal.png',
        'description'  => 'Magnifique machine à laver avec un écran 4K !!!',
        'prix'         => 9999.99,

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
function readProduct10($connexion)
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

/**
 * Obtient un produit en fonction de son identifiant
 *
 * @param PDO $connexion connexion à la bdd
 * @param int $id        id du produit
 *
 * @return array tableau associatif dont les clés correspondent au nom des
 *               colonnes de la table produit
 * @throws Exception
 */
function readProductById(PDO $connexion, int $id): array
{

    $query = $connexion->prepare('SELECT * FROM produit WHERE idProduit = :id');

    $query->bindValue(':id', $id, PDO::PARAM_INT);
    try {
        $resultIsOk = $query->execute();

        //si la requête échoue on lève une exception pour exécuter le code du bloc catch
        if (!$resultIsOk) {
            throw new Exception('L\exécution de la requête a échoué');
        }


        $product = $query->fetch(PDO::FETCH_ASSOC);

        //si la récupération échoue ou s'il n'y a aucun résultat, fetch retourne false. Dans ce cas, nous retournons un tableau vide
        if ($product === false) {
            return [];
        }


    } catch (Exception $e) {
        throw new Exception(
            'Un problème est survenue : '.$e->getMessage()
        );
    }


    return $product;

}

/**
 * Retourne tous les produits
 *
 * @param PDO $connexion
 *
 * @return array tableau de tableaux associatifs
 * @throws Exception
 */
function readAllProducts(PDO $connexion): array
{

    $query = $connexion->query('SELECT * FROM produit');

    if ($query === false) {
        throw new Exception('Erreur dans la requête');
    }

    //récupération de tous les produits et on les charge dans la mémoire du SGBDR
//    return $query->fetchAll(PDO::FETCH_ASSOC);
    $products = [];
    //récupération des produits un par un. (cela évite de saturer la mémoire du SGBDR si jamais il y avait un très grand nombre de produits)
    while ($product = $query->fetch(PDO::FETCH_ASSOC)) {
        $products[] = $product;
    }

    return $products;


}

/**
 * Insère un produit dans la bdd
 *
 * @param PDO   $connexion connexion à la bdd
 * @param array $product   tableau associatif dont les clés correspondent aux
 *                         noms des colonnes de la table produit dans la bdd
 *
 * @return array tableau associatif représentant le produit inséré dont les
 *               clés correspondent aux noms des colonnes de la table produit
 *               ou un tableau vide si l'insertion a échoué
 * @throws Exception Echec de l'exécution de la requête
 */
function createProduct(PDO $connexion, array $product): array
{
    $query = $connexion->prepare(
        "INSERT INTO produit VALUES (NULL,:designation,:description,now(),:qte,:prix, 'nophoto.jpg', 88)"
    );

    $query->bindValue(':designation', $product['designation'], PDO::PARAM_STR);
    $query->bindValue(':description', $product['description'], PDO::PARAM_STR);
    $query->bindValue(':qte', $product['qte'], PDO::PARAM_STR);
    $query->bindValue(':prix', $product['prix'], PDO::PARAM_STR);

    try {
        $insertIsOk = $query->execute();

        //récupération du produit inséré
        if ($insertIsOk) {
            $id = intval($connexion->lastInsertId());

            return readProductById($connexion, $id);
        }

        return [];

    } catch (Exception $e) {
        throw new Exception(
            'Un problème est survenu lors de l\'exécution de la requête.'
        );
    }
}

/**
 * Met à jour un produit
 *
 * @param PDO   $connexion connexion à la bdd
 * @param array $product   tableau associatif dont les clés correspondent aux
 *                         noms des colonnes de la table produit dans la bdd
 *
 * @return array tableau associatif représentant le produit inséré dont les
 *               clés correspondent aux noms des colonnes de la table produit
 *               ou un tableau vide si l'insertion a échoué
 * @throws Exception Echec de l'exécution de la requête
 */
function updateProduct(PDO $connexion, array $product)
{
    $query = $connexion->prepare(
        "UPDATE produit SET designation = :designation, description = :description, qte = :qte, prix = :prix WHERE idProduit = :id"
    );

    $query->bindValue(':designation', $product['designation'], PDO::PARAM_STR);
    $query->bindValue(':description', $product['description'], PDO::PARAM_STR);
    $query->bindValue(':qte', $product['qte'], PDO::PARAM_STR);
    $query->bindValue(':prix', $product['prix'], PDO::PARAM_STR);
    $query->bindValue(':id', $product['idProduit'], PDO::PARAM_STR);

    try {
        $isOK = $query->execute();

        //récupération du produit mis à jour
        if ($isOK) {
            return readProductById($connexion, $product['idProduit']);
        } else {
            throw new Exception('Echec');
        }
    } catch (Exception $e) {
        throw new Exception(
            'Un problème est survenu lors de l\'exécution de la requête.'
        );
    }

}