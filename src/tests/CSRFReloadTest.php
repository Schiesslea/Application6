<?php
use PHPUnit\Framework\TestCase;
require_once 'src/Fonctions/CSRF--reload.php';
class CSRFReloadTest extends TestCase
{
protected function setUp(): void
{
session_start();
$_SESSION = []; // Réinitialise la session pour chaque test
}

public function testGenereCsrfGeneratesToken()
{
$token = genereCSRF();
$this->assertNotEmpty($token, "Le token généré ne doit pas être vide.");
$this->assertIsInt($token, "Le token généré doit être un entier.");
}

public function testGenereCsrfReturnsSameTokenIfUnused()
{
$token1 = genereCSRF();
$token2 = genereCSRF();
$this->assertEquals($token1, $token2, "Le token doit rester le même tant qu'il n'est pas utilisé.");
}

public function testGenereCsrfGeneratesNewTokenIfUsed()
{
$token1 = genereCSRF();
$_SESSION["CSRF"][0]["nbUsage"] = 1; // Simule l'utilisation du jeton
$token2 = genereCSRF();
$this->assertNotEquals($token1, $token2, "Un nouveau token doit être généré lorsque l'ancien est utilisé.");
}

public function testGenereChampHiddenCsrf()
{
$input = genereChampHiddenCSRF();
$this->assertStringContainsString('<input type="hidden" name="CSRF" value="', $input, "Le champ caché doit contenir un token CSRF.");
}

public function testGenereVarHrefCsrf()
{
$varHref = genereVarHrefCSRF();
$this->assertStringContainsString('&CSRF=', $varHref, "La variable CSRF pour les liens doit contenir un token CSRF.");
}

public function testVerifierCsrfValidToken()
{
$token = genereCSRF();
$result = verifierCSRF($token);
$this->assertTrue($result, "La vérification doit réussir pour un token valide.");
}

public function testVerifierCsrfInvalidToken()
{
genereCSRF();
$result = verifierCSRF(999999999);
$this->assertFalse($result, "La vérification doit échouer pour un token invalide.");
}

public function testVerifierCsrfIncrementsUsage()
{
$token = genereCSRF();
verifierCSRF($token);
$this->assertEquals(1, $_SESSION["CSRF"][0]["nbUsage"], "Le nombre d'utilisations doit être incrémenté après vérification.");
}

public function testVerifierCsrfStoresConsumedToken()
{
$token = genereCSRF();
verifierCSRF($token);
$this->assertEquals($token, $_SESSION["CSRFConsomme"], "Le jeton consommé doit être mémorisé.");
}

public function testDireIsReloadReturnsFalseForNewSession()
{
genereCSRF();
$isReload = direIsReload();
$this->assertFalse($isReload, "La fonction doit retourner false pour une nouvelle session.");
}

public function testDireIsReloadReturnsTrueOnReload()
{
genereCSRF();
$_SESSION["CSRF"][0]["nbUsage"] = 2; // Simule l'utilisation multiple du jeton
$isReload = direIsReload();
$this->assertTrue($isReload, "La fonction doit retourner true pour un rechargement de page.");
}
}

