<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CommentCommandRepository
 * @package AppBundle\Repository
 */
class CommentCommandRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * CommentCommandRepository constructor.
     * @param EntityManager $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManager $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @param $title
     * @param $content
     * @param User $user
     * @return array
     * @throws \OutOfBoundsException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function addComment($title, $content, User $user)
    {
        $errors = [];

        $comment = new Comment();
        $comment->setTitle($title);
        $comment->setContent($content);
        $comment->setAuthor($user);

        $validationErrors = $this->validator->validate($comment);

        if (0 === $validationErrors->count()) {
            $this->entityManager->persist($comment);
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

}