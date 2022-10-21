<?php

declare(strict_types=1);

namespace CuyZ\Valinor\Tests\Integration\Mapping\Attribute;

use CuyZ\Valinor\Attribute\Identifier;
use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\MapperBuilder;
use CuyZ\Valinor\Tests\Integration\IntegrationTest;

use function get_class;

final class IdentifierAttributeMappingTest extends IntegrationTest
{
    /**
     * @requires PHP >= 8
     */
    public function test_identifier_attribute_is_mapped_properly(): void
    {
        $class = new class () {
            /** @var \CuyZ\Valinor\Tests\Integration\Mapping\Attribute\IdentifierAttribute[] */
            public array $identifierAttribute;

            /** @var \CuyZ\Valinor\Tests\Integration\Mapping\Attribute\IdentifierAttributeWithConstructor[] */
            public array $identifierAttributeWithConstructor;
        };

        $source = [
            'identifierAttribute' => [
                'foo' => ['value' => 'foo'],
                'bar' => ['value' => 'foo'],
                'baz' => ['value' => 'foo'],
            ],
            'identifierAttributeWithConstructor' => [
                'foo' => ['value' => 'foo'],
                'bar' => ['value' => 'foo'],
                'baz' => ['value' => 'foo'],
            ],
        ];

        try {
            $result = (new MapperBuilder())->mapper()->map(get_class($class), $source);
        } catch (MappingError $error) {
            $this->mappingFail($error);
        }

        self::assertSame('foo', $result->identifierAttribute['foo']->identifier);
        self::assertSame('bar', $result->identifierAttribute['bar']->identifier);
        self::assertSame('baz', $result->identifierAttribute['baz']->identifier);
        self::assertSame('foo', $result->identifierAttributeWithConstructor['foo']->identifier);
        self::assertSame('bar', $result->identifierAttributeWithConstructor['bar']->identifier);
        self::assertSame('baz', $result->identifierAttributeWithConstructor['baz']->identifier);
    }
}

class IdentifierAttribute
{
    #[Identifier]
    public string $identifier;

    public string $value;
}

class IdentifierAttributeWithConstructor extends IdentifierAttribute
{
    public function __construct(
        #[Identifier]
        string $identifier
    ) {
        $this->identifier = $identifier;
    }
}
