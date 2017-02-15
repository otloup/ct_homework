<?php
namespace Utils\TypedCollection;

use Exception;

/**
 * Exception for typed collection
 * @package Utils\TypedCollection
 */
class TypedCollectionException extends \Exception
{
    const INVALID_TYPE_CODE = 0;
    const INVALID_TYPE_MESSAGE = 'supplied object does not correspond to declared type of collection';

    /**
     * TypedCollectionException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param Exception|null $exception
     * @return TypedCollectionException
     */
    public static function createWithInvalidType (\Exception $exception = null)
    {
        return new self(
            self::INVALID_TYPE_MESSAGE,
            self::INVALID_TYPE_CODE,
            $exception
        );
    }
}