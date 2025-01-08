<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Action_Sur_Commande_Entreprise extends Vue_Composant
{
    private array $infoCommande;
    public function __construct(array $infoCommande)
    {
        $this->infoCommande=$infoCommande;
    }


    function donneTexte(): string
    {
        $str="";
        $str .=  "<H1>Action(s) sur cette commande</H1>
    <form>
         ".genereChampHiddenCSRF()."
        <input type='hidden' name='case' value='Gerer_CommandeClient' >
        <input type='hidden' name='changementEtatCommande' >
        <input type='hidden' name='idCommande' value='".$this->infoCommande["id"]."' >
";
        switch ($this->infoCommande["etat"]) {
            case 2:
                $str .=  "
                  <button type='submit' name='action' value='Signaler_CommandePayee'>
                        Commande payée, virement reçu
                  </button>
                  
                  <br>
                  <label>Informations complémentaires</label>
                  <input type='text' placeholder='numéro transaction' value='info' style='width: 400px;height: 80px'>
                ";
                break;
            case 3:
                $str .=  "
                <button type='submit' name='action' value='Signalee_CommandeEnPreparation'>
                    Commande en préparation (QTT OK)
                </button>               <br>
                
                
                <br>
                <button type='submit' name='action' value='Signalee_CommandeProblemeStock'>
                    Commande en attente approvisionnement (QTT Pas OK)
                </button>
                
                
                <br>
                  <label>Informations complémentaires</label>
                  <input type='text' placeholder='Estimation réassort' value='info' style='width: 400px;height: 80px'>
            ";
                break;
            case 4:
                $str .=  "
                <button type='submit' name='action' value='Signalee_CommandeEnvoyée'>
                    Commande expédiée
                </button>
                               
                <br>
                  <label>Informations complémentaires</label>
                  <input type='text' placeholder='Numero de colis' value='info' style='width: 400px;height: 80px'>";
                break;

            case 5:
                $str .=  "
                <button type='submit' value='action' name='Signalee_CommandeEnPreparation'>
                        Réassort arrivé
                </button>               
                ";

                break;
            case 6:
                $str .=  "Commande expédiée, nous sommes en attente de la réponse du client";
                break;


        }

        $str .=  " </form > ";
        return $str;
    }

}