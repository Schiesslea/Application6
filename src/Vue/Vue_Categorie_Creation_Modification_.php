<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Categorie_Creation_Modification_  extends Vue_Composant
{
    private bool $modeCreation=true;
private string $idCategorie="";
private string $libelle="";
private string $description="";

    public function __construct(bool $modeCreation=true,string $idCategorie="",string $libelle="",string $description="")
    {
        $this->modeCreation=$modeCreation ;
        $this->idCategorie=$idCategorie ;
        $this->libelle=$libelle ;
        $this->description=$description ;
    }

    function donneTexte(): string
    {
        if ($this->modeCreation)
            $str= "<H1>Création d'une nouvelle catégorie</H1>";
        else
            $str= "<H1>Edition d'une catégorie</H1>";

        $str .=  "
<table style='display: inline-block'> 
    <form>
        ".genereChampHiddenCSRF()."
        <input type='hidden' name='idCategorie' value='$this->idCategorie'>
        <input type='hidden' name='case' value='Gerer_catalogue'>
        <tr>
            <td>
                <label>ID Catégorie : </label>
            </td>
            <td>
                $this->idCategorie
            </td>
        </tr>
        <tr>
        
            <td>
                <label>Libellé Catégorie: </label>
            </td>
            <td>
    
                <input type='text' required name='libelle' pattern='[A-z\ ]{0,30}' placeholder='libelle' autofocus value='$this->libelle'>
            </td>
        </tr>
        <tr>
            <td>
                <label>Description de la Catégorie : </label>
            </td>
            <td><input type='text' placeholder='Description' name='description' value='$this->description'>
            </td>
        </tr>
        ";
        if ($this->modeCreation) {
            //if ($modeCategorieProduit == false) {
            $str .=  " 
                    
                <td colspan='2' style='text-align: center'>
                    
                    <button type='submit' name='action' value='CreerCategorie'>
                        Créer cette catégorie
                    </button>";

        } else {
            $str .=  "
            <td>
                
                <button type='submit' name='action' value='mettreAJourCategorie'>
                        Mettre à jour
                </button>";
        }

        $str .=  "</td>
        </tr>

    </form>
</table>

";
        return $str;
    }
}