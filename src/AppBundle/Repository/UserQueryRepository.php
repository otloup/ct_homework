<?php
namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class UserQueryRepository
{
    /**
     * @var EntityRepository
     */
    private $entityRepository;

    /**
     * UserQueryRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityRepository = $entityManager->getRepository('AppBundle:User');
    }

    /**
     * @return \AppBundle\Entity\User[]|array
     */
    public function getAllUsers()
    {
        $query = $this->entityRepository->createQueryBuilder('user')
                    ->where('user.email IS NOT NULL')
                    ->orderBy('user.id', 'DESC')
                    ->getQuery();

        return $query->getResult();
    }

    /**
     * @param $userId
     * @return User
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     */
    public function getUserById($userId)
    {
        return $this->entityRepository->find($userId);
    }

}