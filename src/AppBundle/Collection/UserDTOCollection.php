<?php
namespace AppBundle\Collection;

use AppBundle\DTO\UserDTO;
use Utils\TypedCollection\TypedCollection;

/**
 * Class CommentCollection
 * @package AppBundle\Collection
 */
class UserDTOCollection extends TypedCollection
{
    /**
     * CommentCollection constructor.
     */
    public function __construct()
    {
        $type = UserDTO::class;
        parent::__construct($type);
    }
}