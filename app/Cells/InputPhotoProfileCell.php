<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class InputPhotoProfileCell extends Cell
{
    public $name;
    public $label;
    public $value;
    public $errorMessage;
    public $className;
    public $placeholder;
    public $disable = false;

    protected string $view = "components/input-photo-profile";
}
