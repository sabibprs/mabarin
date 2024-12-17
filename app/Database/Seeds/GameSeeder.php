<?php

namespace App\Database\Seeds;

use App\Models\GameModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory as FakerFactory;

class GameSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create('id_ID');
        $tableName = GameModel::getConfigName('tableName');
        $games = [
            [
                'code'        => 'mobile-legends',
                'creator'     => $faker->numberBetween(1, 20),
                'name'        => 'Mobile Legends: Bang Bang',
                'description' => 'Mobile Legends: Bang Bang adalah permainan video seluler ber-genre multiplayer online battle arena yang dikembangkan dan diterbitkan oleh Moonton, anak perusahaan dari ByteDance.',
                'image'       => base_url('/img/game/mobile-legends-icon.jpg'),
                'max_player'  => $faker->numberBetween(1, 5),
                'is_verified' => $faker->randomElement([true, false])
            ],
            [
                'code'        => 'pubg-mobile',
                'creator'     =>  $faker->numberBetween(1, 20),
                'name'        => 'PUBG Mobile | #1 Battle Royale Mobile Game',
                'description' => "PUBG Mobile adalah sebuah permainan video battle royale gratis dimainkan yang dikembangkan oleh LightSpeed dan Quantum Studio, sebuah divisi dari Tencent Games. Ini merupakan adaptasi permainan piranti genggam dari PlayerUnknown's Battlegrounds yang dirilis untuk Android dan iOS pada tanggal 19 Maret 2018.",
                'image'       => base_url('/img/game/pubg-mobile-icon.png'),
                'max_player'  => $faker->numberBetween(1, 5),
                'is_verified' => $faker->randomElement([true, false])
            ]
        ];

        foreach ($games as $game) {
            $this->db->table($tableName)->insert($game);
        }
    }
}
