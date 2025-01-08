<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Entreprise_Formulaire extends Vue_Composant
{
    private bool $modeCreation=true;
    private string $idEntreprise="";
    private string $denomination="";
    private string $rueAdresse="";
    private string $complementAdresse="";
    private string $codePostal="";
    private string $ville="";
    private string $pays="France";
    private string $numCompte="";
    private string $mailContact="";
    private string $siret="";


    /**
     * Affiche le formulaire de création/mise à jour d'une entreprise. Les valeurs proposées seront celles données aux values des différents input.
     * @param bool $modeCreation A true si le formulaire est utiliser pour créer une entreprise, False : en mise à jour, tous les attributs doivent être paramétrés
     * @param string $idEntreprise
     * @param string $denomination
     * @param string $rueAdresse
     * @param string $complementAdresse
     * @param string $codePostal
     * @param string $ville
     * @param string $pays
     * @param string $numCompte
     * @param string $mailContact
     * @param string $siret
     */
    public function __construct(bool   $modeCreation=true, string $idEntreprise="", string $denomination="", string $rueAdresse="",
                                string $complementAdresse="", string $codePostal="", string $ville="", string $pays="France",
                                string $numCompte="", string $mailContact="", string $siret="")
    {
        $this->modeCreation=$modeCreation;
        $this->idEntreprise=$idEntreprise;
        $this->denomination=$denomination;
        $this->rueAdresse=$rueAdresse;
        $this->complementAdresse=$complementAdresse;
        $this->codePostal=$codePostal;
        $this->ville=$ville;
        $this->pays=$pays;
        $this->numCompte=$numCompte;
        $this->mailContact=$mailContact;
        $this->siret=$siret;
    }


    function donneTexte(): string
    {
        // vous trouverez des explications sur les paramètres HTML5 des balises INPUT sur ce site :
        // https://darchevillepatrick.info/html/html_form.htm
        if ($this->modeCreation)
            $str= "<H1>Création d'un nouveau client Entreprise</H1>";
        else
            $str= "<H1>Edition d'une entreprise</H1>";

        $str .=  "
<table style='display: inline-block'> 
    <form>
        ".genereChampHiddenCSRF()."
        <input type='hidden' name='case' value='Gerer_entreprisesPartenaires'>
        
        <input type='hidden' name='idEntreprise' value='$this->idEntreprise'>
        <tr>
            <td>
                <label>Numéro de compte : </label>
            </td>
            <td>
                $this->numCompte
            </td>
        </tr>
        <tr>
        
            <td>
                <label>Dénomination (en lettres majuscules) : </label>
            </td>
            <td>
    
                <input type='text' required name='denomination'
                       pattern='[A-z\ ]{0,30}' placeholder='lettres et espace' autofocus value='$this->denomination'>
            </td>
        </tr>
        <tr>
            <td>
                <label>Rue : </label>
            </td>
            <td><input type='text' required
                       placeholder='Rue' name='rueAdresse' value='$this->rueAdresse'>
            </td>
        </tr>
        <tr>
            <td>
                <label>Rue (complément)  : </label>
            </td>
            <td><input type='text' optional placeholder='Complément' name='complementAdresse' value='$this->complementAdresse'>
        </tr>
        <tr>
            <td>
                <label>Code postal : </label>
            </td>
            <td><input type='text' required
                         placeholder='Code postal/cedex' maxlength='10' name='codePostal' value='$this->codePostal'>
            </td>
        </tr>
        <tr>
            <td>
                <label>Ville : </label>
            </td>
            <td>
    
                <input type='text' required
                       pattern='[A-z\ ]{2,30}' placeholder='ville' autofocus name='ville' value='$this->ville'>
            </td>
        </tr>
        
        <tr>
            <td>
                <label>Pays : </label>
            </td>
            <td>
    
                <input type='text' required
                       pattern='[A-z\ ]{2,30}' placeholder='pays' autofocus value='$this->pays' name='pays'>
            </td>
        </tr>
        
         
        
        <!--tr>
            <td>
                <label>Téléphone : </label>
            </td>
            <td><input type='tel' required
                       pattern='[0-9]{10}' placeholder='dix chiffres' maxlength='10' value=''>
            </td>
        </tr-->
        <tr>
            <td>
                <label>Couriel : </label>
            </td>
            <td><input type='email' required value='$this->mailContact' name='mailContact'
                       placeholder='____@___ .___'>
            </td>
        </tr>
        <tr>
            <td>
                <label>Siret (14 chiffres) </label>
            </td>
            <td><input type='text' pattern='[0-9]{14}' name='siret' value='$this->siret' required>
            </td>
        </tr>
        <tr>";
        if ($this->modeCreation) {
            $str .=  " 
                
            <td colspan='2' style='text-align: center'>
                
                <button type='submit' name='action' value='buttonCreer'>Créer ce client</button>";
        } else {
            $str .=  "<td>
                
                <button type='submit' name='action' value='réinitialiserMDP'>Réinitialiser le mot de passe</button>
            </td>
            <td>
                <button type='submit' name='action' value='mettreAJour'>Mettre à jour</button>";
        }

        $str .=  "</td>
        </tr>

    </form>
</table>

";
        return $str;
    }


}