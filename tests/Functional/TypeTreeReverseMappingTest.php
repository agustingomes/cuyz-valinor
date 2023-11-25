<?php

declare(strict_types=1);

namespace CuyZ\Valinor\Tests\Functional;

use CuyZ\Valinor\Mapper\TreeReverseMapper;
use CuyZ\Valinor\MapperBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class TypeTreeReverseMappingTest extends TestCase
{
    public function test_normalize_object_to_array(): void
    {
        $objectToNormalize = new EventRecorded(
            new Identity('id'),
            new Moment(new DateTimeImmutable('2023-12-01T10:30:00+00:00')),
            new DomainInformation(
                'a title',
                'a description',
            ),
        );

        /**
         * This is likely not the best way to do this,
         * but I think is a good placeholder to start with.
         *
         * @var TreeReverseMapper $treeReverseMapper
         */
        $treeReverseMapper = (new MapperBuilder())->mapper();

        $normalized = $treeReverseMapper->reverseMap($objectToNormalize);

        self::assertEquals([
            'id' => 'id',
            'happenedAt' => '2023-12-01T10:30:00+00:00',
            'details' => [
                'title' => 'a title',
                'description' => 'a description',
            ],
        ], $normalized);
    }
}

final class Identity
{
    public function __construct(
        /** @phpstan-ignore-next-line */
        private string $value,
    ) {
    }
}

final class Moment
{
    public function __construct(
        /** @phpstan-ignore-next-line */
        private DateTimeImmutable $timestamp,
    ) {
    }
}

final class DomainInformation
{
    public function __construct(
        /** @phpstan-ignore-next-line */
        private string $title,
        /** @phpstan-ignore-next-line */
        private string $description,
    ) {
    }
}

final class EventRecorded
{
    public function __construct(
        /** @phpstan-ignore-next-line */
        private Identity $id,
        /** @phpstan-ignore-next-line */
        private Moment $happenedAt,
        /** @phpstan-ignore-next-line */
        private DomainInformation $details,
    ) {
    }
}
