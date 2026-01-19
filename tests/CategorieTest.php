<?php

namespace App\Tests;

use App\Entity\Categorie;
use App\Tests\Helper\TestEntityFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CategorieTest extends WebTestCase
{
    public function testLoggeduserCanCreateCategorie(): void
    {
        $client = static::createClient();

        $em = self::getContainer()->get(EntityManagerInterface::class);
        $hasher = self::getContainer()->get(UserPasswordHasherInterface::class);

        $user = TestEntityFactory::createUser($em, $hasher);
        $client->loginUser($user);

        $client->request('GET', '/categorie/new');
        $this->assertResponseIsSuccessful();

        $nom = 'Comedie ' . uniqid();
        $slug = 'comedie_' . uniqid();

        $client->submitForm('Save', [
            'categorie[nom]' => $nom,
            'categorie[slug]' => $slug,
        ]);

        $this->assertResponseRedirects('/categorie', 303);

        $repo = $em->getRepository(Categorie::class);
        $cat = $repo->findOneBy(['slug' => $slug]);

        self::assertNotNull($cat);
        self::assertSame($nom, $cat->getNom());
    }
}
