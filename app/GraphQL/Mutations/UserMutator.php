<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\CustomException;
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
        //CustomHelpers::consoleDrop($args);

        //CustomHelpers::consoleDropUser();


        // Authorization

        $authorized = 0;
        $currentUser = Request::user();

        if ($currentUser->roles->contains('id', 1)) {
            $authorized = 1;
        } else {
            if ($currentUser->roles->contains('id', 2)) {
                if ($args['role'] = 2) {
                    if ($currentUser->companies->contains('id', $args['company'])) {
                        $authorized = 1;
                    }
                } elseif ($args['role'] = 3) {
                    foreach ($currentUser->companies as $company) {
                        if ($company->chapters->contains('id', $args['chapter'])) {
                            $authorized = 1;
                            break;
                        }
                    }
                }
            } elseif ($currentUser->roles->contains('id', 3) && $args['role'] == 3) {
                if ($currentUser->chapters->contains('id', $args['chapter'])) {
                    $authorized = 1;
                }
            }
        }
        if ($authorized == 0) {
            throw new CustomException(
                'This is the error message',
                'The reason why this error was thrown, is rendered in the extension output.'
            );
        }


        $user = new User();
        $user->name = $args['name'];
        $user->email = $args['email'];
        $user->password = $args['password'];
        $user->save();


        $company = Company::find($args['company']);
        //$chapter = Chapter::find($args['chapter']);
        $user->companies()->save($company);
        $user->chapters()->save($user);

        $user->roles()->attach($args['role']);



        //CustomHelpers::consoleDrop($user);





        return $user;
    }
}
