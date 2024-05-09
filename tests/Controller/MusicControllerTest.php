<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Music;
use App\Entity\User;

// Classe de test pour le contrôleur de musique
class MusicControllerTest extends WebTestCase
{
    // Teste la page d'index de la musique
    public function testIndex()
    {
        // Crée un client pour faire des requêtes
        $client = static::createClient();

        // Fait une requête GET sur la page d'index de la musique
        $crawler = $client->request('GET', '/music/');

        // Vérifie que la réponse est réussie
        $this->assertResponseIsSuccessful();

        // Vérifie que le texte 'Musique' est présent dans le h1 de la page
        $this->assertSelectorTextContains('h1', 'Musique');

        // Restaure les gestionnaires d'erreurs et d'exceptions par défaut
        restore_error_handler();
        restore_exception_handler();
    }

    // Teste la page de création de nouvelle musique
    public function testNew()
    {
        // Crée un client pour faire des requêtes
        $client = static::createClient();

        // Fait une requête GET sur la page de création de nouvelle musique
        $crawler = $client->request('GET', '/music/new');

        // Vérifie que la réponse est réussie
        $this->assertResponseIsSuccessful();

        // Vérifie que le texte 'Nouvelle Musique' est présent dans le h1 de la page
        $this->assertSelectorTextContains('h1', 'Nouvelle Musique');

        // Restaure les gestionnaires d'erreurs et d'exceptions par défaut
        restore_error_handler();
        restore_exception_handler();
    }

    // Teste la page de visualisation d'une musique
    public function testShow()
    {
        // Crée un client pour faire des requêtes
        $client = static::createClient();

        // Fait une requête GET sur la page de visualisation d'une musique
        $crawler = $client->request('GET', '/music/1');

        // Vérifie que la réponse est réussie
        $this->assertResponseIsSuccessful();

        // Vérifie que le texte 'Musique' est présent dans le h1 de la page
        $this->assertSelectorTextContains('h1', 'Musique');

        // Restaure les gestionnaires d'erreurs et d'exceptions par défaut
        restore_error_handler();
        restore_exception_handler();
    }

    // Teste la page d'édition d'une musique
    public function testEdit()
    {
        // Crée un client pour faire des requêtes
        $client = static::createClient();

        // Obtient le conteneur de services
        $container = self::getContainer();

        // Récupère un utilisateur existant
        $userRepository = $container->get('doctrine')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.fr');

        // Vérifie que l'utilisateur existe
        if (!$testUser) {
            $this->fail('User not found');
        }

        // Authentifie l'utilisateur
        $client->loginUser($testUser);

        // Vérifie que la musique avec l'ID 1 existe
        $musicRepository = $container->get('doctrine')->getRepository(Music::class);
        $music = $musicRepository->find(1);

        // Si la musique n'existe pas, le test échoue
        if (!$music) {
            $this->fail('Music not found');
        }

        // Fait une requête GET sur la page d'édition de la musique
        $crawler = $client->request('GET', '/music/1/edit');

        // Vérifie que la réponse est réussie
        $this->assertResponseIsSuccessful();

        // Vérifie que le texte 'Modifier Music' est présent dans le h1 de la page
        $this->assertSelectorTextContains('h1', 'Modifier Music');

        // Restaure les gestionnaires d'erreurs et d'exceptions par défaut
        restore_error_handler();
        restore_exception_handler();
    }
}