<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 05.11.19
 * Time: 12:44
 */

namespace App\Exceptions;

/**
 * Class NotAllowException
 * @package App\Exceptions
 */
class NotAllowException extends \Exception
{
    public function __construct($message = '')
    {
        parent::__construct($message, 401);
    }
}