<?php

namespace App\GraphQL\Execution;

use Closure;
use GraphQL\Error\Error;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;
use Nuwave\Lighthouse\Execution\ExtensionErrorHandler;
use App\GraphQL\Exceptions\ClientAwareAuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Config;

/**
 * Handle Exceptions that implement Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions
 * and add extra content from them to the 'extensions' key of the Error that is rendered
 * to the User.
 */
class CustomExtensionErrorHandler extends ExtensionErrorHandler
{
    public static function handle(Error $error, Closure $next): array
    {
        $underlyingException = $error->getPrevious();

        if ($underlyingException instanceof RendersErrorsExtensions) {
            // Reconstruct the error, passing in the extensions of the underlying exception
            $origin = Config::get('app.debug') ? $underlyingException->getFile() . ', line: ' . $underlyingException->getLine() : null;
            $error = new Error( // @phpstan-ignore-line TODO remove after graphql-php upgrade
                $error->message,
                null,
                null,
                null,
                $origin,
                null,
                $underlyingException->extensionsContent(),

            );
        }
        /*
        if ($error->getPrevious() instanceof AuthenticationException) {
            $error = new Error(
                $error->message,
                $error->nodes,
                $error->getSource(),
                $error->getPositions(),
                $error->getPath(),
                new ClientAwareAuthorizationException(
                    $error->getPrevious()->getMessage(),
                    $error->getPrevious()->guards(),
                    $error->getPrevious()->redirectTo()
                )
            );
        }
*/
        return $next($error);
    }
}
