<?php

namespace Folk\Schema;

use FormManager\InputInterface;

interface ColumnInterface
{
	public function getLabel(): string;

	public function setValue($value): void;

	public function getValue();

	public function renderHtml(): string;

    public function renderInput(InputInterface $input): string;
}