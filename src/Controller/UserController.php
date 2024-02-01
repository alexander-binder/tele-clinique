<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class UserController extends AbstractController
{
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/api/users', name: 'get_users', methods: ['GET'])]
    public function getUsers(SerializerInterface $serializer): Response
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $users = $userRepository->findAll();

        //  transforming the $users array to a more API-friendly structure
        // to handle sensitive data like password

        $jsonUsers = $serializer->serialize($users, 'json', [
            'attributes' => ['id', 'username', 'email','roles' ],
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']
        ]);
           
            return new Response($jsonUsers, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }



    #[Route('/api/user/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function getUserById(int $id, SerializerInterface $serializer): Response
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->find($id);
    
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
    
        // Serialize the user object, excluding sensitive fields
        $jsonUser = $serializer->serialize($user, 'json', [
            'attributes' => ['id', 'username', 'email','roles' ],
            // If you have nested objects or relations, you can control their serialization as well
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['password', /* other sensitive attributes */]
        ]);
    
        return new Response($jsonUser, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }


    #[Route('/api/user/delete/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function deleteUser(int $id): Response
    {

        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json(['message' => 'User deleted successfully']);
    }
}