<?php
//error_log("page debut");
session_start();
include_once "vendor/autoload.php";
require_once 'src/Fonctions/CRSF.php'; // Inclure le fichier contenant les fonctions CSRF


use App\Modele\Modele_Token;
use App\Utilitaire\Vue;
use App\Vue\Vue_AfficherMessage;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Structure_Entete;


// Page appelée pour les utilisateurs publics


$Vue = new Vue();
$Vue->setEntete(new Vue_Structure_Entete());
// Charge le gestionnaire de vue


if (isset($_SESSION["typeConnexionBack"])) {
    $typeConnexion = $_SESSION["typeConnexionBack"];
} else {
    $typeConnexion = "visiteur";
}
//error_log("typeConnexion : " . $typeConnexion);
// utiliser en débuggage pour avoir le type de connexion
//$Vue->addToCorps(new Vue_AfficherMessage("<br>typeConnexion $typeConnexion<br>"));


// Identification du cas demandé (situation)
if (isset($_REQUEST["case"])) {
    $case = $_REQUEST["case"];
} else {
    $case = "Cas_Par_Defaut";
}
//error_log("case : " . $case);
// utiliser en débuggage pour avoir le type de connexion
//$Vue->addToCorps(new Vue_AfficherMessage("<br>Case $case<br>"));


// Identification de l'action demandée
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
} else {
    $action = "Action_Par_Defaut";
}
//error_log("action : " . $action);
// utiliser en débuggage pour avoir le type de connexion
//$Vue->addToCorps(new Vue_AfficherMessage("<br>Action $action<br>"));


// Vérifier les requêtes POST pour le jeton CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }
}


if (isset($_REQUEST["token"])) {
    $token = $_REQUEST["token"];
    $tokenBDD = Modele_Token::Token_Select($token);
    if ($tokenBDD != null) {
        include "Controleur/Controleur_Gerer_Token.php";
    } else {
        $Vue->addToCorps(new Vue_AfficherMessage("Token : action non reconnue"));
        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
    }
} else {
    switch ($typeConnexion) {
        case "visiteur":
            switch ($case) {
                case "Gerer_Rgpd":
                    include "Controleur/Controleur_Gerer_Rgpd.php";
                    break;
                default:
                    include "Controleur/Controleur_visiteur.php";
            }
            break;


        case "gestionnaireCatalogue":
        case "commercialCafe":
        case "administrateurLogiciel":
            switch ($case) {
                case "Gerer_CommandeClient":
                case "Gerer_Commande":
                    include "Controleur/Controleur_Gerer_Commande.php";
                    break;
                case "Gerer_entreprisesPartenaires":
                    include "Controleur/Controleur_Gerer_entreprisesPartenaires.php";
                    break;
                case "Gerer_utilisateur":
                    include "Controleur/Controleur_Gerer_utilisateur.php";
                    break;
                case "Gerer_catalogue":
                    include "Controleur/Controleur_Gerer_catalogue.php";
                    break;
                case "Gerer_monCompte":
                    include "Controleur/Controleur_Gerer_monCompte.php";
                    break;
                default:
                    include "Controleur/Controleur_Gerer_monCompte.php";
                    break;
            }
            break;
        case "entrepriseCliente":
        case "salarieEntrepriseCliente":
            switch ($case) {
                case "Gerer_CommandeClient":
                    include "Controleur/Controleur_Gerer_CommandeClient.php";
                    break;
                case "Gerer_Panier":
                    include "Controleur/Controleur_Gerer_Panier.php";
                    break;
                case "Gerer_MonCompte_Salarie":
                    include "Controleur/Controleur_Gerer_MonCompte_Salarie.php";
                    break;
                case "Gerer_monCompte":
                case "Gerer_Entreprise":
                    include "Controleur/Controleur_Gerer_Entreprise.php";
                    break;
                case "Gerer_Rgpd":
                    include "Controleur/Controleur_Gerer_Rgpd.php";
                    break;
                case "Cas_Par_Defaut":
                case "Gerer_catalogue":
                case "Catalogue_client":
                default:
                    include "Controleur/Controleur_Catalogue_client.php";
                    break;
            }
        default:
            $Vue->addToCorps(new Vue_AfficherMessage("Type de connexion non reconnu"));
    }
}
$Vue->afficher();
