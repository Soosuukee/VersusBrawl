<?php

namespace App\Security\Voter;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EventVoter extends Voter
{
    public const CREATE = 'EVENT_CREATE';
    public const DELETE = 'EVENT_DELETE';
    public const EDIT = 'EVENT_EDIT';
    public const MANAGE = 'EVENT_MANAGE';

    public function __construct(private Security $security) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::CREATE, self::DELETE, self::EDIT, self::MANAGE])
            && ($subject instanceof Event || $subject === null);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        switch ($attribute) {
            case self::CREATE:
                if ($this->security->isGranted('ROLE_EVENT_ADMIN')) {
                    return true;
                }

                if ($this->security->isGranted('ROLE_USER')) {
                    if ($subject instanceof Event) {
                        return strtolower((string) $subject->getMode()) === 'deathmatch';
                    }

                    return true;
                }

                return false;

            case self::EDIT:
                if (!$subject instanceof Event) {
                    return false;
                }

                if ($this->security->isGranted('ROLE_EVENT_ADMIN')) {
                    return $subject->getCreatedBy() === $user;
                }

                return false;

            case self::DELETE:
                if (!$subject instanceof Event) {
                    return false;
                }

                if ($this->security->isGranted('ROLE_EVENT_ADMIN')) {
                    return $subject->getCreatedBy() === $user;
                }

                return false;

            case self::MANAGE:
                return $this->security->isGranted('ROLE_SUPER_ADMIN') || $this->security->isGranted('ROLE_EVENT_ADMIN');
        }

        return false;
    }
}
