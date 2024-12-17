<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function main()
    {
        /**
         * If Authenticated   | return to dashboard view
         * If UnAuthenticated | return to homepage view
         */

        if (!auth()->isLoggedIn()) return redirect('login');

        return view('homepage', [
            'metadata' => ['title' => "Cari Tim Mabar Game Terbaikmu"]
        ]);
    }
}
