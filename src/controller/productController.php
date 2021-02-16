<?php
//ici toutes les fonctions qui permettent d'agir sur les produits

//inclusions des fichiers utiles aux contrôleurs
require_once '../src/lib/helper.php';
require_once '../src/lib/formFunctions.php';
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


/**
 * Construit la page relative à un produit donné
 */
function productXAction(): void
{
    //valeurs par défaut de la page
    $dataPage = [
        'title'     => 'Telem - fiche produit X',
        'titlePage' => 'fiche-produit-X',
    ];

    //récupération de l'id passé dans l'url lorsqu'il existe
    $idProduit = 0;
    if (isset($_GET['id'])) {
        $idProduit = intval($_GET['id']);
    }

    //récupération du produit dont l'id a été passé dans l'url
    $connexion = connectionBdd();

    try {
        $product = getProductById($connexion, $idProduit);

        if (empty($product)) {
            $output = 'Aucun résultat';
            $dataPage['mainContent'] = $output;
        } else {
            ob_start();
            require '../templates/product/productCard.php';
            $output = ob_get_clean();
            $dataPage = [
                'title'       => 'Telem - '.$product['designation'],
                'titlePage'   => $product['designation'],
                'mainContent' => $output,
            ];
        }


    } catch (Exception $e) {
        $output = $e->getMessage();
        $dataPage['mainContent'] = $output;
    }

    renderView($dataPage);

}

/**
 * Sert la page avec tous les produits au catalogue
 */
function listProducts()
{
    $dataPage = [
        'title'     => 'Telem - catalogue',
        'titlePage' => 'Catalogue de nos produits',
    ];

    $connexion = connectionBdd();
    try {
        $products = getAllProducts($connexion);
        $viewData['nbProducts'] = count($products);
        $viewData['products'] = $products;
        $viewData['isCatalog'] = true;

        ob_start();
//        var_dump($products);
        require '../templates/product/listProducts.php';
        $output = ob_get_clean();

    } catch (Exception $e) {
        $output = $e->getMessage();
    }
    $dataPage['mainContent'] = $output;

    renderView($dataPage);

}

/**
 * Insère un produit dans la bdd
 */
function formCreateProduct()
{
    $dataPage = [
        'title'     => 'Telem - ajout produit',
        'titlePage' => 'Formulaire d\'ajout d\'un produit',
    ];

    //tableau contenant les éléments du formulaire à créer
    //chaque valeur du tableau est un tableau associatif
    $formData = [
        [
            'name'    => 'designation',
            'label'   => 'Désignation',
            'value'   => '',
            'type'    => 'text',
            'wrapTag' => 'p',
        ],
        [
            'name'    => 'description',
            'label'   => 'Description',
            'value'   => '',
            'type'    => 'text',
            'wrapTag' => 'p',
        ],
        [
            'name'    => 'qte',
            'label'   => 'Quantite',
            'value'   => '',
            'type'    => 'number',
            'wrapTag' => 'p',
        ],
        [
            'name'    => 'prix',
            'label'   => 'Prix',
            'value'   => '',
            'type'    => 'text',
            'wrapTag' => 'p',
        ],
        [
            'name'    => 'valider',
            'label'   => '',
            'value'   => 'Valider',
            'type'    => 'submit',
            'wrapTag' => 'p',
        ],
    ];

    $formCreate = formForm('bidon.php', $formData);


    $dataPage['mainContent'] = $formCreate;

    renderView($dataPage);

}
