<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TeamModel;

class Team extends BaseController
{
    protected TeamModel $team;

    public function __construct()
    {
        $this->team = model(TeamModel::class);
    }

    public function main()
    {
        $teams['own'] = $this->team->findOwnTeams(auth()->user()->id);
        $teams['recruite'] = $this->team->where('status', 'recruite')->findAllTeams();
        $teams['matches'] = $this->team->where('status', 'matches')->findAllTeams();
        $teams['archive'] = $this->team->where('status', 'archive')->findAllTeams();

        if (auth()->isAdmin()) $teams['draft'] = $this->team->where('status', 'draft')->findAllTeams();

        return view('team/main', [
            'teams'     => $teams,
            'metadata'  => [
                'title'   => "Team",
                'header'  => [
                    'title'        => 'Team',
                    'description'  => 'Lihat semua tim dari berbagai game yang di pertemukan di sini.'
                ]
            ]
        ]);
    }

    public function addTeam()
    {

        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('team');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'team_creator'  => $this->validation->getError('team_creator'),
                    'team_game'  => $this->validation->getError('team_game'),
                    'team_name'  => $this->validation->getError('team_name'),
                    'team_code'  => $this->validation->getError('team_code'),
                    'team_status'  => $this->validation->getError('team_status')
                ];
            }

            $teamValidated = $this->validation->getValidated();
            $teamData = $this->serialize($teamValidated);

            if (isset($teamData['code'])) {
                $isTeamCodeExist = $this->team->where('code', $teamData['code'])->first();
                if ($isTeamCodeExist) $validationErrors['team_code'] = "Kode tim sudah ada, gunakan kode tim yang lain.!";
            }

            if ($teamData && empty($validationErrors)) {
                $isTeamAdded = $this->team->addTeam($teamData);
                if ($isTeamAdded) return redirect('team')->with('toast_success', "Berhasil membuat tim {$teamData['name']}!");
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Gagal membuat tim, Silahkan Coba Lagi!"]);
        }

        return view('team/add', [
            'error'     => $this->session->getFlashdata('error'),
            'metadata'  => [
                'title'   => "Buat Team",
                'header'  => [
                    'title'        => 'Buat Team',
                    'description'  => 'Buat tim kamu sendiri.'
                ]
            ]
        ]);
    }


    public function editTeam(string $teamCode)
    {
        $team = $this->team->findTeamByCode($teamCode);
        if (empty($team)) return redirect('team')->with('toast_error', "Tim dengan kode $teamCode tidak ditemukan!");

        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('team');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'team_creator'  => $this->validation->getError('team_creator'),
                    'team_game'  => $this->validation->getError('team_game'),
                    'team_name'  => $this->validation->getError('team_name'),
                    'team_code'  => $this->validation->getError('team_code'),
                    'team_status'  => $this->validation->getError('team_status')
                ];
            }

            $teamValidated = $this->validation->getValidated();
            $teamData = $this->serialize($teamValidated);

            if (isset($teamData['code']) && $teamData['code'] !== $team->code) {
                $isTeamCodeExist = $this->team->where('code', $teamData['code'])->first();
                if ($isTeamCodeExist) $validationErrors['team_code'] = "Kode tim sudah ada, gunakan kode tim yang lain!";
            }

            if (isset($teamData['game']) && intval($teamData['game']) !== intval($team->game->id) && count($team->members) > 0)
                $validationErrors['team_game'] = "Game tidak dapat diubah, Jika tim ini sudah memiliki anggota maka game sudah tidak dapat lagi diubah!";

            if ($teamData && empty($validationErrors)) {
                $isTeamEdited = $this->team->updateTeam($team->id, $teamData);
                if ($isTeamEdited) return redirect('team')->with('toast_success', "Berhasil mengedit tim {$teamData['name']}!");
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Gagal mengedit tim $team->name, Silahkan Coba Lagi!"]);
        }

        return view('team/edit', [
            'team'      => $team,
            'error'     => $this->session->getFlashdata('error'),
            'metadata'  => [
                'title'   => "Edit Team",
                'header'  => [
                    'title'        => 'Edit Team',
                    'description'  => "Edit tim."
                ]
            ]
        ]);
    }

    public function deleteTeam(int|string $teamCode)
    {
        $error = null;
        $team = $this->team->findTeamByCode($teamCode);
        if (empty($team)) $error = "Gagal menghapus tim, Tim dengan kode $teamCode tidak ditemukan!";

        if (isset($team) && intval($team->creator->id) !== intval(auth()->user()->id) && auth()->isUser())
            $error = "Gagal menghapus tim, Kamu tidak memiliki akses untuk menghapus tim $team->name!";

        if (count($team->members) > 0)
            $error = "Gagal menghapus tim, Tim sudah di isi oleh pengguna!";

        $isTeamDeleted = $this->team->deleteTeam($team->id);
        if (!$isTeamDeleted) $error = "Gagal menghapus tim $team->name";

        return redirect('team')->with(
            isset($error) ?
                'toast_error' :
                'toast_success',
            isset($error) ?
                $error :
                "Berhasil menghapus tim $team->name!"
        );
    }


    private function serialize($teamDataValidated)
    {
        $team = [];
        foreach ($teamDataValidated as $teamKey => $teamValue) {
            $team[str_replace("team_", "", $teamKey)] = $teamValue;
        }

        return $team;
    }
}
