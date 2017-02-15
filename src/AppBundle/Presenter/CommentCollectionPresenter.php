<?php
namespace AppBundle\Presenter;

use AppBundle\DTO\CommentDTO;
use AppBundle\Entity\Comment;
use Doctrine\Common\Collections\Collection;
use Utils\Presenter\Presenter;

class CommentCollectionPresenter extends Presenter
{
    /**
     * @param Collection $commentCollection
     * @return array
     */
    protected function extractData($commentCollection)
    {
        $view = [];

        if ($commentCollection->count() > 0) {
            $commentCollectionIterator = $commentCollection->getIterator();

            while($commentCollectionIterator->valid()) {
                /** @var Comment $currentComment */
                $currentComment = $commentCollectionIterator->current();
                $view[] = (new CommentDTOPresenter())->presentAsArray(CommentDTO::createFromComment($currentComment));

                $commentCollectionIterator->next();
            }
        }

        return $view;
    }
}