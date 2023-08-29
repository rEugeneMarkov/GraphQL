<?php

namespace Tests\Functional\GraphQL\MutationTypes;

use Tests\SendGraphQLRequest;
use Tests\Functional\TestCase;

class BookMutationsTest extends TestCase
{
    use SendGraphQLRequest;

    private string $authToken;

    public function setUp(): void
    {
        parent::setUp();
        $this->authToken = $this->getAuthToken('test@test.com', 'password');
    }

    public function tearDown(): void
    {
    }

    public function testAddBookMutationWithAuthentication()
    {
        $query = '
            mutation {
                addBook(name: "Test book", author_id: 2) {
                    id
                    name
                }
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx', $this->authToken);

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('addBook', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['addBook']);
        $this->assertArrayHasKey('name', $data['data']['addBook']);
        $this->assertEquals('Test book', $data['data']['addBook']['name']);
    }

    public function testAddBookMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                addBook(name: "Test book", author_id: 2) {
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
        $this->assertArrayHasKey('addBook', $data['data']);
        $this->assertNull($data['data']['addBook']);
    }

    public function testUpdateBookMutationWithAuthentication()
    {

        $query = '
            mutation {
                updateBook(id: 2, name: "Test book updated", author_id: 2) {
                    id
                    name
                }
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx', $this->authToken);

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('updateBook', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['updateBook']);
        $this->assertArrayHasKey('name', $data['data']['updateBook']);
        $this->assertEquals('Test book updated', $data['data']['updateBook']['name']);
    }

    public function testUpdateBookMutationWithoutAuthentication()
    {

        $query = '
            mutation {
                updateBook(id: 2, name: "Test book updated", author_id: 2) {
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
        $this->assertArrayHasKey('updateBook', $data['data']);
        $this->assertNull($data['data']['updateBook']);
    }

    public function testDeleteBookMutationWithAuthentication()
    {
        $query = '
            mutation {
                deleteBook(id: 2)
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx', $this->authToken);

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteBook', $data['data']);
        $this->assertEquals('Success', $data['data']['deleteBook']);
    }

    public function testDeleteBookMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                deleteBook(id: 2)
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx');

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteBook', $data['data']);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals($data['errors'][0]['message'], 'Unauthorized');
        $this->assertNull($data['data']['deleteBook']);
    }
}
