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
                  email: "teeest@test.hr", 
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

    public function testUnauthorizedCreatesUser(): void
    {

        $user = User::find(23);

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

    public function testLowerAdminCreatesUser(): void
    {

        $user = User::find(3);

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

    public function testCreatesDifferentCompanyUser(): void
    {

        $user = User::find(2);

        $response = $this->actingAs($user, 'api')->graphQL(
            '
            mutation {
                createUser(           
                name: "Testing Name", 
                  email: "test@test.hr", 
                    password: "testpass", 
                  role: 2,
                company: 123
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

    public function testCreatesDifferentChapterUser(): void
    {

        $user = User::find(3);

        $response = $this->actingAs($user, 'api')->graphQL(
            '
            mutation {
                createUser(           
                name: "Testing Name", 
                  email: "test@test.hr", 
                    password: "testpass", 
                  role: 3,
                company: null
                chapter: 124){
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
