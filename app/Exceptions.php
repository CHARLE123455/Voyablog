<?php

namespace App\Exceptions;

use Exception;

class InvalidPostException extends Exception
{
    public function __construct($message = "Invalid Post ID.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class InvalidUserException extends Exception
{
    public function __construct($message = "Invalid User.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class DatabaseException extends Exception
{
    public function __construct($message = "A database error occurred.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
class LikeAlreadyExistsException extends Exception
{
    public function __construct($message = "User has already liked this post.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
