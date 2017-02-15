<?php

namespace AppBundle\DTO;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class UserDTO
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $email;
    /**
     * @var Collection
     */
    private $comments;
    /**
     * @var int
     */
    private $id;

    /**
     * UserDTO constructor.
     * @param int $id
     * @param string $name
     * @param string $email
     * @param Collection $comments
     */
    private function __construct(
        $id,
        $name,
        $email,
        Collection $comments
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->comments = $comments;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param User $user
     * @return UserDTO
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     */
    public static function createFromUser(User $user)
    {
        return new self(
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getComments()
        );
    }
}