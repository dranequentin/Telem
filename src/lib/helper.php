<?php
//Ici toutes les fonctions qui permettent d'aider, un peu comme une boîte à outils

//inclusions utiles


/**
 * Inclusion des fichiers constituant la structure par défaut d'une page du
 * site
 *
 * @param array $dataPage tableau associatif contenant les données à passer à
 *                        la page. Liste des clés du tableau :
 *                        - title
 *                        - titlePage
 *                        - mainContent
 */
//function layout($title, $titlePage, $mainContent = 'Page d\'accueil'){
function renderView($dataPage)
{
    require_once '../templates/layout/header.php';
    require_once '../templates/layout/menu.php';
    require_once '../templates/layout/mainContent.php';
    require_once '../templates/layout/footer.php';
}

/**
 * Créer une connexion à la bdd à partir des données de configuration du fichier de configuration config\database.php
 *
 * @return PDO
 */
function connectionBdd()
{
    //le fichier de configuration pour les accès à la bdd doit être inclus dans la fonction sans quoi la variable $configDatabase ne sera pas accessible dans cette dernière en raison de sa portée (voir cours vidéo sur la portée des variables)
    require_once '../config/database.php';
    //sprintf permet d'éviter de concaténer des variables. C'est plus pratique dans le cas présent.
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        $configDatabase['host'],
        $configDatabase['port'],
        $configDatabase['dbname'],
        $configDatabase['charset'],
    );

//    $dsn = 'mysql:host='.$configDatabase['host'].';port='.$configDatabase['port'].';dbname='. $configDatabase['dbname'].';charset='.$configDatabase['charset'];

    $objetPdo = new PDO($dsn, $configDatabase['user'], $configDatabase['pwd']);

    return $objetPdo;
}