<?php

namespace App\Controllers;

use App\Cells\InputGameHeroCell;
use App\Controllers\BaseController;
use App\Libraries\MobileLegendsLibrary;
use App\Models\GameAccountModel;
use App\Models\GameModel;
use App\Models\TeamMemberModel;
use App\Models\TeamModel;

class TeamMember extends BaseController
{
    protected TeamModel $team;
    protected TeamMemberModel $teamMember;
    protected GameAccountModel $account;

    public function __construct()
    {
        $this->team       = model(TeamModel::class);
        $this->teamMember = model(TeamMemberModel::class);
        $this->account    = model(GameAccountModel::class);
    }

    public function joinTeam(int|string $teamCode)
    {
        $team = $this->team->findTeamByCode($teamCode);
        if (empty($team)) {
            return redirect('team')->with('toast_error', "Tim dengan kode $teamCode tidak ditemukan!");
        } else if (count($team->members) >= intval($team->game->max_player)) {
            return redirect('team')->with('toast_error', "Tim $team->name sudah penuh!");
        }

        $heroScraper = GameModel::getHeroScraper($team->game->code);

        // Join on post data
        if ($this->request->is("post")) {
            $validationErrors = [];
            $this->validation->setRuleGroup('teamMember');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'team_member_hero'       => $this->validation->getError('team_member_hero'),
                    'team_member_hero_id'    => $this->validation->getError('team_member_hero_id'),
                    'team_member_hero_role'  => $this->validation->getError('team_member_hero_role'),
                    'team_member_hero_image' => $this->validation->getError('team_member_hero_image'),
                    'team_member_team'       => $this->validation->getError('team_member_team'),
                    'team_member_account'    => $this->validation->getError('team_member_account'),
                ];
            }

            $teamMemberValidated = $this->validation->getValidated();
            $teamMemberData = $this->serialize($teamMemberValidated, $heroScraper);

            if (empty($validationErrors) && intval($team->id) !== intval($teamMemberData['team']))
                $validationErrors['team_member_team'] = "Kamu tidak memiliki akses untuk mengedit tim melalui dokumen!";

            if ($teamMemberData && empty($validationErrors)) {
                $isJoined = $this->teamMember->joinTeam($teamMemberData);

                if ($isJoined) {
                    if (count($team->members) + 1 >= $team->game->max_player)
                        $this->team->updateTeam($team->id, ['status' => 'matches']);

                    return redirect('team')->with('toast_success', "Berhasil bergabung ke tim {$team->name}!");
                }
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Gagal bergabung ke tim $team->name, Silahkan Coba Lagi!"]);
        }

        $accounts = $this->account->findAccountsByUserAndGame(auth()->user()->id, $team->game->id);
        if (empty($accounts) || count($accounts) < 1) {
            $this->session->setFlashdata('toast_error', "Kamu tidak memiliki akun untuk game {$team->game->name}, Silahkan sambungkan akun ke game {$team->game->name} terlebih dahulu!");
            $this->session->setFlashdata('connect_game_account_ref', $team->game->id);
            $this->session->set('redirect_after_action', current_url());
            return redirect('game.account.add');
        }

        return view('team/member/join', [
            'team'        => $team,
            'accounts'    => $accounts,
            'heroScraper' => $heroScraper,
            'error'       => $this->session->getFlashdata('error'),
            'metadata'    => [
                'title'   => "Join Team $team->name",
                'header'  => [
                    'title'        => "Gabung ke $team->name",
                    'description'  => "Bergabung ke tim $team->name."
                ]
            ],
        ]);
    }

    public function leaveTeam(int|string $teamCode, int|string $teamMemberAccountId)
    {
        if (!$this->request->is('post')) return redirect('team')->with('toast_error', "Method {$this->request->getMethod()} tidak diizinkan!");

        $error = null;
        $team = $this->team->findTeamByCode($teamCode);
        if (empty($team)) redirect('team')->with('toast_error', "Tim $teamCode tidak dapat ditemukan!");

        $teamMember = !empty($team) ? array_filter($team->members, fn ($member) => intval($member->account->id) == intval($teamMemberAccountId)) : null;
        if (empty($teamMember)) return redirect('team')->with('toast_error', "Akun dengan id $teamMemberAccountId pada tim $team->name tidak dapat ditemukan!");

        $teamMember = reset($teamMember);
        $isMemberLeaved = $this->teamMember->leaveTeam($teamMember->id);
        if (!$isMemberLeaved) $error = "Gagal keluar dari tim $team->name";

        if ($isMemberLeaved && intval(count($team->members)) == intval($team->game->max_player) && $team->status == 'matches')
            $this->team->updateTeam($team->id, ['status' => 'recruite']);

        return redirect('team')->with(
            isset($error) ?
                'toast_error' :
                'toast_success',
            isset($error) ?
                $error :
                "Berhasil keluar dari tim $team->name!"
        );
    }

    private function serialize($teamMemberDataValidated, $scraper = null)
    {
        $teamMember = [];

        foreach ($teamMemberDataValidated as $teamMemberKey => $teamMemberValue) {
            $teamMemberKey = str_replace("team_member_", "", $teamMemberKey);
            if ($teamMemberKey == 'hero_role' && $teamMemberValue == "null" || $teamMemberValue == "" && !empty($scraper) && !empty($teamMemberDataValidated['team_member_hero_id'])) {
                $heroDetail = $scraper->getHero($teamMemberDataValidated['team_member_hero_id'], 'object');
                if (!empty($heroDetail->role)) $teamMember[$teamMemberKey] = $heroDetail->role;
                continue;
            }

            $teamMember[$teamMemberKey] = $teamMemberValue;
        }

        $teamMember['hero_scraper'] = (!empty($scraper) && !empty($teamMember['hero_id']) && $teamMember['hero_id'] !== '')
            ? GameModel::getHeroScraperName($scraper)
            : "";

        return $teamMember;
    }
}
