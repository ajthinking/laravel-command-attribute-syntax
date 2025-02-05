<?php

namespace Thettler\LaravelCommandAttributeSyntax\Reflections;

use Thettler\LaravelCommandAttributeSyntax\Attributes\Argument;
use Thettler\LaravelCommandAttributeSyntax\Exceptions\CommandAttributeSyntaxException;

final class ArgumentReflection
{
    public readonly Argument $argumentAttribute;

    protected function __construct(
        protected \ReflectionProperty $property
    ) {
        $this->argumentAttribute = $property->getAttributes(Argument::class)[0]
            ->newInstance();
    }

    /**
     * @throws CommandAttributeSyntaxException
     */
    public static function new(\ReflectionProperty $property): ArgumentReflection
    {
        if (! ArgumentReflection::isArgument($property)) {
            throw new CommandAttributeSyntaxException("$property->name has no Argument Attribute.");
        }

        return new ArgumentReflection($property);
    }

    public static function isArgument(\ReflectionProperty $property): bool
    {
        return ! empty($property->getAttributes(Argument::class));
    }

    public function getName(): string
    {
        return $this->property->getName();
    }

    public function getDescription(): string
    {
        return $this->argumentAttribute->description;
    }

    public function getDefault(): string|bool|int|float|array|null
    {
        return $this->property->hasDefaultValue()
            ? $this->property->getDefaultValue()
            : null;
    }

    public function isOptional(): bool
    {
        return $this->property->hasDefaultValue() || $this->property->getType()?->allowsNull();
    }

    public function isArray(): bool
    {
        if (($type = $this->property->getType()) instanceof \ReflectionNamedType) {
            return $type->getName() === 'array';
        }

        return false;
    }
}
