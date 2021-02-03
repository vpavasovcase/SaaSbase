<?php

namespace App\GraphQL\Directives;

use App\Exceptions\CustomException;
use App\Tools\CustomHelpers;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;


class createUserDirective extends BaseDirective implements FieldMiddleware
{
    public static function definition(): string
    {
        return
            /** @lang GraphQL */
            <<<'GRAPHQL'
directive @createUser on FIELD_DEFINITION
GRAPHQL;
    }

    public function handleField(FieldValue $fieldValue, Closure $next): FieldValue
    {

        //private $errorMessage = "";

        //CustomHelpers::consoleDrop((array)$fieldValue);

        $resolver = $fieldValue->getResolver();

        $fieldValue->setResolver(function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) use ($resolver) {
            // Do something before the resolver, e.g. validate $args, check authentication

            $authorized = false;
            $message = '';

            $currentUser = request()->user();

            $role = $currentUser->roles->contains('id', 1) ? 1 : ($currentUser->roles->contains('id', 2) ? 2 : ($currentUser->roles->contains('id', 3) ? 3 : 0));

            switch ($role) {
                case 1: {
                        $authorized = true;
                        break;
                    }
                case 2: {
                        if ($args['role'] === 2 && $currentUser->companies->contains('id', $args['company'])) {
                            $authorized = true;
                        }
                        if ($args['role'] === 3 && $currentUser->allUserChapters()->contains($args['chapter'])) {
                            $authorized = true;
                        }
                        $message = 'You are not authorized to create users for this company or chapter';

                        break;
                    }
                case 3: {
                        if ($args['role'] === 3 && $currentUser->allUserChapters()->contains($args['chapter'])) {
                            $authorized = true;
                        }
                        $message = 'You are not authorized to create users for this company or chapter';
                        break;
                    }
                default:
                    $authorized = false;
            }

            //CustomHelpers::consoleDrop($authorized);

            if ($authorized == false) {
                throw new CustomException(
                    'You are not authorized to add users.',
                    $message,
                );
            }


            // Call the actual resolver
            $result = $resolver($root, $args, $context, $resolveInfo);

            // Do something with the result, e.g. transform some fields

            return $result;
        });

        // Keep the chain of adding field middleware going by calling the next handler.
        // Calling this before or after ->setResolver() allows you to control the
        // order in which middleware is wrapped around the field.
        return $next($fieldValue);
    }
}
