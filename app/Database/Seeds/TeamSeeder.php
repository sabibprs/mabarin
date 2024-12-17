<?php

namespace App\Database\Seeds;

use App\Models\TeamModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory as FakerFactory;

class TeamSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create('id_ID');
        $tableName = TeamModel::getConfigName("tableName");
        $availableStatus = TeamModel::$availableTeamStatus;

        $teamDataset = $this->dataset();
        foreach ($teamDataset as $team) {
            $this->db->table($tableName)->insert([
                'code'    => $team['code'],
                'game'    => $faker->numberBetween(1, 2),
                'creator' => $faker->numberBetween(1, 26),
                'name'    => $team['name'],
                'status'  => $faker->randomElement($availableStatus),
            ]);
        }
    }

    private function dataset(): array
    {
        // team dataset generated from chatGPT
        return [
            [
                'code'    => 'evos-esports',
                'game'    => 'mobile-legends',
                'creator' => 'EVOS Esports',
                'name'    => 'EVOS Esports',
                'status'  => 'active',
            ],
            [
                'code'    => 'rrq-hoshi',
                'game'    => 'mobile-legends',
                'creator' => 'Rex Regum Qeon',
                'name'    => 'RRQ Hoshi',
                'status'  => 'active',
            ],
            [
                'code'    => 'bigetron-esports',
                'game'    => 'pubg-mobile',
                'creator' => 'Bigetron Esports',
                'name'    => 'Bigetron Esports',
                'status'  => 'active',
            ],
            [
                'code'    => 'onic-esports',
                'game'    => 'pubg-mobile',
                'creator' => 'ONIC Esports',
                'name'    => 'ONIC Esports',
                'status'  => 'active',
            ],
            [
                'code'    => 'team-secret',
                'game'    => 'dota-2',
                'creator' => 'Team Secret',
                'name'    => 'Team Secret',
                'status'  => 'active',
            ],
            [
                'code'    => 'fnatic',
                'game'    => 'pubg-mobile',
                'creator' => 'Fnatic',
                'name'    => 'Fnatic',
                'status'  => 'active',
            ],
            [
                'code'    => 'cloud9',
                'game'    => 'counter-strike',
                'creator' => 'Cloud9',
                'name'    => 'Cloud9',
                'status'  => 'active',
            ],
            [
                'code'    => 'g2-esports',
                'game'    => 'rainbow-six-siege',
                'creator' => 'G2 Esports',
                'name'    => 'G2 Esports',
                'status'  => 'active',
            ],
            [
                'code'    => 'natus-vincere',
                'game'    => 'cs-go',
                'creator' => 'Natus Vincere',
                'name'    => 'Natus Vincere',
                'status'  => 'active',
            ],
            [
                'code'    => 'tsm',
                'game'    => 'valorant',
                'creator' => 'Team SoloMid',
                'name'    => 'TSM',
                'status'  => 'active',
            ],
            [
                'code'    => 'liquid',
                'game'    => 'league-of-legends',
                'creator' => 'Team Liquid',
                'name'    => 'Team Liquid',
                'status'  => 'active',
            ],
            [
                'code'    => 'faze',
                'game'    => 'call-of-duty',
                'creator' => 'FaZe Clan',
                'name'    => 'FaZe Clan',
                'status'  => 'active',
            ],
            [
                'code'    => 'mgc',
                'game'    => 'free-fire',
                'creator' => 'Mega Conqueror',
                'name'    => 'Mega Conqueror',
                'status'  => 'active',
            ],
            [
                'code'    => 'boomboom',
                'game'    => 'mobile-legends',
                'creator' => 'Boom Esports',
                'name'    => 'BOOM Esports',
                'status'  => 'active',
            ],
            [
                'code'    => 'alter-ego',
                'game'    => 'pubg-mobile',
                'creator' => 'Alter Ego',
                'name'    => 'Alter Ego',
                'status'  => 'active',
            ],
            [
                'code'    => 'aurafire',
                'game'    => 'free-fire',
                'creator' => 'AURA Fire',
                'name'    => 'AURA Fire',
                'status'  => 'active',
            ],
            [
                'code'    => 'geekfam',
                'game'    => 'mobile-legends',
                'creator' => 'Geek Fam',
                'name'    => 'Geek Fam',
                'status'  => 'active',
            ],
            [
                'code'    => 'execration',
                'game'    => 'dota-2',
                'creator' => 'Execration',
                'name'    => 'Execration',
                'status'  => 'active',
            ],
            [
                'code'    => 'mibr',
                'game'    => 'counter-strike',
                'creator' => 'MIBR',
                'name'    => 'MIBR',
                'status'  => 'active',
            ],
            [
                'code'    => 'pain-gaming',
                'game'    => 'dota-2',
                'creator' => 'paiN Gaming',
                'name'    => 'paiN Gaming',
                'status'  => 'active',
            ],
            [
                'code'    => 'vp-dota',
                'game'    => 'dota-2',
                'creator' => 'Virtus.pro',
                'name'    => 'Virtus.pro',
                'status'  => 'active',
            ],
            [
                'code'    => 'rng',
                'game'    => 'pubg-mobile',
                'creator' => 'Royal Never Give Up',
                'name'    => 'Royal Never Give Up',
                'status'  => 'active',
            ],
            [
                'code'    => 'og',
                'game'    => 'counter-strike',
                'creator' => 'OG',
                'name'    => 'OG',
                'status'  => 'draft',
            ],
            [
                'code'    => 'astralis',
                'game'    => 'rainbow-six-siege',
                'creator' => 'Astralis',
                'name'    => 'Astralis',
                'status'  => 'active',
            ],
            [
                'code'    => 'nip',
                'game'    => 'dota-2',
                'creator' => 'Ninjas in Pyjamas',
                'name'    => 'Ninjas in Pyjamas',
                'status'  => 'active',
            ]
        ];
    }
}
