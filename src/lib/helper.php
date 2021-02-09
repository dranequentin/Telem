<?php
//Ici toutes les fonctions qui permettent d'aider, un peu comme une boîte à outils

/**
 * Inclusion des fichiers constituant la structure par défaut d'une page du site
 *
 * @param array $dataPage tableau associatif contenant les données à passer à la page.
 *                        Liste des clés du tableau :
 *                        - title
 *                        - titlePage
 *                        - mainContent
 *
 *
 */
//function layout($title, $titlePage, $mainContent = 'Page d\'accueil'){
function renderView($dataPage){
    require_once '../templates/layout/header.php';
    require_once '../templates/layout/menu.php';
    require_once '../templates/layout/mainContent.php';
    require_once '../templates/layout/footer.php';
}