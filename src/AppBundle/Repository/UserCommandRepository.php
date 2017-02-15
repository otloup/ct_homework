<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\Config\Tests\Util\Validator;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserCommandRepository
{
    private $entityRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var Validator
     */
    private $validator;

    /**
     * UserCommandRepository constructor.
     * @param EntityManager $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManager $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityManager->getRepository('AppBundle:User');
        $this->validator = $validator;
    }

    /**
     * @param string $name
     * @param string $email
     * @return array
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     * @throws \OutOfBoundsException
     */
    public function addUser($name, $email)
    {
        $user = new User();
        $user->setName($name);
        $user->setEmail($email);

        $errors = [];

        $validationErrors = $this->validator->validate($user);

        if (0 === $validationErrors->count()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } else {
            for ($i = 0; $i < $validationErrors->count(); $i++) {
                /** @var ConstraintViolation $error */
                $error = $validationErrors->get($i);
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }
        }

        return $errors;

    }

    public function assignCommentToUser($userId, Comment $comment)
    {
        /** @var User $user */
        $user = $this->entityRepository->find($userId);

        $comments = $user->getComments();
        $comments->add($comment);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}