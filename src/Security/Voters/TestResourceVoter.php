<?php
namespace App\Security\Voters;

use App\Entity\TestResource;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TestResourceVoter extends Voter
{


    protected function supports(string $attribute, $subject): bool
    {
        // Only vote on TestResource objects for specific attributes
        return $subject instanceof TestResource && in_array($attribute, ['VIEW_PUBLIC', 'VIEW_PRIVATE', 'VIEW_ADMIN']);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
       
        $user = $token->getUser();
     

        // If the user is not authenticated, deny access
        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case 'VIEW_PUBLIC':
                // All users can view public data
                return true;
            case 'VIEW_PRIVATE':
                // Subscribe users can view their own private data
                return $user->hasRole(User::ROLE_SUBSCRIBE_USER) && $subject->getUser()->getId() === $user->getId();
            case 'VIEW_ADMIN':
                // Admins can view all data
                return $user->hasRole(User::ROLE_ADMIN);
        }

        return false;
    }
}
