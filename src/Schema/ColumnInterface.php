<?php

namespace Folk\Schema;

use FormManager\InputInterface;

interface ColumnInterface
{
    public function getTitle(): string;

    public function setValue($value): void;

    public function getValue();

    public function isValid(): bool;

    public function renderHtml(): string;

    public function createInput(): InputInterface;

    public function renderInput(InputInterface $input): string;
}
