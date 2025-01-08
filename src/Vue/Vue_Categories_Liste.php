<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Categories_Liste extends Vue_Composant
{
    private array $listeCategorie;
    private bool $utilisateur=true;
    public function __construct(array $listeCategorie, bool $utilisateur=true)
    {
        $this->listeCategorie=$listeCategorie;
        $this->utilisateur=$utilisateur;
    }

    function donneTexte(): string
    {
        $str="";
        $i=0;
        $str .= "<nav id='categorie'>
                <ul id='menu-closed'>
                ";
        if ($this->utilisateur) {
            $str .= "<form style='display: contents'> 
            ".genereChampHiddenCSRF()."
                <li>
                    <input type='hidden' name='case' value='Gerer_catalogue'>
                    
                    <button type='submit' name='action' value='AjouterCategorie'>+</button> </li>
                </form>";
        }


        while ($i < count($this->listeCategorie)) {
            $iemeCategorie=$this->listeCategorie[$i];
            if ($iemeCategorie["desactiverCategorie"] == 0) {
                $str .= "
                   <li>
                        <form style='display: contents'> 
                            ".genereChampHiddenCSRF()."
                            <input type='hidden' name='case' value='Gerer_catalogue'>
                            <input type='hidden' name='idCategorie' value='$iemeCategorie[idCategorie]'>
                            <button type='submit' value='boutonCategorie' name='action'>
                                $iemeCategorie[libelle]
                            </button>
                        </form>
                   </li> 
                   ";
            }
            $i++;
        }
        $str .= "
                <form style='display: contents'> 
                    ".genereChampHiddenCSRF()."
                    <li><input type='text' name='recherche' placeholder='Rechercher'> </li>
                        <input type='hidden' name='case' value='Gerer_catalogue'>
                    <li>
                                <button type='submit' value='okRechercher' name='action'>OK</button>
                     </li>
                </form>";

        $str .= "
            </ul>
            </nav>";

        return $str;
    }
}