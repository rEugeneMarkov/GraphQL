<?php

namespace App\GraphQL\MutationTypes;

use App\Models\Author;
use App\Services\AuthService;
use App\Traits\ResolversTrait;
use App\GraphQL\Types\AuthorType;
use GraphQL\Type\Definition\Type;
use App\Factories\UserErrorFactory;
use GraphQL\Type\Definition\ObjectType;

class AuthorMutations extends ObjectType
{
    use ResolversTrait;

    public function __construct(
        private AuthService $authService,
        private UserErrorFactory $userErrorFactory,
    ) {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'addAuthor' => [
                    'type' => AuthorType::getInstance(),
                    'args' => [
                        'name' => ['type' => Type::nonNull(Type::string())],
                    ],
                    'resolve' => fn ($rootValue, $args): Author =>
                        $this->resolversFactory('resolveAddAuthor', $args),
                ],
                'updateAuthor' => [
                    'type' => AuthorType::getInstance(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                        'name' => ['type' => Type::nonNull(Type::string())],
                    ],
                    'resolve' => fn ($rootValue, $args): Author =>
                        $this->resolversFactory('resolveUpdateAuthor', $args),
                ],
                'deleteAuthor' => [
                    'type' => Type::string(),
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => fn ($rootValue, $args): string =>
                        $this->resolversFactory('resolveDeleteAuthor', $args)
                ],
            ],
        ]);
    }

    private function resolveAddAuthor(array $args): Author
    {
        return Author::create($args);
    }

    private function resolveUpdateAuthor(array $args): Author
    {
        $author = Author::find($args['id']);

        if (is_null($author)) {
            throw new \Exception("Author don't exists");
        }
        return $author->update($args);
    }

    private function resolveDeleteAuthor(array $args): string
    {
        $author = Author::find($args['id']);

        if (is_null($author)) {
            throw new \Exception("Author don't exists");
        }

        $author->delete($args['id']);
        return "Success";
    }
}
