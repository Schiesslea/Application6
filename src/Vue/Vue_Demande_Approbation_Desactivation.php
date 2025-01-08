<?php

namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Demande_Approbation_Desactivation  extends Vue_Composant
{
    private string $idCategorie;
    public function __construct(string $idCategorie ="")
    {
        $this->idCategorie=$idCategorie;
    }

    function donneTexte(): string
    {

        return   " <table style='margin: auto'>
            <h3> Etes-vous sûr(e) de vouloir désactiver cette catégorie ?
             <br> Si oui, les produits se trouvant à l'intérieur de celle-ci ne seront plus visibles sur le catalogue client.</h3>
            <form style='display: contents; align-content: center'>
                ".genereChampHiddenCSRF()."
                <input type='hidden' value='$this->idCategorie' name='idCategorie'>
                <input type='hidden' name='case' value='Gerer_catalogue'>
                
                <td style='width: 100px; height: 100px;'>
                    <button type='submit' name='action' value='OuiDesactivation'>Oui</button>
                </td>
                <td style='width: 100px; height: 100px;'>
                    <button type='submit' name='action' value='AnnulerDesactivation'>Annuler</button>
                </td>
            </form>
            </table>
 ";
    }
}