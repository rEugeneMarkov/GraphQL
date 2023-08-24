<?php

namespace App\GraphQL\MutationTypes;

use App\Models\Book;
use App\Services\AuthService;
use App\Traits\ResolversTrait;
use App\GraphQL\Types\BookType;
use GraphQL\Type\Definition\Type;
use App\Factories\UserErrorFactory;
use GraphQL\Type\Definition\ObjectType;

class BookMutations extends ObjectType
{
    use ResolversTrait;

    public function __construct(
        private AuthService $authService,
        private UserErrorFactory $userErrorFactory,
    ) {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'addBook' => [
                    'type' => BookType::getInstance(),
                    'args' => [
                        'name' => ['type' => Type::nonNull(Type::string())],
                        'author_id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args): Book => $this->resolversFactory('resolveAddBook', $args),
                ],
                'updateBook' => [
                    'type' => BookType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                        'name' => ['type' => Type::nonNull(Type::string())],
                        'author_id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args): Book => $this->resolversFactory('resolveUpdateBook', $args),
                ],
                'deleteBook' => [
                    'type' => Type::string(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args): string => $this->resolversFactory('resolveDeleteBook', $args),
                ],
            ],
        ]);
    }

    private function resolveAddBook(array $args): Book
    {
        return Book::create($args);
    }

    private function resolveUpdateBook(array $args): Book
    {
        $book = Book::find($args['id']);

        if (is_null($book)) {
            throw new \Exception("Book don't exists");
        }

        return Book::update($args);
    }

    private function resolveDeleteBook(array $args): string
    {
        $book = Book::find($args['id']);

        if (is_null($book)) {
            throw new \Exception("Book don't exists");
        }

        $book->delete($args['id']);
        return "Success";
    }
}
