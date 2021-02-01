<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Tests\TestCase;

class UserTest extends TestCase
{
    use MakesGraphQLRequests;
    use RefreshDatabase;

    public function testQueriesUser(): void
    {
        $user = User::find(1);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $user->api_token",
        ])->graphQL(
            /** @lang GraphQL */
            '
            {
                users {
                    id
                    name
                    email
                }
            }
            '
        )->assertJson([
            'data' => [
                'users' => [
                    [
                        'id' => 1,
                        'name' => 'Vojislav Pavasović',
                        'email' => 'vpavasov@gmail.com'
                    ]
                ]
            ]
        ]);
    }

    public function testCreatesUser(): void
    {
        //User::where('email', '=', 'testmail@test.hr')->first()->delete();

        $user = User::find(1);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $user->api_token",
        ])->graphQL(
            /** @lang GraphQL */
            '
            mutation {
                createUser(           
                name: "Testing Name", 
                  email: "test@test.hr", 
                    password: "testpass", 
                  role: 2,
                company: 1
                chapter: 1){
                  name    
                }  
              }
            '
        )->assertJson([
            'data' => [
                'createUser' =>
                [
                    'name' => 'Test Name',
                ]

            ]
        ]);
    }
}
