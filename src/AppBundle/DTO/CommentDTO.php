<?php

namespace AppBundle\DTO;


use AppBundle\Entity\Comment;

class CommentDTO
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $content;
    /**
     * @var \DateTime
     */
    private $createdOn;

    /**
     * CommentDTO constructor.
     * @param string $title
     * @param string $content
     * @param \DateTime $createdOn
     */
    private function __construct($title, $content, \DateTime $createdOn)
    {
        $this->title = $title;
        $this->content = $content;
        $this->createdOn = $createdOn;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Comment $comment
     * @return CommentDTO
     */
    public static function createFromComment(Comment $comment)
    {
        return new self(
            $comment->getTitle(),
            $comment->getContent(),
            $comment->getCreatedOn()
        );
    }
}