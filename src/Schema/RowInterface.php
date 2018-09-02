<?php

namespace Folk\Schema;

use FormManager\InputInterface;

interface RowInterface
{
    public function setValue(iterable $value): void;

    public function getValue(): array;

    public function isValid(): bool;

    public function renderHtml(): string;

    public function createInput(): InputInterface;

    public function renderInput(InputInterface $input): string;
}
