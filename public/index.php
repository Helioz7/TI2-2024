<?php
/*
 * Front Controller de la gestion du livre d'or
 */
 
/*
 * Chargement des dépendances
 */
// chargement de configuration
require_once "../config.php";
// chargement du modèle de la table livreor
require_once "../model/livreorModel.php";
/*
 * Connexion à la base de données en utilisant PDO
 * Avec un try catch pour gérer les erreurs de connexion
 */
try {
    $MyPDO = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=" . DB_CHARSET,DB_LOGIN, DB_PWD);
} catch (Exception $e) {
    die($e->getMessage());
}
/*
 * Si le formulaire a été soumis
 */
if (isset($_POST['firstname'],$_POST['lastname'] ,$_POST['usermail'], $_POST['message'])) {
 
    // on appelle la fonction d'insertion dans la DB (addLivreOr())
    $insert = addLivreOr($MyPDO,$_POST['firstname'],$_POST['lastname'] ,$_POST['usermail'], $_POST['message']);
 
    //Si on obtient une erreur
    if ($insert === true) $message = "Insertion réussie";
    else $message = $insert;
 
 
 // si l'insertion a réussi
    if ($insert) {
        // on redirige vers la page actuelle
        header("Location: ./");
        exit();
    } else {
        // sinon, on affiche un message d'erreur
        $message = "Erreur lors de l'insertion";
    }
   
}
 
   
/*
 * On récupère les messages du livre d'or
 */
$commentaires = getAllLivreOr($MyPDO);
// on appelle la fonction de récupération de la DB (getAllLivreOr())
$MyPDO = null;

 
include "../view/livreorView.php";