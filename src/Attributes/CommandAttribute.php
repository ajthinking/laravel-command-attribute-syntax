<?php

namespace Thettler\LaravelCommandAttributeSyntax\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
class CommandAttribute
{
    public function __construct(
        public readonly string $name,
        public readonly string $description = '',
        public readonly string $help = '',
        public readonly bool $hidden = false,
    ) {
    }
}
