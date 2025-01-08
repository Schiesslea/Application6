<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Utilisateur_Formulaire  extends Vue_Composant
{

private bool $modeCreation=true;
private array $listeCategorieUtilisateur;
private  string $idUtilisateur="";
private string $login="";
private string $categorieUtilisateur="";

    public function __construct(bool $modeCreation=true, array $listeNiveauAutorisation, string $idUtilisateur="",
                                string $login="", string $niveauAutorisation="")
    {
        $this->modeCreation=$modeCreation;
        $this->listeCategorieUtilisateur=$listeNiveauAutorisation;
        $this->idUtilisateur=$idUtilisateur;
        $this->login=$login;
        $this->categorieUtilisateur=$niveauAutorisation;
    }

    function donneTexte(): string
    {
        // vous trouverez des explications sur les paramètres HTML5 des balises INPUT sur ce site :
        // https://darchevillepatrick.info/html/html_form.htm
        if ($this->modeCreation)
            $str= "<H1>Création d'un nouvel utilisateur</H1>";
        else
            $str= "<H1>Edition d'un utilisateur</H1>";

        $str .= "
<table style='display: inline-block'> 
    <form method='get'>
        ".genereChampHiddenCSRF()."
        <input type='hidden' name='case' value='Gerer_utilisateur'>
        
        <input type='hidden' name='idUtilisateur' value='$this->idUtilisateur'>
        <tr>
            <td>
                <label>Numéro d'utilisateur : </label>
            </td>
            <td>
                $this->idUtilisateur
            </td>
        </tr>
        <tr>
        
            <td>
                <label>Login : </label>
            </td>
            <td>
    
                <input type='text' required name='login'
                       pattern='[A-z\ ]{0,30}' placeholder='login' autofocus value='$this->login'>
            </td>
        </tr>
        <tr>
            <td>
                <label>Niveau d'autorisation : </label>
            </td>
            <td>
                <select name=\"codeCategorie\">";
        foreach ($this->listeCategorieUtilisateur as $niveau) {
            $str .=  "<option value='$niveau[id]' " . ($this->categorieUtilisateur == $niveau["id"] ? "selected" : "") . ">$niveau[libelle]</option>";
        }

        $str .=  "</select>
            </td>
        </tr>
        ";
        if ($this->modeCreation) {
            $str .=  " 
                
            <td colspan='2' style='text-align: center'>
                
                <button type='submit' name='action' value='buttonCreerUtilisateur'>Créer cet utilisateur</button>";
        } else {
            $str .=  "<td>
                
                <button type='submit' name='action' value='réinitialiserMDPUtilisateur'>Réinitialiser le mot de passe</button>
            </td>
            <td>                
                
                <button type='submit' name='action' value='mettreAJourUtilisateur'>Mettre à jour</button>";
        }

        $str .=  "</td>
        </tr>

    </form>
</table>

";
        return $str;
    }
}