<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class TeamCardCell extends Cell
{
    public $team;

    public $includeSelfAccountId;
    public $includeSelf;
    protected string $view = "components/team-card";

    public function mount()
    {
        $this->includeSelf = false;
        $this->includeSelfAccountId = null;
        if (!empty($this->team->members)) {
            foreach ($this->team->members as $member) {
                if (intval($member->account->user->id) == intval(auth()->user()->id)) {
                    $this->includeSelfAccountId = $member->account->id;
                    $this->includeSelf = true;
                }
            }
        }
    }
}
