<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Tests\TestCase;

class UserTest extends TestCase
{
    use MakesGraphQLRequests;
    use DatabaseTransactions;

    public function testQueriesUser(): void
    {
        $user = User::find(1);

        $response = $this->actingAs($user, 'api')->graphQL(
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
        );
        $response->assertJson([
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

        $user = User::find(1);

        $response = $this->actingAs($user, 'api')->graphQL(
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
                    'name' => 'Testing Name',
                ]

            ]
        ]);
    }

    public function testUnauthenticatedCreatesUser(): void
    {

        $user = User::find(4);

        $response = $this->actingAs($user, 'api')->graphQL(
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

            'errors' =>
            [
                ['message' => 'You are not authorized to add users.']
            ]


        ]);
    }
}
