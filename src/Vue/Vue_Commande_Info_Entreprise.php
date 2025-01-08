<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Commande_Info_Entreprise extends Vue_Composant
{
    private array $listeCommande;
    public function __construct(array $listeCommande)
    {
        $this->listeCommande=$listeCommande;
    }

    function donneTexte(): string
    {
    $str="";
        $str .=  " 
            <h1 > Commandes</h1 >
        ";

        //print_r($listeProduits);
        if (count($this->listeCommande) >= 1) {
            $str .=  " <table style='padding: 20px; margin-bottom: 50px;   display: inline-block;   border: 1px solid #f1f1f1; box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24); background: #fff; ' >             
 <thead >
                    <tr >
                        <th > Reference Commande </th >
                        <th > Date commande </th >
                        
                        <th > Nb d'articles</th>
                        <th >Total HT</th>
                        <th >Montant TVA</th>
                        <th >Total TTC</th>
                        
                        <th>Etat</th>
                    
                    </tr>
                
                </thead>

 
             ";

            //var_dump($listeCommande);
            foreach ($this->listeCommande as $item) {

                $montantTVA=$item["prixTotalTTC"] - $item["prixTotalHT"];
                $str .=  "
            <tr style='text - align: center;font - size: '>
                        <td>$item[id]</td>
                        <td >$item[dateCreation]</td>
                        
                        <td >$item[nbProduit]</td>
                        <td >" . number_format($item["prixTotalHT"], 2) . " €</td>
                        <td >" . number_format($montantTVA, 2) . " €</td>
                        <td >" . number_format($item["prixTotalTTC"], 2) . " €</td>
                        <td >$item[libEtat]</td>
                        <td >
                            <form style='display: contents'>
                                ".genereChampHiddenCSRF()."
                                <input type='hidden' name='case' value='Gerer_CommandeClient'>
                                <input type='hidden' name='idCommande' value='$item[id]'/>
                                
                                <button type='submit' name='action' value='VoirDetailCommande'>Voir</button>
                            
                            </form>
                        </td>
                    </tr>
            ";

            }


        } else
            $str .=  "Vous n'avez pas encore passé de commande";
        return $str;
    }
}