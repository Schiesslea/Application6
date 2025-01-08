<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Produit_Tous extends Vue_Composant
{
    private array $listeProduits;
    private  int $idCategorie=-1;
    public function __construct(array $listeProduits, int $idCategorie=-1)
    {
        $this->listeProduits=$listeProduits ;
        $this->idCategorie=$idCategorie ;
    }

    function donneTexte(): string
    {
        $str= "";
        $str .= "
                <table style='margin: auto'>
                    <tr>
                        <td colspan='4'>
                            <form style='display: contents;' method='post'>
                                ".genereChampHiddenCSRF()."
                                <input type='hidden' name='case' value='Gerer_catalogue'>
                                <input type='hidden' name='idCategorie' value='$this->idCategorie'>
                                <button class='btnRadius' type='submit' value='nouveauProduit' name='action'>
                              Nouveau produit ?</button> 
                            </form>   
                        </td>
                    </tr>
                </table>
                ";
        if (isset($this->listeProduits) and is_array($this->listeProduits) and (count($this->listeProduits) > 0)) {
            foreach ($this->listeProduits as $produit) {
                $nArticle=$produit["nom"];
                $nReference=$produit["reference"];
                $nCategorie=$produit["libelle"];
                $nPrixHT=$produit["prixVenteHT"];
                $nResume=$produit["resume"];
                $nDescription=$produit["description"];
                $nImage=$produit["fichierImage"];
                $path="public/image/" . $nImage;
                $nproduit=$produit["idProduit"];
                if ($produit["desactiverProduit"] == 0) {
                    // le produit est activé
                    $desactivation=false;
                } else {
                    // Le produit est désactivée
                    $desactivation=true;
                }

                $str .= "
            <form id='form-id-$nproduit' class='form_produit'>
            ".genereChampHiddenCSRF()."
            <input type='hidden' value='$nproduit' name='idProduit'>
            <input type='hidden' name='action' value='ModifierProduit'>
            <input type='hidden' name='case' value='Gerer_catalogue'>
            <button onclick='document.getElementById('form-id-" . $nproduit . "').submit();'>
                 <table style='padding: 20px;    display: inline-block;     ' >
                    <tr>
                        <td style='vertical-align: top;width : 400px'>
                            <b>Article : </b>
                            $nArticle <br>
                        </td><td rowspan='6'>  <br><div style='height:220px; width: 220px; text-align: center'><img style='max-width: 220px; max-height: 220px; ' src='$path'></div></td>
                    </tr>
                    <tr>   
                        <td style='vertical-align: top;width : 400px'>
                            <b>Categorie : </b>
                            $nCategorie<br>
                        </td>
                    </tr>
                    <tr>   
                        <td style='vertical-align: top;width : 400px'>
                            <b>Code référence : </b>
                            $nReference<br>
                        </td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width : 400px'><b>Prix : </b>$nPrixHT € HT</td>
                    </tr>
                    <tr>
                        <td><div class='resume'> <b>Résumé :</b> $nResume</div></td>
                    </tr> 
                    <tr>
                        <td><div class='resume'><b>Description :</b> $nDescription</div></td>
                    </tr>
                    ";
                $str .= "</table>
            </button>
            </form>";
            }
        } else {
            $str .= "<h3>Aucun produit n'est disponible pour le moment</h3>";
        }
        return $str;
    }
}