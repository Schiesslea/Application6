<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Entreprise_Liste  extends Vue_Composant
{
    private array $listeEntreprise;
    public function __construct(array $listeEntreprise)
    {
        $this->listeEntreprise=$listeEntreprise;
    }

    /**
     * Affiche la liste des entreprises
     * @param $listeEntreprise
     */
    function donneTexte(): string
    {
        $str= '
<H1>Liste des entreprises partenaires</H1>

    <table style="    display: inline-block;">
         <tr>
            <td colspan="5" style="text-align: center">
                <form style=\'display: contents\'>
                     ".genereChampHiddenCSRF()."
                    <input type="hidden" name="case" value="Gerer_entreprisesPartenaires">
 
                        <button type="submit" 
                                onmouseover="this.style.background=\'#FFFF99\';this.style.color=\'#FF0000\';"
                                onmouseout="this.style.background=\';this.style.color=\';" 
                                name="action" value="nouveau">
                                    Nouvelle entreprise ? 
                        </button>
                </form>
            </td>
 
        </tr>
        <tr>
            <th>Num compte</th>
            <th>Dénomination</th>
            <th>Ville</th>
        </tr>';

        $i=0;
        while ($i < count($this->listeEntreprise)) {
            $iemeEntreprise=$this->listeEntreprise[$i];

            $str .=  "
           
            
        <tr >
            <td>$iemeEntreprise[numCompte]</td>
            <td>$iemeEntreprise[denomination]</td>
            <td>$iemeEntreprise[codePostal] - $iemeEntreprise[ville]</td>
            ";


                $str .=  "
                <td>
                    <form style='display: contents'>
                        ".genereChampHiddenCSRF()."
                        <input type='hidden' name='case' value='Gerer_entreprisesPartenaires'>
                            <input type='hidden' value='$iemeEntreprise[idEntreprise]' name='idEntreprise'>
                            
                            <button type='submit' 
                                    onmouseover=\"this.style.background='#FFFF99';this.style.color='#FF0000';\"
                                    onmouseout=\"this.style.background='';this.style.color='';\" 
                                    name='action' value='Modifer'> 
                                        Modifier 
                            </button>
                    </form>
                </td>
                <!-- Création du bouton Désactiver ou Activer-->
                ";
                switch ($iemeEntreprise["desactiver"]) {
                    case 0:
                        $str .=  "
                <td>
                    <form style='display: contents'>
                        ".genereChampHiddenCSRF()."
                        <input type='hidden' name='case' value='Gerer_entreprisesPartenaires'>
                            <input type='hidden' value='$iemeEntreprise[idEntreprise]' name='idEntreprise'>
                            
                            <button type='submit' 
                                    onmouseover=\"this.style.background= '#FFFF99';this.style.color= '#FF0000';\"
                                    onmouseout=\"this.style.background='';this.style.color='';\" 
                                    name='action' value='DesactiverEntreprise'> 
                                            Désactiver 
                            </button>
                    </form>
                </td>
            </tr>
            
             ";
                        break;
                    case 1:
                        $str .=  "
                <td>
                    <form style='display: contents'>
                        ".genereChampHiddenCSRF()."
                            <input type='hidden' name='case' value='Gerer_entreprisesPartenaires'>
                            
                            <input type='hidden' value='$iemeEntreprise[idEntreprise]' name='idEntreprise'>
                            <button type='submit' 
                                    onmouseover=\"this.style.background ='#FFFF99';this.style.color= '#FF0000';\"
                                    onmouseout=\"this.style.background='';this.style.color='';\"
                                    name='action' value='ActiverEntreprise'> 
                                        Activer 
                            </button>
                    </form>
                </td>
            </tr>
            
             ";
                        break;
                }

            $i++;
        }

        $str .=  "
</table>";
    return $str;
    }
}