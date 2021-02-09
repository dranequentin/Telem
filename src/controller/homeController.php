<?php
//inclusions des fichiers utiles aux contrôleurs
require_once '../src/lib/helper.php';
/**
 * Construit et sert la page d'accueil
 */
function indexAction(){

    ob_start();
    require '../templates/home.php';
    $output = ob_get_clean();

    $dataPage = [
        'title'=> 'Telem - Accueil',
        'titlePage'=> 'Présentation de Telem',
        'mainContent' => $output
    ];

    renderView($dataPage);
}
