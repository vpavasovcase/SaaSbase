<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\CustomException;
use App\GraphQL\Exceptions\ClientAwareAuthorizationException;
use App\Models\Chapter;
use App\Models\Company;
use App\Models\User;
use App\Tools\CustomHelpers;
use Illuminate\Support\Facades\Request;

class UserMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
    }
    public function upsert($rootValue, array $args)
    {

        $user = new User();
        $user->name = $args['name'];
        $user->email = $args['email'];
        $user->password = $args['password'];
        $user->save();

        $company = Company::find($args['company']);
        //$chapter = Chapter::find($args['chapter']);
        $user->companies()->attach($company);
        $user->chapters()->attach($user);

        $user->roles()->attach($args['role']);

        return $user;
    }
}
