<?php

namespace Tests\Integration\GraphQL\MutationTypes;

use GraphQL\GraphQL;
use App\GraphQL\GraphQLSchema;
use App\Models\Author;
use App\Models\Book;
use App\Models\Review;
use Tests\Integration\TestCase;

class ReviewMutationsTest extends TestCase
{
    private string $authToken;
    private GraphQLSchema $schema;
    private Author $author;
    private Book $book;
    private Review $review;

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

        $this->review = Review::create([
            'review' => 'Book for test Book',
            'book_id' => $this->book->id,
        ]);
    }

    public function tearDown(): void
    {
        Author::delete($this->author->id);
    }

    public function testAddReviewMutationWithAuthentication()
    {
        $query = '
            mutation {
                addReview(review: "Test review", book_id: ' . $this->book->id . ') {
                    id
                    review
                }
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = $this->authToken;
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('addReview', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['addReview']);
        $this->assertArrayHasKey('review', $data['data']['addReview']);
        $this->assertEquals('Test review', $data['data']['addReview']['review']);

        Review::delete($data['data']['addReview']['id']);
    }

    public function testAddReviewMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                addReview(review: "Test review", book_id: ' . $this->book->id . ') {
                    id
                    review
                }
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = '';
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals($data['errors'][0]['message'], 'Unauthorized');
        $this->assertArrayHasKey('addReview', $data['data']);
        $this->assertNull($data['data']['addReview']);
    }

    public function testUpdateReviewMutationWithAuthentication()
    {

        $query = '
            mutation {
                updateReview(id: ' . $this->review->id . ', review: "Review update", book_id: ' . $this->book->id . ') {
                    id
                    review
                }
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = $this->authToken;
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('updateReview', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['updateReview']);
        $this->assertArrayHasKey('review', $data['data']['updateReview']);
        $this->assertEquals('Review update', $data['data']['updateReview']['review']);
    }

    public function testUpdateReviewMutationWithoutAuthentication()
    {

        $query = '
            mutation {
                updateReview(id: ' . $this->review->id . ', review: "Review update", book_id: ' . $this->book->id . ') {
                    id
                    review
                }
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = '';
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals($data['errors'][0]['message'], 'Unauthorized');
        $this->assertArrayHasKey('updateReview', $data['data']);
        $this->assertNull($data['data']['updateReview']);
    }

    public function testDeleteReviewMutationWithAuthentication()
    {
        $query = '
            mutation {
                deleteReview(id: ' . $this->review->id . ')
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = $this->authToken;
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteReview', $data['data']);
        $this->assertEquals('Success', $data['data']['deleteReview']);
    }

    public function testDeleteReviewMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                deleteReview(id: ' . $this->review->id . ')
            }
        ';

        $_SERVER['HTTP_AUTHORIZATION'] = '';
        $result = GraphQL::executeQuery($this->schema, $query);

        $data = $result->toArray();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteReview', $data['data']);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals($data['errors'][0]['message'], 'Unauthorized');
        $this->assertNull($data['data']['deleteReview']);
    }
}
