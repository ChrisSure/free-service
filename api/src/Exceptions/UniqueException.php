<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 05.11.19
 * Time: 12:44
 */

namespace App\Exceptions;

/**
 * Class UniqueException
 * @package App\Exceptions
 */
class UniqueException extends \Exception
{
    public function __construct($message = '')
    {
        parent::__construct($message, 403);
    }
}