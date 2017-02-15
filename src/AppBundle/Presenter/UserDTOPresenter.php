<?php
namespace AppBundle\Presenter;

use AppBundle\DTO\UserDTO;
use Utils\Presenter\Presenter;

class UserDTOPresenter extends Presenter
{
    /**
     * @param UserDTO $userDTO
     * @return array
     */
    protected function extractData($userDTO)
    {
        return [
            'id' => $userDTO->getId(),
            'name' => $userDTO->getName(),
            'email' => $userDTO->getEmail(),
            'comments' => $userDTO->getComments()->count()
        ];
    }
}