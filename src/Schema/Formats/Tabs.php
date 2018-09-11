<?php

namespace Folk\Schema\Formats;

use Folk\Schema\FormatInterface;
use ArrayAccess;
use FormManager\Groups\Group as InputGroup;

class Tabs implements FormatInterface
{
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

    public function addTab(Tab $tab)
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

    public function renderInput(): string
    {
        $html = [];

        foreach ($this->tabs as $name => $tab) {
            $html[] = $tab->renderInput();
        }

        $html = implode("\n", $html);

        return <<<HTM
        <h3 class="editForm-head">{$this->getTitle()}</h3>
        <div class="editForm module-tabs">
            {$html}
        </div>
HTM;
    }
}
