<?php

namespace Tests\Unit\GraphQL\Types;

use App\GraphQL\Types\BookType;
use PHPUnit\Framework\TestCase;
use App\GraphQL\Types\AuthorType;
use GraphQL\Type\Definition\IntType;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\StringType;

class AuthorTypeTest extends TestCase
{
    public function testAuthorTypeFields()
    {
        $authorType = AuthorType::getInstance();

        $this->assertEquals('Author', $authorType->name);

        $fields = $authorType->config['fields'];

        $this->assertArrayHasKey('id', $fields);
        $this->assertArrayHasKey('name', $fields);
        $this->assertArrayHasKey('books', $fields);

        $this->assertInstanceOf(IntType::class, $fields['id']['type']);
        $this->assertInstanceOf(StringType::class, $fields['name']['type']);
        $this->assertInstanceOf(ListOfType::class, $fields['books']['type']);
        $this->assertInstanceOf(BookType::class, $fields['books']['type']->getWrappedType());

        $this->assertInstanceOf(\Closure::class, $fields['books']['resolve']);
    }
}
