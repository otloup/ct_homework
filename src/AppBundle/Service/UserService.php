<?php
namespace AppBundle\Service;

use AppBundle\Collection\UserDTOCollection;
use AppBundle\DTO\UserDTO;
use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Repository\UserCommandRepository;
use AppBundle\Repository\UserQueryRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;
use Utils\TypedCollection\TypedCollectionException;

class UserService
{
    /**
     * @var UserCommandRepository
     */
    private $userCommandRepository;
    /**
     * @var UserQueryRepository
     */
    private $userQueryRepository;

    /**
     * UserService constructor.
     * @param UserCommandRepository $userCommandRepository
     * @param UserQueryRepository $userQueryRepository
     */
    public function __construct(
        UserCommandRepository $userCommandRepository,
        UserQueryRepository $userQueryRepository
    )
    {
        $this->userCommandRepository = $userCommandRepository;
        $this->userQueryRepository = $userQueryRepository;
    }

    /**
     * @return UserDTOCollection
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     * @throws TypedCollectionException
     */
    public function getUsers()
    {
        $users = $this->userQueryRepository->getAllUsers();
        $usersCollection = new UserDTOCollection();

        if (!empty($users)) {
            /** @var User $user */
            foreach ($users as $user) {
                $usersCollection->add(UserDTO::createFromUser($user));
            }
        }

        return $usersCollection;
    }

    /**
     * @param string $name
     * @return array
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     * @throws \OutOfBoundsException
     */
    public function addUser($name, $email)
    {
        return $this->userCommandRepository->addUser($name, $email);
    }

    /**
     * @param $userId
     * @param Comment $comment
     */
    public function assignCommentToUser($userId, Comment $comment)
    {
        $this->userCommandRepository->assignCommentToUser($userId, $comment);
    }

    /**
     * @param $userId
     * @return User
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     */
    public function getUser($userId)
    {
        return $this->userQueryRepository->getUserById($userId);
    }
}