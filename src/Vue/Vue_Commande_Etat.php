<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Commande_Etat extends Vue_Composant
{
    private array $listeEtatCommande;
    public function __construct(array $listeEtatCommande)
    {
        $this->listeEtatCommande=$listeEtatCommande;
    }

    function donneTexte(): string
    {
        $str="";
        $i=0;
        $str .=  "<nav id='etatCommande'>
                <ul id='menu-closed'>
                ";

        $str .=  "
                <form style='display: contents'> 
                    ".genereChampHiddenCSRF()."
                    <input type='hidden' name='case' value='Gerer_Commande'>
                    
                    <li><button type='submit' name='action' value='Toute'>Toutes</button> </li>
                </form>";

        while ($i < count($this->listeEtatCommande)) {
            $iemeEtatCommande=$this->listeEtatCommande[$i];

            $str .=  "
                   <li>
                        <form style='display: contents'> 
                            ".genereChampHiddenCSRF()."
                            <input type='hidden' name='case' value='Gerer_Commande'>
                            <input type='hidden' name='idEtatCommande' value='$iemeEtatCommande[idEtatCommande]'>
                            <button type='submit' name='action' value='boutonCategorie'> $iemeEtatCommande[libelle]</button>
                        </form>
                   </li> 
                   ";

            $i++;
        }
        $str .=  "
                <form style='display: contents'> 
                    ".genereChampHiddenCSRF()."
                    <input type='hidden' name='case' value='Gerer_Commande'> 
                    <li><input type='text' name='recherche' placeholder='Rechercher'> </li>
                    <li><button type='submit' name='action' value='okRechercher'>OK</button> </li>
                </form>";
        $str .=  "
            </ul>
            </nav>";
        return $str;
    }

}