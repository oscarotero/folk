<?php

namespace Folk\Schema\Formats\Tabs;

use Folk\Schema\FormatInterface;
use ArrayAccess;
use FormManager\Groups\Group as InputGroup;
use Folk\Schema\Traits\RenderTrait;

class Tabs implements FormatInterface
{
    use RenderTrait;

    const IS_BLOCK = true;

    private $tabs = [];

    public function __construct(string $title, $tabs = [])
    {
        $this->title = $title;

        foreach ($tabs as $tab) {
            $this->addTab($tab);
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function __clone()
    {
        foreach ($this->tabs as $key => $tab) {
            $this->tabs[$key] = clone $tab;
        }
    }

    public function addTab(FormatInterface $tab)
    {
        $this->tabs[] = $tab;

        return $this;
    }

    public function setValue(string $name, array $values): void
    {
        foreach ($this->tabs as $key => $tab) {
            $tab->setValue($key, $values);
        }
    }

    public function getValue(string $name, array &$values): void
    {
        foreach ($this->tabs as $name => $tab) {
            $tab->getValue($name, $values);
        }
    }

    public function isValid(): bool
    {
        foreach ($this->tabs as $tab) {
            if (!$tab->isValid()) {
                return false;
            }
        }

        return true;
    }

    public function isBlock(): bool
    {
        return true;
    }

    public function renderHtml(): string
    {
        $html = [];

        foreach ($this->tabs as $tab) {
            $html[] = "<li>{$tab->renderHtml()}</li>";
        }

        $html = implode("\n", $html);

        return "<ul>{$html}</ul>";
    }

    public function initInput(string $name, ArrayAccess $parent)
    {
        foreach ($this->tabs as $name => $tab) {
            $tab->initInput($name, $parent);
        }
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
