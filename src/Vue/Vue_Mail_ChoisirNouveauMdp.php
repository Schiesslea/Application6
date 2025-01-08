<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Mail_ChoisirNouveauMdp  extends Vue_Composant
{
    private string $token;
    private string $msg;
    public function __construct(string $token, string $msg="")
    {
        $this->token=$token;
        $this->msg=$msg;
    }

    function donneTexte(): string
    {
        return "  <form action='index.php' method='post' style='    width: 50%;    display: block;    margin: auto;'>
               ".genereChampHiddenCSRF()."
                <h1>Choisissez votre nouveau mdp</h1>
                <input type='hidden' name='token' value='$this->token'>
                <label><b>Compte</b></label>
                <input type='password' placeholder='nouveau mdp' name='mdp1' required>
                <input type='password' placeholder='confirme nouveau mdp' name='mdp2' required>
                
                <button type='submit' id='submit' name='action' value='choixmdp'>
                      Confirmer le mdp
                </button>
                <div> $this->msg </div>
            </form>
    ";
    }

}