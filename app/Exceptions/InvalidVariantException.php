<?php
namespace App\Exceptions;

use Exception;

class InvalidVariantException extends Exception
{
    public function report()
    {
        logger('Invalid Variant');
    }
}
