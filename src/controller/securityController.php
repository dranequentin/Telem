<?php
require_once'../src/lib/helper.php';
require_once '../src/lib/formFunctions.php';
require_once '../src/lib/securityFunctions.php';
session_start();


function loginAction():void
{
    $dataPage=[
        'title'=>'Telem - Login',
        'titlePage'=>'Connexion au backoffice <br><br>Utiliser le login sylvain et le mot de passe toto pour acceder à de nouvelles fonctionalités'
    ];
    /*ob_start();
    require '../templates/forms/login.php';
    $output =ob_get_clean();*/
    $dataForm =[
      [
      'name'=>'login',
      'label'=>'Votre login',
      'type'=>'text',
      'wrapTag'=>'p',
      'value'=>''
      ],
      [
      'name'=>'password',
      'label'=>'Votre mot de passe',
      'type'=>'password',
      'wrapTag'=>'p',
      'value'=>''
      ],
      [
      'name'=>'submit',
      'label'=>'',
      'type'=>'submit',
      'wrapTag'=>'p',
      'value'=>'Se connecter'
      ]
    ];
    $output =formForm('authentification.php',$dataForm);
    $dataPage['mainContent']=$output;
    renderView($dataPage);
}

/**
 * Vérifier l'identité de l'utilisateur grâce à ses paramètre
 * de connexion(c'est l'authentification)
 */
function autenticationAction()
{
    $loginPost = $_POST['login'];
    $passwordPost = $_POST['password'];
    require_once'../config/security.php';
    foreach($configUsers as $login =>$info){
        $viewData['message'] = 'Login et / ou mot de passe incorrecte.';
        if($login ===$loginPost){
            if($info['password']===$passwordPost){
                //authentification réussie
                $viewData['message'] = 'Vous êtes connecté';
                $_SESSION['user']=[
                    'login'=>$login,
                    'mail'=>$info['mail'],
                    'name'=>$info['name'],
                ];
                break;
            }
        }
    }
    ob_start();
    require_once '../templates/message/default.php';
    $output = ob_get_clean();
    $dataPage['title']='Telem - Authentification';
    $dataPage['titlePage']='Résultat de la connexion';
    $dataPage['mainContent']=$output;
    renderView($dataPage);
}

/**
 * Déconecte l'utilisateur en détruisant sa session et les données de session
 */
function logoutAction(){
    session_destroy();
    unset($_SESSION);
    header('Location:connexion.php');
}