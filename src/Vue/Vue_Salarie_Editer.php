<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Salarie_Editer extends Vue_Composant
{
private bool $ajouter=true;
private string $idSalarie="";
private string $nom="";
private string $prenom="";
private string $role="";
private  string $mail="";
    public function __construct(bool $ajouter=true,string $idSalarie="",string $nom="",string $prenom="",
                                string $role="", string $mail="")
    {
        $this->ajouter=$ajouter;
        $this->idSalarie=$idSalarie;
        $this->nom=$nom;
        $this->prenom=$prenom;
        $this->role=$role;
        $this->mail=$mail;

    }

    function donneTexte(): string
    {
        $str= '<H1>Ajout d\'un salarié habilité</H1>';

        $str .=  "
<table style='display: inline-block'> 
    <form method='get'>
        ".genereChampHiddenCSRF()."
        <input type='hidden' name='case' value='Gerer_Entreprise'>
        <input type='hidden' name='idSalarie' value='$this->idSalarie'>
        <tr>
            <td>
                <label>Nom : </label>
            </td>
            <td>
                <input type='text' required name='nom'
                       pattern='[A-z\ ]{0,30}' placeholder='Nom' autofocus value='$this->nom'>
            </td>
        </tr>
        <tr>
            <td>
                <label>Prénom : </label>
            </td>
            <td>
                <input type='text' required name='prenom'
                       pattern='[A-z\ ]{0,30}' placeholder='Prénom' autofocus value='$this->prenom'>
            </td>
        </tr>
        <tr>
            <td>
                <label>Fonction : </label>
            </td>
            <td>
                <input type='text' required name='role'
                       pattern='[A-z\ ]{0,30}' placeholder='Fonction dans l&apos;entreprise' autofocus value='$this->role'>
            </td>
        </tr>
        <tr>
            <td>
                <label>Mail : </label>
            </td>
            <td>
                <input type='email' required value='$this->mail' name='mailContact' placeholder='____@___ .___'>
            </td>
        </tr>

        ";
        if ($this->ajouter) {
            $str .=  " 
                
            <td colspan='2' style='text-align: center'>
                
                <button type='submit' name='action' value='buttonCreerSalarie'>Ajouter</button>";
        } else {
            $str .=  "<td>
                
                <button type='submit' name='action' value='réinitialiserMDPSalarie'>Réinitialiser le mot de passe</button>
            </td>
            <td>
                
                <button type='submit' name='action' value='ModiferSalarieValider'>Mettre à jour</button>";
        }
        $str .=  "</td>
        </tr>
    </form>
</table>

";
        return $str;
    }
}