<?php

namespace CuyZ\Valinor\Mapper;

/**
 * This is likely not the best way to do this,
 * but I think is a good placeholder to start with.
 *
 * @api
 */
interface TreeReverseMapper
{
    /** @return array<array-key, mixed> */
    public function reverseMap(object $objectToSerialize): array;
}
