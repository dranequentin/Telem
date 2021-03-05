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
        $product = readProduct10($connexionBdd);
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
        $product = readProductById($connexion, $idProduit);

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
function listProductsAction()
{
    $dataPage = [
        'title'     => 'Telem - catalogue',
        'titlePage' => 'Catalogue de nos produits',
    ];

    $connexion = connectionBdd();
    try {
        $products = readAllProducts($connexion);
        $viewData['nbProducts'] = count($products);
        $viewData['products'] = $products;
        $viewData['isCatalog'] = true;

        ob_start();
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
function formCreateProductAction()
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

    $formCreate = formForm('insertion-du-produit.php', $formData);


    $dataPage['mainContent'] = $formCreate;

    renderView($dataPage);

}

/**
 * Insertion d'un produit dans la bdd
 */
function addProductInBddAction(): void
{
    $dataPage = [
        'title'     => 'Telem - insertion du produit',
        'titlePage' => 'Résultat de l\'insertion du produit',
    ];

    //récupération des données postées
    $product['designation'] = $_POST['designation'];
    $product['description'] = $_POST['description'];
    $product['prix'] = $_POST['prix'];
    $product['qte'] = $_POST['qte'];


    //insertion en bdd
    $connexion = connectionBdd();
    try {
        $product = createProduct($connexion, $product);
        if (empty($product)) {
            $viewData['message'] = "Le produit n'a pas été inséré dans la bdd";
        } else {
            $viewData['message'] = "Le produit a été inséré dans la bdd avec l'identifiant ".$product['idProduit'];
        }
    } catch (Exception $e) {
        $viewData['message'] = $e->getMessage();
    }

    ob_start();
    require '../templates/message/default.php';
    $output = ob_get_clean();

    $dataPage['mainContent'] = $output;

    renderView($dataPage);

}

/**
 * Rend la vue qui propose le formulaire prérempli pour le produit à modifier
 */
function updateFormProductAction()
{
    $dataPage = [
        'title'     => 'Telem - modification d\'un produit',
        'titlePage' => 'Formulaire de modification d\'un produit',
    ];


    //s'il n'y a aucun produit à modifier, on redirige vers une autre route
    if (empty($_GET['id']) || (int)$_GET['id'] === 0) {
        header('Location: catalogue.php');
    }

    $id = (int)$_GET['id'];

    //récupération du produit
    $connection = connectionBdd();
    try {
        $product = readProductById($connection, $id);


        //chaque valeur du tableau est un tableau associatif
        $formData = [
            [
                'name'    => 'id',
                'label'   => '',
                'value'   => $product['idProduit'],
                'type'    => 'hidden',
                'wrapTag' => 'p',
            ],
            [
                'name'    => 'designation',
                'label'   => 'Désignation',
                'value'   => $product['designation'],
                'type'    => 'text',
                'wrapTag' => 'p',
            ],
            [
                'name'    => 'description',
                'label'   => 'Description',
                'value'   => $product['description'],
                'type'    => 'text',
                'wrapTag' => 'p',
            ],
            [
                'name'    => 'qte',
                'label'   => 'Quantite',
                'value'   => $product['qte'],
                'type'    => 'number',
                'wrapTag' => 'p',
            ],
            [
                'name'    => 'prix',
                'label'   => 'Prix',
                'value'   => $product['prix'],
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

        $output = formForm('mise-a-jour-du-produit.php', $formData);
    } catch (Exception $e) {
        $output = $e->getMessage();
    }

    $dataPage['mainContent'] = $output;

    renderView($dataPage);


}

/**
 * Met à jour un  produit et redirige sur la fiche du produit concerné
 */
function updateProductAction()
{
    $dataPage = [
        'title'     => 'Telem - mise à jour d\'un produit',
        'titlePage' => 'Echec de la mise à jour du produit',
    ];

    //récupération des données du formulaire
    $product['designation'] = $_POST['designation'];
    $product['description'] = $_POST['description'];
    $product['prix'] = $_POST['prix'];
    $product['qte'] = $_POST['qte'];
    $product['idProduit'] = $_POST['id'];


    $connection = connectionBdd();
    try {
        $product = updateProduct($connection, $product);
        header('Location:fiche-produit.php?id='.$product['idProduit']);
    } catch (Exception $e) {
        $viewData['message'] = $e->getMessage();

        ob_start();
        require '../templates/message/default.php';
        $output = ob_get_clean();

        $dataPage['mainContent'] = $output;

        renderView($dataPage);
    }
}
