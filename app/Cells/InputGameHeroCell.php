<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class InputGameHeroCell extends Cell
{
    public $name;
    public $label;
    public $value;
    public $errorMessage;
    public $className;
    public $placeholder;
    public $heroes;
    public $heroSelected;
    public $scraper;
    public $disable = false;

    protected string $view = "components/input-game-hero";

    public function mount()
    {
        $this->heroes = $this->scraper->getHero(null, 'object', true);

        if (!empty($this->value['hero_id'])) {
            $selected = array_filter($this->heroes, fn ($hero) => intval($hero->id) == intval($this->value['hero_id']));
            if (!empty($selected)) {
                $this->heroSelected = reset($selected);
            } else {
                $this->heroSelected = $this->heroes[0];
            }
        } else {
            $this->heroSelected = $this->heroes[0];
        }
    }
}
