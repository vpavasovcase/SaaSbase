<?php

namespace App\GraphQL\Exceptions;

use GraphQL\Error\ClientAware;
use Nuwave\Lighthouse\Exceptions\AuthorizationException;

class ClientAwareAuthorizationException extends AuthorizationException implements ClientAware
{
    public function isClientSafe(): bool

    {
        return true;
    }

    public function getCategory(): string
    {
        return 'custom';
    }
}
