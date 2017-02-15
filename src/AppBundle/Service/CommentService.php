<?php
namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Repository\CommentCommandRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;

class CommentService
{
    /**
     * @var CommentCommandRepository
     */
    private $commentCommandRepository;

    /**
     * CommentService constructor.
     * @param CommentCommandRepository $commentCommandRepository
     */
    public function __construct(
        CommentCommandRepository $commentCommandRepository
    )
    {
        $this->commentCommandRepository = $commentCommandRepository;
    }

    /**
     * @param $title
     * @param $content
     * @param User $user
     * @return array
     * @throws \OutOfBoundsException
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     */
    public function addComment($title, $content, User $user)
    {
        return $this->commentCommandRepository->addComment($title, $content, $user);
    }
}