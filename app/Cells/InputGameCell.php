<?php

namespace App\Cells;

use App\Models\GameModel;
use CodeIgniter\View\Cells\Cell;

class InputGameCell extends Cell
{
    public $name;
    public $label;
    public $value;
    public $errorMessage;
    public $className;
    public $placeholder;
    public $games;
    public $gameSelected;
    public $disable = false;

    protected string $view = "components/input-game";

    public function mount(array|null $games = null, bool $isOnEdit =  false)
    {
        if (!empty($games)) {
            $this->games = $games;
            return;
        }

        $games = model(GameModel::class);
        if (auth()->isUser()) $games->where('is_verified', true);

        $games = $games->findAll();
        $this->games = $games;

        if (!empty($this->value) && $this->value !== "") {
            $selected = array_filter($games, fn ($game) => intval($game->id) == intval($this->value));
            $this->gameSelected = (count($selected) >= 1) ? reset($selected) : $games[0];
        } else {
            $this->gameSelected =  $games[0];
        }
    }
}
