<?php

/***
 * Fonction qui génère la valeur CSRF pour cette page
 * @return string
 * @throws Exception
 */
function genereCSRF(): string
{
    if (!isset($_SESSION["CSRF"])) {
        //On va générer une nouvelle valeur
        $_SESSION["CSRF"] = random_int(0, 999999999);
    }
    return $_SESSION["CSRF"];
}

/**
 * Fonction qui génère un champ CSRF pour formulaire
 * @return string
 * @throws Exception
 */
function genereChampHiddenCSRF(): string
{
    return '<input type="hidden" name="CSRF" value= "' . genereCSRF() . '" />';
}


/**
 * Fonction qui génère un champ CSRF pour un lien hypertexte
 * @return string
 * @throws Exception
 */
function genereVarHrefCSRF(): string
{
    return '&CSRF=' . genereCSRF();
}

/**
 * Fonction qui consomme un jeton CSRF.
 * Elle vérifie si la valeur CSRF proposée correspondant à la valeur attendue,
 * puis détruit le jeton
 * @param $valeurCSRFProposée
 * @return bool
 */
function verifierCSRF($valeurCSRFProposée): int
{
    if(isset($_SESSION["CSRF"])) {
        if ($valeurCSRFProposée == $_SESSION["CSRF"]) {    // On est bien !
            unset($_SESSION["CSRF"]);
            return 1;
        } else {

            return -1;
        }

    }
    return 0;
}