<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;
class Vue_Salarie_Liste extends Vue_Composant
{
private array $listeSalarie;
private string $msg="";
    public function __construct(array $listeSalarie, string $msg="")
    {
        $this->listeSalarie=$listeSalarie;
        $this->msg=$msg;
    }

    function donneTexte(): string
    {

        $str= '
<H1>Liste des personnes habilitées à passer des commandes</H1>
<br>
Seuls les personnes habilitées peuvent passer des commandes au nom de votre entreprise. <br>
Ce compte d\'entreprise ne permet pas de passer des commandes.
<br>
Les salariés se connecteront avec leur e-mail<br>
    <table style="    display: inline-block;">
         <tr>
            <td colspan="5" style="text-align: center">
                <form style=\'display: contents\'>
                    ".genereChampHiddenCSRF()."
                    <input type="hidden" name="case" value="Gerer_Entreprise">
 
                        <button type="submit" 
                            onmouseover="this.style.background=\'#FFFF99\';this.style.color=\'#FF0000\';"
                            onmouseout="this.style.background=\'\';this.style.color=\'\';" 
                            name="action" 
                            value="ajouterSalarie"> 
                                Ajouter un salarié 
                        </button>
                </form>
            </td>
 
        </tr>';
        if (count($this->listeSalarie) <= 0) {
            $str .=  '

         <tr>
            <td colspan="5" style="text-align: center">
                Il n\'y pas encore de salarié. Vous devez en ajouter un.
            </td>

        </tr>';

        } else
            $str .=  '<tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Rôle</th>
         
         
        </tr>';

        foreach ($this->listeSalarie as $salarie) {
            $str .=  "
           
            
        <tr >
            <td>$salarie[nom]</td>
            <td>$salarie[prenom]</td>
            <td>$salarie[roleEntreprise]</td>
            ";
            /* if ($salarie["actif"])
                 $str .=  "Oui";
             else
                 $str .=  "Non";
             $str .=  "</td>";
     */

            $str .=  "
                <td>
                    <form style='display: contents'>
                    ".genereChampHiddenCSRF()."
                        <input type='hidden' name='case' value='Gerer_Entreprise'>
                            
                            <input type='hidden' value='$salarie[idSalarie]' name='idSalarie'>
                            
                            <button type='submit' 
                                onmouseover=\"this.style.background='#FFFF99';this.style.color='#FF0000';\"
                                onmouseout=\"this.style.background='';this.style.color='';\"
                                name='action'
                                value='ModiferSalarie'>
                                 Modifier 
                            </button>
                    </form>
                </td>
                <!-- Création du bouton Désactiver ou Activer-->
                ";

            switch ($salarie["actif"]) {
                case 0:
                    $str .=  "
                <td>
                    <form style='display: contents'>
                        ".genereChampHiddenCSRF()."
                        <input type='hidden' name='case' value='Gerer_Entreprise'>
                            <input type='hidden' value='$salarie[idSalarie]' name='idSalarie'>
                            
                            <button type='submit' 
                                onmouseover=\"this.style.background= '#FFFF99';this.style.color= '#FF0000';\"   
                                onmouseout=\"this.style.background='';this.style.color='';\"
                                name='action'
                                value='DesactiverSalarie'> 
                                    Désactiver 
                            </button>
                    </form>
                </td>";
                    break;
                case 1:
                    $str .=  "
                <td>
                    <form style='display: contents'>
                        ".genereChampHiddenCSRF()."
                            <input type='hidden' name='case' value='Gerer_Entreprise'>
                            <input type='hidden' value='$salarie[idSalarie]' name='idSalarie'>
                            
                            <button type='submit' 
                            onmouseover=\"this.style.background ='#FFFF99';this.style.color= '#FF0000';\"
                            onmouseout=\"this.style.background='';this.style.color='';\"
                            name='action' 
                            value='ActiverSalarie'>
                                Activer 
                            </button>
                    </form>
                </td>";
                    break;
            }
            $str .=  "</tr>";

        }


        $str .=  "</table>";
        $str .=  $this->msg;
        return $str;
    }
}