<?php

namespace App\Database\Seeds;

use App\Libraries\MobileLegendsLibrary;
use App\Models\GameAccountModel;
use App\Models\GameModel;
use App\Models\TeamMemberModel;
use App\Models\TeamModel;
use CodeIgniter\Database\Seeder;
use Faker\Factory as FakerFactory;

class TeamMemberSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create('id_ID');
        $tableName = TeamMemberModel::getConfigName('tableName');

        $teams = model(TeamModel::class)->where("status !=", "draft")->findAll();
        $accounts = model(GameAccountModel::class)->findAll();

        $mobileLegends = new MobileLegendsLibrary();
        $mobileLegendsHero = null;

        foreach (array_merge($accounts, $accounts) as $account) {
            $matchesTeam = array_filter($teams, function ($team) use ($account) {
                return boolval($team->game == $account->game);
            });
            $team = $faker->randomElement($matchesTeam);

            $teamMember = [
                'team'         => intval($team->id),
                'account'      => intval($account->id),
                'hero'         => $faker->name,
                'hero_id'    => null,
                'hero_role'    => null,
                'hero_image'   => null,
                'hero_scraper' => null,
            ];

            if (intval($team->game) == 1) {
                if (empty($mobileLegendsHero)) $mobileLegendsHero = $mobileLegends->getHero(null, 'object');
                $heroPicked = $faker->randomElement($mobileLegendsHero);
                $heroDetail = $mobileLegends->getHero($heroPicked->id, 'object');

                $teamMember['hero'] = $heroDetail->name;
                $teamMember['hero_id'] = $heroPicked->id;
                $teamMember['hero_role'] = $heroDetail->role;
                $teamMember['hero_image'] = $heroDetail->image;
                $teamMember['hero_scraper'] = GameModel::$defaultScrapper;
            }

            $this->db->table($tableName)->insert($teamMember);
        }
    }
}
