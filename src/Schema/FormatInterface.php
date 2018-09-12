<?php

namespace Folk\Schema;

use ArrayAccess;

interface FormatInterface
{
    public function getTitle(): string;

    public function setValue(string $name, array $values): void;

    public function getValue(string $name, array &$values): void;

    public function isValid(): bool;

    public function isBlock(): bool;

    public function initInput(string $name, ArrayAccess $parent);

    public function render(string $template): string;
}
