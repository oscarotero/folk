<?php

namespace Folk\Schema;

use FormManager\InputInterface;

interface RowInterface
{
	public function setValue(iterable $value): void;

	public function getValue(): array;

	public function renderHtml(): string;

    public function renderForm(string $entityName, $id = null): string;
}