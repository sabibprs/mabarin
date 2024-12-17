<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class GameAccountCardCell extends Cell
{

    public $account;
    public $accountStatus;
    public $accountStatusColor;
    protected string $view = "components/game-account-card";

    public function mount()
    {
        switch ($this->account->status) {
            case 'verified':
                $this->accountStatus = "Terverifikasi";
                $this->accountStatusColor = "text-green-400";
                break;
            case 'unverified':
                $this->accountStatus = "Belum Diverifikasi";
                $this->accountStatusColor = "text-yellow-500";
                break;
            case 'scam':
                $this->accountStatus = "Terindikasi Palsu";
                $this->accountStatusColor = "text-red-400";
                break;
        }
    }
}
