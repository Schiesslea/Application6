<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Utilisateur_Changement_MDPForce extends Vue_Composant
{

    private string $action;
    private string $msg;

    function __construct(string $msg="", string $case="Gerer_Entreprise")
    {
        $this->msg=$msg;
        $this->case=$case;

    }

    function donneTexte(): string
    {

        $str="    <form style='display: contents'>
    ".genereChampHiddenCSRF()."
<table style='display: inline-block'> 
        <input type='hidden' name='case' value='$this->case'>
        <h1>Changement Mot de passe obligatoire</h1>
        <tr> <td><label>Veuillez saisir votre nouveau mot de passe : </label></td>
            <td><input type='password' placeholder='mot de passe' name='NouveauPassword' required></td> </tr>
        <tr><td><label>Veuillez confirmer votre nouveau mot de passe : </label></td>
            <td><input type='password' placeholder='mot de passe' name='ConfirmPassword' required></td></tr>
        <tr> <td><button type='submit' id='submitModifMDPForce' name='action' value='submitModifMDPForce'>Modifier son mot de passe</button></td></tr>
    </form>
    <div>$this->msg</div>";
        return $str;
    }
}
