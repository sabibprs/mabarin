<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class GameCardCell extends Cell
{
    public $game;
    protected string $view = "components/game-card";
}
