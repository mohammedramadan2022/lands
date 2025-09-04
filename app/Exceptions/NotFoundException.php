<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function render()
    {
        return responseError('Not Found',404);
    }
}
