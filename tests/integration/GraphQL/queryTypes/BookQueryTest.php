<?php

namespace Tests\Integration\GraphQL\QueryTypes;

use App\Models\Book;
use GraphQL\GraphQL;
use App\Models\Author;
use App\Models\Review;
use App\GraphQL\GraphQLSchema;
use Tests\Integration\TestCase;

class BookQueryTest extends TestCase
{
    private GraphQLSchema $schema;
    private Author $author;
    private Book $book;
    private Review $review;

    public function setUp(): void
    {
        parent::setUp();
        $this->schema = $this->container->get(GraphQLSchema::class);

        $this->author = Author::create([
            'name' => 'Author for test Book',
        ]);

        $this->book = Book::create([
            'name' => 'Book for test Book',
            'author_id' => $this->author->id,
        ]);

        $this->review = Review::create([
            'review' => 'Book for test Book',
            'book_id' => $this->book->id,
        ]);
    }

    public function tearDown(): void
    {
        Author::delete($this->author->id);
    }

    public function testBooksQuery()
    {
        $query = '{
            books {
                id
                name
                reviews {
                    id
                    review
                }
            }
        }';

        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('books', $data['data']);
        $this->assertIsArray($data['data']['books']);
        $this->assertGreaterThan(0, count($data['data']['books']));

        foreach ($data['data']['books'] as $book) {
            $this->assertArrayHasKey('id', $book);
            $this->assertArrayHasKey('name', $book);
            $this->assertArrayHasKey('reviews', $book);
            $this->assertIsArray($book['reviews']);

            foreach ($book['reviews'] as $review) {
                $this->assertArrayHasKey('id', $review);
                $this->assertArrayHasKey('review', $review);
            }
        }
    }

    public function testBookQuery()
    {
        $query = '{
            book (id: ' . $this->book->id . ') {
                id
                name
                reviews {
                    id
                    review
                }
            }
        }';

        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('book', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['book']);
        $this->assertArrayHasKey('name', $data['data']['book']);
        $this->assertArrayHasKey('reviews', $data['data']['book']);
        $this->assertIsArray($data['data']['book']);
        $this->assertGreaterThan(0, count($data['data']['book']));

        foreach ($data['data']['book']['reviews'] as $review) {
            $this->assertArrayHasKey('id', $review);
            $this->assertArrayHasKey('review', $review);
        }
    }
}
