<?php

namespace App\Tests\Helper;

use App\Entity\Categorie;
use App\Entity\Utilisateur;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class TestEntityFactory
{
    public static function createUser(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
        ?string $email = null,
        string $plainPassword = "password230"
    ) {
        $user = new Utilisateur();
        $user->setEmail($email ?? ('user_' . uniqid() . '@test.local'));
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($hasher->hashPassword($user, $plainPassword));
        $em->persist($user);
        $em->flush();
        return $user;
    }
    public static function createCategorie(
        EntityManagerInterface $em,
        ?string $nom = null,
        ?string $slug = null,
    ){
        $categorie = new Categorie();
        $categorie->setNom( $nom ?? ('cat '.uniqid()));
        $categorie->setSlug( $slug ?? ('cat_'.uniqid()));
        if(method_exists($categorie, 'setCreatedAt')){
            $categorie->setCreatedAt(new DateTimeImmutable());
        }
        $em->persist( $categorie);


            
            }
}
