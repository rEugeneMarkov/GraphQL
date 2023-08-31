<?php

namespace Tests\Integration\GraphQL\MutationTypes;

use GraphQL\GraphQL;
use App\GraphQL\GraphQLSchema;
use App\Models\Author;
use App\Models\Book;
use Tests\Integration\TestCase;

class BookMutationsTest extends TestCase
{
    private string $authToken;
    private GraphQLSchema $schema;
    private Author $author;
    private Book $book;

    public function setUp(): void
    {
        parent::setUp();
        $this->authToken = $this->getAuthToken('test@test.com', 'password');
        $this->schema = $this->container->get(GraphQLSchema::class);

        $this->author = Author::create([
            'name' => 'Author for test Book',
        ]);

        $this->book = Book::create([
            'name' => 'Book for test Book',
            'author_id' => $this->author->id,
        ]);
    }

    public function tearDown(): void
    {
        Author::delete($this->author->id);
    }

    public function testAddBookMutationWithAuthentication()
    {
        $query = '
            mutation {
                addBook(name: "Test book", author_id: ' . $this->author->id . ') {
                    id
                    name
                }
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = $this->authToken;
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('addBook', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['addBook']);
        $this->assertArrayHasKey('name', $data['data']['addBook']);
        $this->assertEquals('Test book', $data['data']['addBook']['name']);

        Book::delete($data['data']['addBook']['id']);
    }

    public function testAddBookMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                addBook(name: "Test book", author_id: ' . $this->author->id . ') {
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
        $this->assertArrayHasKey('addBook', $data['data']);
        $this->assertNull($data['data']['addBook']);
    }

    public function testUpdateBookMutationWithAuthentication()
    {

        $query = '
            mutation {
                updateBook(id: ' . $this->book->id . ', name: "Book updated", author_id: ' . $this->author->id . ') {
                    id
                    name
                }
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = $this->authToken;
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('updateBook', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['updateBook']);
        $this->assertArrayHasKey('name', $data['data']['updateBook']);
        $this->assertEquals('Book updated', $data['data']['updateBook']['name']);
    }

    public function testUpdateBookMutationWithoutAuthentication()
    {

        $query = '
            mutation {
                updateBook(id: ' . $this->book->id . ', name: "Book updated", author_id: ' . $this->author->id . ') {
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
        $this->assertArrayHasKey('updateBook', $data['data']);
        $this->assertNull($data['data']['updateBook']);
    }

    public function testDeleteBookMutationWithAuthentication()
    {
        $query = '
            mutation {
                deleteBook(id: ' . $this->book->id . ')
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = $this->authToken;
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteBook', $data['data']);
        $this->assertEquals('Success', $data['data']['deleteBook']);
    }

    public function testDeleteBookMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                deleteBook(id: ' . $this->book->id . ')
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = '';
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteBook', $data['data']);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals($data['errors'][0]['message'], 'Unauthorized');
        $this->assertNull($data['data']['deleteBook']);
    }
}
