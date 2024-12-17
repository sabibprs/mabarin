<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Error;

class User extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = model(UserModel::class);
    }

    public function main()
    {
        if (auth()->isUser()) return redirect("user.profile");

        $users = $this->user->orderBy('role', "DESC")->orderBy('created_at', "DESC")->findAll();
        return view('user/main', [
            'users'     => $users,
            'metadata'  => [
                'title'   => "Pengguna",
                'header'  => [
                    'title'        => 'Pengguna',
                    'description'  => 'Semua pengguna yang telah terdaftar.'
                ]
            ]
        ]);
    }

    public function selfProfile()
    {
        $userLoggedInId = auth()->user()->id;
        $user = $this->user
            ->withTotalAccounts()
            ->withTotalGames()
            ->withTotalTeams()
            ->find($userLoggedInId);

        return view('user/profile', [
            'user'      => $user,
            'metadata'  => [
                'title'   => "Profil",
                'header'  => [
                    'title'        => 'Profil',
                    'description'  => "Profil kamu nih " . first_name($user->name) . "."
                ]
            ]
        ]);
    }

    public function userProfile(int|string $usernameOrEmail)
    {
        if (strval($usernameOrEmail) == strval(auth()->user()->username) || strval($usernameOrEmail) == strval(auth()->user()->email))
            return redirect('user.profile');

        $user = $this->user
            ->findByUsernameOrEmail($usernameOrEmail, ['returning_model' => true])
            ->withTotalAccounts()
            ->withTotalGames()
            ->withTotalTeams()
            ->first();

        if (empty($user)) $this->session->setFlashdata('error', "Pengguna $usernameOrEmail tidak dapat ditemukan!");

        return view('user/detail', [
            'user'      => $user,
            'metadata'  => [
                'title'   => !empty($user) ? "Profil {$user->name} (@{$user->username})" : "Pengguna $usernameOrEmail tidak dapat ditemukan",
                'header'  => [
                    'title'        => !empty($user->name) ? $user->name : "Profil",
                    'description'  => !empty($user->name) ? "Profil {$user->name}." : "Profil $usernameOrEmail tidak dapat ditemukan."
                ]
            ]
        ]);
    }

    public function editSelfProfile()
    {
        $userLoggedInId = auth()->user()->id;
        $user = $this->user->find($userLoggedInId);

        if (intval($user->id) !== intval(auth()->user()->id))
            return redirect()->with('toast_error', "Kamu tidak memiliki akses untuk mengubah ini!");

        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('userProfile');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'name'             => $this->validation->getError('name'),
                    'username'         => $this->validation->getError('username'),
                    'email'            => $this->validation->getError('email'),
                    'phone'            => $this->validation->getError('phone'),
                    'photo'            => $this->validation->getError('photo'),
                    'password'         => $this->validation->getError('password'),
                ];
            }

            $userData = $this->validation->getValidated();

            if (!empty($userData['phone']) && strval($userData['phone']) == strval($user->phone)) unset($userData['phone']);
            if (empty($userData['photo']) || strval($userData['photo']) == strval($user->photo)) unset($userData['photo']);
            if (empty($userData['username']) || strval($userData['username']) == strval($user->username)) unset($userData['username']);
            if (empty($userData['email']) || strval($userData['email']) == strval($user->email)) unset($userData['email']);
            if (empty($userData['password']) || $userData['password'] == '') unset($userData['password']);

            if (!empty($userData['email'])) {
                $isEmailExist = $this->user->where('email', $userData['email'])->first();
                if ($isEmailExist) $validationErrors['email'] = "Email sudah digunakan (mungkin oleh pengguna lain), Silahkan gunakan alamat email yang lain.";
            }

            if (!empty($userData['username'])) {
                $isUsernameExist = $this->user->where('username', $userData['username']);
                if ($isUsernameExist) $validationErrors['username'] = "Username sudah digunakan, pilih username yang lain.";
            }

            if (!empty($userData['password']) && auth()->isSameCreds($userData['password'], $user->password))
                $validationErrors['password'] = "Password sama dengan yang sebelumnya, Silahkan ganti dengan password yang baru atau kosongkan jika ingin tetap menggunakan password yang sebelumnya!";

            if (!empty($userData['password']) && empty($validationErrors)) {
                if (strlen($userData['password']) < 8) $validationErrors['password'] = 'Password harus minimal 8 karakter.';
                if (strlen($userData['password']) > 132) $validationErrors['password'] = 'Password tidak boleh lebih dari 132 karakter.';
            }

            if ($userData && empty($validationErrors)) {
                $isUserUpdated = $this->user->update($user->id, $userData);
                if ($isUserUpdated) return redirect('user.profile')->with('toast_success', "Berhasil mengedit profil!");
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Gagal mengedit profil, Silahkan Coba Lagi!"]);
        }

        return view('user/edit-profile', [
            'user'      => $user,
            'error'     => $this->session->getFlashdata('error'),
            'metadata'  => [
                'title'   => "Edit Profil",
                'header'  => [
                    'title'        => "Edit Profil",
                    'description'  => "Edit profil mu $user->name."
                ]
            ]
        ]);
    }


    public function uploadPhotoProfile()
    {
        if (!$this->request->is("post")) return $this->response->setJSON(['status' => 'error', 'message' => 'Must be use POST method!']);
        $file = $this->request->getFile('photo');

        try {
            if (!$file->isValid()) throw new Error("Foto invalid, pastikan file yang di upload berupa gambar!");
            if ($file->hasMoved()) throw new Error("Foto telah di upload sebelumnya!");

            $fileName = $file->getRandomName();
            if (ENVIRONMENT == 'development') $fileName = $file->getName();

            $gamePath = 'photo/';
            $uploadPath = IMAGEPATH . $gamePath;

            $previewUri = base_url("img/$gamePath/$fileName");

            $isMoved = $file->move($uploadPath, $fileName, (bool)(ENVIRONMENT == 'development'));
            if (!$isMoved) throw new Error("Gagal upload foto profil, File gagal dipindahkan!");

            if (isset($uploadedFile)) return true;
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 'success',
                'message' => 'Foto profil uploaded!',
                'preview'   => $previewUri
            ]);
        } catch (\Throwable $th) {
            if (isset($uploadedFile)) return false;
            $errMsg = $th->getMessage();
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => $errMsg ?? 'Upload foto profil gagal!'
            ]);
        }
    }
}
