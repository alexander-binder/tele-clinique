<?php

namespace App\Controller;

use App\Entity\TestResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Security\TestResourceVoter;


class TestResourceController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/api/test-resources', name: 'get_test_resources', methods: ['GET'])]
public function getTestResources(SerializerInterface $serializer): Response
{
    $repository = $this->entityManager->getRepository(TestResource::class);
    $resources = $repository->findAll();

    $viewableResources = [];
    foreach ($resources as $resource) {
     
        $data = [];
        if ($this->isGranted('VIEW_PUBLIC', $resource)) {
           
            $data['public_data'] = $resource->getPublicData();
        }
        if ($this->isGranted('VIEW_PRIVATE', $resource)) {
     
            $data['private_user_data'] = $resource->getPrivateUserData();
        }
        if ($this->isGranted('VIEW_ADMIN', $resource)) {
          
            $data['admin_only_data'] = $resource->getAdminOnlyData();
        }
        $viewableResources[] = $data;
    }

    

          $jsonResources = $serializer->serialize($viewableResources, 'json', [
            'groups' => ['default']
        ]);

    return new Response($jsonResources, Response::HTTP_OK, ['Content-Type' => 'application/json']);
}


    #[Route('/api/test-resource/{id}', name: 'get_test_resource_by_id', methods: ['GET'])]
    public function getTestResourceById(int $id, SerializerInterface $serializer): Response
    {
        $repository = $this->entityManager->getRepository(TestResource::class);
        $resource = $repository->find($id);

        if (!$resource) {
            return $this->json(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        $jsonResource = $serializer->serialize($resource, 'json', [
            'attributes' => ['id', 'public_data', 'private_user_data', 'admin_only_data'],
        ]);

        return new Response($jsonResource, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    #[Route('/api/test-resource/create', name: 'create_test_resource', methods: ['POST'])]
    public function createTestResource(Request $request, ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(), true);
        $resource = new TestResource();
    
        // Setting fields from the request data
        $resource->setPublicData($data['public_data'] ?? null);
        $resource->setPrivateUserData($data['private_user_data'] ?? null);
        $resource->setAdminOnlyData($data['admin_only_data'] ?? null);
    
        // Validate the entity
        $errors = $validator->validate($resource);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(['message' => 'Validation failed', 'errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }
    
        $this->entityManager->persist($resource);
        $this->entityManager->flush();
    
        return $this->json(['message' => 'Resource created successfully', 'id' => $resource->getId()], Response::HTTP_CREATED);
    }
    

    #[Route('/api/test-resource/edit/{id}', name: 'update_test_resource', methods: ['PUT'])]
    public function updateTestResource(int $id, Request $request): Response
    {
        $repository = $this->entityManager->getRepository(TestResource::class);
        $resource = $repository->find($id);
    
        if (!$resource) {
            return $this->json(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }
    
        $data = json_decode($request->getContent(), true);
    
        if (isset($data['public_data'])) {
            $resource->setPublicData($data['public_data']);
        }
        if (isset($data['private_user_data'])) {
            $resource->setPrivateUserData($data['private_user_data']);
        }
        if (isset($data['admin_only_data'])) {
            $resource->setAdminOnlyData($data['admin_only_data']);
        }
    
        $this->entityManager->flush();
    
        return $this->json(['message' => 'Resource updated successfully']);
    }
    

    #[Route('/api/test-resource/{id}', name: 'delete_test_resource', methods: ['DELETE'])]
    public function deleteTestResource(int $id): Response
    {
        $repository = $this->entityManager->getRepository(TestResource::class);
        $resource = $repository->find($id);

        if (!$resource) {
            return $this->json(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($resource);
        $this->entityManager->flush();

        return $this->json(['message' => 'Resource deleted successfully']);
    }
}
