<?php

namespace Tests\Functional\GraphQL;

use Tests\SendGraphQLRequest;
use PHPUnit\Framework\TestCase;

class BookQueryTest extends TestCase
{
    use SendGraphQLRequest;

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

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx');
        $data = json_decode($response, true);

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
            book (id: 2) {
                id
                name
                reviews {
                    id
                    review
                }
            }
        }';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx');
        $data = json_decode($response, true);

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
