<?php

namespace App\Factories;

use GraphQL\Error\UserError;

class UserErrorFactory
{
    public function create(\Exception $e = null): UserError
    {
        return new UserError($e->getMessage(), $e->getCode(), $e);
    }
}
