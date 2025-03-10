<?php
/***
 * Fonction qui génère la valeur CSRF pour cette page
 * @return string
 * @throws Exception
 */
function genereCSRF(): string
{
    if (!isset($_SESSION["CSRF"])) {
        //Démarrage de la session
        //On crée le tableau des jetons CSRF !
        $_SESSION["CSRF"] = [];
    }
    $nb = count($_SESSION["CSRF"]);
    //Le tableau existe et on va se focaliser sur la dernière valeur.
    if (!isset($_SESSION["CSRF"][$nb - 1])) {
        //La dernière valeur n'existe pas !!
        //Détruite ? pas de raison !
        //On est au premier passage
        $CSRF = [];
        $CSRF["ValCsrf"] = random_int(0, 999999999);
        $CSRF["nbUsage"] = 0;
        $CSRF["isReload"] = false;
        $_SESSION["CSRF"][] = $CSRF;
        return $CSRF["ValCsrf"];
    } else {
        //on a un jeton qui existe à la fin du tableau...
        if ($_SESSION["CSRF"][$nb - 1]["nbUsage"] == 0) {
            //Si nbUsage = 0, il vient d'être généré pour cette page !
            return $_SESSION["CSRF"][$nb - 1]["ValCsrf"];
        } else {
            //Si nbUsage != 0, il est déjà utilisé, on va faire un jeton neuf !
            //On va détecter si l'ancien est un refresh
            //On parcours la collection pour retrouver notre valeur de jeton
            $CSRF = [];
            $CSRF["isReload"] = false;
            if(isset($_SESSION["CSRFConsomme"])) {
                //Si on a consommé un jeton on peut être sur un reload
                $boolTrouve = false;
                for ($i = 0; $i < $nb && $boolTrouve == false; $i++) {
                    if ($_SESSION["CSRFConsomme"] == $_SESSION["CSRF"][$i]["ValCsrf"]) {
                        $boolTrouve = true;
                        if ($_SESSION["CSRF"][$i]["ValCsrf"] > 1) {
                            //Ce jeton a servi plus de 2 fois, donc un moins reload
                            // ou un lancement en double de la même action !
                            $CSRF["isReload"] = true;
                        }
                        //On invalide le jeton de consommation pour limiter les risques de chevauchements
                        $_SESSION["CSRFConsomme"] = -1;
                    }
                }
            }
            $CSRF["ValCsrf"] = random_int(0, 999999999);
            $CSRF["nbUsage"] = 0;
            $_SESSION["CSRF"][] = $CSRF;
            return $CSRF["ValCsrf"];
        }
    }

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
function verifierCSRF($valeurCSRFProposee): bool
{
    if (isset($_SESSION["CSRF"])) {
        var_dump($_SESSION["CSRF"]);
        //si la session existe, on attend une collection
        $nb = count($_SESSION["CSRF"]);
        $boolTrouve = false;

        //On parcours la collection pour retrouver notre valeur de jeton
        $i = 0;
        $memoI = 0;
        for ($i = 0; $i < $nb && $boolTrouve == false; $i++) {
            if ($valeurCSRFProposee == $_SESSION["CSRF"][$i]["ValCsrf"]) {
                $boolTrouve = true;
                $memoI = $i;
            }
        }
        if ($boolTrouve == true) {//Le jeton est trouvé, on incrémente son nombre d'usages.
            $_SESSION["CSRF"][$memoI]["nbUsage"]++;

            //On mémorise le jeton CSRF Consommé par cette page
            $_SESSION["CSRFConsomme"] = $valeurCSRFProposee;
        }
        return $boolTrouve;
    }
    echo "session inconnue";
    return true;
}

/**
 * Fonction qui indique si la page encours est un rechargement
 */
function direIsReload(): bool
{
    $nb = count($_SESSION["CSRF"]);
    return $_SESSION["CSRF"][$nb - 1]["isReload"];
}