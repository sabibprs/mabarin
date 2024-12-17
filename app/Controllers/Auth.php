<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * AuthController
 * 
 * All auth logic is handled on \App\Libraries\AuthLibrary::class
 */
class Auth extends BaseController
{

    public function __construct()
    {
        $this->helpers = ['form'];
    }

    /**
     * Redirect to Login Page
     * 
     * redirect if user access `/auth`.
     * valid auth route:
     * - /auth/login    | [GET, POST]
     * - /auth/logout   | [POST]
     * - /auth/register | [GET, POST]
     *
     * @return RedirectResponse
     */
    public function main(): RedirectResponse
    {
        return redirect('login');
    }

    /**
     * Handling Login Page & Action
     * 
     * if method is GET, handling login ui/page.
     * if method is POST, that assumse requested from form login & handling login logic.
     *
     * @return string|RedirectResponse 
     */
    public function login(): string | RedirectResponse
    {
        // Redirect to homepage if user id authenticated
        if (auth()->isLoggedIn()) return redirect('home')->with('toast_info', 'Kamu sudah login sebelumnya, Silahkan logout untuk ganti akun.');

        // Handling post method | from login form
        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('login');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'username'  => $this->validation->getError('username'),
                    'password'  => $this->validation->getError('password'),
                ];
            }

            $userData = $this->validation->getValidated();
            $isUserCredentialsValid = auth()->validCreds($userData);
            if ($isUserCredentialsValid) {
                $firstName = first_name(auth()->user()->name);


                $this->session->setFlashdata('toast_info', "Halo $firstName, Selamat datang kembali.");
                $redirection = $this->session->get("redirect_after_login");

                if ($redirection && is_string($redirection)) {
                    $this->session->remove("redirect_after_login");
                    return redirect()->to($redirection);
                }

                return redirect('home');
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Username atau Kata Sandi salah!"]);
        }

        // Handling login view/ui
        return view("auth/login", [
            'metadata' => ['title' => "Login"],
            'error'    => $this->session->getFlashdata('error')
        ]);
    }

    /**
     * Handling Logout Action
     * 
     * Auth::logout method is accept http method only POST.
     *
     * @return RedirectResponse 
     */
    public function logout(): RedirectResponse
    {
        $referer = $this->request->getHeaderLine('Referer');
        if (!empty($referer)) $this->session->set("redirect_after_login", $referer);
        return auth()->logout();
    }

    /**
     * Handling Register Page & Action
     * 
     * if method is GET, handling register ui/page.
     * if method is POST, that assumse requested from form register & handling register logic.
     *
     * @return string|RedirectResponse 
     */
    public function register(): string | RedirectResponse
    {
        // Redirect to homepage if user id authenticated
        if (auth()->isLoggedIn())
            return redirect('home')->with('toast_info', 'Kamu sudah login sebelumnya, Silahkan logout untuk ganti akun.');

        // Handling post method | from register form 
        if ($this->request->is('post')) {
            $validationErrors = [];
            $this->validation->setRuleGroup('register');
            if (!$this->validation->withRequest($this->request)->run()) {
                $validationErrors = [
                    'name'             => $this->validation->getError('name'),
                    'username'         => $this->validation->getError('username'),
                    'email'            => $this->validation->getError('email'),
                    'password'         => $this->validation->getError('password'),
                    'retype_password'  => $this->validation->getError('retype_password'),
                ];
            }

            $userData = $this->validation->getValidated();

            if ($userData && empty($validationErrors)) {
                $userIdCreated = auth()->register($userData['name'], $userData['username'], $userData['email'], $userData['password']);

                if ($userIdCreated) {
                    $this->session->setFlashdata('toast_success', "Berhasil mendaftar, Sekarang silahkan login!");
                    return redirect('login')->withInput($this->request);
                }
            }

            $this->session->setFlashdata('error', count($validationErrors) ? $validationErrors : ['global' => "Terjadi Kesalahan, Silahkan Coba Lagi!"]);
        }

        // Handling register view/ui
        return view("auth/register", [
            'metadata' => ['title' => "Daftar"],
            'error'    => $this->session->getFlashdata('error')
        ]);
    }
}
