<?php

namespace App\Vue;

use App\Utilitaire\Vue_Composant;

class Vue_Panier_Client extends Vue_Composant
{

    private array $listeProduits;
    private bool $commandeFinalisee=false;
    private array $infoCommande=[];

    public function __construct(array $listeProduits, bool $commandeFinalisee=false, array $infoCommande=[])
    {
        $this->listeProduits=$listeProduits;
        $this->commandeFinalisee=$commandeFinalisee;
        $this->infoCommande=$infoCommande;
    }

    function donneTexte(): string
    {
        $str="";
        if ($this->commandeFinalisee == false)
            $str .= "<h1 > Panier</h1 > ";
        else
            $str .= "<h1 > Commande</h1 > ";

        if ($this->infoCommande != null) {
            //  var_dump($this->infoCommande);
            $str .= "<br > Numéro " . $this->infoCommande["id"] . ", créée le " . $this->infoCommande["dateCreation"] . " <br>";
        }
        //print_r($listeProduits);
        if (count($this->listeProduits) >= 1) {
            $str .= " <table style='padding: 20px; margin-bottom: 50px;   display: inline-block;   border: 1px solid #f1f1f1; box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24); background: #fff; ' >             
 <thead >
                    <tr >
                        <th colspan=2 > Article</th >
                        <th > Categorie</th >
                        <th > Reference</th >
                        <th > Prix HT </th >
                        <th colspan='3' > Quantité</th >
                        <th > Total HT </th >
                        <th > Taux TVA </th >
                        <th > Montant TVA </th >
                        <th > Total TTC </th >
                        
                    
                    </tr >
                
                </thead >


        ";


            $totalHT=0;
            $totalTVA=0;
            $totalTTC=0;
            foreach ($this->listeProduits as $produit) {


                // Si le produit a été activé par l'utilisateur, alors il s'affiche sur le catalogue client


                $path="public/image/" . $produit["fichierImage"];

                $str .= "
            
                <tr >
                    <td > ";
                if ($this->commandeFinalisee == false) $str .= "<img style='max-width: 50px; max-height: 50px; ' src='$path' > ";
                $str .= "</td >
                    <td > $produit[nom]</td >
                    <td > $produit[libelleCat]</td >
                    <td > $produit[idProduit]</td >
                    <td > $produit[prixVenteHT] € </td > ";
                if ($this->commandeFinalisee == false) {
                    $str .= "<td >
                    
                        <form style='display: contents' >
                        ".genereChampHiddenCSRF()."
                            <input type='hidden' name='case' value='Gerer_Panier' >
                            <input type='hidden' name='idProduit' value='$produit[idProduit]' />
                            
                            <button type='submit' name='action' value='diminuerQTT' style='width: auto'>-</button>
                    
                        </form > 
                    </td > 
                    <td style='text-align: center' >
            $produit[quantite]   
                     </td > 
                     <td >
                     <form style='display: contents' >
                        ".genereChampHiddenCSRF()."
                        <input type='hidden' name='case' value='Gerer_Panier' >
                        <input type='hidden' name='idProduit' value='$produit[idProduit]' >
                        
                        <button type='submit' name='action' value='augmenterQTT' style='width: auto'>+</button>
                    </form >
                    </td > ";
                } else {
                    $str .= "<td style='text-align: center' colspan='3' >
            $produit[quantite]   
                     </td > ";
                }
                $str .= "<td > ";
                $coutLigneHT=$produit["prixVenteHT"] * $produit["quantite"];
                $str .= $coutLigneHT;
                $totalHT += $coutLigneHT;

                $str .= " € </td > ";
                $str .= "<td > ";

                $str .= $produit["pourcentageTVA"];
                $str .= " %
                    </td >
                    <td > ";
                $coutMontantTVA=$coutLigneHT * $produit["pourcentageTVA"];
                $str .= $coutMontantTVA;
                $totalTVA += $coutMontantTVA;

                $str .= " €
        </td >
                    <td > ";
                $coutTotalTTC=$coutMontantTVA + $coutLigneHT;
                $str .= $coutTotalTTC;
                $totalTTC += $coutTotalTTC;
                $str .= " €
        </td >
                </tr >


        ";

            }
            $str .= "
            <tr >
                <td colspan='8' style='text-align: right' > <b > Total</b ></td >
                <td > $totalHT € </td >
                <td ></td >
                <td > $totalTVA € </td >
                <td > $totalTTC € </td >
            
            </tr > ";
            if ($this->commandeFinalisee == false)
                $str .= "
            <tr >
                <td colspan='12' style='text-align: center' >
                    <form style='display: contents' >
                        ".genereChampHiddenCSRF()."
                        <input type='hidden' name='case' value='Gerer_Panier' >
                        <input type='hidden' name='idProduit' value='$produit[idProduit]' >
                        
                        <button type='submit' name='action' value='validerPanier' style='width: auto'>
                            VALIDER CETTE COMMANDE
                        </button>
                    </form >
                </td >
            </tr > ";
            $str .= "</table > ";

        } else {
            $str .= "<h3 > Panier vide !</h3 > ";
        }
        return $str;
    }

}