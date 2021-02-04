<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use MakesGraphQLRequests;
    use DatabaseTransactions;


    public function testQueriesCompanies(): void
    {
        $user = User::find(1);

        $response = $this->actingAs($user, 'api')->graphQL(
            /** @lang GraphQL */
            '
            {
                companies {
                    id
                    name
                    email
                    address
                    phone
                    vat
                    type
                    country{
                      name
                    }
                    language{
                      name
                    }
                    users{
                        id
                        name
                    }
                    chapters{
                        id
                        name
                    }
                }
            }
            '
        );
        $response->assertJsonStructure([
            'data' => [
                'companies' => [
                    [
                        'id',
                        'name',
                        'email',
                        'users' => [
                            [
                                'id',
                                'name',

                            ]
                        ],
                    ]
                ]
            ]
        ]);
    }
}
