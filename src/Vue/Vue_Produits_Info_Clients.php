<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Produits_Info_Clients extends Vue_Composant
{

    private array $listeProduits;
    private int $idCategorie;
    private ?string $recherche;

    function __construct(array $listeProduits=[], int $idCategorie=-1, $recherche="")
    {
        $this->listeProduits=$listeProduits;
        $this->idCategorie=$idCategorie;
        $this->recherche=$recherche;

    }

    function donneTexte(): string
    {


        $str="<table style='margin: auto'>
            <h1>Liste des produits</h1>
                </table>";
        if (isset($this->listeProduits) and  (count($this->listeProduits) > 0)) {
            //print_r($listeProduits);
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
                    $desactivation=false;
                } else {
                    // Le produit est désactivée
                    $desactivation=true;
                }


                // Si le produit a été activé par l'utilisateur, alors il s'affiche sur le catalogue client
                if ($desactivation == false) {
                    $str .= "
             <table style='padding: 20px; margin-bottom: 50px;   display: inline-block; height: 300px; border: 1px solid #f1f1f1; box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24); background: #fff; ' >
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
                    <td> <div class='resume'> <b>Résumé :</b> $nResume</div></td>
                </tr>
                <tr>
                    <td><div class='resume'><b>Description :</b> $nDescription</div></td>
                </tr>
                
                <form>
                ".genereChampHiddenCSRF()."
                    <td colspan='2'>
                        <form>
                        ".genereChampHiddenCSRF()."
                        <input type='hidden' value='$nproduit' name='idProduit'>
                        <input type='hidden' value='$this->idCategorie' name='idCategorie'>
                        <input type='hidden' value='$this->recherche' name='recherche'>
                        <button class='btnRadius' type='submit' name='action' value='AjoutPanierClient'>
                            Ajouter au panier
                        </button>
                        
                       </form>
                    </td>
                    </form>
                </tr>
            
        ";
                    $str .= "</table>";
                }
            }
        } else {
            $str .= "<h3>Aucun produit n'est disponible pour le moment</h3>";
        }
        return $str;
    }
}