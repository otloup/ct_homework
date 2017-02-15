<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityManager;

/**
 * Class CommentCommandRepository
 * @package AppBundle\Repository
 */
class CommentQueryRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * CommentCommandRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager->getRepository('AppBundle:Comment');
    }

    public function getComments()
    {

    }

}