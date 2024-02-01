<?php

// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractController
{
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, SerializerInterface $serializer): Response
    {
       
        $data = json_decode($request->getContent(), true);
        // dd( $data['email']);
        // $data = $serializer->deserialize($request->getContent(), 'array', 'json');

        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password'])); // Updated method

       
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Generate JWT token for the user
        // ...

        return $this->json([
            'message' => 'User successfully registered',
            // 'token' => $jwtToken
        ]);
    }
}
