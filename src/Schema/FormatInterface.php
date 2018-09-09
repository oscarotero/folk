<?php

namespace Folk\Schema;

use ArrayAccess;

interface FormatInterface
{
    public function getTitle(): string;

    public function setValue($value): void;

    public function getValue();

    public function isValid(): bool;

    public function renderHtml(): string;

    public function initInput(string $name, ArrayAccess $parent);

    public function renderInput(): string;
}
