<?php

namespace App\Controller;

use App\Entity\TestResource;
use App\Entity\TestResource2;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Security\TestResourceVoter;


class TestResource2Controller extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/api/test-resources2', name: 'get_test_resources2', methods: ['GET'])]
    public function getTestResources(SerializerInterface $serializer): Response
    {
        $repository = $this->entityManager->getRepository(TestResource2::class);
        $resources = $repository->findAll();

        $group = 'public'; // Default group for all users
    
        if ($this->isGranted('ROLE_SUBSCRIBE_USER')) {
           
            $group = 'subscriber'; // Group for subscribe users
        } 
    
        if ($this->isGranted('ROLE_ADMIN')) {
            // dd('hello I am admin');
            $group = 'admin'; // Group for admins

        }

       
    
        $jsonResources = $serializer->serialize($resources, 'json', [
            'groups' => [$group]
        ]);
    
        return new Response($jsonResources, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
    


  
}
