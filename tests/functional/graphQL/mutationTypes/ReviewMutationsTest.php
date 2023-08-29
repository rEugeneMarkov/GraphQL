<?php

namespace Tests\Functional\GraphQL\MutationTypes;

use Tests\SendGraphQLRequest;
use Tests\Functional\TestCase;

class ReviewMutationsTest extends TestCase
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

    public function testAddReviewMutationWithAuthentication()
    {
        $query = '
            mutation {
                addReview(review: "Test review", book_id: 3) {
                    id
                    review
                }
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx', $this->authToken);

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('addReview', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['addReview']);
        $this->assertArrayHasKey('review', $data['data']['addReview']);
        $this->assertEquals('Test review', $data['data']['addReview']['review']);
    }

    public function testAddReviewMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                addReview(review: "Test review", book_id: 3) {
                    id
                    review
                }
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx');

        $data = json_decode($response, true);

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
                updateReview(id: 3, review: "Test review updated", book_id: 3) {
                    id
                    review
                }
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx', $this->authToken);

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('updateReview', $data['data']);
        $this->assertArrayHasKey('id', $data['data']['updateReview']);
        $this->assertArrayHasKey('review', $data['data']['updateReview']);
        $this->assertEquals('Test review updated', $data['data']['updateReview']['review']);
    }

    public function testUpdateReviewMutationWithoutAuthentication()
    {

        $query = '
            mutation {
                updateReview(id: 2, review: "Test review updated", book_id: 3) {
                    id
                    review
                }
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx');

        $data = json_decode($response, true);

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
                deleteReview(id: 3)
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx', $this->authToken);

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteReview', $data['data']);
        $this->assertEquals('Success', $data['data']['deleteReview']);
    }

    public function testDeleteBookMutationWithoutAuthentication()
    {
        $query = '
            mutation {
                deleteReview(id: 3)
            }
        ';

        $response = $this->sendGraphQLRequest($query, 'http://graph-ql-nginx');

        $data = json_decode($response, true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('deleteReview', $data['data']);
        $this->assertArrayHasKey('errors', $data);
        $this->assertEquals($data['errors'][0]['message'], 'Unauthorized');
        $this->assertNull($data['data']['deleteReview']);
    }
}
