<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GameModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use Error;

class Game extends BaseController
{
    protected GameModel $game;

    public function __construct()
    {
        $this->game = model(GameModel::class);
    }

    public function main()
    {
        $limit = $this->request->getVar('limit') ?? 100;

        $data['all'] = $this->game->where("creator !=", auth()->user('id'))->where("is_verified", true)->findAllGame($limit, 0);
        $data['own'] = $this->game->findGameByUserId(auth()->user('id'), $limit);
        $data['verifyRequired'] = $this->game->where('is_verified', false)->findAllGame($limit);

        return view('game/main', [
            'games'     => $data,
            'metadata'  => [
                'title'   => "Game",
                'header'  => [
                    'title'        => 'Game',
                    'description'  => 'Lihat semua game yang tersedia, kami akan menambahkan game lainnya di waktu mendatang.'
                ]
            ]
        ]);
    }

    public function addGame()
    {
        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('game');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'game_creator'  => $this->validation->getError('game_creator'),
                    'game_image'  => $this->validation->getError('game_image'),
                    'game_name'  => $this->validation->getError('game_name'),
                    'game_code'  => $this->validation->getError('game_code'),
                    'game_description'  => $this->validation->getError('game_description'),
                    'game_max_player'  => $this->validation->getError('game_max_player'),
                    'game_is_verified'  => $this->validation->getError('game_is_verified'),
                ];
            }

            $gameValidated = $this->validation->getValidated();
            $gameData = $this->serialize($gameValidated);

            if (isset($gameData['code'])) {
                $isGameExist = $this->game->findGameByCode($gameData['code']);
                if ($isGameExist) $validationErrors['game_code'] = "Kode game sudah ada, gunakan kode game yang lain.!";
            }

            if (isset($gameData['is_verified']) && $gameData['is_verified'] == "1" && auth()->isUser())
                $validationErrors['game_is_verified'] = "Kamu tidak memiliki akses untuk mengubah ini";
            if (isset($gameData['creator']) && intval($gameData['creator']) !== intval(auth()->user('id')))
                $validationErrors['game_creator'] = "Creator game tidak dapat kamu ubah!";

            if ($gameData && empty($validationErrors)) {
                $isGameAdded = $this->game->addGame($gameData);
                if ($isGameAdded) {
                    $this->session->setFlashdata('toast_success', "Yuhhu, Berhasil menambah game!");
                    return redirect('game');
                }
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Gagal menambahkan game, Silahkan Coba Lagi!"]);
        }

        return view('game/add', [
            'metadata'  => [
                'title'   => "Tambah Game",
                'header'  => [
                    'title'        => 'Tambah Game',
                    'description'  => 'Tambah game favoritmu.'
                ]
            ],
            'error'    => $this->session->getFlashdata('error')
        ]);
    }

    public function editGame(string $gameCode)
    {
        $isFromVerify = url_to('game.verify', $gameCode) == current_url();
        $messageType = $isFromVerify ? 'memverifikasi' : 'mengedit';
        $game = $this->game->findGameByCode($gameCode);
        if (empty($game)) return redirect('game')->with('toast_error', "Game $gameCode tidak ditemukan!");

        if (($isFromVerify && auth()->isUser()) || (intval($game->creator->id) !== intval(auth()->user('id')) && auth()->isUser()))
            return redirect('game')->with('toast_error', "Kamu tidak memiliki akses untuk $messageType game $gameCode!");


        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('game');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'game_creator'  => $this->validation->getError('game_creator'),
                    'game_image'  => $this->validation->getError('game_image'),
                    'game_name'  => $this->validation->getError('game_name'),
                    'game_code'  => $this->validation->getError('game_code'),
                    'game_description'  => $this->validation->getError('game_description'),
                    'game_max_player'  => $this->validation->getError('game_max_player'),
                    'game_is_verified'  => $this->validation->getError('game_is_verified'),
                ];
            }

            $gameValidated = $this->validation->getValidated();
            $gameData = $this->serialize($gameValidated);
            if ($gameData['code'] !== $game->code) {
                $isGameExist = $this->game->findGameByCode($gameData['code']);
                if ($isGameExist) $validationErrors['game_code'] = "Kode game sudah ada, gunakan kode game yang lain.!";
            }

            if ($isFromVerify) {
                if (isset($gameData['is_verified']) && $gameData['is_verified'] !== $game->is_verified && auth()->isUser())
                    $validationErrors['game_is_verified'] = "Kamu tidak memiliki akses untuk verifikasi game!";
                if (isset($gameData['creator']) && intval($gameData['creator']) !== intval(auth()->user('id')) && auth()->isUser())
                    $validationErrors['game_creator'] = "Kamu tidak memiliki akses untuk mengubah creator game!";
            } else {
                if (isset($gameData['is_verified']) && $gameData['is_verified'] && auth()->isUser()) $gameData['is_verified'] = false;
            }

            if ($gameData && empty($validationErrors)) {
                $isGameUpdated = $this->game->update($game->id, $gameData);
                if ($isGameUpdated) return redirect('game')->with('toast_success', "Berhasil $messageType game {$gameData['name']}!");
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Gagal $messageType game, Silahkan Coba Lagi!"]);
        }

        return view('game/edit', [
            'game'      => $game,
            'error'     => $this->session->getFlashdata('error'),
            'metadata'  => [
                'title'   => $isFromVerify  ? "Verifikasi Game $game->name" : "Edit Game $game->name",
                'header'  => [
                    'title'        => $isFromVerify  ? "Verifikasi Game" : "Edit Game",
                    'description'  => $isFromVerify  ? "Verifikasi Game $game->name dari {$game->creator->name}" : "Edit Game $game->name",
                ]
            ],
        ]);
    }

    public function detailGame(string $gameCode)
    {
        $game = $this->game->findGameByCode($gameCode);
        if (empty($game)) {
            $this->session->setFlashdata('toast_error', "Game $gameCode tidak ditemukan!");
            return redirect('game');
        }

        return view('game/detail', [
            'game'      => $game,
            'error'     => $this->session->getFlashdata('error'),
            'metadata'  => [
                'title'   => "Game $game->name",
                'header'  => [
                    'title'        => 'Detail Game',
                    'description'  => "Detal Game $game->name."
                ]
            ],
        ]);
    }

    public function deleteGame(string $gameCode)
    {
        $error = null;
        $game = $this->game->findGameByCode($gameCode);
        if (empty($game)) $error = "Gagal menghapus game, game dengan kode $gameCode tidak ditemukan!";

        if (isset($game) && intval($game->creator->id) !== intval(auth()->user('id')) && auth()->isUser())
            $error = "Gagal menghapus game, Kamu tidak memiliki akses untuk menghapus game $game->name!";

        // Must be check is game not have team

        $isDeleted = $this->game->deleteGame($game->id);
        if (!$isDeleted) $error = "Gagal menghapus game $game->name";

        return redirect('game')->with(
            isset($error) ?
                'toast_error' :
                'toast_success',
            isset($error) ?
                $error :
                "Berhasil menghapus game $game->name!"
        );
    }

    /**
     * Upload Game Image
     * 
     * Game image upload by route /game/upload-image, or
     * Call this method manual from another method 
     *
     * @param UploadedFile|null $uploadedFile
     * @return void
     */
    public function uploadImage(?UploadedFile $uploadedFile = null)
    {
        if (isset($uploadedFile)) {
            $file = $uploadedFile;
        } else {
            if (!$this->request->is("post")) return $this->response->setJSON(['status' => 'error', 'message' => 'Must be use POST method!']);
            $file = $this->request->getFile('game_image');
        }

        try {
            if (!$file->isValid()) throw new Error("Gambar game invalid, pastikan file yang di upload berupa gambar!");
            if ($file->hasMoved()) throw new Error("File gambar telah di upload sebelumnya!");

            $fileName = $file->getRandomName();
            if (ENVIRONMENT == 'development') $fileName = $file->getName();

            $gamePath = 'game/';
            $uploadPath = IMAGEPATH . $gamePath;

            $previewUri = base_url("img/$gamePath/$fileName");

            $isMoved = $file->move($uploadPath, $fileName, (bool)(ENVIRONMENT == 'development'));
            if (!$isMoved) throw new Error("Gagal upload gambar game, File gagal dipindahkan!");

            if (isset($uploadedFile)) return true;
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'success',
                'message' => 'Game image uploaded!',
                'preview'   => $previewUri
            ]);
        } catch (\Throwable $th) {
            if (isset($uploadedFile)) return false;
            $errMsg = $th->getMessage();
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => $errMsg ?? 'Upload gambar game gagal!'
            ]);
        }
    }


    /**
     * Filter Duplicate Game Data
     *
     * @param array $allGamesData
     * @param array $ownGamesData
     * @return array
     */
    private function duplicateGameFilter(array $allGamesData, array $ownGamesData): array
    {
        // Array of id game
        $ownGamesId = array_map(function ($ownGame) {
            return $ownGame->id;
        }, $ownGamesData);

        $allGamesData = array_filter($allGamesData, function ($allGame) use ($ownGamesId) {
            if (!in_array($allGame->id, $ownGamesId)) return $allGame;
        });

        return [
            'all' => $allGamesData,
            'own' => $ownGamesData,
        ];
    }

    private function serialize($gameDataValidated)
    {
        $game = [];

        foreach ($gameDataValidated as $gameKey => $gameValue) {
            if ($gameKey == 'game_is_verified') {
                $game[str_replace("game_", "", $gameKey)] = boolval($gameValue == "true" || $gameValue == '1');
                continue;
            }

            $game[str_replace("game_", "", $gameKey)] = $gameValue;
        }

        return $game;
    }
}
