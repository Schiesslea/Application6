<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Catalogue_Formulaire extends Vue_Composant
{
    private array $listeCategorie;
    private array $listeTVA;
    private bool $modeCreation=true;
    private bool $modeCategorieProduit=false;
    private string $idProduit="";
    private string $nom="";
    private string $description="";
    private string $resume="";
    private string $fichierImage="";
    private string $prixVenteHT="";
    private string $idCategorie="";
    private string $idTVA="";
    private string $desactiver="";

    public function __construct(array  $listeCategorie, array $listeTVA, bool $modeCreation=true, bool $modeCategorieProduit=false,
                                string $idProduit="", string $nom="", string $description="", string $resume="",
                                string $fichierImage="", string $prixVenteHT="", string $idCategorie="", string $idTVA="",
                                string $desactiver="")
    {
        $this->listeCategorie=$listeCategorie;
        $this->listeTVA=$listeTVA;
        $this->modeCreation=$modeCreation;
        $this->modeCategorieProduit=$modeCategorieProduit;
        $this->idProduit=$idProduit;
        $this->nom=$nom;
        $this->description=$description;
        $this->resume=$resume;
        $this->fichierImage=$fichierImage;
        $this->prixVenteHT=$prixVenteHT;
        $this->idCategorie=$idCategorie;
        $this->idTVA=$idTVA;
        $this->desactiver=$desactiver;
    }

    function donneTexte(): string
    {
        if ($this->modeCreation)
            $str= "<H1>Création d'un nouveau produit</H1>";
        else
            $str= "<H1>Edition du produit</H1>";

        $str .=  "
<form method='post' enctype='multipart/form-data' action='$GLOBALS[adminFileName]'>
    ".genereChampHiddenCSRF()."
    <input type='hidden' name='idProduit' value='$this->idProduit'>
    <input type='hidden' name='case' value='Gerer_catalogue'>
    <table style='display: inline-block'> 
";


        if ($this->modeCreation == false) {
            $str .=  "<tr>
            <td>
                <label>Id du produit </label>
            </td>
            <td>
                $this->idProduit
            </td>
        </tr>";
        }
        $str .=  "   
        <tr>
            <td>
                <label>Nom du produit : </label>
            </td>
            <td>
    
                <input type='text' required name='nom'
                       pattern='[A-z\ ]{0,30}' placeholder='lettres et espace' autofocus value='$this->nom'>
            </td>
        </tr>
        <tr>
            <td>
                <label>Description : </label>
            </td>
            <td><textarea placeholder='Description' name='description' rows='5' cols='33'>$this->description</textarea>
            </td>
        </tr>
        <tr>
            <td>
                <label>Résumé  : </label>
            </td>
            <td> <textarea placeholder='Résumé' name='resume' rows='5' cols='33'>$this->resume</textarea></td>
        </tr>
        <tr>
            <td>
                <label>Fichier Image : </label>
            </td>
            <td>
            <!--<input type='text' placeholder='Lien fichier image' maxlength='1000' name='fichierImage' value='$this->fichierImage'>-->
            <input type='file' name='image_utilisateur' accept='.png, .jpg, .jpeg'></td>
        </tr>";
        if ($this->modeCreation == false) {
            $str .=  "<tr>
            <td> <label> Ancienne image : </label> </td>
            <td>$this->fichierImage</td>
             <input type='hidden' value='$this->fichierImage' name='fichierImage'>
        </tr>";
        }
        $str .=  "
        <tr>
            <td>
                <label>Prix de vente HT : </label>
            </td>
            <td>
    
                <input type='number' required
                       pattern='[A-z\ ]{2,30}' placeholder='prix vente HT' autofocus name='prixVenteHT' value='$this->prixVenteHT'>
            </td>
        </tr>
        
        <tr>
            <td>
                <label>Catégorie : </label>
            </td>
            <td>";
        if ($this->modeCategorieProduit == false) {
            $str .=  "<select name='idCategorie'>";
            foreach ($this->listeCategorie as $categorie) {
                if ($this->idCategorie == $categorie["idCategorie"])
                    $str .=  "<option value='$categorie[idCategorie]' selected>$categorie[libelle]</option>";
                else
                    $str .=  "<option value='$categorie[idCategorie]'>$categorie[libelle]</option>";
            }
            $str .=  "</select>";

        }

        if ($this->modeCreation and $this->modeCategorieProduit == false) {
            $str .=  "

                <button type='submit' name='action' value='CreationCategorieAvecProduit'>+</button>";
        }

        if ($this->modeCategorieProduit == true) {
            $str .=  "<input type='text' name='CategorieAvecProduit' placeholder='Nouvelle Catégorie'>
                    <input type='text' name='DescriptionCategorieAvecProduit' placeholder='Description Catégorie'>";
        }
        $str .=  "
            </td>
        </tr> 
        <tr>
            <td>
                <label> TVA : </label>
            </td>
            <td> <select name='idTVA'>";

        foreach ($this->listeTVA as $tva) {
            if ($this->idTVA == $tva["idTVA"])
                $str .=  "<option value='$tva[idTVA]' selected>$tva[pourcentageTVA] %</option>";
            else
                $str .=  "<option value='$tva[idTVA]'>$tva[pourcentageTVA] %</option>";
        }
        $str .=  "
                        <input type='hidden' value='$this->idProduit' name='idProduit'>
            </select>
            </td>
        </tr>
        <tr>
            <td><label>Désactiver : </label></td>
            <td>
                <input type='radio' name='DesactiverProduit' value='1' " . ($this->desactiver == 1 ? 'checked' : "") . "> Oui
                <input type='radio' name='DesactiverProduit' value='0' " . ($this->desactiver == 0 ? 'checked' : "") . "> Non
            </td>
        </tr>
        <tr>";
        if ($this->modeCreation) {
            $str .=  " 
                
            <td colspan='2' style='text-align: center'>
                
                <button type='submit' name='action' value='CreationProduit'>Créer ce produit</button>";
        } else {
            $str .=  "
            <td>
                <button type='submit' name='action'  value='mettreAJourProduit'>Mettre à jour</button>";
        }

        $str .=  "</td>
        </tr>

   
</table>
 </form>
";
        return $str;
    }
}