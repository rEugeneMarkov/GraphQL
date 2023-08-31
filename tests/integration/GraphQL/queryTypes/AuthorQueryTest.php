<?php

namespace Tests\Integration\GraphQL\QueryTypes;

use App\Models\Book;
use GraphQL\GraphQL;
use App\Models\Author;
use App\Models\Review;
use App\GraphQL\GraphQLSchema;
use Tests\Integration\TestCase;

class AuthorQueryTest extends TestCase
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

    public function testAuthorsQuery()
    {
        $query = '{
            authors {
                id
                name
                books {
                    id
                    name
                    reviews {
                        id
                        review
                    }
                }
            }
        }';

        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('authors', $data['data']);
        $this->assertIsArray($data['data']['authors']);
        $this->assertGreaterThan(0, count($data['data']['authors']));

        foreach ($data['data']['authors'] as $author) {
            $this->assertArrayHasKey('id', $author);
            $this->assertArrayHasKey('name', $author);
            $this->assertArrayHasKey('books', $author);
            $this->assertIsArray($author['books']);

            foreach ($author['books'] as $book) {
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
    }

    public function testAuthorQuery()
    {
        $query = '{
            author (id: ' . $this->author->id . ') {
                id
                name
                books {
                    id
                    name
                    reviews {
                        id
                        review
                    }
                }
            }
        }';

        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('author', $data['data']);
        $this->assertArrayHasKey('books', $data['data']['author']);
        $this->assertIsArray($data['data']['author']);
        $this->assertGreaterThan(0, count($data['data']['author']));

        foreach ($data['data']['author']['books'] as $book) {
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
}
