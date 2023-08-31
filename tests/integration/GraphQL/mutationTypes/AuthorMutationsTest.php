<?php

namespace Tests\Integration\GraphQL\MutationTypes;

use GraphQL\GraphQL;
use App\Models\Author;
use App\GraphQL\GraphQLSchema;
use Tests\Integration\TestCase;

class AuthorMutationsTest extends TestCase
{
    private string $authToken;
    private GraphQLSchema $schema;
    private Author $author;

    public function setUp(): void
    {
        parent::setUp();
        $this->authToken = $this->getAuthToken('test@test.com', 'password');
        $this->schema = $this->container->get(GraphQLSchema::class);
        $this->author = Author::create([
            'name' => 'Author test Author',
        ]);
    }

    public function tearDown(): void
    {
        Author::delete($this->author->id);
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

        $_SERVER['HTTP_AUTHORIZATION'] = $this->authToken;
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('addAuthor', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['addAuthor']);
        $this->assertArrayHasKey('name', $data['data']['addAuthor']);
        $this->assertEquals('John Doe', $data['data']['addAuthor']['name']);

        Author::delete($data['data']['addAuthor']['id']);
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

        $_SERVER['HTTP_AUTHORIZATION'] = '';
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

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
                updateAuthor(id: ' . $this->author->id . ', name: "John Doe updated") {
                    id
                    name
                }
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = $this->authToken;
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

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
                updateAuthor(id: ' . $this->author->id . ', name: "John Doe updated") {
                    id
                    name
                }
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = '';
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

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
                deleteAuthor(id: ' . $this->author->id . ')
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = $this->authToken;
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteAuthor', $data['data']);
        $this->assertEquals('Success', $data['data']['deleteAuthor']);
    }

    public function testDeleteAuthorMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                deleteAuthor(id: ' . $this->author->id . ')
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = '';
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteAuthor', $data['data']);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals($data['errors'][0]['message'], 'Unauthorized');
        $this->assertNull($data['data']['deleteAuthor']);
    }
}
