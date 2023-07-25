<?php

namespace Tests\Functional\GraphQL;

use Tests\TestCase;

class AuthorQueryTest extends TestCase
{
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

        $response = $this->sendGraphQLRequest($query);
        $data = json_decode($response, true);

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
            author (id: 2) {
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

        $response = $this->sendGraphQLRequest($query);
        $data = json_decode($response, true);

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
