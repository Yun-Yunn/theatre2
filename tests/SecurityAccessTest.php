<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityAccessTest extends WebTestCase
{
    public function testAccessNewCategorie(): void
    {
        $client = static::createClient();
        $client->request('GET', 'categorie/new');
        $this->assertResponseRedirects('/login');
    }
}
