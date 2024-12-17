<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class InputCell extends Cell
{
    public $name;
    public $label;
    public $type;
    public $placeholder;
    public $value;
    public $required;
    public $errorMessage;
    public $className;
    public $rows;
    public $cols;
    public $autoComplete;
    public $options;
    public $mathParent = null;
    public $mathParentSlug = null;
    public $disable = false;

    protected string $view = "components/input";

    public function mount()
    {
        if (!empty($this->options))
            $this->options = to_object($this->options);
    }
}
