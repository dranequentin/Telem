<?php
/**
 * Affiche le contenue passé en argument lorsque l'utilisateur est authentifié
 * @param $stringToDisplay*
 */
function displayIfAuthenticated(string $stringToDisplay){
    if(empty($_SESSION)) {
        return ;
    }
   echo $stringToDisplay;
}
/**
 * @param string $stringToDisplay
 * Cache le contenue passé en argument lorsque l'utilisateur est authentifié
 */
function hideIfAuthenticated(string $stringToDisplay){
    if(!empty($_SESSION)) {
        return ;
    }
   echo $stringToDisplay;
}
/**
 * Check si l'utilisateur est authentifié
 */
function checkUserIfAuthenticated(){
if($_SESSION['user']===null){
    header('Location:error-403.php');
}
}

