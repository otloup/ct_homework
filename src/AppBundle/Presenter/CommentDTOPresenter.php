<?php
namespace AppBundle\Presenter;

use AppBundle\DTO\CommentDTO;
use Utils\Presenter\Presenter;

class CommentDTOPresenter extends Presenter
{
    /**
     * @param CommentDTO $commentDTO
     * @return array
     */
    protected function extractData($commentDTO)
    {
        return [
            'title' => $commentDTO->getTitle(),
            'content' => $commentDTO->getContent(),
            'createdOn' => $commentDTO->getCreatedOn()
        ];
    }
}