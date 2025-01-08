<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Liste_Categorie  extends Vue_Composant
{
    private array $listeCategorie;
    public function __construct(array $listeCategorie)
    {
        $this->listeCategorie=$listeCategorie;
    }

    function donneTexte(): string
    {
        $str= "
    <h1>Liste des Catégories de produit</h1> <br>
    <table style='    display: inline-block;'>
        <form>
            ".genereChampHiddenCSRF()."
            <td colspan='4'>
            <button class='btnRadius'  type='submit' name='action' 
                            value='nouvelleCategorie'>
                             Nouvelle Catégorie ?
            </button>
            <input type='hidden' name='case' value='Gerer_catalogue'>
            
            </td> 
        </form>
            <tr>
                <th>ID Catégorie</th>
                <th>Catégorie</th>
            </tr>";
        $i=0;
        while ($i < count($this->listeCategorie)) {
            $iemeCategorie=$this->listeCategorie[$i];
            $str .=  "
            <tr>
                <input type='hidden' name='idCategorie' value='$iemeCategorie[idCategorie]'>
                
                <td>$iemeCategorie[idCategorie]</td>
                <td>$iemeCategorie[libelle]</td>
                <td>
                    <form style='display: contents'>
                        ".genereChampHiddenCSRF()."
                        <input type='hidden' name='case' value='Gerer_catalogue'>
                            
                            <input type='hidden' value='$iemeCategorie[idCategorie]' name='idCategorie'>
                              
                         <button class='btnRadius'  type='submit' name='action' value='ModifierCategorie'>
                          Modifier</button>
                    </form>
                </td>
                
            ";
            if ($iemeCategorie["desactiverCategorie"] == 0) {
                $str .=  "<td>
                <form style='display: contents'>
                ".genereChampHiddenCSRF()."
                    <input type='hidden' name='case' value='Gerer_catalogue'>
                        
                            <input type='hidden' value='$iemeCategorie[idCategorie]' name='idCategorie'>
                              
                            <button class='btnRadius'  type='submit' name='action' value='DesactiverCategorie'>
                                Désactiver
                             </button>
                       </form>
                  </td>";
            } elseif ($iemeCategorie["desactiverCategorie"] == 1) {
                $str .=  "<td>
                        <form style='display: contents'>
                            ".genereChampHiddenCSRF()."
                            <input type='hidden' name='case' value='Gerer_catalogue'>
                            
                            <input type='hidden' value='$iemeCategorie[idCategorie]' name='idCategorie'>
                             
                            <button class='btnRadius'  type='submit' name='action' value='ActiverCategorie'>
                                Activer
                             </button>
                       </form>
                  </td>";
            }
            $str .=  "</tr>";
            $i++;
        }
        $str .=  "</table>";
        return $str;
    }
}