<?php
namespace AppBundle\Presenter;

use AppBundle\Collection\UserDTOCollection;
use Utils\Presenter\Presenter;

class UserDTOCollectionPresenter extends Presenter
{
    /**
     * @param UserDTOCollection $userDTOCollection
     * @return array
     */
    protected function extractData($userDTOCollection)
    {
        $view = [];

        if (null !== $userDTOCollection) {
            $userCollectionIterator = $userDTOCollection->getIterator();

            while($userCollectionIterator->valid()) {
                $currentUser = $userCollectionIterator->current();
                $view[] = (new UserDTOPresenter())->presentAsArray($currentUser);

                $userCollectionIterator->next();
            }
        }

        return $view;
    }
}