<?php
require_once'../src/lib/helper.php';
require_once'../src/lib/securityFunctions.php';
session_start();

/**
 * Rend la vue de la fiche utilisateur connecté
 */
function accountAction(){

    if(empty($_SESSION['user'])){
        header('Location:erreur-403.php');
    }
    $dataPage['title']='Votre compte';
    $dataPage['titlePage']='Vos informations';

    ob_start();
    require_once'../templates/user/userCard.php';
    $output= ob_get_clean();
    $dataPage['mainContent']=$output;
    renderView($dataPage);
}
