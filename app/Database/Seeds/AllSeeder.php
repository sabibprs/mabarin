<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AllSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('GameSeeder');
        $this->call('GameAccountSeeder');
        $this->call('TeamSeeder');
        $this->call('TeamMemberSeeder');
    }
}
