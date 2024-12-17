<?php

namespace App\Cells;

use App\Models\GameAccountModel;
use CodeIgniter\View\Cells\Cell;

class InputGameAccountCell extends Cell
{
    public $name;
    public $label;
    public $value;
    public $errorMessage;
    public $className;
    public $placeholder;
    public $accounts;
    public $accountSelected;
    public $disable = false;

    protected string $view = "components/input-game-account";

    public function mount()
    {
        if (empty($this->accounts) && auth()->isLoggedIn()) {
            $account = model(GameAccountModel::class);
            $this->accounts = $account->findAccountsByUser(auth()->user()->id);
        }

        if (!empty($this->value) && $this->value !== "") {
            $selected = array_filter($this->accounts, fn ($account) => intval($account->id) == intval($this->value));
            $this->accountSelected = (count($selected) >= 1) ? reset($selected) : $this->accounts[0];
        } else {
            $this->accountSelected =  $this->accounts[0];
        }
    }
}
