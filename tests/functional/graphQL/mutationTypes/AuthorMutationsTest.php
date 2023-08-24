<?php

namespace Tests\Functional\GraphQL\MutationTypes;

use Tests\SendGraphQLRequest;
use PHPUnit\Framework\TestCase;

class AuthorMutationsTest extends TestCase
{
    use SendGraphQLRequest;

    private $authToken;

    public function setUp(): void
    {
        $this->authToken = $this->getAuthToken('test@test.com', 'password');
    }

    public function tearDown(): void
    {
    }

    public function testAddAuthorMutationWithAuthentication()
    {
        $query = '
            mutation {
                addAuthor(name: "John Doe") {
                    id
                    name
                }
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx', $this->authToken);

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('addAuthor', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['addAuthor']);
        $this->assertArrayHasKey('name', $data['data']['addAuthor']);
        $this->assertEquals('John Doe', $data['data']['addAuthor']['name']);
    }

    public function testAddAuthorMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                addAuthor(name: "John Doe") {
                    id
                    name
                }
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx');

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals($data['errors'][0]['message'], 'Unauthorized');
        $this->assertArrayHasKey('addAuthor', $data['data']);
        $this->assertNull($data['data']['addAuthor']);
    }

    public function testUpdateAuthorMutationWithAuthentication()
    {

        $query = '
            mutation {
                updateAuthor(id: 1, name: "John Doe updated") {
                    id
                    name
                }
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx', $this->authToken);

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('updateAuthor', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['updateAuthor']);
        $this->assertArrayHasKey('name', $data['data']['updateAuthor']);
        $this->assertEquals('John Doe updated', $data['data']['updateAuthor']['name']);
    }

    public function testUpdateAuthorMutationWithoutAuthentication()
    {

        $query = '
            mutation {
                updateAuthor(id: 1, name: "John Doe updated") {
                    id
                    name
                }
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx');

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals($data['errors'][0]['message'], 'Unauthorized');
        $this->assertArrayHasKey('updateAuthor', $data['data']);
        $this->assertNull($data['data']['updateAuthor']);
    }

    public function testDeleteAuthorMutationWithAuthentication()
    {
        $query = '
            mutation {
                deleteAuthor(id: 1)
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx', $this->authToken);

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteAuthor', $data['data']);
        $this->assertEquals('Success', $data['data']['deleteAuthor']);
    }

    public function testDeleteAuthorMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                deleteAuthor(id: 1)
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx');

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteAuthor', $data['data']);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals($data['errors'][0]['message'], 'Unauthorized');
        $this->assertNull($data['data']['deleteAuthor']);
    }
}
